<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Question;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Media;
use Innova\SelfBundle\Entity\Proposition;
use Innova\SelfBundle\Form\TestType;
use Innova\SelfBundle\Entity\MediaType;
use Symfony\Component\Security\Core\Util\SecureRandom;

class TqrController extends Controller
{

    /**
     * tqrProcess function
     *
     */
    public function tqrProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {

        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);
      //  $em->flush();

        // Traitement sur le nombre d'items
        for ( $i = 1; $i <= $nbItems; $i++ )
        {
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
    public function qrProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Question"
        $question = new Question();

        $question->setQuestionnaire($questionnaire);
        $question->setTypology($typo);

        $em->persist($question);
        //$em->flush();

        // Traitement sur le nombre d'items
        // Créer une occurrence dans la table "SubQuestion"
        $subQuestion = new Subquestion();
        $this->processAmorceSubquestion(1, $subQuestion, $dir2copy, $dir_paste, $data);
        $subQuestion->setTypology($typo);
        $subQuestion->setQuestion($question);

        // Voir le traitement de l'amorce // AB.
        $em->persist($subQuestion);
        //$em->flush();

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
    public function vfProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
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
        for ( $i = 1; $i <= $nbItems; $i++ )
        {
            // Créer une occurrence dans la table "SubQuestion"
            $subQuestion = new Subquestion();
            $this->processAmorceSubquestion($i, $subQuestion, $dir2copy, $dir_paste, $data);

            $ctrlTypo = $typo->getName();
            if ($ctrlTypo[0] == "T")
            {
                $libTypoSubQuestion = substr($typo->getName(), 1); // J'enlève le premier caractère de la typoQuestion pour avoir la typoSubQuestion
                $typoSubQuestion = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($libTypoSubQuestion);
                $subQuestion->setTypology($typoSubQuestion);
            }
            else
            {
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
            // $em->flush();

            // Créer une occurrence dans la table "Proposition"
            $indice = 11+(2*$i);
            $rightAnswer = $data[$indice-1];

            $this->vfPropositionProcess($rightAnswer, "VRAI", "V", $subQuestion);
            $this->vfPropositionProcess($rightAnswer, "FAUX", "F", $subQuestion);

            if ($data[$indice] == "VFPM")
            {
                $this->vfPropositionProcess($rightAnswer, "PM", "PM", $subQuestion); // PM : à confirmer
            }
        }
    }

    /**
     * vfPropositionProcess function
     *
     */
    public function vfPropositionProcess($rightAnswer, $nameProposition, $expectedAnswer, $subQuestion)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);
        if ($rightAnswer == $expectedAnswer)
        {
            $proposition->setRightAnswer(true);
        }
        else
        {
            $proposition->setRightAnswer(false);
        }

        if (!$media = $em->getRepository('InnovaSelfBundle:Media')->findOneByName($nameProposition)){
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
    public function appatProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
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
        for ( $i = 0; $i < $nbItems; $i++ )
        {
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
            $nbProposition = $data[$indice];
            $rightAnswer = $data[$indice-1];

            for ($j=0; $j < count($medias); $j++) {
                $this->propositionAppatProcess($i, $j, $subQuestion, $medias[$j]);
            }
        }
    }

    /**
     * propositionAppatProcess function
     *
     */
    public function propositionAppatProcess($i, $j, $subQuestion, $media)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);

        if ($i == $j)
        {
            $proposition->setRightAnswer(true);
        }
        else
        {
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
    public function qruiProcess($typo, $questionnaire, $nbItems, $data, $dir2copy, $dir_paste)
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
    public function propositionQruiProcess($j, $subQuestion, $rightAnswer, $dir2copy, $dirName, $dir_paste)
    {
        $em = $this->getDoctrine()->getManager();

        // Créer une occurrence dans la table "Proposition"
        $proposition = new Proposition();
        $proposition->setSubquestion($subQuestion);

        if ($j == $rightAnswer)
        {
            $proposition->setRightAnswer(true);
        }
        else
        {
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
    public function propositionProcess($i, $j, $rightAnswer, $dirName, $subQuestion, $dir2copy, $dir_paste, $nbItems)
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
            if (preg_match("/".$j."/", $rightAnswer))
            {
                $proposition->setRightAnswer(true);
            }
            else
            {
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
        }

        // Enregistrement en base
        $em->persist($proposition);
        //$em->flush();

    }

    /**
     * mediaAppatProcess function
     *
     */
    public function mediaAppatProcess($texte, &$medias)
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

     /**
     * dragAction function
     *
     * @Route(
     *     "/drag",
     *     name = "drag",
     *     options = {"expose"=true}
     * )
     *
     * @Method("GET")
     * @Template()
     */
    public function dragAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InnovaSelfBundle:Typology')->findAll();

        return array(
            'entities' => $entities
        );
    }

    /**
     * dragNew function
     *
     * @Route(
     *     "/drag/new",
     *     name = "drag_new",
     *     options = {"expose"=true}
     * )
     *
     * @Method("GET")
     * @Template()
     */
    public function dragNewAction()
    {

        echo "ici";
        die();
        // Ici, on peut faire le traitement suite à la validation.
        //
        // Appel de la redirection après la validation.
        return $this->redirect($this->generateUrl('drag'));

    }

}
