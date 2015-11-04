<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Session;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Trace;

/**
 * Class TraceController.
 *
 * @Route(
 *      "",
 *      name = "innova_trace",
 *      service = "innova_player_trace"
 * )
 * @ParamConverter("session", isOptional="true", class="InnovaSelfBundle:Session", options={"id" = "sessionId"})
 * @ParamConverter("test", isOptional="true", class="InnovaSelfBundle:Test", options={"id" = "testId"})
 * @ParamConverter("questionnaire", isOptional="true", class="InnovaSelfBundle:Questionnaire", options={"id" = "questionnaireId"})
 * @ParamConverter("trace", isOptional="true", class="InnovaSelfBundle:Trace", options={"id" = "traceId"})
 */
class TraceController
{
    protected $traceManager;
    protected $session;
    protected $router;
    protected $user;

    public function __construct($traceManager, $session, $router)
    {
        $this->traceManager = $traceManager;
        $this->session = $session;
        $this->router = $router;
    }

    /**
     * Save Trace and display a form to set the difficulty.
     *
     * @Route("trace_submit/{testId}/{sessionId}/{questionnaireId}", name="trace_submit")
     * @Method("POST")
     */
    public function saveTraceAction(Test $test, Session $session, Questionnaire $questionnaire, Request $request)
    {
        $trace = $this->traceManager->saveTrace($test, $session, $questionnaire, $request);

        $url = ($test->getDifficulty())
                ? $this->router->generate('trace_difficulty_form', array('testId' => $test->getId(), 'sessionId' => $session->getId(), 'traceId' => $trace->getId()))
                : $this->router->generate('test_start', array('testId' => $test->getId(), 'sessionId' => $session->getId()));

        return new RedirectResponse($url);
    }

    /**
     * Display difficulty form for a task.
     *
     * @Route("trace_difficulty/{sessionId}/{testId}/{traceId}", name="trace_difficulty_form")
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Player:common/difficulty.html.twig")
     */
    public function displayDifficultyAction(Test $test, Session $session, Trace $trace)
    {
        return array('trace' => $trace, 'test' => $test, 'session' => $session);
    }

    /**
     * update a trace to set the difficulty.
     *
     * @Route("trace_setDifficulty/{traceId}/{testId}/{sessionId}", name="trace_setDifficulty")
     * @Method("POST")
     */
    public function traceSetDifficultyAction(Request $request, Trace $trace, Test $test, Session $session)
    {
        $this->traceManager->setDifficulty($trace, $request);

        $url = $this->router->generate('test_start', array('testId' => $test->getId(), 'sessionId' => $session->getId()));

        return new RedirectResponse($url);
    }
}
