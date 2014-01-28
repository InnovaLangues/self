<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Question;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Media;
use Innova\SelfBundle\Entity\Proposition;
use Innova\SelfBundle\Form\TestType;
use Innova\SelfBundle\Entity\Typology;

class ImportController extends Controller
{

    /**
     * importCsvSQLCoce function
     *
     * @Route(
     *     "/admin/csv_import/{language}/{type}",
     *     name = "csv_import_coce",
     *     requirements={"language" = "en|it","type" = "ce|co"}
     * )
     * @Method({"GET"})
     * @Template()
     */
    public function importCsvSQLCoceAction($language, $type)
    {

        $em = $this->getDoctrine()->getManager();

        echo $language;
        echo $type;

        //
        // CSV Import part
        //

        // File import path
        $csvPathImport    = '/media/Innova/SELF/Italien/'; // test sur le serveur "commun"
        $csvPathImport    =__DIR__.'/../../../../web/upload/import/csv/'; // Symfony

        // File import name
        $csvName = 'CE_pilote.csv'; // CE Italien à partir du serveur "commun"
        $csvName = 'CE_piloteII-27-01-14.csv'; // CE Italien

        // Symfony
        $urlCSVRelativeToWeb = 'upload/import/csv/';
        // Path + Name:wq
        $csvPath = $csvPathImport . $csvName;

        // File import path
        // Répertoire où seront stockés les fichiers
        $dir2copy =__DIR__.'/../../../../web/upload/import/mp3/'; // A modifier quand on aura l'adresse

        // File copy path
        // Répertoire où seront copiés les fichiers
        $dir_paste =__DIR__.'/../../../../web/upload/media/'; // A modifier quand on aura l'adresse


        // Traitement du fichier d'entrée afin de ne pas prendre la ou les premières lignes.
        // Contrainte : dans la colonne "A", il faut une donnée de type "entier" séquentielle (1 puis 2 ...)
        // Cette contrainte a été prise en compte par rapport au fichier reçu.
        $row = 0;
        $indice = 0;

        if (($handle = fopen($csvPath, "r+")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

                // Ainsi, je ne prends pas les intitulés des colonnes
                if ($row != 0) {
                    //
                    //
                    // Première partie : ajout dans la table Questionnaire
                    //
                    //

                    // Add to Questionnaire table
                    $questionnaire = new Questionnaire();
                    $language = $em->getRepository('InnovaSelfBundle:Language')->findOneByName("Italian");
                    $testName = "CO-pilote-dec2013-ang"; // For tests.
                    $testName = "CE_piloteII-27-01-14"; // For tests.

//                    if (!$test =  $em->getRepository('InnovaSelfBundle:Test')->findOneByName($testName)) {
                    if ($row == 1) {
                        echo "<br />Création du test row=1";
                        $test = new Test();
                        $test->setName($testName);
                        $test->setLanguage($language);
                        $em->persist($test);
                    }

                    $questionnaire->addTest($test);
                    //
                    // J'ai traité les colonnes de la table Questionnaire dans l'ordre
                    //
                    //
                    //
                    //
                    $data[1] = strtolower($data[1]); // Mise en minuscules du nom du fichier suite aux tests.

                    // Traitement sur le level
                    $libLevel = $data[2];
                    $level = $em->getRepository('InnovaSelfBundle:Level')->findOneByName($libLevel);
                    $questionnaire->setLevel($level);

                    // Traitement sur le skill
                    $libSkill = $data[3];
                    $skill = $em->getRepository('InnovaSelfBundle:Skill')->findOneByName($libSkill);
                    $questionnaire->setSkill($skill);

                    // Traitement sur la typologie
                    $libTypo = $data[4];
                    $typo = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($libTypo);

                    // Traitement des autres colonnes
                    $questionnaire->setAuthor();
                    $questionnaire->setInstruction();
                    $questionnaire->setSource();
                    $questionnaire->setDuration();
                    $questionnaire->setDomain();
                    $questionnaire->setSupport();
                    $questionnaire->setFlow();
                    $questionnaire->setFocus();
                    $questionnaire->setTheme($data[1]); // Thême

                    //Dialogue
                    $questionnaire->setDialogue(0);
                    // Vu avec Arnaud : 1 pour Dialogue / 0 pour Monologue
                    $libDialogue = $data[8];
                    $pos = strripos($libDialogue, 'dialogue');

                    if ($pos === false) {
                        $pos = strripos($libDialogue, 'monologue');
                        if (!($pos === false)) {
                            $questionnaire->setDialogue(0);
                        }
                    } else {
                        $questionnaire->setDialogue(1);
                    }

                    //ListeningLimit
                    $questionnaire->setListeningLimit($data[9]);

                    //Autres colonnes
                    $questionnaire->setMediaInstruction();
                    $questionnaire->setMediaContext();
                    $questionnaire->setMediaText();

                    $indice++;
                    echo "<br />" . $indice . " theme : "  . $questionnaire->getTheme();
                    // Enregistrement en base
                    $em->persist($questionnaire);

                    //
                    //
                    // Deuxième partie : traitement des fichiers de type "Media"
                    //
                    //
                    // $data[1]  = nom du répertoire = nom du thême
                    // $data[10] = nom de l'extension du fichier (ex : mp3)
                    //$this->copieFileDir($data[1], $data[10], $questionnaire, $dir2copy, $dir_paste);

                    //
                    //
                    // Troisième partie : travail sur les types TQRM et TQRU
                    //
                    //

            echo "dans boucle";
            echo $data[4];
            die();

                    // Traitement suivi le type de questionnaire.
                    switch ($data[4]) {
                        case "RE";
                        case "TQRU";
                        case "TQRM";
                            $this->tqrProcess($typo, $questionnaire, $data[11], $data, $dir2copy, $dir_paste);
                            break;
/*
                        case "QRU";
                        case "QRM";
                            $this->qrProcess($typo, $questionnaire, $data[11], $data, $dir2copy, $dir_paste);
                            break;
                        case "TVF";
                        case "VF";
                        case "VFPM";
                        case "TVFPM";
                            $this->vfProcess($typo, $questionnaire, $data[11], $data, $dir2copy, $dir_paste);
                            break;
                        case "APPAT";
                            $this->appatProcess($typo, $questionnaire, $data[11], $data, $dir2copy, $dir_paste);
                            break;
                        case "QRU_I";
                            $this->qruiProcess($typo, $questionnaire, $data[11], $data, $dir2copy, $dir_paste);
                            break;
                        case "APPAA";
                            $this->appaaProcess($typo, $questionnaire, $data[11], $data, $dir2copy, $dir_paste);
                            break;
                        case "APPAI";
                            $this->appaiProcess($typo, $questionnaire, $data[11], $data, $dir2copy, $dir_paste);
                            break;
*/
                    }

                    $em->flush();
                }
                $row++;
            }
            fclose($handle);
        }

        //SOX. To execute shell SOX command to have Ogg files. 13/01/2014.
        //shell_exec(__DIR__.'/../../../../import/import.sh > ' . __DIR__ . '/../../../../import/logs/import.log');

        //
        // To view
        //
        return array(
            "urlCSVRelativeToWeb" => $urlCSVRelativeToWeb,
            "csvName"             => $csvName
        );
    }

    /**
     * appaiProcess function
     *
     */
    private function appaiProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);

        $medias = array();
        $this->mediaAppaiPropositionProcess($data[1], $medias, $dir2copy, $dir_paste);

        $nbItems = $data[11];
        // Traitement sur le nombre d'items
        for ($i = 0; $i < $nbItems; $i++) {
            // Créer une occurrence dans la table "SubQuestion"
            $subQuestion = new Subquestion();
            $this->processAmorceSubquestion($i+1, $subQuestion, $dir2copy, $dir_paste, $data);

            $subQuestion->setTypology($typo);
            $subQuestion->setQuestion($question);

            $this->mediaAppaiSubQuestionProcess($data[1], $i, $dir2copy, $dir_paste, $subQuestion);

            // Voir le traitement de l'amorce // AB.
            $em->persist($subQuestion);

            $nbMedias = count($medias); #80
            for ($j = 0; $j <  $nbMedias; $j++) {
                $this->propositionAppaiProcess($i, $j, $subQuestion, $medias[$j]);
            }
        }
    }

    /**
     * mediaAppaiPropositionProcess function
     *
     */
    private function mediaAppaiPropositionProcess($dirName, &$medias, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        $i = 1;

        while (file_exists($dir2copy . $dirName . "/reponse_" . $i . ".jpg")) {
            $media = new Media();
            $media->setName($dirName . "_reponse_" . $i);
            $media->setUrl($dirName . "_reponse_" . $i . "_" . uniqid());

            $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("image"));

            // Enregistrement en base
            $em->persist($media);

            // Copie du fichier
            $fileCopy = $media->getUrl();
            copy($dir2copy . $dirName . "/reponse_" . $i . ".jpg", $dir_paste . $fileCopy . ".jpg");

            $medias[] = $media;
            $i++;
        }
    }

    /**
     * mediaAppaiSubQuestionProcess function
     *
     */
    private function mediaAppaiSubQuestionProcess($dirName, $i, $dir2copy, $dir_paste, Subquestion $subQuestion)
    {
        $em = $this->getDoctrine()->getManager();

        $indice = $i+1;

        $testFile = $dir2copy . $dirName . "/option_" . $indice . ".mp3";

        if (file_exists($testFile)) {
            // Création dans "Media"
            $media = new Media();
            $media->setName($dirName . "_option_" . $indice);
            $media->setUrl($dirName . "_option_" . $indice . "_" . uniqid());

            $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("audio"));

            // Enregistrement en base
            $em->persist($media);

            $subQuestion->setMedia($media);

            // Copie du fichier
            $fileCopy = $media->getUrl();
            copy($testFile, $dir_paste . $fileCopy . ".mp3");
        }
    }

    /**
     * propositionAppaaProcess function
     *
     */
    private function propositionAppaiProcess($i, $j, $subQuestion, $media)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);

        if ($i == $j) {
            $proposition->setRightAnswer(true);
        } else {
            $proposition->setRightAnswer(false);
        }

        $proposition->setMedia($media);

        // Enregistrement en base
        $em->persist($proposition);
        //$em->flush();
    }

    /**
     * appaProcess function
     *
     */
    private function appaaProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);

        $medias = array();
        $this->mediaAppaaPropositionProcess($data[1], $medias, $dir2copy, $dir_paste);

        $nbItems = $data[11];
        // Traitement sur le nombre d'items
        for ($i = 0; $i < $nbItems; $i++) {
            // Créer une occurrence dans la table "SubQuestion"
            $subQuestion = new Subquestion();
            $this->processAmorceSubquestion($i+1, $subQuestion, $dir2copy, $dir_paste, $data);

            $subQuestion->setTypology($typo);
            $subQuestion->setQuestion($question);

            $this->mediaAppaaSubQuestionProcess($data[1], $i, $dir2copy, $dir_paste, $subQuestion);

            // Voir le traitement de l'amorce // AB.
            $em->persist($subQuestion);

            $nbMedias = count($medias); #80
            for ($j = 0; $j < $nbMedias; $j++) {
                $this->propositionAppaaProcess($i, $j, $subQuestion, $medias[$j]);
            }
        }
    }

    /**
     * mediaAppaaSubQuestionProcess function
     *
     */
    private function mediaAppaaSubQuestionProcess($dirName, $i, $dir2copy, $dir_paste, Subquestion $subQuestion)
    {
        $em = $this->getDoctrine()->getManager();

        $indice = $i+1;
        $testFile = $dir2copy . $dirName . "/option_" . $indice . ".mp3";

        if (file_exists($testFile)) {
            // Création dans "Media"
            $media = new Media();
            $media->setName($dirName . "_option_" . $indice);
            $media->setUrl($dirName . "_option_" . $indice . "_" . uniqid());

            $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("audio"));

            // Enregistrement en base
            $em->persist($media);

            $subQuestion->setMedia($media);

            // Copie du fichier
            $fileCopy = $media->getUrl();
            copy($testFile, $dir_paste . $fileCopy . ".mp3");
        }
    }

    /**
     * mediaAppaaPropositionProcess function
     *
     */
    private function mediaAppaaPropositionProcess($dirName, &$medias, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        $i = 1;

        while (file_exists($dir2copy . $dirName . "/reponse_" . $i . ".mp3")) {
            $media = new Media();
            $media->setName($dirName . "_reponse_" . $i);
            $media->setUrl($dirName . "_reponse_" . $i . "_" . uniqid());

            $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("audio"));

            // Enregistrement en base
            $em->persist($media);

            // Copie du fichier
            $fileCopy = $media->getUrl();
            copy($dir2copy . $dirName . "/reponse_" . $i . ".mp3", $dir_paste . $fileCopy . ".mp3");

            $medias[] = $media;
            $i++;
        }
    }

    /**
     * propositionAppaaProcess function
     *
     */
    private function propositionAppaaProcess($i, $j, $subQuestion, $media)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);

        if ($i == $j) {
            $proposition->setRightAnswer(true);
        } else {
            $proposition->setRightAnswer(false);
        }

        $proposition->setMedia($media);

        // Enregistrement en base
        $em->persist($proposition);
        //$em->flush();
    }

    /**
     * copieFileDir function
     *
     */
    //#77
    private function copieFileDir($mediaDir, $itemExtention, Questionnaire $questionnaire, $dir2copy, $dir_paste)
    {

        $em = $this->getDoctrine()->getManager();

        // File import path
        // Répertoire où seront stockés les fichiers
        //$dir2copy =__DIR__.'/../../../../web/upload/test_eric/'; // A modifier quand on aura l'adresse

        // File copy path
        // Répertoire où seront copiés les fichiers
        //$dir_paste =__DIR__.'/../../../../web/upload/test_eric/media/'; // A modifier quand on aura l'adresse

        if (is_dir($dir2copy)) {
            // Si oui, on l'ouvre
            if ($dh = opendir($dir2copy)) {
                $filesToCopy = array('consigne', 'texte', 'contexte');
                // Consigne = audio
                // Item = cf Excel
                // Contexte = audio
                foreach ($filesToCopy as $fichier) {

                    if ($fichier != 'texte') {
                        $newItemExtention = "mp3";
                    } else {
                         $newItemExtention = $itemExtention;
                    }

                    // Recherche si le fichier existe
                    // S'il n'existe pas, je passe au suivant.
                    //
                    $testFile = $dir2copy . $mediaDir . '/' . $fichier . "." . $newItemExtention;

                    if (file_exists($testFile)) {
                        // Création dans "Media"
                        $media = new Media();
                        $media->setName($mediaDir . "_" . $fichier);
                        $media->setUrl($mediaDir . "_" . $fichier . "_" . uniqid());

                        // Tableau d'extension
                        $aMedia["label"] = array("audio", "video");
                        $aMedia["extension"][0] = array('mp3');
                        $aMedia["extension"][1] = array('flv', 'mp4');

                        // Traitement suivant le type de fichier.
                        if ($fichier != 'texte') {
                            $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("audio");
                        } else {
                            foreach ($aMedia["extension"] as $key => $value) {
                                if (in_array($newItemExtention, $value)) {
                                    $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName($aMedia["label"][$key]);
                                }
                            }
                        }
                        $media->setMediaType($mediaType);

                        // Enregistrement en base
                        $em->persist($media);

                        // Copie du fichier
                        $fileCopy = $media->getUrl();
                        copy($dir2copy . $mediaDir . '/' . $fichier . "." . $newItemExtention, $dir_paste . $fileCopy . "." . $newItemExtention);

                        // Mise à jour de Questionnaire suivant le type de média
                        switch ($fichier) {
                            case 'consigne':
                                $questionnaire->setMediaInstruction($media);
                                break;
                            case 'texte':
                                $questionnaire->setMediaText($media);
                                break;
                            case 'contexte':
                                $questionnaire->setMediaContext($media);
                                break;
                        }

                        // Enregistrement en base
                        $em->persist($questionnaire);
                        $em->flush();
                    }
                }
              // On ferme $dir2copy
              closedir($dh);
            }
       }
    }

    /**
     * processAmorceSubquestion function
     *
     */
    private function processAmorceSubquestion($i, Subquestion $subQuestion, $dir2copy, $dir_paste, $data)
    {
        $em = $this->getDoctrine()->getManager();
        $mediaDir = $data[1];
        $typo = $data[4];

        if ($typo[0] == "T" && $typo != "TVF" && $typo != "TVFPM") {
            $testFile = $dir2copy . $mediaDir . "/amorce_" . $i. ".mp3";
        } else {
            $testFile = $dir2copy . $mediaDir . "/amorce.mp3";
        }

        if (file_exists($testFile)) {
            $media = new Media();
            $media->setUrl($mediaDir . "_amorce_" . $i . "_" . uniqid());
            $media->setName($mediaDir . "_amorce_" .$i);
            $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("audio"));
            $em->persist($media);
            $subQuestion->setMediaAmorce($media);

            copy($testFile, $dir_paste . $media->getUrl() . ".mp3");
        }
    }

    /**
     * tqrProcess function
     *
     */
    private function tqrProcess(Typology $typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);
      //  $em->flush();

        // Traitement sur le nombre d'items
        for ($i = 1; $i <= $nbItems; $i++) {
            // Créer une occurrence dans la table "SubQuestion"
            $subQuestion = new Subquestion();
            $this->processAmorceSubquestion($i, $subQuestion, $dir2copy, $dir_paste, $data);

            $libTypoSubQuestion = substr($typo->getName(), 1); // J'enlève le premier caractère de la typoQuestion pour avoir la typoSubQuestion
            $typoSubQuestion = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($libTypoSubQuestion);
            $subQuestion->setTypology($typoSubQuestion);
            $subQuestion->setQuestion($question);

            // Voir le traitement de l'amorce // AB.
            $em->persist($subQuestion);
        //    $em->flush();

            // Créer une occurrence dans la table "Proposition"
            $indice = 11+(2*$i);
            $nbProposition = $data[$indice];
            $rightAnswer = $data[$indice-1];

            for ($j=1; $j <= $nbProposition; $j++) {
                $this->propositionProcess($i, $j, $rightAnswer, $data[1], $subQuestion, $dir2copy, $dir_paste, $nbItems);
            }
        }
    }

    /**
     * qrProcess function
     *
     */
    private function qrProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);

        // Traitement sur le nombre d'items
        // Créer une occurrence dans la table "SubQuestion"
        $subQuestion = new Subquestion();
        $this->processAmorceSubquestion(1, $subQuestion, $dir2copy, $dir_paste, $data);
        $subQuestion->setTypology($typo);
        $subQuestion->setQuestion($question);

        // Voir le traitement de l'amorce // AB.
        $em->persist($subQuestion);

        // Créer une occurrence dans la table "Proposition"
        $nbProposition = $data[13];
        $rightAnswer = $data[12];

        for ($j=1; $j <= $nbProposition; $j++) {
            $this->propositionProcess(1, $j, $rightAnswer, $data[1], $subQuestion, $dir2copy, $dir_paste, $nbItems);
        }
    }

    /**
     * vfProcess function
     *
     */
    private function vfProcess(Typology $typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);
        //$em->flush();

        $dirName = $data[1];

        // Traitement sur le nombre d'items
        for ($i = 1; $i <= $nbItems; $i++) {
            // Créer une occurrence dans la table "SubQuestion"
            $subQuestion = new Subquestion();
            if ($i == 1) $this->processAmorceSubquestion($i, $subQuestion, $dir2copy, $dir_paste, $data);

            $ctrlTypo = $typo->getName();
            if ($ctrlTypo[0] == "T") {
                $libTypoSubQuestion = substr($typo->getName(), 1); // J'enlève le premier caractère de la typoQuestion pour avoir la typoSubQuestion
                $typoSubQuestion = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($libTypoSubQuestion);
                $subQuestion->setTypology($typoSubQuestion);
            } else {
                $subQuestion->setTypology($typo);
            }
            $subQuestion->setQuestion($question);

            // Recherche si le fichier existe
            // S'il n'existe pas, je passe au suivant.
            //
            $fileName = "option_" . $i;
            $testFile = $dir2copy . $dirName . '/' . $fileName . ".mp3";

            if (file_exists($testFile)) {
                // Création dans "Media"
                $media = new Media();
                $media->setName($dirName . "_" . $fileName);
                $media->setUrl($dirName . "_" . $fileName . "_" . uniqid());

                $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("audio");
                $media->setMediaType($mediaType);
                $subQuestion->setMedia($media);

                // Enregistrement en base
                $em->persist($media);
                copy($dir2copy . $dirName . "/" . $fileName . ".mp3", $dir_paste . '/' . $media->getUrl() . ".mp3");
            }

            // Voir le traitement de l'amorce // AB.
            $em->persist($subQuestion);

            // Créer une occurrence dans la table "Proposition"
            $indice = 11+(2*$i);
            $rightAnswer = $data[$indice-1];

            $this->vfPropositionProcess($rightAnswer, "VRAI", "V", $subQuestion);
            $this->vfPropositionProcess($rightAnswer, "FAUX", "F", $subQuestion);

            if ($data[$indice] == "VFPM") {
                $this->vfPropositionProcess($rightAnswer, "PM", "PM", $subQuestion); // PM : à confirmer
            }
        }
    }

    /**
     * vfPropositionProcess function
     *
     */
    private function vfPropositionProcess($rightAnswer, $nameProposition, $expectedAnswer, $subQuestion)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);
        if ($rightAnswer == $expectedAnswer) {
            $proposition->setRightAnswer(true);
        } else {
            $proposition->setRightAnswer(false);
        }

        if (!$media = $em->getRepository('InnovaSelfBundle:Media')->findOneByName($nameProposition)) {
            // Création dans "Media"
            $media = new Media();
            $media->setName($nameProposition); // Ajout contrôle existance V ou F

            $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("texte");
            $media->setMediaType($mediaType);
        }
        $em->persist($media);

        $proposition->setMedia($media);
        $em->persist($proposition);

        $em->flush();
    }

    /**
     * appatProcess function
     *
     */
    private function appatProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);
      //  $em->flush();

        $medias = array();
        $nbItems = $data[11];
        for ($i=0; $i < $nbItems; $i++) {
            $indice = 12+(2*$i);
            $this->mediaAppatProcess($data[$indice], $medias);
        }

        // Traitement sur le nombre d'items
        for ($i = 0; $i < $nbItems; $i++) {
            // Créer une occurrence dans la table "SubQuestion"
            $subQuestion = new Subquestion();
            $this->processAmorceSubquestion($i+1, $subQuestion, $dir2copy, $dir_paste, $data);

            $subQuestion->setTypology($typo);
            $subQuestion->setQuestion($question);

            // Voir le traitement de l'amorce // AB.
            $em->persist($subQuestion);
        //    $em->flush();

            // Créer une occurrence dans la table "Proposition"
            $indice = 11+(2*$i);

            $nbMedias = count($medias); #80
            for ($j=0; $j < $nbMedias; $j++) {
                $this->propositionAppatProcess($i, $j, $subQuestion, $medias[$j]);
            }
        }
    }

    /**
     * propositionAppatProcess function
     *
     */
    private function propositionAppatProcess($i, $j, $subQuestion, $media)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);

        if ($i == $j) {
            $proposition->setRightAnswer(true);
        } else {
            $proposition->setRightAnswer(false);
        }

        $proposition->setMedia($media);

        // Enregistrement en base
        $em->persist($proposition);
        //$em->flush();
    }

    /**
     * qruiProcess function
     *
     */
    private function qruiProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);
      //  $em->flush();

        // Créer une occurrence dans la table "SubQuestion"
        $subQuestion = new Subquestion();
        $this->processAmorceSubquestion(1, $subQuestion, $dir2copy, $dir_paste, $data);
        $subQuestion->setTypology($typo);
        $subQuestion->setQuestion($question);

        // Voir le traitement de l'amorce // AB.
        $em->persist($subQuestion);
        // $em->flush();

        // Créer une occurrence dans la table "Proposition"
        $nbProposition = $data[13];
        $rightAnswer = $data[12];

        for ($j=1; $j <= $nbProposition; $j++) {
            $this->propositionQruiProcess($j, $subQuestion, $rightAnswer, $dir2copy, $data[1], $dir_paste);
        }
    }

    /**
     * propositionQruiProcess function
     *
     */
    private function propositionQruiProcess($j, $subQuestion, $rightAnswer, $dir2copy, $dirName, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);

        if ($j == $rightAnswer) {
            $proposition->setRightAnswer(true);
        } else {
            $proposition->setRightAnswer(false);
        }

        // Recherche si le fichier existe
        // S'il n'existe pas, je passe au suivant.
        //
        $fileName = "option_" . $j;
        $testFile = $dir2copy . $dirName . '/' . $fileName . ".jpg";

        if (file_exists($testFile)) {
            // Création dans "Media"
            $media = new Media();
            $media->setName($dirName . "_" . $fileName);
            $media->setUrl($dirName . "_" . $fileName . "_" . uniqid() . ".jpg");

            $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("image");
            $media->setMediaType($mediaType);
            $proposition->setMedia($media);

            // Enregistrement en base
            $em->persist($media);

            copy($dir2copy . $dirName . "/" . $fileName . ".jpg", $dir_paste . $fileName . ".jpg");
        }

        // Enregistrement en base
        $em->persist($proposition);
        //$em->flush();
    }

    /**
     * propositionProcess function
     *
     */
    private function propositionProcess($i, $j, $rightAnswer, $dirName, $subQuestion, $dir2copy, $dir_paste, $nbItems)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);

        // Formatage et test si le fichier existe
        // exemple de nom de fichier : option_1_2.mp3
        if ($nbItems == 1 ) // Test QRU/QRM
            $fileName = "option" . "_" . $j;
        else
            $fileName = "option" . "_" . $i . "_" . $j;

        $pathFileName = $dir2copy . $dirName . "/" . $fileName;

        $extension = ".mp3";

        if (file_exists($pathFileName . $extension)) {
            if (preg_match("/".$j."/", $rightAnswer)) {
                $proposition->setRightAnswer(true);
            } else {
                $proposition->setRightAnswer(false);
            }

            // Création dans "Media"
            $media = new Media();
            $media->setName($dirName . "_" . $fileName);
            $media->setUrl($dirName . "_" . $fileName . "_" . uniqid());

            $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("audio");
            $media->setMediaType($mediaType);
            $proposition->setMedia($media);

            // Enregistrement en base
            $em->persist($media);

            // Copie du fichier
            copy($pathFileName . $extension, $dir_paste . '/' . $media->getUrl() . $extension);
        } else {
            echo "<br/>PAS TROUVE !" . $pathFileName . $extension;
        }

        // Enregistrement en base
        $em->persist($proposition);
        //$em->flush();

    }

    /**
     * mediaAppatProcess function
     *
     */
    private function mediaAppatProcess($texte, &$medias)
    {
        $em = $this->getDoctrine()->getManager();
        // Création dans "Media"
        $media = new Media();
        $media->setName($texte);

        $mediaType = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("texte");
        $media->setMediaType($mediaType);

        $em->persist($media);
        $medias[] = $media;
    }

}
