<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class UploadController
 * @Route(
 *      "admin/editor",
 *      name    = "",
 *      service = "innova_editor_upload"
 * )
 */
class UploadController extends Controller
{
    protected $kernelRoot;
    protected $request;

    public function __construct($kernelRoot)
    {
        $this->kernelRoot = $kernelRoot;
    }

    public function setRequest(Request $request = null)
    {
        $this->request = $request;

        return $this;
    }

    /**
     *
     * @Route("/questionnaires/upload-file", name="editor_questionnaire_upload-file", options={"expose"=true})
     * @Method("POST")
     */
    public function uploadFileAction()
    {
        $request = $this->request;
        $fileType = $request->get("file-type");

        foreach ($request->files as $uploadedFile) {
            $originalName = $uploadedFile->getClientOriginalName();
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);
            $newName = uniqid(). "." . $ext;

            $directory = $this->kernelRoot.'/../web/upload/media/';
            $uploadedFile->move($directory, $newName);
        }

        return new JsonResponse(
            array(
                'url' => $newName,
            )
        );
    }

}
