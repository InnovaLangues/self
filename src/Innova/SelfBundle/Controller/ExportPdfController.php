<?php

namespace Innova\SelfBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ExportPdfController
 *
 * @Route(
 *      "",
 *      name = "",
 *      service = "innova_pdf_export"
 * )
 */
class ExportPdfController
{
    protected $kernelRoot;
    protected $entityPdfManager;
    protected $exportPdfManager;

    public function __construct($kernelRoot, $entityPdfManager, $exportPdfManager)
    {
        $this->kernelRoot = $kernelRoot;
        $this->entityPdfManager = $entityPdfManager;
        $this->exportPdfManager = $exportPdfManager;
    }

    /**
     * Lists all Test entities.
     *
     * @Route(
     *     "/admin/pdf",
     *     name = "pdf_export",
     *     options = {"expose"=true}
     * )
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {

        $em = $this->entityPdfManager;

        $tests = $em->getRepository('InnovaSelfBundle:Test')->findAll();

        return array(
            'tests' => $tests,
        );
    }


    /**
     * @Route(
     *     "/admin/test/{testId}/file/{filename}",
     *     name = "get-file"
     * )
     *
     * @Method("GET")
     */
    public function getFileAction($testId, $filename)
    {
        $file = $this->kernelRoot ."/data/export/".$testId."/".$filename;

        $response = new Response();
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($file));
        $response->headers->set('Content-Disposition', 'attachment; filename="' . basename($file) . '";');
        $response->headers->set('Content-length', filesize($file));
        $response->sendHeaders();

        $response->setContent(file_get_contents($file));

        return $response;
    }

    /**
     * exportPdf function
     * @Route(
     *     "/admin/pdf-export/test/{testId}",
     *     name = "pdf-export"
     * )
     *
     * @Method("PUT")
     * @Template()
     */
    public function exportPdfAction($testId)
    {
        $test = $this->entityPdfManager->getRepository('InnovaSelfBundle:Test')->find($testId);

        $pdfName = $this->exportPdfManager->exportPdfAction($test);
        $fileList = $this->exportPdfManager->getFileList($test);

        return array(
            "pdfName" => $pdfName,
            'test' => $test,
            "fileList"=> $fileList,
        );
    }


}
