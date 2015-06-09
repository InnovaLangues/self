<?php

namespace Innova\SelfBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpFoundation\Response;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Session;

/**
 * Class ExportController
 *
 * @Route(
 *      "",
 *      name = "",
 *      service = "innova_export"
 * )
 * @ParamConverter("test", isOptional="true", class="InnovaSelfBundle:Test",  options={"id" = "testId"})
 * @ParamConverter("session", isOptional="true", class="InnovaSelfBundle:Session",  options={"id" = "sessionId"})
 * @ParamConverter("user", isOptional="true", class="InnovaSelfBundle:User",  options={"id" = "userId"})
 */
class ExportController
{
    protected $kernelRoot;
    protected $entityManager;
    protected $exportManager;
    protected $securityContext;

    public function __construct($kernelRoot, $entityManager, $exportManager, $securityContext)
    {
        $this->kernelRoot = $kernelRoot;
        $this->entityManager = $entityManager;
        $this->exportManager = $exportManager;
        $this->securityContext = $securityContext;
        $this->user = $this->securityContext->getToken()->getUser();
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
     * @Cache(sMaxAge=0)
     * @Template("InnovaSelfBundle:Export:index.html.twig")
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
     * @Cache(sMaxAge=0)
     */
    public function getFileAction($testId, $filename, $mode)
    {
        if ($mode == "pdf") {
            $dir = "exportPdf";
        } else {
            $dir = "export";
        }

        $file = $this->kernelRoot."/data/".$dir."/".$testId."/".$filename;

        $response = new Response();
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($file));
        $response->headers->set('Content-Disposition', 'attachment; filename="'.basename($file).'";');
        $response->headers->set('Content-length', filesize($file));
        $response->sendHeaders();

        $response->setContent(file_get_contents($file));

        return $response;
    }

    /**
     * exportCsvSQL function
     * @Route(
     *     "/admin/csv-export/export/test/{testId}/{sessionId}/{tia}",
     *     name = "csv-export"
     * )
     *
     * @Method("PUT")
     * @Cache(sMaxAge=0)
     * @Template("InnovaSelfBundle:Export:exportCsv.html.twig")
     */
    public function exportCsvAction(Test $test, Session $session, $tia)
    {
        $csvName = $this->exportManager->exportCsvAction($test, $session, $tia);
        $fileList = $this->exportManager->getFileList($test, "csv");

        return array(
            "csvName" => $csvName,
            'test' => $test,
            "fileList" => $fileList,
            "tia" => $tia,
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
     * @Cache(sMaxAge=0)
     * @Template("InnovaSelfBundle:Export:exportCsv.html.twig")
     */
    public function showCsvAction(Test $test, $tia)
    {
        $fileList = $this->exportManager->getFileList($test, "csv");

        return array(
            'test' => $test,
            "fileList" => $fileList,
            "tia" => $tia,
        );
    }

     /**
     * exportPdf function
     * @Route(
     *     "/admin/pdf-export/test/{testId}",
     *     name = "pdf-export"
     * )
     *
     * @Method("PUT")
     * @Cache(sMaxAge=0)
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
            "fileList" => $fileList,
        );
    }

    /**
     * exportPdf function
     * @Route(
     *     "/admin/pdf-export/show/test/{testId}",
     *     name = "pdf-export-show"
     * )
     *
     * @Method("GET")
     * @Cache(sMaxAge=0)
     * @Template("InnovaSelfBundle:Export:exportPdf.html.twig")
     */
    public function showPdfAction(Test $test)
    {
        // Appel de la vue et de la génération du PDF
        $fileList = $this->exportManager->getFileList($test, "pdf");

        return array(
            "test" => $test,
            "fileList" => $fileList,
        );
    }

    /**
     * exportPdf function
     * @Route(
     *     "/student/pdf-export/session/{sessionId}",
     *     name = "pdf-export-session-user"
     * )
     *
     * @Method("GET")
     * @Cache(sMaxAge=0)
     */
    public function exportSessionUserPdfAction(Session $session)
    {
        $pdf = $this->exportManager->exportSessionUserPdfAction($session, $this->user);

        $response = new Response();
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($pdf));
        $response->headers->set('Content-Disposition', 'attachment; filename="'.basename($pdf).'";');
        $response->headers->set('Content-length', filesize($pdf));
        $response->sendHeaders();

        $response->setContent(file_get_contents($pdf));

        return $response;
    }

    /**
     * exportPdf function
     * @Route(
     *     "/admin/pdf-export/session/{sessionId}/user/{userId}",
     *     name = "admin-pdf-export-session-user"
     * )
     *
     * @Method("GET")
     * @Cache(sMaxAge=0)
     */
    public function exportSessionUserPdfAdminAction(Session $session, User $user)
    {
        $pdf = $this->exportManager->exportSessionUserPdfAction($session, $user);

        $response = new Response();
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($pdf));
        $response->headers->set('Content-Disposition', 'attachment; filename="'.basename($pdf).'";');
        $response->headers->set('Content-length', filesize($pdf));
        $response->sendHeaders();

        $response->setContent(file_get_contents($pdf));

        return $response;
    }
}
