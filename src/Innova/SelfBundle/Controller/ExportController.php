<?php

namespace Innova\SelfBundle\Controller;

use Innova\SelfBundle\Exception\ExportTimeoutException;
use Innova\SelfBundle\Manager\ExportManager;
use Innova\SelfBundle\Manager\Right\RightManager;
use Innova\SelfBundle\Voter\Voter;
use Symfony\Component\Debug\Exception\OutOfMemoryException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
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
    protected $tokenStorage;
    protected $rightManager;
    protected $voter;
    protected $user;
    protected $flashBag;

    public function __construct(
        string $kernelRoot,
        ExportManager $exportManager,
        TokenStorageInterface $tokenStorage,
        RightManager $rightManager,
        Voter $voter,
        \Symfony\Component\HttpFoundation\Session\Session $session
    ) {
        $this->kernelRoot = $kernelRoot;
        $this->exportManager = $exportManager;
        $this->tokenStorage = $tokenStorage;
        $this->rightManager = $rightManager;
        $this->voter = $voter;
        $this->user = $this->tokenStorage->getToken()->getUser();
        $this->flashBag = $session->getFlashBag();
    }

    /**
     * @Route("admin/export/test/{testId}/file/{filename}/{mode}", name = "get-file")
     * @Method("GET")
     */
    public function getFileAction($testId, $filename, $mode)
    {
        if ($this->rightManager->checkRight('right.exportPDF', $this->user) ||
            $this->rightManager->checkRight('right.exportCSV', $this->user)
        ) {
            $dir = $mode === 'pdf' ? 'exportPdf' : 'export';
            $file = $this->kernelRoot.'/data/'.$dir.'/'.$testId.'/'.$filename;
            return $this->exportManager->generateResponse($file);
        }

        return;
    }


    /**
     * Export a session
     *
     * @Route("admin/export/csv/test/{testId}/session/{sessionId}/mode/{tia}", name="csv-export-with-dates")
     * @Method("POST")
     * @Template("InnovaSelfBundle:Export:exportCsv.html.twig")
     */
    public function exportCsvWithDatesAction(Request $request, Test $test, Session $session, $tia)
    {
        $this->voter->isAllowed('right.exportCSV');

        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');

        $csvName = null;
        $failed = false;

        try {
            $csvName = $this->exportManager->generateCsv($test, $session, $tia, $startDate, $endDate);
        } catch (ExportTimeoutException $e) {
            $this->flashBag->add('danger', "Impossible de réaliser l'export demandé, celui-ci est trop volumineux.");
        } catch (OutOfMemoryException $e) { // inutile ?
            $this->flashBag->add('danger', "Impossible de réaliser l'export demandé, celui-ci est trop volumineux.");
        }

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
