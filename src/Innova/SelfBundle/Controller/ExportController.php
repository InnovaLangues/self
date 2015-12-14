<?php

namespace Innova\SelfBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Session;

/**
 * Class ExportController.
 *
 * @Route(service = "innova_export")
 *
 * @ParamConverter("test", isOptional="true", class="InnovaSelfBundle:Test",  options={"id" = "testId"})
 * @ParamConverter("session", isOptional="true", class="InnovaSelfBundle:Session",  options={"id" = "sessionId"})
 * @ParamConverter("user", isOptional="true", class="InnovaSelfBundle:User",  options={"id" = "userId"})
 */
class ExportController
{
    protected $kernelRoot;
    protected $exportManager;
    protected $securityContext;
    protected $rightManager;
    protected $voter;
    protected $fileSystem;
    protected $user;

    public function __construct($kernelRoot, $exportManager, $securityContext, $rightManager, $voter, $fileSystem)
    {
        $this->kernelRoot = $kernelRoot;
        $this->exportManager = $exportManager;
        $this->securityContext = $securityContext;
        $this->rightManager = $rightManager;
        $this->voter = $voter;
        $this->fileSystem = $fileSystem;
        $this->user = $this->securityContext->getToken()->getUser();
    }

    /**
     * @Route("admin/export/test/{testId}/file/{filename}/{mode}", name = "get-file")
     * @Method("GET")
     */
    public function getFileAction($testId, $filename, $mode)
    {
        if ($this->rightManager->checkRight('right.exportPDF', $this->user) || $this->rightManager->checkRight('right.exportCSV', $this->user)) {
            $file = $this->fileSystem->getFile('private', 'test/'.$testId.'/'.$mode.'/'.$filename);
            $response = $this->exportManager->generateResponse($file);

            return $response;
        }

        return;
    }

    /**
     * exportCsvSQL function.
     *
     * @Route("admin/export/csv/test/{testId}/session/{sessionId}/mode/{tia}", name = "csv-export")
     * @Method("PUT")
     * @Template("InnovaSelfBundle:Export:exportCsv.html.twig")
     */
    public function exportCsvAction(Test $test, Session $session, $tia)
    {
        $this->voter->isAllowed('right.exportCSV');

        $csvName = $this->exportManager->generateCsv($test, $session, $tia);
        $fileList = $this->exportManager->getFileList($test, 'csv');

        return array(
            'csvName' => $csvName,
            'test' => $test,
            'fileList' => $fileList,
            'tia' => $tia,
        );
    }

    /**
     * List CSV export files for a given test.
     *
     * @Route("admin/export/csv/filelist/test/{testId}/{tia}", name = "csv-export-show")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Export:exportCsv.html.twig")
     */
    public function showCsvAction(Test $test, $tia)
    {
        $this->voter->isAllowed('right.exportCSV');

        $fileList = $this->exportManager->getFileList($test, 'csv');

        return array(
            'test' => $test,
            'fileList' => $fileList,
            'tia' => $tia,
        );
    }

    /**
     * Export result session PDF for current user.
     *
     * @Route("/self-export/pdf-export-session/session/{sessionId}", name = "pdf-export-session-user")
     * @Method("GET")
     */
    public function exportSessionUserPdfAction(Session $session)
    {
        $response = $this->exportManager->exportSessionUserPdfAction($session, $this->user);

        return $response;
    }

    /**
     * Export result session PDF for a given user.
     *
     * @Route("admin/export/pdf-export-session/session/{sessionId}/user/{userId}", name = "admin-pdf-export-session-user")
     * @Method("GET")
     */
    public function exportSessionUserPdfAdminAction(Session $session, User $user)
    {
        $this->voter->isAllowed('right.individualresultssession', $session);

        $response = $this->exportManager->exportSessionUserPdfAction($session, $user);

        return $response;
    }
}
