<?php

namespace Innova\SelfBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\Response;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\User;
/**
 * Class ExportController
 *
 * @Route(
 *      "",
 *      name = "",
 *      service = "innova_export"
 * )
 */
class ExportController
{
    protected $kernelRoot;
    protected $entityManager;

    public function __construct($kernelRoot, $entityManager)
    {
        $this->kernelRoot = $kernelRoot;
        $this->entityManager = $entityManager;
    }

    /**
     * Lists all Test entities.
     *
     * @Route(
     *     "/admin/csv",
     *     name = "csv_export",
     *     options = {"expose"=true}
     * )
     * @Method("GET")
     * @Template()
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
     * exportCsvSQL function
     * Update : 04/2014 by EV pilote 2
     *
     * @Route(
     *     "/admin/test/{testId}/file/{filename}",
     *     name = "get-file"
     * )
     *
     * @Method("GET")
     */
    public function getFileAction($testId, $filename)
    {
        $file = $this->kernelRoot ."/data/export/".$testId."/".$filename;

        $response = new Response();
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($file));
        $response->headers->set('Content-Disposition', 'attachment; filename="' . basename($file) . '";');
        $response->headers->set('Content-length', filesize($file));
        $response->sendHeaders();

        $response->setContent(readfile($file));

        return $response;
    }


    /**
     * exportCsvSQL function   
     * @Route(
     *     "/admin/csv-export/test/{testId}",
     *     name = "csv-export"
     * )
     *
     * @Method("PUT")
     * @Template()
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
        $csvName = 'export-' . $testId . "_" . date("d-m-Y_H:i:s") . '.csv';
        $csvPath = $csvPathExport . "/" . $csvName;
        $fs->mkdir($csvPathExport, 0777);
        $csvh = fopen($csvPathExport . "/" . $csvName, 'w+');

        $questionnaires = $test->getQuestionnaires();
        foreach ($questionnaires as $questionnaire) {
            $traces = $questionnaire->getTraces();
            foreach ($traces as $trace) {
                $userId  = $trace->getUser()->getId();
                $userName  = (string) $trace->getUser();
                $emailName = (string) $trace->getUser()->getEmail();
                $testDate  = date_format($trace->getDate(), 'dm');
                if (!isset($result[$userId]["time"])) {
                    $result[$userId]["time"]=0;
                }
                $result[$userId]["time"] = $result[$userId]["time"] + $trace->getTotalTime();
                $result[$userId]["name"]  = $userName;
                $result[$userId]["email"] = $emailName;
                $result[$userId]["date"]  = $testDate;
            }
        }

        $csv .= "\n";

        //
        // PARTIE HEADER
        //
        // Difficulty part
        $csv .= "Difficulté" . ";" ;
        $csv .= "Libellé" . ";" ;
        $csv .= "\n";
        $csv .= "1" . ";" ;
        $csv .= "Très facile" . ";" ;
        $csv .= "\n";
        $csv .= "2" . ";" ;
        $csv .= "Facile" . ";" ;
        $csv .= "\n";
        $csv .= "3" . ";" ;
        $csv .= "Normal" . ";" ;
        $csv .= "\n";
        $csv .= "4" . ";" ;
        $csv .= "Difficile" . ";" ;
        $csv .= "\n";
        $csv .= "5" . ";" ;
        $csv .= "Très Difficile" . ";" ;
        $csv .= "\n";

        $csv .= "\n";
        $csv .= "\n";

        //
        // PARTIE HEADER COLONNES DU TABLEAU
        //
        // Loop to display all questionnaire of the test
        // $csv .= "Mail;" ; // A
        $csv .= "Nom;" ; // A
        $csv .= "Prénom;" ; // B
        $csv .= "Date;" ; // C
        $csv .= "Temps en secondes (pour le test entier);" ; // D

        //$csv .= "filiere;" ; // F
        $csv .= "Niveau Dialang CO;" ; // E
        $csv .= "Niveau Dialang CE;" ; // F
        $csv .= "Niveau Dialang EEC;" ; // G
        $csv .= "Niveau Lansad acquis;" ; // H

        $csv .= "Score total obtenu dans le test (formule du total);" ; // I

        $cpt_questionnaire = 0;
        if ($cpt_questionnaire == 0) {
            $questionnaires = $test->getQuestionnaires();
            // For THE test, loop on the Questionnaire
            foreach ($questionnaires as $questionnaire) {
                $cpt_questionnaire++;
                // Suite réception nouvelle version du fichier le 29/11/2013 :
                // je prends le dernier ou les 2 derniers caractères du thême
                $themeCode = substr($questionnaire->getTheme(), -2);
                // Si l'extrait est numérique, alors OK
                // sinon, je ne prends que le dernier caractère.
                // Exemple : A1COT2, je prends le dernier
                // A1COT13, je prends les 2 derniers.
                //
                if (!is_numeric($themeCode)) {
                    $themeCode = substr($questionnaire->getTheme(), -1);
                }
                $csv .= "T" . $cpt_questionnaire . " - NOM de ma TACHE;";
                $csv .= "T" . $cpt_questionnaire . " - Protocole d'interaction;";
                $csv .= "T" . $cpt_questionnaire . " - difficulté;";
                $csv .= "T" . $cpt_questionnaire . " - TEMPS;";

                $questions = $questionnaire->getQuestions();

                if(count($questions) > 0){
                    $subquestions = $questions[0]->getSubquestions();
                    $cpt=0;
                    foreach ($subquestions as $subquestion) {
                        $cpt++;
                        $csv .= "T" . $cpt_questionnaire . "_" . $cpt . " - CORR-FAUX : 1 pour correct / 0 pour faux;";
                        $csv .= "T" . $cpt_questionnaire . "_" . $cpt . " - PROPOSITION CHOISIE;";
                    }
                }
            }
        }

        $csv .= "\n";

        //
        // PARTIE BODY
        //
        // Loop to display all data
        $users = $em->getRepository('InnovaSelfBundle:User')->findAll();
        foreach ($users as $user) {
            $countQuestionnaireDone = $em->getRepository('InnovaSelfBundle:Questionnaire')
                ->countDoneYetByUserByTest($test->getId(), $user->getId());
            if ($countQuestionnaireDone > 0 && isset($result[$user->getId()])) {
                $csv .= $user->getUserName() . ";" ;
                $csv .= $user->getFirstName() . ";" ;
                // For THE test, loop on the Questionnaire
                // CR
                //

                $csv .= $result[$user->getId()]["date"] . ";" . $result[$user->getId()]["time"] . ";";
                // Add 4 colums for Level
                $csv .= $user->getCoLevel() . ";";
                $csv .= $user->getCeLevel() . ";";
                $csv .= $user->getEeLevel() . ";";
                $csv .= $user->getlevelLansad() . ";";

                $csv .= $this->calculateScore($user, $test) . ";"; // Calcul du score

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
                        $csv .= $questionnaire->getTheme() . ";" ;
                        $csv .= $questions[0]->getTypology()->getName() .  ";" ; // Typologie
                        $csv .= $trace->getDifficulty() . ";" ;
                        $csv .= $trace->getTotalTime() . ";" ;


                        // création tableau de correspondance subquestion -> réponses
                        foreach ($answers as $answer) {
                            if (!isset ($answersArray[$answer->getProposition()->getSubQuestion()->getId()])) {
                                $answersArray[$answer->getProposition()->getSubQuestion()->getId()] = array();
                            }
                            $answersArray[$answer->getProposition()->getSubQuestion()->getId()][] = $answer->getProposition();
                        }

                         // on récupère la subquestion
                        $subquestions = $questions[0]->getSubquestions();
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

                            $nbAnswers = count($answersArray[$subquestion->getId()]);
                            $subquestionOk = true;
                            if ($nbAnswers == $nbPropositionRightAnswser) {
                                foreach ($rightProps as $rightProp) {
                                    $found = false;
                                    foreach ($answersArray[$subquestion->getId()] as $answerProp) {
                                       if ($rightProp == $answerProp->getId()) {
                                            $found = true;
                                       }
                                    }
                                    if ($found == false) {
                                        $subquestionOk = false;
                                    }
                                }
                            } else {
                                $subquestionOk = false;
                            }

                            if ($subquestionOk) {
                                $csv .= "1" . ";";
                            } else {
                                $csv .= "0" . ";";
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

        // Export file list
        $fileList = array();
        $nbFile = 0;
        if ($dossier = opendir($csvPathExport)) {
            while (false !== ($fichier = readdir($dossier))) {
                if ($fichier != '.' && $fichier != '..') {
                    $nbFile++; 
                    $fileList[$nbFile] = $fichier;
                }
            }
        }

        closedir($dossier);
        arsort($fileList);

        return array(
            "csvName" => $csvName,
            'testId' => $testId,
            "fileList"=> $fileList,
            "nbFile" => $nbFile
        );
    }

    /**
     * calculateScore function
     *
     */
    private function calculateScore(User $user, Test $test)
    {
        $em = $this->entityManager;

        // Initialisation des variables.
        $score = 0;

        // Recherche de toutes les traces pour un utilisateur, un questionnaire et un test.
        $traces = $em->getRepository('InnovaSelfBundle:Trace')->findBy(
            array('user' => $user->getId(),
                  'test' => $test->getId()
                 )
            );

        // Parcours des traces
        foreach ($traces as $trace) {
            $answers = $trace->getAnswers();
            $answersArray = array();

            // Récupération de la typologie.
            $answer = $answers[0];
            $typology = $answer->getProposition()->getSubQuestion()->getTypology()->getName();

            switch ($typology) {
                case "APPAT";
                case "APPAA";
                case "APPAI";
                case "APPTT";
                    foreach ($answers as $answer) {
                        if ($answer->getProposition()->getRightAnswer()) {
                            $score++;
                        }
                    }
                    break;
                case "QRM";
                case "TQRM";
                case "QRU";
                case "TQRU";
                case "VF";
                case "TVF";
                case "VFNM";
                case "TVFNM";
                    foreach ($answers as $answer) {
                        if (!isset ($answersArray[$answer->getProposition()->getSubQuestion()->getId()])) {
                            $answersArray[$answer->getProposition()->getSubQuestion()->getId()] = array();
                        }
                        $answersArray[$answer->getProposition()->getSubQuestion()->getId()][] = $answer->getProposition()->getId();
                    }

                    foreach ($answersArray as $subQuestionId => $answers) {
                        // Initialisation des variables.
                        $nbProposition = $nbPropositionRightAnswser = $nbRightAnswer = 0;
                        // Recherche de toutes les traces pour un utilisateur, un questionnaire et un test.
                        $subQuestion = $em->getRepository('InnovaSelfBundle:Subquestion')->findOneById($subQuestionId);
                        $propositions = $subQuestion->getPropositions();

                        // Calcul du nombre de réponses.
                        $nbAnswers = count($answers);
                        $rightProps = array();
                        // Accès à la proposition.
                        // Calcul du nombre de proposition et
                        // calcul du nombre de bonnes réponses.
                        foreach ($propositions as $proposition) {
                                $nbProposition++;
                                if ($proposition->getRightAnswer()) {
                                    $nbPropositionRightAnswser++;
                                    $rightProps[] = $proposition;
                                }
                        }

                        // Je calcule le score que si le testeur a répondu à autant de réponses
                        // qu'il y a de propositions.
                        // Si ce n'est pas le cas, il aura forcément ZERO point.
                        if ($nbAnswers == $nbPropositionRightAnswser) {

                            foreach ($rightProps as $rightProp) {
                                if (in_array($rightProp->getId(),$answersArray[$subQuestion->getId()])) {
                                        $nbRightAnswer++;
                                }
                            }

                        }

                        if (($nbPropositionRightAnswser == $nbAnswers) && ($nbAnswers == $nbRightAnswer)) {
                            $score++;
                        }
                    }
                    break;

            }
        }

        return $score;
    }

}
