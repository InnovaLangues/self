<?php

namespace Innova\SelfBundle\Controller\Player;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Session;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Manager\PlayerManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PlayerController
 *
 * @Route(
 *      "",
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

    public function __construct(
        SecurityContextInterface $securityContext,
        EntityManager $entityManager,
        SessionInterface $session,
        RouterInterface $router,
        PlayerManager $playerManager,
        $scoreManager
    ) {
        $this->securityContext = $securityContext;
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->router = $router;
        $this->user = $this->securityContext->getToken()->getUser();
        $this->playerManager = $playerManager;
        $this->scoreManager = $scoreManager;
        $this->questionnaireRepo = $this->entityManager->getRepository('InnovaSelfBundle:Questionnaire');
    }

    /**
     * Try to pick a questionnaire entity for a given test and a given sessionr
     * and display it if possible.
     *
     * @Route("student/test/start/{testId}/{sessionId}", name="test_start")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Player:index.html.twig")
     */
    public function startAction(Test $test, Session $session)
    {
        $sessionLogged = $this->session->get('sessionLogged-'.$session->getId());
        if ($sessionLogged != 1) {
            $url = $this->router->generate('session_log_form', array('sessionId' => $session->getId()));

            return new RedirectResponse($url);
        }

        $orderQuestionnaire = $this->playerManager->pickQuestionnaire($test, $session);

        if (is_null($orderQuestionnaire)) {
            $url = $this->router->generate('test_end', array("testId" => $test->getId(), 'sessionId' => $session->getId()));

            return new RedirectResponse($url);
        }
        $questionnaire = $orderQuestionnaire->getQuestionnaire();
        $component = ($test->getPhased()) ? $orderQuestionnaire->getComponent() : null;

        $questionnaires = $this->questionnaireRepo->getByTest($test);
        if ($component) {
            $countQuestionnaireTotal = count($component->getOrderQuestionnaireComponents());
            $countQuestionnaireDone = $this->questionnaireRepo->countDoneYetByUserByTestByComponent($test, $this->user, $session, $component);
        } else {
            $countQuestionnaireTotal = count($questionnaires);
            $countQuestionnaireDone = $this->questionnaireRepo->countDoneYetByUserByTestBySession($test->getId(), $this->user->getId(), $session->getId());
        }

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
     * @Route("/test_end/{testId}/session/{sessionId}", name="test_end")
     * @Template("InnovaSelfBundle:Player:common/end.html.twig")
     * @Method("GET")
     */
    public function endAction(Test $test, Session $session)
    {
        $score = $this->scoreManager->calculateScoreByTest($test, $session, $this->user);

        return array("score" => $score, "session" => $session);
    }

    /**
     * @Route("/student/", name="show_tests")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Player:showTests.html.twig")
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
     * @Route("/form/session/{sessionId}", name="session_log_form")
     * @Template("InnovaSelfBundle:Player:common/log.html.twig")
     */
    public function sessionLogForm(Session $session)
    {
        return array(
            'session' => $session,
        );
    }

     /**
     * @Method("POST")
     * @Route("/log/session/{sessionId}", name="session_log")
     */
    public function sessionLog(Session $session, Request $request)
    {
        $post = $request->request->all();

        if ($post["passwd"] == $session->getPasswd()) {
            $this->session->set('sessionLogged-'.$session->getId(), 1);
            $url = $this->router->generate('test_start', array("testId" => $session->getTest()->getId(), "sessionId" => $session->getId()));
        } else {
            $this->session->getFlashBag()->set('warning', 'wrong passwd');
            $url = $this->router->generate('session_log_form', array("sessionId" => $session->getId()));
        }

        return new RedirectResponse($url);
    }
}
