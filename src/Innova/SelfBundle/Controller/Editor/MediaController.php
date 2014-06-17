<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class MediaController
 * @Route(
 *      "admin/editor",
 *      name    = "",
 *      service = "innova_editor_media"
 * )
 */
class MediaController
{
    protected $mediaManager;
    protected $propositionManager;
    protected $appManager;
    protected $entityManager;
    protected $request;
    protected $templating;

    public function __construct(
            $mediaManager,
            $propositionManager,
            $appManager,
            $entityManager,
            $templating
    ) {
        $this->mediaManager = $mediaManager;
        $this->propositionManager = $propositionManager;
        $this->appManager = $appManager;
        $this->entityManager = $entityManager;
        $this->templating = $templating;

    }

    public function setRequest(Request $request = null)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @Route("/set-listening-limit", name="set-listening-limit", options={"expose"=true})
     * @Method("POST")
     */
    public function setListeningLimitAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));
        $media = $em->getRepository('InnovaSelfBundle:Media')->find($request->get('mediaId'));
        $limit = $request->get('listeningLimit');

        $this->mediaManager->updateMediaLimit($test, $questionnaire, $media, $limit);

        return new JsonResponse(
            array()
        );
    }

    /**
     * @Route("/questionnaires/create-media", name="editor_questionnaire_create-media", options={"expose"=true})
     * @Method("POST")
     */
    public function createMediaAction()
    {
        $request = $this->request->request;
        $em = $this->entityManager;

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));
        $media = $this->mediaManager->createMedia($test, $questionnaire, $request->get('type'), $request->get('name'), $request->get('description'), $request->get('url'), 0);

        /* Création de la relation avec une entité */
        $entityType = $request->get('entityType');
        $entityId = $request->get('entityId');
        $entityField = $request->get('entityField');

        $template = "";
        switch ($entityType) {
            case "questionnaire":
                $entity =  $em->getRepository('InnovaSelfBundle:Questionnaire')->findOneById($entityId);
                if ($entityField == "contexte") {
                    $entity->setMediaContext($media);
                    $em->persist($entity);
                    $em->flush();

                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:contexte.html.twig',array('test'=> $test, 'questionnaire' => $entity));
                } elseif ($entityField == "texte") {
                    $entity->setMediaText($media);
                    $em->persist($entity);
                    $em->flush();

                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:texte.html.twig',array('test'=> $test, 'questionnaire' => $entity));
                }
                break;
            case "subquestion":
                $entity =  $em->getRepository('InnovaSelfBundle:Subquestion')->findOneById($entityId);
                if ($entityField == "amorce") {
                    $entity->setMediaAmorce($media);
                    $em->persist($entity);
                    $em->flush();

                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:subquestion.html.twig',array('test'=> $test, 'questionnaire' => $questionnaire, 'subquestion' => $entity));
                } elseif ($entityField == "media") {
                    $entity->setMedia($media);
                    $em->persist($entity);
                    $em->flush();

                    $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('test' => $test, 'questionnaire' => $questionnaire));
                }
                break;
            case "proposition":
                if ($entityField == "app-answer") {
                    $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->findOneById($entityId);
                    $proposition = $this->propositionManager->createProposition($subquestion, $media, true);
                    $this->appManager->createAppFakeAnswer($proposition);

                    $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('test'=> $test, 'questionnaire' => $questionnaire));
                } elseif ($entityField == "app-distractor") {
                    $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->findOneById($entityId);
                    $subquestions = $questionnaire->getQuestions()[0]->getSubquestions();
                    foreach ($subquestions as $subquestion) {
                        $proposition = $this->propositionManager->createProposition($subquestion, $media, false);
                    }
                    $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('test'=> $test, 'questionnaire' => $questionnaire));
                } else {
                    $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->findOneById($entityId);
                    $proposition = $this->propositionManager->createProposition($subquestion, $media, false);

                    $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestion.html.twig',array('test'=> $test, 'questionnaire' => $questionnaire, 'subquestion' => $subquestion));
                }
                break;
        }

        return new Response($template);
    }

    /**
     * Supprime la relation qu'a un media avec un élément (ou supprime l'élément)... il faudrait supprimer le media dans certains cas.
     *
     * @Route("/questionnaires/unlink-media", name="editor_questionnaire_unlink-media", options={"expose"=true})
     * @Method("POST")
     */
    public function unlinkMediaAction()
    {
        $request = $this->request->request;
        $em = $this->entityManager;

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));

        $entityType = $request->get('entityType');
        $entityId = $request->get('entityId');
        $entityField = $request->get('entityField');

        $template = "";
        switch ($entityType) {
            case "questionnaire":
                $entity =  $em->getRepository('InnovaSelfBundle:Questionnaire')->findOneById($entityId);
                if ($entityField == "contexte") {
                    $entity->setMediaContext(null);
                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:contexte.html.twig', array('test'=> $test, 'questionnaire' => $entity));
                } elseif ($entityField == "texte") {
                    $entity->setMediaText(null);
                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:texte.html.twig', array('test'=> $test, 'questionnaire' => $entity));
                }
                $em->persist($entity);
                $em->flush();
                break;
            case "subquestion":
                $entity =  $em->getRepository('InnovaSelfBundle:Subquestion')->findOneById($entityId);
                if ($entityField == "amorce") {
                    $entity->setMediaAmorce(null);
                    $em->persist($entity);
                    $em->flush();

                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:subquestion.html.twig', array('test'=> $test, 'questionnaire' => $questionnaire, 'subquestion' => $entity));
                } elseif ($entityField == "app") {
                    if ($rightProposition = $em->getRepository('InnovaSelfBundle:Proposition')->findOneBy(array("subquestion" => $entity, "rightAnswer" => true))) {
                        $mediaToSearch = $rightProposition->getMedia();
                        $question = $entity->getQuestion();
                        $this->appManager->appDeletePropositions($mediaToSearch, $question);
                    }

                    $em->remove($entity);
                    $em->flush();

                    $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('test'=> $test, 'questionnaire' => $questionnaire));
                }
                break;
            case "proposition":
                if ($entityField == "app-distractor") {
                    $proposition =  $em->getRepository('InnovaSelfBundle:Proposition')->findOneById($entityId);
                    $mediaToSearch = $proposition->getMedia();
                    $question = $proposition->getSubquestion()->getQuestion();
                    $this->appManager->appDeletePropositions($mediaToSearch, $question);

                    $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('test'=> $test, 'questionnaire' => $questionnaire));
                } else {
                    $entity =  $em->getRepository('InnovaSelfBundle:Proposition')->findOneById($entityId);
                    $em->remove($entity);
                    $em->flush();

                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:proposition.html.twig', array('test'=> $test, 'questionnaire' => $questionnaire, 'proposition' => null));
                }
                break;
        }

        return new Response($template);
    }
}
