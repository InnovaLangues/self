<?php

namespace Innova\SelfBundle\Controller\Player;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Session;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Trace;

/**
 * Class TraceController
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
    protected $mediaManager;
    protected $propositionManager;
    protected $traceManager;
    protected $answerManager;
    protected $entityManager;
    protected $session;
    protected $router;
    protected $securityContext;
    protected $user;
    protected $translator;

    /**
     * Class constructor
     */
    public function __construct(
        $mediaManager,
        $propositionManager,
        $traceManager,
        $answerManager,
        $entityManager,
        $session,
        $router,
        $securityContext,
        $translator
    ) {
        $this->mediaManager = $mediaManager;
        $this->propositionManager = $propositionManager;
        $this->traceManager = $traceManager;
        $this->answerManager = $answerManager;
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->router = $router;
        $this->securityContext = $securityContext;
        $this->user = $this->securityContext->getToken()->getUser();
        $this->translator = $translator;
    }

    /**
     * Save Trace and display a form to set the difficulty
     *
     * @Route("trace_submit/{testId}/{sessionId}/{questionnaireId}", name="trace_submit")
     * @Method("POST")
     */
    public function saveTraceAction(Test $test, Session $session, Questionnaire $questionnaire, Request $request)
    {
        $em = $this->entityManager;

        $post = $request->request->all();

        if (isset($post["componentId"])) {
            $component = $em->getRepository('InnovaSelfBundle:PhasedTest\Component')->find($post["componentId"]);
        } else {
            $component = null;
        }

        $trace = $em->getRepository('InnovaSelfBundle:Questionnaire')->findByUserByTestByQuestionnaire($test, $questionnaire, $this->user, $component, $session);
        if ($trace) {
            $this->session->getFlashBag()->set('danger', 'Vous avez déjà répondu à cette question.');
        } else {
            $agent = $request->headers->get('User-Agent');
            $trace = $this->traceManager->createTrace($questionnaire, $test, $this->user, $post["totalTime"], $agent, $component, $session);
            $this->parsePost($post, $trace);
        }

        $url = $this->router->generate('trace_difficulty_form', array('testId' => $test->getId(), 'sessionId' => $session->getId(), 'traceId' => $trace->getId() ));

        return new RedirectResponse($url);
    }

    /**
    * Parse post var
    */
    private function parsePost($post, Trace $trace)
    {
        $em = $this->entityManager;
        $this->session->getFlashBag()->set('success', $this->translator->trans("trace.answer_saved", array(), "messages"));

        foreach ($post as $subquestionId => $postVar) {
            $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($subquestionId);
            if (is_array($postVar)) {
                foreach ($postVar as $key => $propositionId) {
                    if ($subquestion->getTypology()->getName() != "TLQROC") {
                        $proposition = $em->getRepository('InnovaSelfBundle:Proposition')->find($propositionId);
                        $this->answerManager->createAnswer($trace, $subquestion, $proposition);
                    } else {
                        $this->createAnswerProposition($trace, $propositionId, $subquestion);
                    }
                }
            }
        }
    }

    /**
     * si la proposition N'est PAS de type numéric alors on est dans le cas d'une SAISIE
     */
    private function createAnswerProposition(Trace $trace, $saisie, Subquestion $subquestion)
    {
        $em = $this->entityManager;

        $typo = $subquestion->getTypology()->getName();

        if ($typo == "TLQROC") {
            $propositions = $subquestion->getPropositions();
            $rightAnswer = false;
            $propositionFound = null;

            // Il faut concaténer la syllabe avec la saisie.
            if ($subquestion->getMediaSyllable()) {
                $syllableAnswer = $subquestion->getMediaSyllable()->getDescription();
                $saisie = $syllableAnswer.$saisie;
            }

            foreach ($propositions as $proposition) {
                $text = $proposition->getMedia()->getName();
                if (strtolower($text) == htmlentities(strtolower($saisie))) {
                    $propositionFound = $proposition;
                    if ($proposition->getRightAnswer() === true) {
                        $rightAnswer = true;
                    } else {
                        $rightAnswer = false;
                    }
                    break;
                }
            }

            if ($propositionFound === null) {
                $media = $this->mediaManager->createMedia(null, "texte", $saisie, $saisie, null, 0, "reponse");
                $proposition = $this->propositionManager->createProposition($subquestion, $media, $rightAnswer);
            } else {
                $proposition = $propositionFound;
            }
        }

        $answer = $this->answerManager->createAnswer($trace, $subquestion, $proposition);

        return $answer;
    }

    /**
     * Display difficulty form for a task
     *
     * @Route("trace_difficulty/{sessionId}/{testId}/{traceId}", name="trace_difficulty_form")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Player:common/difficulty.html.twig")
     */
    public function displayDifficulty(Test $test, Session $session, Trace $trace)
    {
        return array("trace" => $trace, "test" => $test, "session" => $session);
    }

    /**
     * update a trace to set the difficulty
     *
     * @Route("trace_setDifficulty/{traceId}/{testId}/{sessionId}", name="trace_setDifficulty")
     * @Method("POST")
     */
    public function traceSetDifficultyAction(Request $request, Trace $trace, Test $test, Session $session)
    {
        $em = $this->entityManager;
        $post = $request->request->all();

        $trace->setDifficulty($post["difficulty"]);
        $em->persist($trace);
        $em->flush();

        $url = $this->router->generate('test_start', array('testId' => $test->getId(), 'sessionId' => $session->getId()));

        return new RedirectResponse($url);
    }
}
