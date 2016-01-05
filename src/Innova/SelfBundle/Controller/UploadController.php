<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class UploadController.
 *
 * @Route(
 *      "/admin",
 *      name    = "",
 *      service = "innova_editor_upload"
 * )
 */
class UploadController extends Controller
{
    protected $kernelRoot;
    protected $fileSystemManager;

    public function __construct($kernelRoot, $fileSystemManager)
    {
        $this->kernelRoot = $kernelRoot;
        $this->fileSystemManager = $fileSystemManager;
    }

    /**
     * @Route("/upload-file", name="editor_questionnaire_upload-file", options={"expose"=true})
     * @Method("POST")
     */
    public function uploadFileAction(Request $request)
    {
        $authorizedExtensions = array('png', 'mp3', 'jpg', 'jpeg', 'webm', 'gif');
        $msg = '';
        $newName = '';

        foreach ($request->files as $file) {
            $originalName = $file->getClientOriginalName();
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);

            if (in_array(strtolower($ext), $authorizedExtensions)) {
                $newName = uniqid().'.'.$ext;
                $this->fileSystemManager->writeFile('public', $newName, file_get_contents($file->getPathname()));
            } else {
                $msg = "Upload error. Wrong file type ('png', 'mp3', 'jpg', 'jpeg', 'webm', 'gif')";
            }
        }

        return new JsonResponse(
            array(
                'url' => $newName,
                'msg' => $msg,
            )
        );
    }
}
