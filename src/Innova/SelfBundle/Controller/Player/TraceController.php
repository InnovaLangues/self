<?php

namespace Innova\SelfBundle\Controller\Player;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class TraceController
 *
 * @Route(
 *      "",
 *      name = "innova_trace",
 *      service = "innova_player_trace"
 * )
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
     * @Route("trace_submit", name="trace_submit")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Player:common/difficulty.html.twig")
     */
    public function saveTraceAction()
    {
        $em = $this->entityManager;

        $post = $this->request->request->all();

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($post["questionnaireId"]);
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($post["testId"]);
        $user = $this->user;

        $countTrace = $em->getRepository('InnovaSelfBundle:Questionnaire')
            ->countTraceByUserByTestByQuestionnaire($test->getId(), $questionnaire->getId(), $user->getId());

        if ($countTrace > 0) {
            $this->session->getFlashBag()->set('notice', 'Vous avez déjà répondu à cette question.');

            return array("traceId" => 0, "testId" => $test->getId());
        } else {
            $agent = $this->request->headers->get('User-Agent');
            $trace = $this->traceManager->createTrace($questionnaire, $test, $user, $post["totalTime"], $agent);
            $this->parsePost($post, $trace);

            $session = $this->session;
            $session->set('traceId', $trace->getId());
            $session->set('testId', $post["testId"]);

            return new RedirectResponse($this->router->generate('display_difficulty'));
        }
    }

    /**
     * display a form to set the difficulty
     *
     * @Route("display_difficulty", name="display_difficulty")
     * @Template("InnovaSelfBundle:Player:common/difficulty.html.twig")
     * @Method("GET")
     */
    public function displayDifficultyFormAction()
    {
        $session = $this->session;
        $traceId = $session->get('traceId');
        $testId = $session->get('testId');

        return array("traceId" => $traceId, "testId" => $testId);
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

        $displayHelp = 1;

        return new RedirectResponse($this->router->generate('test_start',
        array('id' => $post["testId"], 'displayHelp' => $displayHelp)));
    }
}
