<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Test;
use Symfony\Component\Filesystem\Filesystem;

class ExportTestManager
{
    protected $entityManager;
    protected $kernelRoot;
    protected $knpSnappyPdf;
    protected $templating;

    public function __construct($entityManager, $kernelRoot, $knpSnappyPdf, $templating)
    {
        $this->entityManager = $entityManager;
        $this->kernelRoot = $kernelRoot;
        $this->knpSnappyPdf = $knpSnappyPdf;
        $this->templating = $templating;
    }

    public function exportPdfAction(Test $test)
    {
        $testId = $test->getId();
        $pdfName = "self_export-pdf-test_".$testId."-".date("d-m-Y_H:i:s").'.pdf';

        // Appel de la vue et de la génération du PDF
        $this->knpSnappyPdf->generateFromHtml(
            $this->templating->render(
                'InnovaSelfBundle:Export:templatePdf.html.twig', array('test' => $test)),
                $this->kernelRoot."/data/exportPdf/".$test->getId()."/".$pdfName
        );

        return $pdfName;
    }

    public function exportCsvAction(Test $test)
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

        return $csvName;
    }

    private function getCsvContent(Test $test)
    {
        $csv        = "";
        $taskCount  = 0;
        $itemCount  = 0;

        $this->addColumn($test->getName());
        $csv .= $this->addLine();
        $csv .= $this->addColumn("n° tâche");
        $csv .= $this->addColumn("n° item");
        $csv .= $this->addColumn("clés");
        $csv .= $this->addColumn("nb options");
        $csv .= $this->addColumn("");
        $csv .= $this->addColumn("typologie");
        $csv .= $this->addColumn("nom de l'item");

        $em = $this->entityManager;
        $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->getByTest($test);
        foreach ($questionnaires as $questionnaire) {
            $taskCount++;
            $subquestions = $questionnaire->getQuestions()[0]->getSubquestions();
            foreach ($subquestions as $subq) {
                $itemCount++;
                $propsInfos = $this->getPropsInfos($subq);
                $csv .= $this->addLine();
                $csv .= $this->addColumn($taskCount);
                $csv .= $this->addColumn($itemCount);
                $csv .= $this->addColumn($propsInfos[0]);
                $csv .= $this->addColumn($propsInfos[1]);
                $csv .= $this->addColumn("");
                $csv .= $this->addColumn($propsInfos[2]);
                $csv .= $this->addColumn($propsInfos[3]);
            }
        }

        return $csv;
    }

    private function getPropsInfos($subquestion)
    {
        $keys = "";
        $propCount  = 0;
        $em = $this->entityManager;
        $propositions = $em->getRepository('InnovaSelfBundle:Proposition')->getBySubquestionExcludingAnswers($subquestion);
        foreach ($propositions as $prop) {
            $propCount++;
            if ($prop->getRightAnswer()) {
                $keys .= $this->intToLetter($propCount);
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

    private function addColumn($text)
    {
        $column = "\"".$text."\"".";";

        return $column;
    }

    private function addLine()
    {
        $newLine = "\n";

        return $newLine;
    }

    private function intToLetter($int)
    {
        $arr = array(1 => "A", 2 => "B", 3 => "C", 4 => "D", 5 => "E", 6 => "F",
        7 => "G", 8 => "H", 9 => "I", 10 => "J", 11 => "K", 12 => "L", 13 => "M", );

        return $arr[$int];
    }
}
