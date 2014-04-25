<?php

namespace Innova\SelfBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Question;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Media;
use Innova\SelfBundle\Entity\Answer;
use Innova\SelfBundle\Entity\Trace;
use Innova\SelfBundle\Entity\Proposition;
use Innova\SelfBundle\Entity\Typology;

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
     *     "/admin/csv-export/{language}/{level}/{test}/{levelId}",
     *     name = "csv-export"
     * )
     *
     * @Method("GET")
     * @Template()
     */
    public function exportCsvSQLAction($language, $level, $test, $levelId)
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
            $csvPathExport = $rootPath . 'web/upload/export/csv/p2/' . $language;
            // File export name
            $csvName = 'export-' . $language . "_" . date("d-m-Y_H:i:s") . '.csv';
            // File export path
            $csvPathExport = $rootPath . 'web/upload/export/csv/p2/' . $language;
            // Symfony
            $urlCSVRelativeToWeb = 'upload/export/csv/p2/' . $language . "/";
        }
        if ($language == "it") {
            // File export path
            $csvPathExport = $rootPath . 'web/upload/export/csv/p2/' . $language . "/" . $level;
            // File export name
            $csvName = 'export-' . $language . "-" . $level . "_" . date("d-m-Y_H:i:s") . '.csv';
            // File export path
            $csvPathExport = $rootPath . 'web/upload/export/csv/p2/' . $language . "/" . $level;
            // Symfony
            $urlCSVRelativeToWeb = 'upload/export/csv/p2/' . $language . "/" . $level . "/";
        }
        // Path + Name
        $csvPath = $csvPathExport . "/" . $csvName;

        // Open file
        $csvh = fopen($csvPath, 'w+');

        // Init csv write variable
        $csv = '';

        // Loop for THE test
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($test);

        $result = array();

//        foreach ($tests as $test) {
            $questionnaires = $test->getQuestionnaires();
            // For THE test, loop on the Questionnaire
            foreach ($questionnaires as $questionnaire) {
                // For THE questionnaire, loop on the Trace
                $traces = $questionnaire->getTraces();
                foreach ($traces as $trace) {
                    $userName  = (string) $trace->getUser();
                    $emailName = (string) $trace->getUser()->getEmail();
                    $testDate  = date_format($trace->getDate(), 'dm');
                    if (!isset($result[$userName]["time"])) {
                        $result[$userName]["time"]=0;
                    }
                    $result[$userName]["time"] = $result[$userName]["time"] + $trace->getTotalTime();
                    $result[$userName]["name"]  = $userName;
                    $result[$userName]["email"] = $emailName;
                    $result[$userName]["date"]  = $testDate;
                }
            }
//        }

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

        $cpt_questionnaire=0;
//        foreach ($tests as $test) {
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

                    $subquestions = $questions[0]->getSubQuestions();
                    $cpt=0;
                    foreach ($subquestions as $subquestion) {
                        $cpt++;
//                            $csv .= "t" . $themeCode . "res" . $cpt . ";"; // Ajout d'une colonne pour chaque proposition de la question.
//                            $csv .= "t" . $themeCode . "ch" . $cpt . ";";
                        $csv .= "T" . $cpt . " - CORR-FAUX : 1 pour correct / 0 pour faux;";
                        $csv .= "T" . $cpt . " -  PROPOSITION CHOISIE;";
                    }
                }
            }
//        }

        $csv .= "\n";

        //
        // PARTIE BODY
        //
        // Loop to display all data
//        foreach ($tests as $test) {
            $rightProps = array();
            $users = $em->getRepository('InnovaSelfBundle:User')->findAll();
            foreach ($users as $user) {
                $countQuestionnaireDone = $em->getRepository('InnovaSelfBundle:Questionnaire')
                    ->countDoneYetByUserByTest($test->getId(), $user->getId());
                if ($countQuestionnaireDone > 0) {
                //$csv .= $user->getEmail() . ";" ;
                $csv .= $user->getUserName() . ";" ;
                $csv .= $user->getFirstName() . ";" ;
                // For THE test, loop on the Questionnaire
                // CR
                //

                    $csv .= $result[$user->getUserName()]["date"] . ";" . $result[$user->getUserName()]["time"] . ";";
                    // Add 5 colums for Level

                    //$csv .= $user->getOriginStudent() . ";";
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
                            $colonneO = "";
                            $trueFalse = true;
                            $answers = $trace->getAnswers();
                            $csv .= $questionnaire->getTheme() . ";" ;
                            $csv .= $questions[0]->getTypology()->getName() .  ";" ; // Typologie
                            $csv .= $trace->getDifficulty() . ";" ;
                            $csv .= $trace->getTotalTime() . ";" ;


                            // création tableau de correspondance subquestion -> réponses
                            foreach ($answers as $answer) {
                                if (!isset ($answersArray[$answer->getProposition()->getSubQuestion()->getId()])){
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

                                $nbAnswers = count($answersArray[$subquestion->getId()]);
                                $subquestionOk = true;
                                if ( $nbAnswers == $nbPropositionRightAnswser) {
                                    foreach ($rightProps as $rightProp) {
                                        $found = false;
                                        foreach ($answersArray[$subquestion->getId()] as $answerProp) {
                                           if ($rightProp == $answerProp->getId()){
                                                $found = true;
                                           }
                                        }
                                        if ($found == false) {
                                            $subquestionOk = false;
                                        }
                                    }
                                }
                                else {
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
                                foreach($letters as $key => $value){
                                    $csv .= $key;
                                }
                                $csv .= ";";
                            }
                        }
                    }
                }
                $csv .= "\n";

            }
//        }
        // FOOTER
        // Empty

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






    /**
     * exportTiaCsvSQL function
     * Update : 04/2014 by EV pilote 2
     *
     * @Route(
     *     "/admin/csv-export-tia/{language}/{level}/{test}/{levelId}",
     *     name = "csv-export-tia"
     * )
     *
     * @Method("GET")
     * @Template()
     */
    public function exportTiaCsvSQLAction($language, $level, $test, $levelId)
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
die();

        // Open file
        $csvh = fopen($csvPath, 'w+');

        // Init csv write variable
        $csv = '';

        // Loop for THE test
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($test);

        $result = array();

//        foreach ($tests as $test) {
            $questionnaires = $test->getQuestionnaires();
            // For THE test, loop on the Questionnaire
            foreach ($questionnaires as $questionnaire) {
                // For THE questionnaire, loop on the Trace
                $traces = $questionnaire->getTraces();
                foreach ($traces as $trace) {
                    $userName  = (string) $trace->getUser();
                    $emailName = (string) $trace->getUser()->getEmail();
                    $testDate  = date_format($trace->getDate(), 'dm');
                    if (!isset($result[$userName]["time"])) {
                        $result[$userName]["time"]=0;
                    }
                    $result[$userName]["time"] = $result[$userName]["time"] + $trace->getTotalTime();
                    $result[$userName]["name"]  = $userName;
                    $result[$userName]["email"] = $emailName;
                    $result[$userName]["date"]  = $testDate;
                }
            }
//        }

        $csv .= "\n";


        //
        // PARTIE HEADER COLONNES DU TABLEAU
        //
        // Loop to display all questionnaire of the test
        // $csv .= "Mail;" ; // A
        $csv .= "Etudiant;" ; // A


        $cpt_questionnaire=0;
//        foreach ($tests as $test) {
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
                    foreach ($questions as $question) {
                        $subquestions = $question->getSubQuestions();
                        $cpt=0;
                        foreach ($subquestions as $subquestion) {
                            $cpt++;
//                            $csv .= "t" . $themeCode . "res" . $cpt . ";"; // Ajout d'une colonne pour chaque proposition de la question.
//                            $csv .= "t" . $themeCode . "ch" . $cpt . ";";
                            $csv .= "T" . $cpt_questionnaire . " - CORR-FAUX : 1 pour correct / 0 pour faux;";
                            $csv .= "T" . $cpt_questionnaire . " -  PROPOSITION CHOISIE;";
                        }
                    }
                }
            }
//        }

        $csv .= "\n";

        //
        // PARTIE BODY
        //
        // Loop to display all data
//        foreach ($tests as $test) {
            $rightProps = array();
            $users = $em->getRepository('InnovaSelfBundle:User')->findAll();
            foreach ($users as $user) {
                //$csv .= $user->getEmail() . ";" ;
                $csv .= $user->getUserName() . ";" ;
                $csv .= $user->getFirstName() . ";" ;
                // For THE test, loop on the Questionnaire
                // CR
                //
                $countQuestionnaireDone = $em->getRepository('InnovaSelfBundle:Questionnaire')
                    ->countDoneYetByUserByTest($test->getId(), $user->getId());

                if ($countQuestionnaireDone > 0) {
                    $csv .= $result[$user->getUserName()]["date"] . ";" . $result[$user->getUserName()]["time"] . ";";
                    // Add 5 colums for Level

                    //$csv .= $user->getOriginStudent() . ";";
                    $csv .= $user->getCoLevel() . ";";
                    $csv .= $user->getCeLevel() . ";";
                    $csv .= $user->getEeLevel() . ";";
                    $csv .= $user->getlevelLansad() . ";";

                    $csv .= $this->calculateScore($user, $test) . ";"; // Calcul du score

                    $arr = array(1 => "A", 2 => "B", 3 => "C", 4 => "D", 5 => "E");
                    $answersArray = array();

                    $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->findAll();
                    foreach ($questionnaires as $questionnaire) {

                        $traces = $em->getRepository('InnovaSelfBundle:Trace')->findBy(array('user' => $user->getId(),
                                        'questionnaire' => $questionnaire->getId()
                                        )
                                    );

                        $questions = $em->getRepository('InnovaSelfBundle:Question')->findBy(
                                        array('questionnaire' => $questionnaire->getId())
                                    );

                        foreach ($traces as $trace) {
                            $colonneO = "";
                            $trueFalse = true;
                            $answers = $trace->getAnswers();
                            $csv .= $questionnaire->getTheme() . ";" ;
                            $csv .= $questions[0]->getTypology()->getName() .  ";" ; // Typologie
                            $csv .= $trace->getDifficulty() . ";" ;
                            $csv .= $trace->getTotalTime() . ";" ;

                            switch ($questions[0]->getTypology()->getName()) {
                                case "TQRM";
                                    foreach ($answers as $answer) {
                                        if (!isset ($answersArray[$answer->getProposition()->getSubQuestion()->getId()])){
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
                                        $cptProposition = 0;
                                        // Accès à la proposition.
                                        // Calcul du nombre de proposition et
                                        // calcul du nombre de bonnes réponses.
                                        foreach ($propositions as $proposition) {
                                            $cptProposition++;
                                            if ($proposition->getRightAnswer()) {
                                                $nbPropositionRightAnswser++;
                                                $colonneO .= $cptProposition;
                                            }
                                        }

                                        // Je calcule le score que si le testeur a répondu à autant de réponses
                                        // qu'il y a de propositions.
                                        // Si ce n'est pas le cas, il aura forcément ZERO point.
                                        if ( $nbAnswers == $nbPropositionRightAnswser) {

                                            $cptProposition = 0;
                                            foreach ($rightProps as $rightProp) {
                                                if (in_array($rightProp->getId(),$answersArray[$subQuestion->getId()]))
                                                {
                                                        $nbRightAnswer++;
                                                }
                                            }

                                        }

                                        if (($nbPropositionRightAnswser == $nbAnswers) && ($nbAnswers == $nbRightAnswer)) {
                                            $csv .= "1" . ";";
                                        }
                                        else
                                        {
                                            $csv .= "0" . ";";
                                        }
                                    }
                                    // Colonne O
                                    //var_dump($rightProps[0]);
                                    $csv .= $colonneO . ";";
                                    break;
                                case "APPAT";
                                case "APPAA";
                                case "APPAI";
                                case "APPTT";
                                    foreach ($answers as $answer) {
                                        $propositions = $answer->getProposition()->getSubQuestion()->getPropositions();
                                        $cptProposition = 0;
                                        foreach ($propositions as $proposition) {
                                            $cptProposition++;
                                            if ($proposition->getId() === $answer->getProposition()->getId()) {
                                                $propositionRank = $cptProposition;
                                                $colonneO = $colonneO . $arr[$propositionRank];
                                                // Colonne N
                                                if (!$answer->getProposition()->getRightAnswer()) {
                                                    $trueFalse = false;
                                                }
                                            }
                                        }
                                    }
                                        // Colonne N
                                        if ($trueFalse)
                                        $csv .= "1" . ";";
                                        else
                                        $csv .= "0" . ";";
                                        // Colonne O
                                        $csv .= $colonneO . ";";
                                    $colonneO = "";
                                    break;
                                case "TQRU";
                                case "TVF";
                                case "TVFNM";
                                    foreach ($answers as $answer) {
                                        $propositions = $answer->getProposition()->getSubQuestion()->getPropositions();
                                        $cptProposition = 0;
                                        foreach ($propositions as $proposition) {
                                            $cptProposition++;
                                            if ($proposition->getId() === $answer->getProposition()->getId()) {
                                                $propositionRank = $cptProposition;
                                                $colonneO = $arr[$propositionRank];
                                                // Colonne N
                                                if (!$answer->getProposition()->getRightAnswer()) {
                                                    $trueFalse = false;
                                                }
                                            }
                                        }
                                        // Colonne N
                                        if ($trueFalse)
                                        $csv .= "1" . ";";
                                        else
                                        $csv .= "0" . ";";
                                        // Colonne O
                                        $csv .= $colonneO . ";";
                                    }
                                    break;
                                case "QRM";
                                case "QRU";
                                case "VF";
                                case "VFNM";
                                    foreach ($answers as $answer) {
                                        $propositions = $answer->getProposition()->getSubQuestion()->getPropositions();
                                        $cptProposition = 0;
                                        foreach ($propositions as $proposition) {
                                            $cptProposition++;
                                            if ($proposition->getId() === $answer->getProposition()->getId()) {
                                                $propositionRank = $cptProposition;
                                                $colonneO = $colonneO . $arr[$propositionRank];
                                                // Colonne N
                                                if (!$answer->getProposition()->getRightAnswer()) {
                                                    $trueFalse = false;
                                                }
                                            }
                                        }
                                    }
                                    // Colonne N
                                    if ($trueFalse)
                                    $csv .= "1" . ";";
                                    else
                                    $csv .= "0" . ";";
                                    // Colonne O
                                    $csv .= $colonneO . ";";
                                    break;
                            }

                                //$csv .= $answer->getProposition()->getMedia()->getName();
                                //$csv .= $arr[$propositionRank] . ";";
/*                                if ($answer->getProposition()->getTitle() != "") {
                                    $csv .= $answer->getProposition()->getTitle() . ";";
                                } else {
                                    $csv .= $propositionRank . ";";
                                }
*/
                        }
                    }
                }
                $csv .= "\n";

            }
//        }
        // FOOTER
        // Empty

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

    }

    /**
     * calculateScore function
     *
     */
    private function calculateScore($user, $test)
    {
        $em = $this->entityManager;

        // Initialisation des variables.
        $score = $nbAnswers = 0;

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
                    if ($answer->getProposition()->getRightAnswer()){
                        $score++;
                    }
                    /*
                    // Accès à la proposition.
                    $propositions = $answer->getProposition()->getSubQuestion()->getPropositions();
                    $cptProposition = 0;
                    foreach ($propositions as $proposition) {
                        if ($proposition->getId() === $answer->getProposition()->getId()) {
                            if ($proposition->getRightAnswer()) {
                            }
                        }
                    }
                    */
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
                        if (!isset ($answersArray[$answer->getProposition()->getSubQuestion()->getId()])){
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
                        if ( $nbAnswers == $nbPropositionRightAnswser) {

                            $cptProposition = 0;
                            foreach ($rightProps as $rightProp) {
                                if (in_array($rightProp->getId(),$answersArray[$subQuestion->getId()]))
                                {
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
