<?php

namespace Innova\SelfBundle\Manager;

use Symfony\Component\Filesystem\Filesystem;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Subquestion;

class ExportTestManager
{
    protected $entityManager;
    protected $kernelRoot;
    protected $knpSnappyPdf;
    protected $templating;
    protected $exportManager;

    public function __construct($entityManager, $kernelRoot, $knpSnappyPdf, $templating, $exportManager)
    {
        $this->entityManager    = $entityManager;
        $this->kernelRoot       = $kernelRoot;
        $this->knpSnappyPdf     = $knpSnappyPdf;
        $this->templating       = $templating;
        $this->exportManager    = $exportManager;
    }

    public function exportPdf(Test $test)
    {
        $em = $this->entityManager;
        $pdfName = "self_export-pdf-test_".$test->getId()."-".date("d-m-Y_H:i:s").'.pdf';
        $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->getByTest($test);

        // Appel de la vue et de la génération du PDF
        $this->knpSnappyPdf->generateFromHtml(
            $this->templating->render(
                'InnovaSelfBundle:Export:templatePdf.html.twig', array('test' => $test, 'questionnaires' => $questionnaires)),
                $this->kernelRoot."/data/exportPdf/".$test->getId()."/".$pdfName
        );

        return $pdfName;
    }

    public function generateCsv(Test $test)
    {
        $fs = new Filesystem();
        $testId = $test->getId();

        $csvName = "self_export-test_".$testId."-".date("d-m-Y_H:i:s").'.csv';
        $csvPathExport = $this->kernelRoot."/data/export/".$testId."/";

        $fs->mkdir($csvPathExport, 0777);
        $csvh = fopen($csvPathExport."/".$csvName, 'w+');

        $csvContent = $this->getCsvContent($test);
        fwrite($csvh, $csvContent);
        fclose($csvh);

        $file = $this->kernelRoot."/data/export/".$test->getId()."/".$csvName;
        $response = $this->exportManager->generateResponse($file);

        return $response;
    }

    private function getCsvContent(Test $test)
    {
        $csv        = "";
        $taskCount  = 0;
        $itemCount  = 0;

        $this->exportManager->addColumn($test->getName());
        $csv .= $this->addLine();
        $csv .= $this->exportManager->addColumn("n° tâche");
        $csv .= $this->exportManager->addColumn("n° item");
        $csv .= $this->exportManager->addColumn("position");
        $csv .= $this->exportManager->addColumn("clés");
        $csv .= $this->exportManager->addColumn("nb options");
        $csv .= $this->exportManager->addColumn("");
        $csv .= $this->exportManager->addColumn("typologie");
        $csv .= $this->exportManager->addColumn("nom de l'item");

        $em = $this->entityManager;
        $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->getByTest($test);
        foreach ($questionnaires as $questionnaire) {
            $taskCount++;
            $subquestions = $questionnaire->getQuestions()[0]->getSubquestions();
            $taskPosition = $this->exportManager->getTaskPosition($test, $questionnaire);
            foreach ($subquestions as $subq) {
                $itemCount++;
                $propsInfos = $this->getPropsInfos($subq);
                $csv .= $this->addLine();
                $csv .= $this->exportManager->addColumn($taskCount);
                $csv .= $this->exportManager->addColumn($itemCount);
                $csv .= $this->exportManager->addColumn($taskPosition);
                $csv .= $this->exportManager->addColumn($propsInfos[0]);
                $csv .= $this->exportManager->addColumn($propsInfos[1]);
                $csv .= $this->exportManager->addColumn("");
                $csv .= $this->exportManager->addColumn($propsInfos[2]);
                $csv .= $this->exportManager->addColumn($propsInfos[3]);
            }
        }

        return $csv;
    }

    private function getPropsInfos(Subquestion $subquestion)
    {
        $keys = "";
        $propCount  = 0;
        $em = $this->entityManager;
        $propositions = $em->getRepository('InnovaSelfBundle:Proposition')->getBySubquestionExcludingAnswers($subquestion);
        foreach ($propositions as $prop) {
            $propCount++;
            if ($prop->getRightAnswer()) {
                $keys .= $this->exportManager->intToLetter($propCount);
            }
        }

        $optionCount = count($propositions);

        $typo = $subquestion->getTypology()->getName();
        if ($typo == "TLQROC") {
            $optionCount = 1;
            $keys = "A";
        }

        $item = $subquestion->getQuestion()->getQuestionnaire()->getTheme();

        return array($keys, $optionCount, $typo, $item);
    }

    private function addLine()
    {
        $newLine = "\n";

        return $newLine;
    }
}
