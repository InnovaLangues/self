<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Question;
use Innova\SelfBundle\Entity\Proposition;
use Innova\SelfBundle\Entity\MediaLimit;
use Innova\SelfBundle\Entity\Media;

/**
 * MediaController controller for editor
 *
 * @Route("admin/editor")
 */
class MediaController extends Controller
{

    /**
     * @Route("/set-listening-limit", name="set-listening-limit", options={"expose"=true})
     * @Method("POST")
     * @Template("")
     */
    public function setListeningLimitAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request')->request;

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));
        $media = $em->getRepository('InnovaSelfBundle:Media')->find($request->get('mediaId'));
        $limit = $request->get('listeningLimit');

        $this->createMediaLimit($test, $questionnaire, $media, $limit);

        return new JsonResponse(
            array()
        );
    }

    /**
     *
     *
     * @Route("/questionnaires/create-media", name="editor_questionnaire_create-media", options={"expose"=true})
     * @Method("POST")
     */
    public function CreateMediaAction()
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->request->get('testId'));
        $questionnaireId = $request->request->get('questionnaireId');
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);

        /* Création du nouveau media */
        $name = $request->request->get('name');
        $description = $request->request->get('description');
        $url = $request->request->get('url');
        $mediaTypeName = $request->request->get('type');
        $type = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName($mediaTypeName);

        $media = new Media();
        $media->setMediaType($type);
        $media->setName($name);
        $media->setDescription($description);
        $media->setUrl($url);

        $em->persist($media);
        $em->flush();

        if ($mediaTypeName == "audio" || $mediaTypeName == "video") {
            $this->createMediaLimit($test, $questionnaire, $media, 0);
        }

        /* Création de la relation avec une entité */
        $entityType = $request->request->get('entityType');
        $entityId = $request->request->get('entityId');
        $entityField = $request->request->get('entityField');

        $template = "";
        switch ($entityType) {
            case "questionnaire":
                $entity =  $em->getRepository('InnovaSelfBundle:Questionnaire')->findOneById($entityId);
                if ($entityField == "contexte") {
                    $entity->setMediaContext($media);
                    $em->persist($entity);
                    $em->flush();

                    $template =  $this->renderView('InnovaSelfBundle:Editor/partials:contexte.html.twig',array('test'=> $test, 'questionnaire' => $entity));
                } elseif ($entityField == "texte") {
                    $entity->setMediaText($media);
                    $em->persist($entity);
                    $em->flush();

                    $template =  $this->renderView('InnovaSelfBundle:Editor/partials:texte.html.twig',array('test'=> $test, 'questionnaire' => $entity));
                }
                break;
            case "subquestion":
                $entity =  $em->getRepository('InnovaSelfBundle:Subquestion')->findOneById($entityId);
                if ($entityField == "amorce") {
                    $entity->setMediaAmorce($media);
                    $em->persist($entity);
                    $em->flush();

                    $template =  $this->renderView('InnovaSelfBundle:Editor/partials:subquestion.html.twig',array('test'=> $test, 'questionnaire' => $questionnaire, 'subquestion' => $entity));
                } elseif ($entityField == "media") {
                    $entity->setMedia($media);
                    $em->persist($entity);
                    $em->flush();

                    $template = $this->renderView('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('test' => $test, 'questionnaire' => $questionnaire));
                }
                break;
            case "proposition":
                if ($entityField == "app-answer") {
                    $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->findOneById($entityId);
                    $proposition = $this->createProposition($subquestion, $media, true);

                    $this->createAppFakeAnswer($proposition);

                    $template = $this->renderView('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('test'=> $test, 'questionnaire' => $questionnaire));
                } elseif ($entityField == "app-distractor") {
                    $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->findOneById($entityId);
                    $subquestions = $questionnaire->getQuestions()[0]->getSubquestions();
                    foreach ($subquestions as $subquestion) {
                        $proposition = $this->createProposition($subquestion, $media, false);
                    }
                    $template = $this->renderView('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('test'=> $test, 'questionnaire' => $questionnaire));
                } else {
                    $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->findOneById($entityId);
                    $proposition = $this->createProposition($subquestion, $media, false);

                    $template = $this->renderView('InnovaSelfBundle:Editor/partials:subquestion.html.twig',array('test'=> $test, 'questionnaire' => $questionnaire, 'subquestion' => $subquestion));
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
    public function UnlinkMediaAction()
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->request->get('testId'));
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->request->get('questionnaireId'));

        $entityType = $request->request->get('entityType');
        $entityId = $request->request->get('entityId');
        $entityField = $request->request->get('entityField');

        $template = "";
        switch ($entityType) {
            case "questionnaire":
                $entity =  $em->getRepository('InnovaSelfBundle:Questionnaire')->findOneById($entityId);
                if ($entityField == "contexte") {
                    $entity->setMediaContext(null);
                    $template =  $this->renderView('InnovaSelfBundle:Editor/partials:contexte.html.twig', array('test'=> $test, 'questionnaire' => $entity));
                } elseif ($entityField == "texte") {
                    $entity->setMediaText(null);
                    $template =  $this->renderView('InnovaSelfBundle:Editor/partials:texte.html.twig', array('test'=> $test, 'questionnaire' => $entity));
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

                    $template =  $this->renderView('InnovaSelfBundle:Editor/partials:subquestion.html.twig', array('test'=> $test, 'questionnaire' => $questionnaire, 'subquestion' => $entity));
                } elseif ($entityField == "app") {
                    if ($rightProposition = $em->getRepository('InnovaSelfBundle:Proposition')->findOneBy(array("subquestion" => $entity, "rightAnswer" => true))) {
                        $mediaToSearch = $rightProposition->getMedia();
                        $question = $entity->getQuestion();
                        $this->appDeletePropositions($mediaToSearch, $question);
                    }

                    $em->remove($entity);
                    $em->flush();

                    $template = $this->renderView('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('test'=> $test, 'questionnaire' => $questionnaire));
                }
                break;
            case "proposition":
                if ($entityField == "app-distractor") {
                    $proposition =  $em->getRepository('InnovaSelfBundle:Proposition')->findOneById($entityId);
                    $mediaToSearch = $proposition->getMedia();
                    $question = $proposition->getSubquestion()->getQuestion();
                    $this->appDeletePropositions($mediaToSearch, $question);

                    $template = $this->renderView('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('test'=> $test, 'questionnaire' => $questionnaire));
                } else {
                    $entity =  $em->getRepository('InnovaSelfBundle:Proposition')->findOneById($entityId);
                    $subquestion = $entity->getSubquestion();
                    $em->remove($entity);
                    $em->flush();

                    $template =  $this->renderView('InnovaSelfBundle:Editor/partials:proposition.html.twig', array('test'=> $test, 'questionnaire' => $questionnaire, 'proposition' => null));
                }
                break;
        }

        return new Response($template);
    }

    /**
     * Create a mediaLimit entity or update one for a given media, and questionnaire
     */
    private function createMediaLimit($test, $questionnaire, $media, $limit)
    {
        $em = $this->getDoctrine()->getManager();

        if (!$mediaLimit = $em->getRepository('InnovaSelfBundle:MediaLimit')->findOneBy(array('test' => $test, 'questionnaire' => $questionnaire, 'media' => $media))) {
            $mediaLimit = new MediaLimit();
            $mediaLimit->setTest($test);
            $mediaLimit->setQuestionnaire($questionnaire);
            $mediaLimit->setMedia($media);
        }
        $mediaLimit->setListeningLimit($limit);

        $em->persist($mediaLimit);
        $em->flush();

        return $mediaLimit;
    }

    private function createProposition($subquestion, $media, $rightAnswer)
    {
        $em = $this->getDoctrine()->getManager();

        $proposition = new Proposition();
        $proposition->setSubquestion($subquestion);
        $proposition->setMedia($media);
        $proposition->setRightAnswer($rightAnswer);
        $em->persist($proposition);
        $em->flush();

        return $proposition;
    }

    private function createAppFakeAnswer($currentProposition)
    {
        $em = $this->getDoctrine()->getManager();

        $currentSubquestion = $currentProposition->getSubquestion();
        $question = $currentSubquestion->getQuestion();
        $subquestions = $question->getSubquestions();

        $propositions = array();

        // on ajoute aux autres subquestions des propositions
        foreach ($subquestions as $subquestion) {
            if ($subquestion != $currentSubquestion) {
                $propositions = $subquestion->getPropositions();
                $proposition = $this->createProposition($subquestion, $currentProposition->getMedia(), false);
            }
        }

        // reste à ajouter les propositions des autres à la subquestion courante.
        foreach ($propositions as $proposition) {
            $media = $proposition->getMedia();
            $mediaId = $proposition->getMedia()->getId();
            $found = false;
            foreach ($currentSubquestion->getPropositions() as $currentSubquestionProposition) {
                $currentMediaId = $currentSubquestionProposition->getMedia()->getId();
                if ($mediaId == $currentMediaId) {
                    $found = true;
                }
            }
            if ($found == false) {
                $proposition = $this->createProposition($currentSubquestion, $media, false);
            }
        }

        return;
    }

    private function appDeletePropositions($media, $question)
    {
        $em = $this->getDoctrine()->getManager();

        $subquestions = $question->getSubquestions();
        foreach ($subquestions as $subquestion) {
            $propositionToDelete = $em->getRepository('InnovaSelfBundle:Proposition')->findOneBy(array("subquestion" => $subquestion, "media" => $media));
            $em->remove($propositionToDelete);
        }
        $em->flush();

        return true;
    }
}
