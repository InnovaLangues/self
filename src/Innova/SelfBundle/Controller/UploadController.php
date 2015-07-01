<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

/**
 * Class UploadController
 * @Route(
 *      "/admin",
 *      name    = "",
 *      service = "innova_editor_upload"
 * )
 */
class UploadController extends Controller
{
    protected $kernelRoot;

    public function __construct($kernelRoot)
    {
        $this->kernelRoot = $kernelRoot;
    }

    /**
     *
     * @Route("/upload-file", name="editor_questionnaire_upload-file", options={"expose"=true})
     * @Method("POST")
     * 
     */
    public function uploadFileAction(Request $request)
    {
        $authorizedExtensions = array('png', 'mp3', 'jpg', 'jpeg', 'webm', 'gif');
        $msg = "";
        $newName = "";

        foreach ($request->files as $uploadedFile) {
            $originalName = $uploadedFile->getClientOriginalName();
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);

            if (in_array(strtolower($ext), $authorizedExtensions)) {
                $newName = uniqid().".".$ext;
                $directory = $this->kernelRoot.'/../web/upload/media/';
                $uploadedFile->move($directory, $newName);
            } else {
                $msg = "Wrong file type ('png', 'mp3', 'jpg', 'jpeg', 'webm', 'gif')";
            }
        }

        return new JsonResponse(
            array(
                'url' => $newName,
                'msg' => $msg,
            )
        );
    }

    /**
     *
     * @Route("/crop-image", name="editor_crop_image", options={"expose"=true})
     * @Method("PUT")
     * 
     */
    public function cropImageAction(Request $request)
    {
        $url = $request->get("url");
        $x = $request->get("x");
        $y = $request->get("y");
        $w = $request->get("w");
        $h = $request->get("h");

        $src = $this->kernelRoot.'/../web/upload/media/'.basename($url);

        $type = strtolower(substr(strrchr($src, "."), 1));
        if ($type == 'jpeg') {
            $type = 'jpg';
        }
        switch ($type) {
            case 'bmp': $img_r = imagecreatefromwbmp($src); break;
            case 'gif': $img_r = imagecreatefromgif($src); break;
            case 'jpg': $img_r = imagecreatefromjpeg($src); break;
            case 'png': $img_r = imagecreatefrompng($src); break;
            default : return "Unsupported picture type!";
        }

        $dst_r = ImageCreateTrueColor($w, $h);
        imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $w, $h, $w, $h);

        switch ($type) {
            case 'bmp': imagewbmp($dst_r, $src); break;
            case 'gif': imagegif($dst_r, $src); break;
            case 'jpg': imagejpeg($dst_r, $src); break;
            case 'png': imagepng($dst_r, $src); break;
        }

        return new JsonResponse(
            array()
        );
    }
}
