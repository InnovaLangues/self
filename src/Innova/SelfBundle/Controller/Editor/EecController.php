<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class EecController
 * @Route(
 *      "admin/editor",
 *      name    = "",
 *      service = "innova_editor_eec"
 * )
 */
class EecController
{
    protected $eecManager;
    protected $propositionManager;
    protected $entityManager;
    protected $request;
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

    public function setRequest(Request $request = null)
    {
        $this->request = $request;

        return $this;
    }

    /**
     *
     * @Route("/questionnaires/create-liste", name="editor_questionnaire_create-liste", options={"expose"=true})
     * @Method("PUT")
     */
    public function createListeAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));

        $this->eecManager->createListe($questionnaire);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     *
     * @Route("/questionnaires/create-lacunes", name="editor_questionnaire_create-lacunes", options={"expose"=true})
     * @Method("PUT")
     */
    public function createLacunesAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));

        $this->eecManager->createLacune($questionnaire);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     *
     * @Route("/questionnaires/create-clue", name="editor_questionnaire_create-clue", options={"expose"=true})
     * @Method("PUT")
     */
    public function createClueAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));
        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($request->get('subquestionId'));
        $clueName = $request->get('clue');

        $this->eecManager->createClue($questionnaire, $subquestion, $clueName);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     *
     * @Route("/questionnaires/set-clue-type", name="editor_questionnaire_set-clue-type", options={"expose"=true})
     * @Method("PUT")
     */
    public function setClueTypeAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $clueId = $request->get('clueId');
        $clueTypeName = $request->get('clueType');
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));

        $this->eecManager->setClueType($clueId, $clueTypeName);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        return new JsonResponse(
            array()
        );
    }

    /**
     *
     * @Route("/questionnaires/create-syllable", name="editor_questionnaire_create-syllable", options={"expose"=true})
     * @Method("PUT")
     */
    public function createSyllableAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));
        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($request->get('subquestionId'));
        $syllable = $request->get('syllable');

        $this->eecManager->createSyllabe($syllable, $questionnaire, $subquestion);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        return new JsonResponse(array());
    }

    /**
     *
     * @Route("/questionnaires/set-display", name="editor_questionnaire_set-display", options={"expose"=true})
     * @Method("PUT")
     */
    public function setDisplayAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        if ($request->get('display') == "true") {
            $display = 1;
        } else {
            $display = 0;
        }

        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($request->get('subquestionId'));
        $subquestion->setDisplayAnswer($display);

        $em->persist($subquestion);
        $em->flush();

        return new JsonResponse(
            array()
        );
    }

    /**
     *
     * @Route("/questionnaires/add-distractor", name="editor_questionnaire_add-distractor", options={"expose"=true})
     * @Method("PUT")
     */
    public function addDistractorAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));

        $this->eecManager->addDistractor($questionnaire);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     *
     * @Route("/questionnaires/add-distractor-mult", name="editor_questionnaire_add-distractor-mult", options={"expose"=true})
     * @Method("PUT")
     */
    public function addDistractorMultAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));
        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($request->get('subquestionId'));

        $this->eecManager->addDistractorMult($questionnaire, $subquestion);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     *
     * @Route("/questionnaires/edit-distractor", name="editor_questionnaire_edit-distractor", options={"expose"=true})
     * @Method("PUT")
     */
    public function editDistractorAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));
        $media = $em->getRepository('InnovaSelfBundle:Media\Media')->find($request->get('mediaId'));
        $text = $request->get('text');

        $this->eecManager->editDistractor($media, $text);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        return new JsonResponse(
            array()
        );
    }

    /**
     *
     * @Route("/questionnaires/ecc_get_answer", name="editor_questionnaire_get_answers", options={"expose"=true})
     * @Method("GET")
     */
    public function getAnswersAction()
    {
        $em = $this->entityManager;
        $request = $this->request->query;

        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($request->get('subquestionId'));

        $answers = $this->eecManager->getAnswers($subquestion);

        $template = $this->templating
            ->render('InnovaSelfBundle:Editor/partials:eec_answers.html.twig', array('answers' => $answers));

        return new Response($template);
    }

    /**
     *
     * @Route("/questionnaires/ecc_toggle_answer", name="ecc_toggle_answer", options={"expose"=true})
     * @Method("PUT")
     */
    public function toggleRightAnswerAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $proposition = $em->getRepository('InnovaSelfBundle:Proposition')->find($request->get('propositionId'));
        $proposition = $this->propositionManager->toggleRightAnswer($proposition);

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:eec_answer.html.twig', array('answer' => $proposition));

        return new Response($template);
    }
}
