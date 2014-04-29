<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Innova\SelfBundle\Entity\Media;

/**
 * Main controller.
 *
 * @Route("/ajax")
 */
class AjaxController extends Controller
{

    /**
     * Vérify if the session variable is OK and initialize if not.
     *
     * @Route("/edit-media", name="edit-media", options={"expose"=true})
     * @Method("GET")
     */
    public function editMedia()
    {
        $em = $this->getDoctrine()->getManager();

        $request = $this->container->get('request');
        $mediaId = $request->query->get('id');
        
        $media = $em->getRepository('InnovaSelfBundle:Media')->findOneById($mediaId);

        return new JsonResponse(
            array(
                'id' => $media->getId(),
                'type' => $media->getMediaType()->getName(),
                'description' => $media->getDescription(),
            )
        );
    }

    /**
     * Delete a Questionnaire entity
     *
     * @Route("/questionnaires/set-theme", name="editor_questionnaire_set-theme", options={"expose"=true})
     * @Method("POST")
     */
    public function setThemeAction()
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();
        $questionnaireId = $request->request->get('questionnaireId');
        $theme = $request->request->get('theme');

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        $questionnaire->setTheme($theme);
        $em->persist($questionnaire);
        $em->flush();

        return new JsonResponse(
            array(
                'theme' => $questionnaire->getTheme(),
            )
        );
    }

     /**
     *
     * @Route("/questionnaires/upload-image", name="editor_questionnaire_upload-image", options={"expose"=true})
     * @Method("POST")
     */
    public function uploadImageAction()
    {
        $request = $this->get('request');

        foreach($request->files as $uploadedFile) {
            $originalName = $uploadedFile->getClientOriginalName();
            $ext = pathinfo($originalName, PATHINFO_EXTENSION); //$ext will be gif
            $newName = uniqid(). "." . $ext;

            $directory = __DIR__.'/../../../../../web/upload/media/';
            $file = $uploadedFile->move($directory, $newName);
        }

        return new JsonResponse(
            array(
                'url' => $newName,
            )
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

        /* Création du nouveau media */
        $name = $request->request->get('name');
        $description = $request->request->get('description');
        $url = $request->request->get('url');
        $type = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName($request->request->get('type'));

        $media = new Media;
        $media->setMediaType($type);
        $media->setName($name);
        $media->setDescription($description);
        $media->setUrl($url);

        $em->persist($media);
        $em->flush();

        /* Création de la relation avec une entité */
        $entityType = $request->request->get('entityType');
        $entityId = $request->request->get('entityId');
        $entityField = $request->request->get('entityField');

        switch ($entityType) {
            case "questionnaire": 
                $entity =  $em->getRepository('InnovaSelfBundle:Questionnaire')->findOneById($entityId);
                if ($entityField == "contexte"){
                    $entity->setMediaContext($media);
                } elseif ($entityField == "consigne") {
                    $entity->setMediaInstruction($media);
                } elseif ($entityField == "texte") {
                    $entity->setMediaText($media);
                } 
                break;
            case "subquestion":
                break;
            case "proposition":
                break;
        }

        $em->persist($entity);
        $em->flush();

        return new JsonResponse(
            array(
                'mediaId' => $media->getId(),
            )
        );
    }


}
