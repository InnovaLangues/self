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
 * Class MediaController
 * @Route(
 *      "admin/editor",
 *      name    = "",
 *      service = "innova_editor_subquestion"
 * )
 */
class SubquestionController
{
    protected $propositionManager;
    protected $mediaManager;
    protected $entityManager;
    protected $request;
    protected $templating;

    public function __construct(
            $mediaManager,
            $propositionManager,
            $entityManager,
            $templating
    ) {
        $this->mediaManager = $mediaManager;
        $this->propositionManager = $propositionManager;
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
     * @Route("/questionnaires/create-subquestion", name="editor_questionnaire_create-subquestion", options={"expose"=true})
     * @Method("PUT")
     */
    public function createSubquestionAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));

        $questionnaireId = $request->get('questionnaireId');
        $questionnaireTypology = $request->get('questionnaireTypology');

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        $question = $questionnaire->getQuestions()[0];
        $arrayLikeTypos = array("TQRU", "TQRM", "TVFNM", "TVF");

        $subquestion = new Subquestion();
        if (!in_array($questionnaireTypology, $arrayLikeTypos)) {
            $typology = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($questionnaireTypology);
        } else {
            $typology = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName(mb_substr($questionnaireTypology, 1));
        }
        $subquestion->setTypology($typology);
        $subquestion->setQuestion($question);

        // création automatique en cas de vrai/faux/(nd)?
        if($questionnaireTypology == "VF" || $questionnaireTypology == "TVF" || $questionnaireTypology == "TVFNM" || $questionnaireTypology == "VFNM") {
            $true = $this->mediaManager->createMedia($test, $questionnaire, "texte", "VRAI", "VRAI", null, 0, "proposition");
            $this->propositionManager->createProposition($subquestion, $true, false);
            $false = $this->mediaManager->createMedia($test, $questionnaire, "texte", "FAUX", "FAUX", null, 0, "proposition");
            $this->propositionManager->createProposition($subquestion, $false, false);
        }
        if($questionnaireTypology == "TVFNM" || $questionnaireTypology == "VFNM") {
            $nd = $this->mediaManager->createMedia($test, $questionnaire, "texte", "ND", "ND", null, 0, "proposition");
            $this->propositionManager->createProposition($subquestion, $nd, false);
        }

        $em->persist($subquestion);
        $em->flush();
        $em->refresh($subquestion);
        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('test' => $test, 'questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     *
     * @Route("/questionnaires/delete-subquestion", name="editor_questionnaire_delete_subquestion", options={"expose"=true})
     * @Method("DELETE")
     */
    public function deleteSubquestionAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));

        $subquestionId = $request->get('subquestionId');
        $questionnaireId = $request->get('questionnaireId');

        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($subquestionId);
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);

        $em->remove($subquestion);
        $em->flush();

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('test'=> $test, 'questionnaire' => $questionnaire));

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

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));
        $question = $questionnaire->getQuestions()[0];

        $subquestions = $question->getSubquestions();
        foreach ($subquestions as $subquestion) {
            $em->remove($subquestion);
        }
        $em->flush();
        $em->refresh($question);

        $texte = $questionnaire->getMediaText()->getDescription();

        preg_match_all("/#(.*?)#/", $texte, $lacunes);

        foreach ($lacunes[1] as $lacune){
            $subquestion = new Subquestion();
            $typology = $question->getTypology();
            $subquestion->setTypology($typology);
            $subquestion->setQuestion($question);
            $em->persist($subquestion);


            $lacuneMedia = $this->mediaManager->createMedia($test, $questionnaire, "texte", $lacune, $lacune, null, 0, "proposition");
            $this->propositionManager->createProposition($subquestion, $lacuneMedia, true);
            $em->flush();
            $em->refresh($subquestion);
        }


        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('test'=> $test, 'questionnaire' => $questionnaire));

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

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));
        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($request->get('subquestionId'));
        $clueName = $request->get('clue');
        $clueTypeName = $request->get('clueTypeName');

        if (!$clue = $subquestion->getClue()) {
            $clue = new Clue();
            $clue->setClueType($em->getRepository('InnovaSelfBundle:ClueType')->findOneByName("fonctionnel"));
            $subquestion->setClue($clue);
        }

        if (!$media = $subquestion->getClue()->getMedia()) {
            $media = $this->mediaManager->createMedia($test, $questionnaire, "texte", $clueName, $clueName, null, 0, "clue");
        } else {
            $media->setDescription($clueName);
            $media->setName($clueName);
            $em->persist($media);
        }

        $clue->setMedia($media);
        $em->persist($clue);
        $em->flush();

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('test'=> $test, 'questionnaire' => $questionnaire));

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

        $clue = $em->getRepository('InnovaSelfBundle:Clue')->find($clueId);
        $clue->setClueType($em->getRepository('InnovaSelfBundle:ClueType')->findOneByName($clueTypeName));

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

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));
        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($request->get('subquestionId'));
        $syllable = $request->get('syllable');

        if (!$syllableMedia = $subquestion->getMediaSyllable()) {
            $syllableMedia = $this->mediaManager->createMedia($test, $questionnaire, "texte", $syllable, $syllable, null, 0, "syllable");
        } else {
            $syllableMedia->setDescription($syllable);
            $syllableMedia->setName($syllable);
            $em->persist($syllableMedia);

        }
        $subquestion->setMediaSyllable($syllableMedia);
        $em->persist($subquestion);
        $em->flush();

        return new JsonResponse(
            array()
        );
    }


}
