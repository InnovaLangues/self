<?php

namespace Innova\SelfBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\User;
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
     *     "/admin/csv",
     *     name = "csv_export",
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

        $response->setContent(readfile($file));

        return $response;
    }

    /**
     * exportCsvSQL function   
     * @Route(
     *     "/admin/csv-export/test/{testId}/{tia}",
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
        $fileList = $this->exportManager->getFileList($test);

        return array(
            "csvName" => $csvName,
            'test' => $test,
            "fileList"=> $fileList,
        );
    }

}
