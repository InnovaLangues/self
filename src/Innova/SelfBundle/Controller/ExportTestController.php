<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Test;

/**
 * @ParamConverter("test", isOptional="true", class="InnovaSelfBundle:Test",  options={"id" = "testId"})
 */
class ExportTestController extends Controller
{
    /**
     * @Route("admin/export/csv/test/{testId}", name = "test-export-csv")
     * @Method("GET")
     */
    public function exportCsvAction(Test $test)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        if ($this->get("self.right.manager")->checkRight("right.exportCSV", $currentUser)) {
            $fileName    = $this->get("self.testexport.manager")->exportCsvAction($test);
            $file        = $this->get('kernel')->getRootDir()."/data/export/".$test->getId()."/".$fileName;

            $response = new Response();
            $response->headers->set('Cache-Control', 'private');
            $response->headers->set('Content-type', mime_content_type($file));
            $response->headers->set('Content-Disposition', 'attachment; filename="'.basename($file).'";');
            $response->headers->set('Content-length', filesize($file));
            $response->sendHeaders();

            $response->setContent(file_get_contents($file));

            return $response;
        }

        return;
    }

    /**
     * @Route("admin/export/pdf/test/{testId}", name = "pdf-export")
     * @Method({"GET", "PUT"})
     * @Template("InnovaSelfBundle:Export:exportPdf.html.twig")
     */
    public function exportPdfAction(Test $test)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.exportPDF", $currentUser)) {
            $pdfName    = $this->get("self.testexport.manager")->exportPdfAction($test);
            $fileList   = $this->get("self.export.manager")->getFileList($test, "pdf");

            return array(
                "pdfName"   => $pdfName,
                "test"      => $test,
                "fileList"  => $fileList,
            );
        }

        return;
    }

    /**
     * @Route("admin/export/pdf/filelist/test/{testId}",name = "pdf-export-show")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Export:exportPdf.html.twig")
     */
    public function showPdfAction(Test $test)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        if ($this->get("self.right.manager")->checkRight("right.exportPDF", $currentUser)) {
            $fileList = $this->get("self.export.manager")->getFileList($test, "pdf");

            return array(
                "test"        => $test,
                "fileList"    => $fileList,
            );
        }

        return;
    }
}
