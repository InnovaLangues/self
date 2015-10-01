<?php

namespace Innova\SelfBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Session;

/**
 * Class ExportController
 * @Route(
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
    protected $rightManager;

    public function __construct($kernelRoot, $entityManager, $exportManager, $securityContext, $rightManager)
    {
        $this->kernelRoot       = $kernelRoot;
        $this->entityManager    = $entityManager;
        $this->exportManager    = $exportManager;
        $this->securityContext  = $securityContext;
        $this->rightManager     = $rightManager;
        $this->user = $this->securityContext->getToken()->getUser();
    }

    /**
     * Lists all Test entities.
     *
     * @Route(
     *     "admin/export",
     *     name = "export",
     *     options = {"expose"=true}
     * )
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Export:index.html.twig")
     */
    public function indexAction()
    {
        if ($this->rightManager->checkRight("right.exportPDF", $this->user) || $this->rightManager->checkRight("right.exportCSV", $this->user)) {
            $em = $this->entityManager;

            $tests = $em->getRepository('InnovaSelfBundle:Test')->findAll();

            return array(
                'tests' => $tests,
            );
        }

        return;
    }

    /**
     * @Route(
     *     "admin/export/test/{testId}/file/{filename}/{mode}",
     *     name = "get-file"
     * )
     *
     * @Method("GET")
     *
     */
    public function getFileAction($testId, $filename, $mode)
    {
        if ($this->rightManager->checkRight("right.exportPDF", $this->user) || $this->rightManager->checkRight("right.exportCSV", $this->user)) {
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

        return;
    }

    /**
     * exportCsvSQL function
     * @Route(
     *     "admin/export/csv/test/{testId}/session/{sessionId}/mode/{tia}",
     *     name = "csv-export"
     * )
     *
     * @Method("PUT")
     *
     * @Template("InnovaSelfBundle:Export:exportCsv.html.twig")
     */
    public function exportCsvAction(Test $test, Session $session, $tia)
    {
        if ($this->rightManager->checkRight("right.exportCSV", $this->user)) {
            $csvName = $this->exportManager->exportCsvAction($test, $session, $tia);
            $fileList = $this->exportManager->getFileList($test, "csv");

            return array(
                "csvName" => $csvName,
                'test' => $test,
                "fileList" => $fileList,
                "tia" => $tia,
            );
        }

        return;
    }

     /**
     * exportCsvSQL function
     * @Route(
     *     "admin/export/csv/filelist/test/{testId}/{tia}",
     *     name = "csv-export-show"
     * )
     *
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Export:exportCsv.html.twig")
     */
    public function showCsvAction(Test $test, $tia)
    {
        if ($this->rightManager->checkRight("right.exportCSV", $this->user)) {
            $fileList = $this->exportManager->getFileList($test, "csv");

            return array(
                'test' => $test,
                "fileList" => $fileList,
                "tia" => $tia,
            );
        }

        return;
    }

    /**
     * exportPdf function
     * @Route(
     *     "/self-export/pdf-export-session/session/{sessionId}",
     *     name = "pdf-export-session-user"
     * )
     *
     * @Method("GET")
     *
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
     *     "admin/export/pdf-export-session/session/{sessionId}/user/{userId}",
     *     name = "admin-pdf-export-session-user"
     * )
     *
     * @Method("GET")
     *
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
