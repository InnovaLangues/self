<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Innova\SelfBundle\Entity\Media;
use Innova\SelfBundle\Entity\Subquestion;
/**
 * Main controller.
 *
 * @Route("admin/editor/ajax")
 */
class UploadController extends Controller
{
    
     /**
     *
     * @Route("/questionnaires/upload-image", name="editor_questionnaire_upload-image", options={"expose"=true})
     * @Method("POST")
     */
    public function uploadImageAction()
    {
        $request = $this->get('request');

        foreach ($request->files as $uploadedFile) {
            $originalName = $uploadedFile->getClientOriginalName();
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);
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
     * @Route("/questionnaires/upload-audio", name="editor_questionnaire_upload-audio", options={"expose"=true})
     * @Method("POST")
     */
    public function uploadAudioAction()
    {
        $request = $this->get('request');

        foreach ($request->files as $uploadedFile) {
            $originalName = $uploadedFile->getClientOriginalName();
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);
            $newName = uniqid();

            //convertir en ogg
            $directory = __DIR__.'/../../../../../web/upload/media/';
            $file = $uploadedFile->move($directory, $newName.".".$ext);
        }

        return new JsonResponse(
            array(
                'url' => $newName,
            )
        );
    }

    /**
     *
     * @Route("/questionnaires/upload-video", name="editor_questionnaire_upload-video", options={"expose"=true})
     * @Method("POST")
     */
    public function uploadVideoAction()
    {
        $request = $this->get('request');

        foreach ($request->files as $uploadedFile) {
            $originalName = $uploadedFile->getClientOriginalName();
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);

            // tester si ext == webm
            $newName = uniqid();

            $directory = __DIR__.'/../../../../../web/upload/media/';
            $file = $uploadedFile->move($directory, $newName);
        }

        return new JsonResponse(
            array(
                'url' => $newName,
            )
        );
    }
}
