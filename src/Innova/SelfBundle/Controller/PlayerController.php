<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Session;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Manager\PlayerManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PlayerController
 *
 * @Route(
 *      name = "innova_player",
 *      service = "innova_player"
 * )
 * @ParamConverter("session", isOptional="true", class="InnovaSelfBundle:Session", options={"id" = "sessionId"})
 * @ParamConverter("test", isOptional="true", class="InnovaSelfBundle:Test", options={"id" = "testId"})
 */
class PlayerController
{
    protected $securityContext;
    protected $entityManager;
    protected $session;
    protected $router;
    protected $user;
    protected $playerManager;
    protected $scoreManager;
    protected $templating;

    public function __construct(
        TokenStorage $securityContext,
        EntityManager $entityManager,
        SessionInterface $session,
        RouterInterface $router,
        PlayerManager $playerManager,
        $scoreManager,
        $templating
    ) {
        $this->securityContext      = $securityContext;
        $this->entityManager        = $entityManager;
        $this->session              = $session;
        $this->router               = $router;
        $this->user                 = $this->securityContext->getToken()->getUser();
        $this->playerManager        = $playerManager;
        $this->scoreManager         = $scoreManager;
        $this->templating           = $templating;
        $this->questionnaireRepo    = $this->entityManager->getRepository('InnovaSelfBundle:Questionnaire');
    }

    /**
     * Try to pick a questionnaire entity for a given test and a given sessionr
     * and display it if possible.
     *
     * @Route("test/{testId}/session/{sessionId}", name="test_start", requirements={"sessionId": "\d+"})
     * @Method("GET")
     * @Template("InnovaSelfBundle:Player:index.html.twig")
     * @Cache(smaxage="0", maxage="0")
     */
    public function startAction(Test $test, Session $session)
    {
        // cas où l'utilisateur doit se connecter. On le redirige vers le formulaire de connexion à la session.
        if ($this->playerManager->needToLog($session)) {
            $url = $this->router->generate('session_connect', array('sessionId' => $session->getId()));

            return new RedirectResponse($url);
        }

        // cas où il n'y a plus de tâche candidate. L'utilisateur est redirigé vers la page de fin de test.
        if (!$orderQuestionnaire = $this->playerManager->pickQuestionnaire($test, $session)) {
            $url = $this->router->generate('test_end', array("testId" => $test->getId(), 'sessionId' => $session->getId()));

            return new RedirectResponse($url);
        }

        $questionnaire = $orderQuestionnaire->getQuestionnaire();
        $questionnaires = $this->questionnaireRepo->getByTest($test);
        $component = ($test->getPhased()) ? $orderQuestionnaire->getComponent() : null;
        $countQuestionnaireDone = $this->playerManager->countQuestionnaireDone($component, $session);
        $countQuestionnaireTotal = $this->playerManager->countQuestionnaireTotal($component, $questionnaires);

        return array(
                'test' => $test,
                'session' => $session,
                'component' => $component,
                'questionnaire' => $questionnaire,
                'questionnaires' => $questionnaires,
                'countQuestionnaireDone' => $countQuestionnaireDone,
                'countQuestionnaireTotal' => $countQuestionnaireTotal,
            );
    }

     /**
     * Gère la vue de fin de test
     *
     * @Route("/test/{testId}/session/{sessionId}/end", name="test_end")
     * @Template("InnovaSelfBundle:Player:common/end.html.twig")
     * @Method("GET")
     * @Cache(smaxage="0", maxage="0")
     */
    public function endAction(Test $test, Session $session)
    {
        $levelFeedback = $this->scoreManager->getGlobalLevelFromThreshold($session, $this->user);
        $eecFeedback = $this->scoreManager->getSkillLevelFromThreshold($session, $this->user, "EEC");
        $coFeedback = $this->scoreManager->getSkillLevelFromThreshold($session, $this->user, "CO");
        $ceFeedback = $this->scoreManager->getSkillLevelFromThreshold($session, $this->user, "CE");
        $score = $this->scoreManager->calculateScoreByTest($test, $session, $this->user);

        return array(
            "score" => $score,
            "session" => $session,
            "levelFeedback" => $levelFeedback,
            "coFeedback" => $coFeedback,
            "ceFeedback" => $ceFeedback,
            "eecFeedback" => $eecFeedback,
        );
    }

    /**
     * @Route("/home", name="show_tests")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Player:showTests.html.twig")
     * @Cache(smaxage="0", maxage="0")
     */
    public function showTestsAction()
    {
        $tests = $this->entityManager->getRepository('InnovaSelfBundle:Test')->findWithOpenSession();

        return array(
            'tests' => $tests,
        );
    }

    /**
     * @Route(
     *      "admin/test/{testId}/session/{sessionId}/questionnaire/{questionnaireId}",
     *      name="questionnaire_pick"
     * )
     * @ParamConverter("questionnairePicked", class="InnovaSelfBundle:Questionnaire", options={"mapping": {"questionnaireId": "id"}})
     * @Method("GET")
     * @Template("InnovaSelfBundle:Player:index.html.twig")
     * @Cache(smaxage="0", maxage="0")
     */
    public function pickAQuestionnaireAction(Test $test, Session $session, Questionnaire $questionnairePicked)
    {
        $questionnaires = $this->questionnaireRepo->getByTest($test);

        $i = 0;
        foreach ($questionnaires as $q) {
            if ($q == $questionnairePicked) {
                $countQuestionnaireDone = $i;
                break;
            }
            $i++;
        }

        return array(
            'test' => $test,
            'session' => $session,
            'questionnaires' => $questionnaires,
            'questionnaire' => $questionnairePicked,
            'countQuestionnaireDone' => $countQuestionnaireDone,
            'component' => null,
        );
    }

    /**
     * @Method("GET")
     * @Route("/session/connect", name="session_connect")
     * @Template("InnovaSelfBundle:Player:common/log.html.twig")
     * @Cache(smaxage="0", maxage="0")
     */
    public function sessionConnectAction()
    {
        return array();
    }

     /**
     * @Method("POST")
     * @Route("/session/log", name="session_log")
     * @Cache(smaxage="0", maxage="0")
     */
    public function sessionLogAction(Request $request)
    {
        $post = $request->request->all();
        $password = $post["passwd"];
        $sessions = $this->entityManager->getRepository('InnovaSelfBundle:Session')->findBy(array("passwd" => $password, "actif" => true));

        if (count($sessions) >= 1) {
            $this->playerManager->considerAsLogged($sessions);
            $template = $this->templating->render('InnovaSelfBundle:Player:common/log.html.twig', array("sessions" => $sessions));

            return new Response($template);
        } else {
            $this->session->getFlashBag()->set('warning', 'wrong passwd');
            $url = $this->router->generate('session_connect');
        }

        return new RedirectResponse($url);
    }
}
