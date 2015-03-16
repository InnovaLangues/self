<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Proposition;
use Innova\SelfBundle\Entity\Media\Media;

/**
 * Class EecController
 * @Route(
 *      "admin/editor",
 *      name    = "",
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

    public function __construct(
            $eecManager,
            $propositionManager,
            $entityManager,
            $templating,
            $questionnaireRevisorsManager
    ) {
        $this->eecManager = $eecManager;
        $this->propositionManager = $propositionManager;
        $this->entityManager = $entityManager;
        $this->templating = $templating;
        $this->questionnaireRevisorsManager = $questionnaireRevisorsManager;
    }

    /**
     *
     * @Route("/questionnaires/create-liste/{questionnaireId}", name="editor_questionnaire_create-liste", options={"expose"=true})
     * @Method("PUT")
     */
    public function createListeAction(Questionnaire $questionnaire)
    {
        $this->eecManager->createListe($questionnaire);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     *
     * @Route("/questionnaires/create-lacunes/{questionnaireId}", name="editor_questionnaire_create-lacunes", options={"expose"=true})
     * @Method("PUT")
     */
    public function createLacunesAction(Questionnaire $questionnaire)
    {
        $this->eecManager->createLacune($questionnaire);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     *
     * @Route("/questionnaires/create-clue/{questionnaireId}/{subquestionId}", name="editor_questionnaire_create-clue", options={"expose"=true})
     * @Method("PUT")
     */
    public function createClueAction(Request $request, Questionnaire $questionnaire, Subquestion $subquestion)
    {
        $clueName = $request->get('clue');

        $this->eecManager->createClue($questionnaire, $subquestion, $clueName);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     *
     * @Route("/questionnaires/set-clue-type/{questionnaireId}", name="editor_questionnaire_set-clue-type", options={"expose"=true})
     * @Method("PUT")
     */
    public function setClueTypeAction(Request $request, Questionnaire $questionnaire)
    {
        $clueId = $request->get('clueId');
        $clueTypeName = $request->get('clueType');

        $this->eecManager->setClueType($clueId, $clueTypeName);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        return new JsonResponse(array());
    }

    /**
     *
     * @Route("/questionnaires/create-syllable/{questionnaireId}/{subquestionId}", name="editor_questionnaire_create-syllable", options={"expose"=true})
     * @Method("PUT")
     */
    public function createSyllableAction(Request $request, Questionnaire $questionnaire, Subquestion $subquestion)
    {
        $syllable = $request->get('syllable');

        $this->eecManager->createSyllabe($syllable, $questionnaire, $subquestion);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        return new JsonResponse(array());
    }

    /**
     *
     * @Route("/questionnaires/set-display/{subquestionId}", name="editor_questionnaire_set-display", options={"expose"=true})
     * @Method("PUT")
     */
    public function setDisplayAction(Request $request, Subquestion $subquestion)
    {
        $em = $this->entityManager;

        if ($request->get('display') == "true") {
            $display = 1;
        } else {
            $display = 0;
        }

        $subquestion->setDisplayAnswer($display);
        $em->persist($subquestion);
        $em->flush();

        return new JsonResponse(array());
    }

    /**
     *
     * @Route("/questionnaires/add-distractor/{questionnaireId}", name="editor_questionnaire_add-distractor", options={"expose"=true})
     * @Method("PUT")
     */
    public function addDistractorAction(Questionnaire $questionnaire)
    {
        $this->eecManager->addDistractor($questionnaire);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     *
     * @Route("/questionnaires/add-distractor-mult/{questionnaireId}/{subquestionId}", name="editor_questionnaire_add-distractor-mult", options={"expose"=true})
     * @Method("PUT")
     */
    public function addDistractorMultAction(Questionnaire $questionnaire, Subquestion $subquestion)
    {
        $this->eecManager->addDistractorMult($questionnaire, $subquestion);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     *
     * @Route("/questionnaires/edit-distractor/{questionnaireId}/{mediaId}", name="editor_questionnaire_edit-distractor", options={"expose"=true})
     * @Method("PUT")
     */
    public function editDistractorAction(Request $request, Questionnaire $questionnaire, Media $media)
    {
        $text = $request->get('text');

        $this->eecManager->editDistractor($media, $text);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        return new JsonResponse(array());
    }

    /**
     *
     * @Route("/questionnaires/ecc_get_answer/{subquestionId}", name="editor_questionnaire_get_answers", options={"expose"=true})
     * @Method("GET")
     */
    public function getAnswersAction(Subquestion $subquestion)
    {
        $answers = $this->eecManager->getAnswers($subquestion);

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:eec_answers.html.twig', array('answers' => $answers));

        return new Response($template);
    }

    /**
     *
     * @Route("/questionnaires/ecc_toggle_answer/{propositionId}", name="ecc_toggle_answer", options={"expose"=true})
     * @Method("PUT")
     */
    public function toggleRightAnswerAction(Proposition $proposition)
    {
        $proposition = $this->propositionManager->toggleRightAnswer($proposition);

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:eec_answer.html.twig', array('answer' => $proposition));

        return new Response($template);
    }
}
