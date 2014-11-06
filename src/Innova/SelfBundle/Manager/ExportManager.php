<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Subquestion;
use Symfony\Component\Filesystem\Filesystem;

class ExportManager
{
    protected $entityManager;
    protected $securityContext;
    protected $kernelRoot;
    protected $knpSnappyPdf;
    protected $templating;
    protected $user;

    public function __construct($entityManager, $securityContext, $kernelRoot, $knpSnappyPdf, $templating)
    {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
        $this->kernelRoot = $kernelRoot;
        $this->knpSnappyPdf = $knpSnappyPdf;
        $this->templating = $templating;
        $this->user = $this->securityContext->getToken()->getUser();
    }

    public function exportPdfAction(Test $test)
    {
        $fs = new Filesystem();
        $testId = $test->getId();
        $pdfContent = "";

        $pdfName = "self_export-pdf-test_" . $testId . "-" . date("d-m-Y_H:i:s") . '.pdf';
        $pdfPathExport = $this->kernelRoot ."/data/exportPdf/".$testId."/";

        // Appel de la vue et de la génération du PDF
        $this->knpSnappyPdf->generateFromHtml(
            $this->templating->render(
                'InnovaSelfBundle:Export:templatePdf.html.twig',
                array(
                    'test' => $test
                )
            ),
            $this->kernelRoot ."/data/exportPdf/". $test->getId() ."/". $pdfName
        );

        return $pdfName;
    }


    public function exportCsvAction(Test $test, $tia)
    {
        $fs = new Filesystem();
        $testId = $test->getId();
        $csvContent = "";

        if ($tia == 0) {
            $tia = "";
            $csvContent = $this->getCvsContent($test);
        } else {
            $tia = "-tia";
            $csvContent = $this->getCvsTiaContent($test);
        }

        $csvName = "self_export-test_" . $testId . "-" . date("d-m-Y_H:i:s") . $tia . '.csv';
        $csvPathExport = $this->kernelRoot ."/data/export/".$testId."/";

        $fs->mkdir($csvPathExport, 0777);
        $csvh = fopen($csvPathExport . "/" . $csvName, 'w+');

        fwrite($csvh, $csvContent);
        fclose($csvh);

        return $csvName;
    }

    /**
     * Retourne la liste des fichiers d'export pour un test et un mode donné (csv | pdf)
     */
    public function getFileList(Test $test, $mode)
    {
        if ($mode == "pdf") {
            $dir = "exportPdf";
        } else {
            $dir = "export";
        }

        $testId = $test->getId();
        $csvPathExport = $this->kernelRoot ."/data/".$dir."/".$testId."/";
        $fileList = array();

        if ($dossier = opendir($csvPathExport)) {
            while (false !== ($fichier = readdir($dossier))) {
                if ($fichier != '.' && $fichier != '..') {
                    $fileList[] = $fichier;
                }
            }
        }

        closedir($dossier);
        arsort($fileList);

        return $fileList;
    }

    /**
     * getCvsContent function
     * Fonction principale pour l'export CSV "classique"
     */
    private function getCvsContent(Test $test){
        $em = $this->entityManager;
        $testId = $test->getId();
        $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->getByTest($test);

        $preprocess  = $this->preprocessTest($testId, $questionnaires);
        $propLetters = $preprocess[0];
        $rightProps   = $preprocess[1];
        $result          = $preprocess[2];
        $csv              = $preprocess[3];
        $typology      = $preprocess[4];
        $theme         = $preprocess[5];
        $subquestionsId = $preprocess[6];

        $users = $em->getRepository('InnovaSelfBundle:User')->getByTraceOnTest($testId);
        foreach ($users as $user) {
            $userId = $user->getId();
            $score = $this->calculateScore($user, $test, $rightProps, $subquestionsId);

            $csv .= $this->addColumn($user->getUserName());
            $csv .= $this->addColumn($user->getFirstName());
            $csv .= $this->addColumn($result[$userId]["date"]);
            $csv .= $this->addColumn($result[$userId]["time"]);
            $csv .= $this->addColumn($user->getCoLevel());
            $csv .= $this->addColumn($user->getCeLevel());
            $csv .= $this->addColumn($user->getEeLevel());
            $csv .= $this->addColumn($user->getlevelLansad());
            $csv .= $this->addColumn($score);

            foreach ($questionnaires as $questionnaire) {
                $questionnaireId = $questionnaire->getId();
                $questions = $questionnaire->getQuestions();
                $typologyName = $typology[$questionnaireId];
                $traces = $em->getRepository('InnovaSelfBundle:Trace')->getByUserAndTestAndQuestionnaire($userId, $testId, $questionnaireId);

                foreach ($traces as $trace) {
                    $csv .= $this->addColumn($theme[$questionnaireId]);
                    $csv .= $this->addColumn($typologyName);
                    $csv .= $this->addColumn($trace->getDifficulty());
                    $csv .= $this->addColumn($trace->getTotalTime());

                    // création tableau de correspondance subquestion -> propositions choisies
                    $answersArray = array();
                    $answers = $trace->getAnswers();
                    foreach ($answers as $answer) {
                        $subquestionId = $answer->getSubquestion()->getId();
                        $answersArray[$subquestionId][] = $answer->getProposition();
                    }

                    // comparaison du tableau créé plus tôt avec le tableau de bonnes propositions
                    $subquestions = $questions[0]->getSubquestions();
                    foreach ($subquestions as $subquestion) {
                        $subquestionId = $subquestion->getId();
                        $csv .= $this->checkRightAnswer($answersArray, $subquestionId, $rightProps["sub".$subquestionId], $typologyName);
                        $csv .= $this->textToDisplay($subquestionId, $answersArray, $propLetters, $typologyName);
                    }
                }
            }
            $csv .= "\n";
        }

        return $csv;
    }

    private function addColumn($text)
    {
        $column = "\"" . $text . "\"" . ";" ;

        return $column;
    }


    private function checkRightAnswer($answersArray, $subquestionId, $rightProps, $typo)
    {
        switch ($typo) {
            case 'TVF':
            case 'VF':
            case 'TVFNM':
            case 'VFNM':
            case 'QRU':
            case 'QRM':
            case 'TQRU':
            case 'TQRM':
            case 'APP':
                if (isset($answersArray[$subquestionId])){
                    $nbAnswers = count($answersArray[$subquestionId]);
                } else {
                    $nbAnswers = 0;
                }

                $subquestionOk = true;
                if ($nbAnswers ==  count($rightProps)) {
                    foreach ($rightProps as $rightProp) {
                        $found = false;
                        foreach ($answersArray[$subquestionId] as $answerProp) {
                            if ($rightProp == $answerProp->getId()) {
                                $found = true;
                            }
                        }
                        if ($found === false) {
                            $subquestionOk = false;
                        }
                    }
                } else {
                    $subquestionOk = false;
                }
                break;

            case 'TLCMLDM':
            case 'TLCMLMULT':
            case 'TLQROC':
                $subquestionOk = false;
                if (isset($answersArray[$subquestionId])) {
                    $proposition = $answersArray[$subquestionId][0];
                    $subquestionOk = $proposition->getRightAnswer();
                }

                break;
        }

        if ($subquestionOk) {
            $output = $this->addColumn(1);
        } else {
            $output = $this->addColumn(0);
        }

        return $output;
    }

    private function textToDisplay($subquestionId, $answersArray, $propLetters, $typo){
        $textToDisplay = "";

        switch ($typo) {
            case 'TVF':
            case 'VF':
            case 'TVFNM':
            case 'VFNM':
            case 'QRU':
            case 'QRM':
            case 'TQRU':
            case 'TQRM':
            case 'APP':
                if (isset($answersArray[$subquestionId])) {
                    $letters = array();
                    foreach ($answersArray[$subquestionId] as $answer) {
                        $idAnswer = $answer->getId();
                        $letters[$propLetters[$idAnswer]] = 1;
                    }
                    ksort($letters);
                    foreach ($letters as $key => $value) {
                        $textToDisplay .= $key;
                    }
                }
                break;

            case 'TLCMLDM':
            case 'TLCMLMULT':
            case 'TLQROC':
                if (isset($answersArray[$subquestionId])) {
                    $proposition = $answersArray[$subquestionId][0];

                    $textToDisplay = "\"" . addslashes(html_entity_decode($proposition->getMedia()->getDescription())) . "\"";
                }
                break;
        }

        $textToDisplay .= ";";

        return $textToDisplay;
    }

    private function getCvsTiaContent(Test $test){
        $em = $this->entityManager;
        $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->getByTest($test);
        $csv = "";

        // HEADER
        $csv .= "Etudiant;" ;
        foreach ($questionnaires as $questionnaire) {
            $i = 0;
            foreach ($questionnaire->getQuestions()[0]->getSubquestions() as $subquestions) {
                $i++;
                $csv .= $questionnaire->getTheme() . " " . $questionnaire->getQuestions()[0]->getTypology()->getName() . " " . $i . ";" ;
                $csv .= $questionnaire->getTheme() . " " . $questionnaire->getQuestions()[0]->getTypology()->getName() . " " . $i . ";" ;
            }
        }
        $csv .= "\n";

        //  BODY
        $users = $em->getRepository('InnovaSelfBundle:User')->findAll();
        foreach ($users as $user) {
            if ($this->countQuestionnaireDone($test, $user) > 0) {
                $csv .= $user->getUserName() . " " . $user->getFirstName() . ";" ;

                $answersArray = array();
                foreach ($questionnaires as $questionnaire) {
                    $traces = $em->getRepository('InnovaSelfBundle:Trace')
                                 ->findBy(array('user' => $user->getId(),
                                                'questionnaire' => $questionnaire->getId()
                                                )
                                        );
                    $questions = $questionnaire->getQuestions();

                    foreach ($traces as $trace) {
                        $answers = $trace->getAnswers();

                        // création tableau de correspondance subquestion -> réponses
                        foreach ($answers as $answer) {
                            if (!isset ($answersArray[$answer->getProposition()->getSubQuestion()->getId()])) {
                                $answersArray[$answer->getProposition()->getSubQuestion()->getId()] = array();
                            }
                            $answersArray[$answer->getProposition()->getSubQuestion()->getId()][] = $answer->getProposition();
                        }

                        $subquestions = $questions[0]->getSubQuestions();
                        foreach ($subquestions as $subquestion) {
                            $propositions = $subquestion->getPropositions();
                            $rightProps = array();
                            $nbPropositionRightAnswser = 0;
                            $cptProposition = 0;
                            $propLetters = array();
                            $libRightAnswer = "";
                            // on compte les bonnes propositions
                            foreach ($propositions as $proposition) {
                                $cptProposition++;
                                if ($proposition->getRightAnswer()) {
                                    $nbPropositionRightAnswser++;
                                    $rightProps[] = $proposition->getId();
                                    $libRightAnswer = $libRightAnswer . $proposition->getMedia()->getDescription() . " ";
                                }
                                $propLetters[$proposition->getId()] = $this->intToLetter($cptProposition);
                            }

                            // Récupération bonne réponse ou non
                            $csv .= $libRightAnswer . ";";
/*
                            $subquestionOk = $this->checkRightAnswer($answersArray, $subquestion, $nbPropositionRightAnswser, $rightProps);
                            if ($subquestionOk) {
                                $csv .= $libRightAnswer . ";";
                            } else {
                                $csv .= "0" . ";";
                            }
*/
                            // Récupération de la saisie ou des lettres associées aux réponses
                            $textToDisplay = $this->textToDisplay($subquestion->getId(), $answersArray, $propLetters, $typologyName);
                            $csv .= $textToDisplay;
                            $csv .= ";";
                        }
                    }
                }
                $csv .= "\n";
              }
        }

        $csv .= "\n";
        $csv .= "Légende :" . ";" ;
        $csv .= "\n";
        $csv .= "première colonne = réponse qui correspond à la réponse correcte établie dans l'éditeur" . ";" ;
        $csv .= "\n";
        $csv .= "seconde colonne = la réponse tapée par l'étudiant, qui peut être fausse OU BIEN inserée parmi les réponses correctes" . ";" ;

        return $csv;
    }

    private function intToLetter($int){
        $arr = array(1 => "A", 2 => "B", 3 => "C", 4 => "D", 5 => "E", 6 => "F",
        7 => "G", 8 => "H", 9 => "I", 10 => "J", 11 => "K", 12 => "L");

        return $arr[$int];
    }

    /**
     * calculateScore function
     */
    private function calculateScore(User $user, Test $test, $rightProps, $subquestionsId)
    {
        $em = $this->entityManager;
        $score = 0;
        $traces = $em->getRepository('InnovaSelfBundle:Trace')->getByUserAndTest($user->getId(), $test->getId());

        foreach ($traces as $trace) {
            if ($answers = $trace->getAnswers()) {
                if(isset($answers[0])){
                $answersArray = array();
                $typology = $answers[0]->getSubquestion()->getTypology()->getName();

                switch ($typology) {
                    case 'TLCMLDM':
                    case 'TLCMLMULT':
                    case 'TLQROC':
                        foreach ($answers as $answer) {
                            $subquestionId = $answer->getSubquestion()->getId();
                            if (!isset ($answersArray[$subquestionId])) {
                                $answersArray[$subquestionId] = array();
                            }
                            $answersArray[$subquestionId][] = $answer->getProposition()->getId();
                        }

                        foreach ($answersArray as $subquestionId => $answers) {
                            $rightPropositions = array();
                            if (isset($rightProps["sub".$subquestionId])) {
                                $rightPropositions = $rightProps["sub".$subquestionId];
                            }

                            $nbPropositionRightAnswer = $nbRightAnswer = 0;
                            $nbAnswers = count($answers);

                            // Je calcule le score que si le testeur a répondu à autant de réponses
                            // qu'il y a de propositions.
                            // Si ce n'est pas le cas, il aura forcément ZERO point.
                            if ($nbAnswers == count($rightPropositions)) {
                                foreach ($rightPropositions as $rightProp) {
                                    if (in_array($rightProp, $answersArray[$subquestionId])) {
                                        $nbRightAnswer++;
                                    }
                                }
                            }

                            if (($nbPropositionRightAnswer == $nbAnswers) && ($nbAnswers == $nbRightAnswer)) {
                                $score++;
                            }
                        }
                        break;

                    case "APP";
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

                        foreach ($answersArray as $subquestionId => $answers) {
                            // Initialisation des variables.
                            $nbProposition = $nbPropositionRightAnswser = $nbRightAnswer = 0;
                            // Recherche de toutes les traces pour un utilisateur, un questionnaire et un test.
                            $propositions = $subquestionsId[$subquestionId]->getPropositions();

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
                                    if (in_array($rightProp->getId(),$answersArray[$subquestionId])) {
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
            }
        }

        return $score;
    }

     /**
     * Précalcule pas mal de choses pour éviter les requêtes redondantes plus tard
     */
    private function preprocessTest($testId, $questionnaires){
        $em = $this->entityManager;
        $propLetters = array();
        $rightProps = array();
        $result = array();  
        $cpt_questionnaire = 0;
        $csv = "";
        $typology = array();
        $theme = array();
        $subquestionsId = array();

        $csv .= $this->addColumn("Nom");
        $csv .= $this->addColumn("Prénom");
        $csv .= $this->addColumn("Date");
        $csv .= $this->addColumn("Temps en secondes (pour le test entier)");
        $csv .= $this->addColumn("Niveau Dialang CO");
        $csv .= $this->addColumn("Niveau Dialang CE");
        $csv .= $this->addColumn("Niveau Dialang EEC");
        $csv .= $this->addColumn("Niveau Lansad acquis");
        $csv .= $this->addColumn("Score total obtenu dans le test (formule du total)");

        foreach ($questionnaires as $questionnaire) {
            $cpt_questionnaire++;
            $questionnaireId = $questionnaire->getId();

            $theme[$questionnaireId] = $questionnaire->getTheme();
            $themeCode = substr($theme[$questionnaireId], -2);
            if (!is_numeric($themeCode)) {
                $themeCode = substr($theme[$questionnaireId], -1);
            }

            $csv .= $this->addColumn("T" . $cpt_questionnaire . " - NOM de ma TACHE");
            $csv .= $this->addColumn("T" . $cpt_questionnaire . " - Protocole d'interaction");
            $csv .= $this->addColumn("T" . $cpt_questionnaire . " - difficulté");
            $csv .= $this->addColumn("T" . $cpt_questionnaire . " - TEMPS");

            $questions = $questionnaire->getQuestions();
            $typology[$questionnaireId] = $questions[0]->getTypology()->getName();

            if(count($questions) > 0){
                $subquestions = $questions[0]->getSubquestions();
                $cpt=0;
                foreach ($subquestions as $subquestion) {
                    $cpt++;
                    $csv .= $this->addColumn("T" . $cpt_questionnaire . "_" . $cpt . " - CORR-FAUX : 1 pour correct / 0 pour faux");
                    $csv .= $this->addColumn("T" . $cpt_questionnaire . "_" . $cpt . " - PROPOSITION CHOISIE");
                }
            }

            $traces = $em->getRepository('InnovaSelfBundle:Trace')->getByTestAndQuestionnaire($testId, $questionnaireId);
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

            foreach ($questions as $question) {
                $typologyName = $question->getTypology()->getName();
                $subquestions = $question->getSubquestions();
                foreach ($subquestions as $subquestion) {
                    $subquestionsId[$subquestion->getId()] = $subquestion;
                    $rightProps["sub".$subquestion->getId()] = array();
                    $cptProposition = 0;
                    $propositions = $subquestion->getPropositions();
                    foreach ($propositions as $proposition) {
                        $cptProposition++;
                        if ($typologyName != "TLQROC") {
                            $propLetters[$proposition->getId()] = $this->intToLetter($cptProposition);
                        }
                        if ($proposition->getRightAnswer()) {
                              $rightProps["sub".$subquestion->getId()][] = $proposition->getId();
                         }
                    }
                }
            }
        }

        $csv .= "\n";

        return array($propLetters, $rightProps, $result, $csv, $typology, $theme, $subquestionsId);
    }
}
