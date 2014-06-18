<?php

namespace Innova\SelfBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
     * exportTiaCsvSQL function
     * Update : 04/2014 by EV pilote 2
     *
     * @Route(
     *     "/admin/csv-export-tia/{language}/{level}/{test}",
     *     name = "csv-export-tia"
     * )
     *
     * @Method("GET|POST")
     * @Template()
     */
    public function exportTiaCsvSQLAction($language, $level, $test)
    {
        $em = $this->entityManager;
        //
        // CSV Export part
        //
        $rootPath = $this->kernelRoot . "/../";

        // File export name
        // Spécificité Anglais : on a un seul test pour le pilote 2.
        if ($language == "en") {
            // File export path
            $csvPathExport = $rootPath . 'web/upload/export/csv/p2/' . $language . "/tia";
            // File export name
            $csvName = 'export-' . $language . "_" . date("d-m-Y_H:i:s") . '.csv';
            // File export path
            $csvPathExport = $rootPath . 'web/upload/export/csv/p2/' . $language . "/tia";
            // Symfony
            $urlCSVRelativeToWeb = 'upload/export/csv/p2/' . $language . "/tia/";
        }
        if ($language == "it") {
            // File export path
            $csvPathExport = $rootPath . 'web/upload/export/csv/p2/' . $language . "/" . $level . "/tia";
            // File export name
            $csvName = 'export-' . $language . "-" . $level . "_" . date("d-m-Y_H:i:s") . '.csv';
            // File export path
            $csvPathExport = $rootPath . 'web/upload/export/csv/p2/' . $language . "/" . $level . "/tia";
            // Symfony
            $urlCSVRelativeToWeb = 'upload/export/csv/p2/' . $language . "/" . $level . "/tia/";
        }
        // Path + Name
        $csvPath = $csvPathExport . "/" . $csvName;

        // Open file
        $csvh = fopen($csvPath, 'w+');

        // Init csv write variable
        $csv = '';

        // Loop for THE test
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($test);

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
                                    $rightProps[] = $proposition->getId();

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

        //
        // To view
        //
        return array(
            "urlCSVRelativeToWeb" => $urlCSVRelativeToWeb,
            "csvName"             => $csvName,
            "fileList"            => $fileList,
            "nbFile"              => $nbFile
        );

    }

}
