<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Session;
use Innova\SelfBundle\Entity\Questionnaire;

/**
 * Class PlayerController.
 *
 * @ParamConverter("session", isOptional="true", class="InnovaSelfBundle:Session", options={"id" = "sessionId"})
 * @ParamConverter("test", isOptional="true", class="InnovaSelfBundle:Test", options={"id" = "testId"})
 */
class PlayerController extends Controller
{
    /**
     * Try to pick a questionnaire entity for a given test and a given sessionr
     * and display it if possible.
     *
     * @Route("test/{testId}/session/{sessionId}", name="test_start", requirements={"sessionId": "\d+"})
     * @ParamConverter("test", class="InnovaSelfBundle:Test", options={"repository_method" = "findOneWithOrderQuestionnaires", "id" = "testId"})
     * @Method("GET")
     * @Template("InnovaSelfBundle:Player:index.html.twig")
     */
    public function startAction(Test $test, Session $session)
    {
        // cas où l'utilisateur doit se connecter. On le redirige vers le formulaire de connexion à la session.
        if ($this->get('self.player.manager')->needToLog($session)) {
            return $this->redirect($this->generateUrl('session_connect', array('sessionId' => $session->getId())));
        }

        // cas où il n'y a plus de tâche candidate. L'utilisateur est redirigé vers la page de fin de test.
        if (!$orderQuestionnaire = $this->get('self.player.manager')->pickQuestionnaire($test, $session)) {
            $this->get('self.mediaclick.manager')->deleteMediaClick($test, $session);

            return $this->redirect($this->generateUrl('test_end', array('testId' => $test->getId(), 'sessionId' => $session->getId())));
        }

        $questionnaire = $orderQuestionnaire->getQuestionnaire();
        $questionnaires = $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
            ? $this->getDoctrine()->getRepository('InnovaSelfBundle:Questionnaire')->getByTest($test)
            : null;

        $component = ($test->getPhased()) ? $orderQuestionnaire->getComponent() : null;
        $percent = $this->get('self.player.manager')->getPercentDone($test, $component, $session);

        return array(
            'test' => $test,
            'session' => $session,
            'component' => $component,
            'questionnaire' => $questionnaire,
            'questionnaires' => $questionnaires,
            'percent' => $percent,
        );
    }

    /**
     * Gère la vue de fin de test.
     *
     * @Route("/test/{testId}/session/{sessionId}/end", name="test_end")
     * @Template("InnovaSelfBundle:Player:common/end.html.twig")
     * @Method("GET")
     */
    public function endAction(Test $test, Session $session)
    {
        $scoreManager = $this->get('self.score.manager');

        $levelFeedback = $scoreManager->getGlobalScore($session, $this->getUser(), true);
        $eecFeedback = $scoreManager->getSkillScore($session, $this->getUser(), 'EEC', true);
        $coFeedback = $scoreManager->getSkillScore($session, $this->getUser(), 'CO', true);
        $ceFeedback = $scoreManager->getSkillScore($session, $this->getUser(), 'CE', true);
        $score = $scoreManager->calculateScoreByTest($test, $session, $this->getUser());

        return array(
            'score' => $score,
            'session' => $session,
            'levelFeedback' => $levelFeedback,
            'coFeedback' => $coFeedback,
            'ceFeedback' => $ceFeedback,
            'eecFeedback' => $eecFeedback,
        );
    }

    /**
     * @Route("/home", name="show_tests")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Player:showTests.html.twig")
     */
    public function showTestsAction()
    {
        $this->get('self.user.manager')->checkCourse();

        return array();
    }

    /**
     * @Route(
     *      "admin/test/{testId}/session/{sessionId}/questionnaire/{questionnaireId}",
     *      name="questionnaire_pick"
     * )
     * @ParamConverter("questionnaire", class="InnovaSelfBundle:Questionnaire", options={"mapping": {"questionnaireId": "id"}})
     * @Method("GET")
     * @Template("InnovaSelfBundle:Player:index.html.twig")
     */
    public function pickAQuestionnaireAction(Test $test, Session $session, Questionnaire $questionnaire)
    {
        $questionnaires = $this->getDoctrine()->getRepository('InnovaSelfBundle:Questionnaire')->getByTest($test);

        return array(
            'test' => $test,
            'session' => $session,
            'questionnaires' => $questionnaires,
            'questionnaire' => $questionnaire,
            'percent' => null,
            'component' => null,
            'canSave' => false,
        );
    }

    /**
     * @Method("GET")
     * @Route("/session/connect", name="session_connect")
     * @Template("InnovaSelfBundle:Player:common/log.html.twig")
     */
    public function sessionConnectAction()
    {
        $this->get('self.user.manager')->checkCourse();

        return array();
    }

    /**
     * @Method("POST")
     * @Route("/session/log", name="session_log")
     */
    public function sessionLogAction(Request $request)
    {
        $password = $request->request->get('passwd');
        $sessions = $this->getDoctrine()->getRepository('InnovaSelfBundle:Session')->findActiveByPassword($password);

        if (count($sessions) >= 1) {
            $this->get('self.player.manager')->considerAsLogged($sessions);

            return $this->render('InnovaSelfBundle:Player:common/log.html.twig', array('sessions' => $sessions));
        }
        $this->get('session')->getFlashBag()->add('warning', 'editor.session.invalid_code');

        return $this->redirect($this->generateUrl('session_connect', array()));
    }
}
