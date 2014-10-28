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
    protected $knpSnappyPdf;
    protected $templating;

    public function __construct($kernelRoot, $entityPdfManager, $exportPdfManager, $knpSnappyPdf, $templating)
    {
        $this->kernelRoot = $kernelRoot;
        $this->entityPdfManager = $entityPdfManager;
        $this->exportPdfManager = $exportPdfManager;
        $this->knpSnappyPdf = $knpSnappyPdf;
        $this->templating = $templating;
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
        $file = $this->kernelRoot ."/data/exportPdf/".$testId."/".$filename;

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

        // Récupération des données du test exporté
        $test = $this->entityPdfManager->getRepository('InnovaSelfBundle:Test')->find($testId);
        $orderQuestionnaireTest = $this->entityPdfManager->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')
                                ->findByTest(array('test' => $test));

//var_dump($orderQuestionnaireTest);die();
        // Génération du nom du fichier exporté
        $pdfName = $this->exportPdfManager->exportPdfAction($test);

        // Appel de la vue et de la génération du PDF
        $this->knpSnappyPdf->generateFromHtml(
            $this->templating->render(
                'InnovaSelfBundle:ExportPdf:export.html.twig',
                array(
                    'test' => $test,
                    'orderQuestionnaires' => $orderQuestionnaireTest
                )
            ),
            $this->kernelRoot ."/data/exportPdf/".$testId."/". $pdfName
        );


        // Appel de la vue et de la génération du PDF
        $fileList = $this->exportPdfManager->getFileList($test);

        return array(
            "pdfName" => $pdfName,
            "test" => $test,
            "fileList"=> $fileList,
        );
    }


}
