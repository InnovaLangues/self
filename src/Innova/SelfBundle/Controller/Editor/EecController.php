<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Proposition;
use Innova\SelfBundle\Entity\Media\Media;

/**
 * Class EecController
 * @Route(
 *      "/admin",
 *      service = "innova_editor_eec"
 * )
 * @ParamConverter("questionnaire", isOptional="true", class="InnovaSelfBundle:Questionnaire", options={"id" = "questionnaireId"})
 * @ParamConverter("subquestion", isOptional="true", class="InnovaSelfBundle:Subquestion", options={"id" = "subquestionId"})
 * @ParamConverter("proposition", isOptional="true", class="InnovaSelfBundle:Proposition", options={"id" = "propositionId"})
 * @ParamConverter("media", isOptional="true", class="InnovaSelfBundle:Media\Media", options={"id" = "mediaId"})
 */
class EecController
{
    protected $eecManager;
    protected $propositionManager;
    protected $entityManager;
    protected $templating;
    protected $questionnaireRevisorsManager;
    protected $securityContext;
    protected $rightManager;
    protected $session;

    public function __construct(
        $eecManager,
        $propositionManager,
        $entityManager,
        $templating,
        $questionnaireRevisorsManager,
        $securityContext,
        $rightManager,
        $session
    ) {
        $this->eecManager = $eecManager;
        $this->propositionManager = $propositionManager;
        $this->entityManager = $entityManager;
        $this->templating = $templating;
        $this->questionnaireRevisorsManager = $questionnaireRevisorsManager;
        $this->securityContext              = $securityContext;
        $this->rightManager                 = $rightManager;
        $this->session                      = $session;
    }

    /**
     *
     * @Route("/questionnaires/create-liste/{questionnaireId}", name="editor_questionnaire_create-liste", options={"expose"=true})
     * @Method("PUT")
     *
     */
    public function createListeAction(Questionnaire $questionnaire)
    {
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $this->eecManager->createListe($questionnaire);
            $this->questionnaireRevisorsManager->addRevisor($questionnaire);
            $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

            return new Response($template);
        }

        return;
    }

    /**
     *
     * @Route("/questionnaires/create-lacunes/{questionnaireId}", name="editor_questionnaire_create-lacunes", options={"expose"=true})
     * @Method("PUT")
     *
     */
    public function createLacunesAction(Questionnaire $questionnaire)
    {
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $this->eecManager->createLacune($questionnaire);
            $this->questionnaireRevisorsManager->addRevisor($questionnaire);
            $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

            return new Response($template);
        }

        return;
    }

    /**
     *
     * @Route("/questionnaires/create-clue/{questionnaireId}/{subquestionId}", name="editor_questionnaire_create-clue", options={"expose"=true})
     * @Method("PUT")
     *
     */
    public function createClueAction(Request $request, Questionnaire $questionnaire, Subquestion $subquestion)
    {
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $this->eecManager->createClue($questionnaire, $subquestion, $request->get('clue'));
            $this->questionnaireRevisorsManager->addRevisor($questionnaire);
            $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

            return new Response($template);
        }

        return;
    }

    /**
     *
     * @Route("/questionnaires/set-clue-type/{questionnaireId}", name="editor_questionnaire_set-clue-type", options={"expose"=true})
     * @Method("PUT")
     *
     */
    public function setClueTypeAction(Request $request, Questionnaire $questionnaire)
    {
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $clueId = $request->get('clueId');
            $clueTypeName = $request->get('clueType');

            $this->eecManager->setClueType($clueId, $clueTypeName);
            $this->questionnaireRevisorsManager->addRevisor($questionnaire);

            return new Response(null, 200);
        }

        return;
    }

    /**
     *
     * @Route("/questionnaires/create-syllable/{questionnaireId}/{subquestionId}", name="editor_questionnaire_create-syllable", options={"expose"=true})
     * @Method("PUT")
     *
     */
    public function createSyllableAction(Request $request, Questionnaire $questionnaire, Subquestion $subquestion)
    {
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $this->eecManager->createSyllabe($request->get('syllable'), $questionnaire, $subquestion);
            $this->questionnaireRevisorsManager->addRevisor($questionnaire);

            return new Response(null, 200);
        }

        return;
    }

    /**
     *
     * @Route("/questionnaires/set-display/{subquestionId}/{display}/", name="editor_questionnaire_set-display", options={"expose"=true})
     * @Method("PUT")
     *
     */
    public function setDisplayAction(Subquestion $subquestion, $display)
    {
        $currentUser = $this->securityContext->getToken()->getUser();
        $questionnaire = $subquestion->getQuestion()->getQuestionnaire();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $this->eecManager->setDisplayAction($subquestion, $display);

            return new Response(null, 200);
        }

        return;
    }

    /**
     *
     * @Route("/questionnaires/add-distractor/{questionnaireId}", name="editor_questionnaire_add-distractor", options={"expose"=true})
     * @Method("PUT")
     *
     */
    public function addDistractorAction(Questionnaire $questionnaire)
    {
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $this->eecManager->addDistractor($questionnaire);
            $this->questionnaireRevisorsManager->addRevisor($questionnaire);
            $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

            return new Response($template);
        }

        return;
    }

    /**
     *
     * @Route("/questionnaires/add-distractor-mult/{questionnaireId}/{subquestionId}", name="editor_questionnaire_add-distractor-mult", options={"expose"=true})
     * @Method("PUT")
     *
     */
    public function addDistractorMultAction(Questionnaire $questionnaire, Subquestion $subquestion)
    {
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $this->eecManager->addDistractorMult($questionnaire, $subquestion);
            $this->questionnaireRevisorsManager->addRevisor($questionnaire);
            $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

            return new Response($template);
        }

        return;
    }

    /**
     *
     * @Route("/questionnaires/edit-distractor/{questionnaireId}/{mediaId}", name="editor_questionnaire_edit-distractor", options={"expose"=true})
     * @Method("PUT")
     *
     */
    public function editDistractorAction(Request $request, Questionnaire $questionnaire, Media $media)
    {
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $this->eecManager->editDistractor($media, $request->get('text'));
            $this->questionnaireRevisorsManager->addRevisor($questionnaire);

            return new Response(null, 200);
        }

        return;
    }

    /**
     *
     * @Route("/questionnaires/ecc_get_answer/{subquestionId}", name="editor_questionnaire_get_answers", options={"expose"=true})
     * @Method("GET")
     *
     */
    public function getAnswersAction(Subquestion $subquestion)
    {
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $subquestion->getQuestion()->getQuestionnaire())) {
            $answers = $this->eecManager->getAnswers($subquestion);
            $template = $this->templating->render('InnovaSelfBundle:Editor/partials:eec_answers.html.twig', array('answers' => $answers, 'subquestion' => $subquestion));

            return new Response($template);
        }

        return;
    }

    /**
     *
     * @Route("/questionnaires/ecc_add_answer/{subquestionId}", name="editor_questionnaire_add-eec-answer", options={"expose"=true})
     * @Method("POST")
     *
     */
    public function addAnswersAction(Request $request, Subquestion $subquestion)
    {
        $currentUser = $this->securityContext->getToken()->getUser();
        $questionnaire = $subquestion->getQuestion()->getQuestionnaire();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $this->eecManager->addAnswer($subquestion, $request->get('answer'));
        }

        return;
    }

    /**
     *
     * @Route("/questionnaires/ecc_toggle_answer/{propositionId}", name="ecc_toggle_answer", options={"expose"=true})
     * @Method("PUT")
     *
     */
    public function toggleRightAnswerAction(Proposition $proposition)
    {
        $currentUser = $this->securityContext->getToken()->getUser();
        $questionnaire = $proposition->getSubquestion()->getQuestion()->getQuestionnaire();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $proposition = $this->propositionManager->toggleRightAnswer($proposition);
            $template = $this->templating->render('InnovaSelfBundle:Editor/partials:eec_answer.html.twig', array('answer' => $proposition));

            return new Response($template);
        }

        return;
    }
}
