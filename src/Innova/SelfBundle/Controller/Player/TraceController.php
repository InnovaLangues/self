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
        $securityContext
    )
    {
        $this->mediaManager = $mediaManager;
        $this->propositionManager = $propositionManager;
        $this->traceManager = $traceManager;
        $this->answerManager = $answerManager;
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->router = $router;
        $this->securityContext = $securityContext;
        $this->user = $this->securityContext->getToken()->getUser();
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
        $typo = $post["typoName"];
        $user = $this->user;

        $countTrace = $em->getRepository('InnovaSelfBundle:Questionnaire')
            ->countTraceByUserByTestByQuestionnaire($test->getId(), $questionnaire->getId(), $user->getId());

        if ($countTrace > 0) {
            $this->session->getFlashBag()->set('notice', 'Vous avez déjà répondu à cette question.');

            return array("traceId" => 0, "testId" => $test->getId());
        } else {
            $trace = $this->traceManager->createTrace($questionnaire, $test, $user, $post["totalTime"]);
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
        $this->session->getFlashBag()->set('success', 'Votre réponse a bien été enregistrée.');

        foreach ($post as $subquestionId => $postVar)
        {
            // Cas classique
            if (is_array($postVar))
            {
                foreach ($postVar as $key => $propositionId)
                {
                    // Cas 1 : si la proposition est de type numéric alors on est dans le cas d'un choix dans une liste
                    if (is_numeric($propositionId))
                    {
                        foreach ($postVar as $key => $propositionId) {
                            $this->createAnswer($trace, $propositionId, $subquestionId);
                        }
                    }
                    // Cas 2 : si la proposition N'est PAS de type numéric alors on est dans le cas d'une SAISIE
                    else {
                        foreach ($postVar as $key => $propositionId) {
                            $this->createAnswerProposition($trace, $propositionId, $subquestionId);
                        }
                    }
                } // Fin foreach dans if
            }
        } // Fin foreach principal
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

        $typosSaisie = array("TLQROCDERIV", "TLQROCFIRST", "TLQROCSYL", "TLQROCNOCLU", "TLQROCLEN", "TLQROCFIRSTLEN" );
        if (in_array($typo, $typosSaisie)) {
            $propositions = $subquestion->getPropositions();
            $rightAnswer = false;
            $propositionFound = null;

            // Il faut concaténer la syllabe avec la saisie.
            $syllableAnswer = "";
            if ($typo == "TLQROCSYL" ) {
                $syllableAnswer = $subquestion->getMediaSyllable()->getDescription();
                $saisie = $syllableAnswer . $saisie;
            }

            // Il faut concaténer le premier caractère de la réponse avec la saisie.
            $firstAnswer = "";
            if ($typo == "TLQROCFIRST" ) {
                $firstAnswer = $propositions[0]->getMedia()->getDescription();
                $firstAnswer = $firstAnswer[0];
                $saisie = $firstAnswer . $saisie;
            }

            foreach ($propositions as $proposition) {
                $text = $proposition->getMedia()->getName();

                if ($text == $saisie) {
                    $propositionFound = $proposition;
                    if ($proposition->getRightAnswer() == true) {
                        $rightAnswer = true;
                    } else {
                        $rightAnswer = false;
                    }
                    break;
                }
            }

            if ($propositionFound == null) {
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
