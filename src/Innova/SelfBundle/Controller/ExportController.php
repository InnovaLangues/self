<?php

namespace Innova\SelfBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Innova\SelfBundle\Entity\Test;

/**
 * Class ExportController
 *
 * @Route(
 *      "",
 *      name = "",
 *      service = "innova_export"
 * )
 */
class ExportController
{
    protected $kernelRoot;
    protected $entityManager;
    protected $exportManager;


    public function __construct($kernelRoot, $entityManager, $exportManager)
    {
        $this->kernelRoot = $kernelRoot;
        $this->entityManager = $entityManager;
        $this->exportManager = $exportManager;

    }

    /**
     * Lists all Test entities.
     *
     * @Route(
     *     "/admin/export",
     *     name = "export",
     *     options = {"expose"=true}
     * )
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {

        $em = $this->entityManager;

        $tests = $em->getRepository('InnovaSelfBundle:Test')->findAll();

        return array(
            'tests' => $tests,
        );
    }


    /**
     * @Route(
     *     "/admin/test/{testId}/file/{filename}/{mode}",
     *     name = "get-file"
     * )
     *
     * @Method("GET")
     */
    public function getFileAction($testId, $filename, $mode)
    {

        if ($mode == "pdf") {
            $dir = "exportPdf";
        } else {
            $dir = "export";
        }

        $file = $this->kernelRoot ."/data/".$dir."/".$testId."/".$filename;

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
     * exportCsvSQL function
     * @Route(
     *     "/admin/csv-export/export/test/{testId}/{tia}",
     *     name = "csv-export"
     * )
     *
     * @Method("PUT")
     * @Template()
     */
    public function exportCsvAction($testId, $tia)
    {
        $test = $this->entityManager->getRepository('InnovaSelfBundle:Test')->find($testId);

        $csvName = $this->exportManager->exportCsvAction($test, $tia);
        $fileList = $this->exportManager->getFileList($test, "csv");

        return array(
            "csvName" => $csvName,
            'test' => $test,
            "fileList"=> $fileList,
            "tia"=> $tia
        );
    }

     /**
     * exportCsvSQL function
     * @Route(
     *     "/admin/csv-export/show/test/{testId}/{tia}",
     *     name = "csv-export-show"
     * )
     *
     * @Method("GET")
     * @Template("InnovaSelfBundle:Export:exportCsv.html.twig")
     */
    public function showCsvAction($testId, $tia)
    {
        $test = $this->entityManager->getRepository('InnovaSelfBundle:Test')->find($testId);

        $fileList = $this->exportManager->getFileList($test, "csv");

        return array(
            'test' => $test,
            "fileList"=> $fileList,
            "tia"=> $tia
        );
    }

     /**
     * exportPdf function
     * @Route(
     *     "/admin/pdf-export/test/{id}",
     *     name = "pdf-export"
     * )
     *
     * @Method("PUT")
     * @Template("InnovaSelfBundle:Export:exportPdf.html.twig")
     */
    public function exportPdfAction(Test $test)
    {

        // Génération du nom du fichier exporté
        $pdfName = $this->exportManager->exportPdfAction($test);

        // Appel de la vue et de la génération du PDF
        $fileList = $this->exportManager->getFileList($test, "pdf");

        return array(
            "pdfName" => $pdfName,
            "test" => $test,
            "fileList"=> $fileList,
        );
    }

    /**
     * exportPdf function
     * @Route(
     *     "/admin/pdf-export/show/test/{id}",
     *     name = "pdf-export-show"
     * )
     *
     * @Method("GET")
     * @Template("InnovaSelfBundle:Export:exportPdf.html.twig")
     */
    public function showPdfAction(Test $test)
    {
        // Appel de la vue et de la génération du PDF
        $fileList = $this->exportManager->getFileList($test, "pdf");

        return array(
            "test" => $test,
            "fileList"=> $fileList,
        );
    }



}
