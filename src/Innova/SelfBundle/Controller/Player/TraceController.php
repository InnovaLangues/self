<?php

namespace Innova\SelfBundle\Controller\Player;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Session;
use Innova\SelfBundle\Entity\Questionnaire;

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
    protected $request;
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

    public function setRequest(Request $request = null)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Save Trace and display a form to set the difficulty
     *
     * @Route("trace_submit/{testId}/{sessionId}/{questionnaireId}", name="trace_submit")
     * @Method("POST")
     * @Template("InnovaSelfBundle:Player:common/difficulty.html.twig")
     */
    public function saveTraceAction(Test $test, Session $session, Questionnaire $questionnaire)
    {
        $em = $this->entityManager;

        $post = $this->request->request->all();

        if (isset($post["componentId"])) {
            $component = $em->getRepository('InnovaSelfBundle:PhasedTest\Component')->find($post["componentId"]);
        } else {
            $component = null;
        }

        $countTrace = $em->getRepository('InnovaSelfBundle:Questionnaire')->countTraceByUserByTestByQuestionnaire($test, $questionnaire, $this->user, $component, $session);
        if ($countTrace > 0) {
            $this->session->getFlashBag()->set('notice', 'Vous avez déjà répondu à cette question.');
            $trace = null;
        } else {
            $agent = $this->request->headers->get('User-Agent');
            $trace = $this->traceManager->createTrace($questionnaire, $test, $this->user, $post["totalTime"], $agent, $component, $session);
            $this->parsePost($post, $trace);
        }

        return array("trace" => $trace, "test" => $test, "session" => $session);
    }

    /**
    * Parse post var
    */
    private function parsePost($post, $trace)
    {
        $em = $this->entityManager;
        $this->session->getFlashBag()->set('success', $this->translator->trans("trace.answer_saved", array(), "messages"));

        foreach ($post as $subquestionId => $postVar) {
            $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($subquestionId);
            if (is_array($postVar)) {
                foreach ($postVar as $key => $propositionId) {
                    if ($subquestion->getTypology()->getName() != "TLQROC") {
                        $this->createAnswer($trace, $propositionId, $subquestionId);
                    } else {
                        $this->createAnswerProposition($trace, $propositionId, $subquestionId);
                    }
                }
            }
        }
    }

    /**
     * si la proposition est de type numéric alors on est dans le cas d'un choix dans une liste
     */
    private function createAnswer($trace, $propositionId, $subquestionId)
    {
        $em = $this->entityManager;
        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($subquestionId);
        $proposition = $em->getRepository('InnovaSelfBundle:Proposition')->find($propositionId);

        $answer = $this->answerManager->createAnswer($trace, $subquestion, $proposition);

        return $answer;
    }

    /**
     * si la proposition N'est PAS de type numéric alors on est dans le cas d'une SAISIE
     */
    private function createAnswerProposition($trace, $saisie, $subquestionId)
    {
        $em = $this->entityManager;

        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($subquestionId);
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
     * update a trace to set the difficulty
     *
     * @Route("trace_setDifficulty", name="trace_setDifficulty")
     * @Method("POST")
     */
    public function traceSetDifficultyAction()
    {
        $em = $this->entityManager;
        $post = $this->request->request->all();

        $trace = $em->getRepository('InnovaSelfBundle:Trace')->find($post["traceId"]);
        $trace->setDifficulty($post["difficulty"]);
        $em->persist($trace);
        $em->flush();

        $testId = $trace->getTest()->getId();
        $sessionId = $trace->getSession()->getId();

        $url = $this->router->generate('test_start', array('testId' => $testId, 'sessionId' => $sessionId));

        return new RedirectResponse($url);
    }
}
