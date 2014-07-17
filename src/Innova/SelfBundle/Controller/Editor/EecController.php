<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Clue;



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
    protected $propositionManager;
    protected $questionManager;
    protected $subquestion;
    protected $mediaManager;
    protected $entityManager;
    protected $editorLogManager;
    protected $request;
    protected $templating;

    public function __construct(
            $mediaManager,
            $propositionManager,
            $questionManager,
            $subquestionManager,
            $editorLogManager,
            $entityManager,
            $templating
    ) {
        $this->mediaManager = $mediaManager;
        $this->propositionManager = $propositionManager;
        $this->questionManager = $questionManager;
        $this->subquestionManager = $subquestionManager;
        $this->editorLogManager = $editorLogManager;
        $this->entityManager = $entityManager;
        $this->templating = $templating;
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
        $question = $this->questionManager->removeSubquestions($questionnaire->getQuestions()[0]);   

        if ($questionnaire->getMediaText()) {
            $this->editorLogManager->createEditorLog("editor_create", "words-list", $questionnaire);
            $texte = $questionnaire->getMediaText()->getDescription();

            preg_match_all("/#(.*?)#/", $texte, $lacunes);

            $i = 0;
            for ($i=0; $i < count($lacunes[1]); $i++) { 
                $lacune = $lacunes[1][$i];
                $subquestion = $this->subquestionManager->createSubquestion($question->getTypology(), $question);
                $lacuneMedia = $this->mediaManager->createMedia($questionnaire, "texte", $lacune, $lacune, null, 0, "proposition");
                $this->propositionManager->createProposition($subquestion, $lacuneMedia, true);

                if ($question->getTypology()->getName() == "TLCMLDM") {
                    for ($j=0; $j < count($lacunes[1]); $j++) {
                        if ($j != $i) {
                            $lacune = $lacunes[1][$j];
                            $lacuneMedia = $this->mediaManager->createMedia($questionnaire, "texte", $lacune, $lacune, null, 0, "proposition"); 
                            $this->propositionManager->createProposition($subquestion, $lacuneMedia, false);   
                        }
                    }
                }

                $em->flush();
                $em->refresh($subquestion);
            }
        }
            
        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('questionnaire' => $questionnaire));

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
        $question = $this->questionManager->removeSubquestions($questionnaire->getQuestions()[0]);

        if ($questionnaire->getMediaText()) {
            $this->editorLogManager->createEditorLog("editor_create", "blanks", $questionnaire);
            $texte = $questionnaire->getMediaText()->getDescription();

            preg_match_all("/#(.*?)#/", $texte, $lacunes);

            $i = 0;
            for ($i=0; $i < count($lacunes[1]); $i++) { 
                $lacune = $lacunes[1][$i];
                $subquestion = $this->subquestionManager->createSubquestion($question->getTypology(), $question);
                $lacuneMedia = $this->mediaManager->createMedia($questionnaire, "texte", $lacune, $lacune, null, 0, "proposition");
                $this->propositionManager->createProposition($subquestion, $lacuneMedia, true);

                $em->flush();
                $em->refresh($subquestion);
            }
        }
            
        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('questionnaire' => $questionnaire));

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
        $clueTypeName = $request->get('clueTypeName');

        if (!$clue = $subquestion->getClue()) {
            $clue = new Clue();
            $clue->setClueType($em->getRepository('InnovaSelfBundle:ClueType')->findOneByName("fonctionnel"));

            $subquestion->setClue($clue);
            $em->persist($clue);
            $em->persist($subquestion);
            $this->editorLogManager->createEditorLog("editor_create", "clue", $questionnaire);
        }

        if (!$media = $subquestion->getClue()->getMedia()) {
            $media = $this->mediaManager->createMedia($questionnaire, "texte", $clueName, $clueName, null, 0, "clue");
            $clue->setMedia($media);
            $em->persist($clue);
        } elseif($media->getDescription() != $clueName) {
            $this->editorLogManager->createEditorLog("editor_edit", "clue", $questionnaire);
            $media->setDescription($clueName);
            $media->setName($clueName);
            $em->persist($media);
        }

        $em->flush();

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('questionnaire' => $questionnaire));

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

        $clue = $em->getRepository('InnovaSelfBundle:Clue')->find($clueId);
        $clue->setClueType($em->getRepository('InnovaSelfBundle:ClueType')->findOneByName($clueTypeName));
        $this->editorLogManager->createEditorLog("editor_edit", "clue-type", $questionnaire);

        $em->persist($clue);
        $em->flush();

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

        if (!$syllableMedia = $subquestion->getMediaSyllable()) {
            $syllableMedia = $this->mediaManager->createMedia($questionnaire, "texte", $syllable, $syllable, null, 0, "syllable");
            $this->editorLogManager->createEditorLog("editor_create", "syllable", $questionnaire);
        } else {
            $syllableMedia->setDescription($syllable);
            $syllableMedia->setName($syllable);
            $em->persist($syllableMedia);
            $this->editorLogManager->createEditorLog("editor_edit", "syllable", $questionnaire);
        }
        $subquestion->setMediaSyllable($syllableMedia);
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

        $media = $this->mediaManager->createMedia($questionnaire, "texte", "", "", null, 0, "distractor");
        $this->editorLogManager->createEditorLog("editor_create", "distractor", $questionnaire);
 
        foreach($questionnaire->getQuestions()[0]->getSubquestions() as $subquestion){

            $this->propositionManager->createProposition($subquestion, $media, false);  

            $em->persist($subquestion);
            $em->refresh($subquestion);
        }
       
        $em->flush();

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('questionnaire' => $questionnaire));

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

        $media = $this->mediaManager->createMedia($questionnaire, "texte", "", "", null, 0, "distractor");
        $this->editorLogManager->createEditorLog("editor_create", "distractor", $questionnaire);
 
        $this->propositionManager->createProposition($subquestion, $media, false);  

        $em->persist($subquestion);
        $em->refresh($subquestion);
        $em->flush();

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('questionnaire' => $questionnaire));

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
        $media = $em->getRepository('InnovaSelfBundle:Media')->find($request->get('mediaId'));
        $text = $request->get('text');

        $media->setDescription($text);
        $media->setName($text);
        $em->persist($media);
        $em->flush();

        $this->editorLogManager->createEditorLog("editor_edit", "distractor", $questionnaire);
   
        return new JsonResponse(
            array()
        );
    }
}
