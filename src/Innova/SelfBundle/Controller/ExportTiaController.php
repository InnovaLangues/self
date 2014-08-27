<?php

namespace Innova\SelfBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;

/**
 * Class ExportTiaController
 *
 * @Route(
 *      "",
 *      name = "",
 *      service = "innova_export_tia"
 * )
 */
class ExportTiaController
{
    protected $kernelRoot;
    protected $entityManager;

    public function __construct($kernelRoot, $entityManager)
    {
        $this->kernelRoot = $kernelRoot;
        $this->entityManager = $entityManager;
    }

    /**
     * exportCsvSQL function   
     * @Route(
     *     "/admin/csv-tia-export/test/{testId}",
     *     name = "csv-tia-export"
     * )
     *
     * @Method("PUT")
     * @Template("InnovaSelfBundle:Export:exportCsv.html.twig")
     */
    public function exportCsvAction($testId)
    {
        $fs = new Filesystem();
        $em = $this->entityManager;
        $csv = "";
        $result = array();
        
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);
        //$csvPathExport = $this->kernelRoot ."/../web/upload/export/".$testId;
        $csvPathExport = $this->kernelRoot ."/data/export/".$testId."/";
        $urlRelativeToWeb = 'upload/export/' . $testId . "/";
        $csvName = 'export-tia-' . $testId . "_" . date("d-m-Y_H:i:s") . '.csv';
        $csvPath = $csvPathExport . "/" . $csvName;
        $fs->mkdir($csvPathExport, 0777);
        $csvh = fopen($csvPathExport . "/" . $csvName, 'w+');

        //
        // HEADER
        //
        $csv .= "Etudiant;" ;
        $questionnaires = $test->getQuestionnaires();
        foreach ($questionnaires as $questionnaire) {
            $i = 0;
            foreach ($questionnaire->getQuestions()[0]->getSubquestions() as $subquestions) {
                $i++;
                $csv .= $questionnaire->getTheme() . " " . $questionnaire->getQuestions()[0]->getTypology()->getName() . " " . $i . ";" ; // Typologie
            }
        }

        $csv .= "\n";

        //
        //  BODY
        //
        $rightProps = array();
        $users = $em->getRepository('InnovaSelfBundle:User')->findAll();
        foreach ($users as $user) {
            $countQuestionnaireDone = $em->getRepository('InnovaSelfBundle:Questionnaire')
                ->countDoneYetByUserByTest($test->getId(), $user->getId());
            if ($countQuestionnaireDone > 0) {
                $csv .= $user->getUserName() . " " . $user->getFirstName() . ";" ;

                $arr = array(1 => "A", 2 => "B", 3 => "C", 4 => "D", 5 => "E");
                $answersArray = array();

                $questionnaires = $test->getQuestionnaires();
                foreach ($questionnaires as $questionnaire) {

                    $traces = $em->getRepository('InnovaSelfBundle:Trace')->findBy(array('user' => $user->getId(),
                                    'questionnaire' => $questionnaire->getId()
                                    )
                                );

                    $questions = $em->getRepository('InnovaSelfBundle:Question')->findBy(
                                    array('questionnaire' => $questionnaire->getId())
                                );

                    foreach ($traces as $trace) {
                        $answers = $trace->getAnswers();

                        // création tableau de correspondance subquestion -> réponses
                        foreach ($answers as $answer) {
                            if (!isset ($answersArray[$answer->getProposition()->getSubQuestion()->getId()])) {
                                $answersArray[$answer->getProposition()->getSubQuestion()->getId()] = array();
                            }
                            $answersArray[$answer->getProposition()->getSubQuestion()->getId()][] = $answer->getProposition();
                        }

                         // on récupère la subquestion
                        $subquestions = $questions[0]->getSubQuestions();
                        foreach ($subquestions as $subquestion) {
                            $propositions = $subquestion->getPropositions();
                            $rightProps = array();
                            $nbPropositionRightAnswser = 0;
                            $cptProposition = 0;
                            $propLetters = array();
                            // on compte les bonnes propositions
                            foreach ($propositions as $proposition) {
                                $cptProposition++;
                                if ($proposition->getRightAnswer()) {
                                    $nbPropositionRightAnswser++;
                                }
                                $propLetters[$proposition->getId()] = $arr[$cptProposition];
                            }

                            $letters = array();
                            foreach ($answersArray[$subquestion->getId()] as $answer) {
                                $idAnswer = $answer->getId();
                                $letters[$propLetters[$idAnswer]] = 1;
                            }
                            ksort($letters);
                            foreach ($letters as $key => $value) {
                                $csv .= $key;
                            }
                            $csv .= ";";
                        }
                    }
                }
                $csv .= "\n";
            }

        }

        fwrite($csvh, $csv);
        fclose($csvh);

        //
        // Export file list
        //
        $fileList = array();
        $nbFile = 0;
        if ($dossier = opendir($csvPathExport)) {
            while (false !== ($fichier = readdir($dossier))) {
                if ($fichier != '.' && $fichier != '..') {
                    $nbFile++; // Number of files + 1
                    $fileList[$nbFile] = $fichier;
                }
            }
        }

        closedir($dossier); // Directory close

        //Sort file
        arsort($fileList);

        return array(
            "csvName" => $csvName,
            'testId' => $testId,
            "fileList"=> $fileList,
            "nbFile" => $nbFile
        );

    }
}
