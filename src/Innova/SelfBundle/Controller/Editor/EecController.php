<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Media\Media;

/**
 * Class EecController.
 *
 * @Route(
 *      "/admin",
 *      service = "innova_editor_eec"
 * )
 * @ParamConverter("questionnaire", isOptional="true", class="InnovaSelfBundle:Questionnaire", options={"id" = "questionnaireId"})
 * @ParamConverter("subquestion", isOptional="true", class="InnovaSelfBundle:Subquestion", options={"id" = "subquestionId"})
 * @ParamConverter("media", isOptional="true", class="InnovaSelfBundle:Media\Media", options={"id" = "mediaId"})
 */
class EecController
{
    protected $eecManager;
    protected $templating;
    protected $questionnaireRevisorsManager;
    protected $voter;

    public function __construct(
        $eecManager,
        $templating,
        $questionnaireRevisorsManager,
        $voter
    ) {
        $this->eecManager = $eecManager;
        $this->templating = $templating;
        $this->questionnaireRevisorsManager = $questionnaireRevisorsManager;
        $this->voter = $voter;
    }

    /**
     * @Route("/questionnaires/create-liste/{questionnaireId}", name="editor_questionnaire_create-liste", options={"expose"=true})
     * @Method("PUT")
     */
    public function createListeAction(Questionnaire $questionnaire)
    {
        $this->voter->canEditTask($questionnaire);

        $this->eecManager->createListe($questionnaire);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);
        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     * @Route("/questionnaires/create-lacunes/{questionnaireId}", name="editor_questionnaire_create-lacunes", options={"expose"=true})
     * @Method("PUT")
     */
    public function createLacunesAction(Questionnaire $questionnaire)
    {
        $this->voter->canEditTask($questionnaire);

        $this->eecManager->createLacune($questionnaire);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);
        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     * @Route("/questionnaires/create-clue/{questionnaireId}/{subquestionId}", name="editor_questionnaire_create-clue", options={"expose"=true})
     * @Method("PUT")
     */
    public function createClueAction(Request $request, Questionnaire $questionnaire, Subquestion $subquestion)
    {
        $this->voter->canEditTask($questionnaire);

        $this->eecManager->createClue($questionnaire, $subquestion, $request->get('clue'));
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);
        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     * @Route("/questionnaires/set-clue-type/{questionnaireId}", name="editor_questionnaire_set-clue-type", options={"expose"=true})
     * @Method("PUT")
     */
    public function setClueTypeAction(Request $request, Questionnaire $questionnaire)
    {
        $this->voter->canEditTask($questionnaire);

        $this->eecManager->setClueType($request->get('clueId'), $request->get('clueType'));
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        return new Response(null, 200);
    }

    /**
     * @Route("/questionnaires/create-syllable/{questionnaireId}/{subquestionId}", name="editor_questionnaire_create-syllable", options={"expose"=true})
     * @Method("PUT")
     */
    public function createSyllableAction(Request $request, Questionnaire $questionnaire, Subquestion $subquestion)
    {
        $this->voter->canEditTask($questionnaire);

        $this->eecManager->createSyllabe($request->get('syllable'), $questionnaire, $subquestion);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        return new Response(null, 200);
    }

    /**
     * @Route("/questionnaires/set-display/{subquestionId}/{display}/", name="editor_questionnaire_set-display", options={"expose"=true})
     * @Method("PUT")
     */
    public function setDisplayAction(Subquestion $subquestion, $display)
    {
        $this->voter->canEditTask($subquestion->getQuestion()->getQuestionnaire());

        $this->eecManager->setDisplayAction($subquestion, $display);

        return new Response(null, 200);
    }

    /**
     * @Route("/questionnaires/add-distractor/{questionnaireId}", name="editor_questionnaire_add-distractor", options={"expose"=true})
     * @Method("PUT")
     */
    public function addDistractorAction(Questionnaire $questionnaire)
    {
        $this->voter->canEditTask($questionnaire);

        $this->eecManager->addDistractor($questionnaire);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);
        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     * @Route("/questionnaires/add-distractor-mult/{questionnaireId}/{subquestionId}", name="editor_questionnaire_add-distractor-mult", options={"expose"=true})
     * @Method("PUT")
     */
    public function addDistractorMultAction(Questionnaire $questionnaire, Subquestion $subquestion)
    {
        $this->voter->canEditTask($questionnaire);

        $this->eecManager->addDistractorMult($questionnaire, $subquestion);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);
        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     * @Route("/questionnaires/edit-distractor/{questionnaireId}/{mediaId}", name="editor_questionnaire_edit-distractor", options={"expose"=true})
     * @Method("PUT")
     */
    public function editDistractorAction(Request $request, Questionnaire $questionnaire, Media $media)
    {
        $this->voter->canEditTask($questionnaire);

        $this->eecManager->editDistractor($media, $request->get('text'));
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        return new Response(null, 200);
    }
}
