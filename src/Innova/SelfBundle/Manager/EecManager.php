<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Clue;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Media\Media;

class EecManager
{
    protected $entityManager;
    protected $questionManager;
    protected $subquestionManager;
    protected $propositionManager;
    protected $mediaManager;

    public function __construct($entityManager, $questionManager, $subquestionManager, $propositionManager, $mediaManager)
    {
        $this->entityManager = $entityManager;
        $this->questionManager = $questionManager;
        $this->subquestionManager = $subquestionManager;
        $this->propositionManager = $propositionManager;
        $this->mediaManager = $mediaManager;
    }

    public function createListe(Questionnaire $questionnaire)
    {
        $em = $this->entityManager;
        // récupération des medias des distracteurs
        $i = 0;
        $distractors = array();
        foreach ($questionnaire->getQuestions()[0]->getSubquestions() as $subquestion) {
            $distractors[$i] = array();
            foreach ($subquestion->getPropositions() as $proposition) {
                if ($proposition->getMedia()->getMediaPurpose() && $proposition->getMedia()->getMediaPurpose()->getName() == "distractor") {
                    $distractors[$i][] = $proposition->getMedia();
                }
            }
            $i++;
        }

        $question = $this->questionManager->removeSubquestions($questionnaire->getQuestions()[0]);

        if ($questionnaire->getMediaBlankText()) {
            $texte = $questionnaire->getMediaBlankText()->getDescription();

            preg_match_all("/#(.*?)#/", $texte, $lacunes);

            $countLacunes = count($lacunes[1]);
            for ($i = 0; $i < $countLacunes; $i++) {
                $lacune = $lacunes[1][$i];
                $subquestion = $this->subquestionManager->createSubquestion($question->getTypology(), $question);
                $lacuneMedia = $this->mediaManager->createMedia($questionnaire, "texte", $lacune, $lacune, null, 0, "proposition");
                $this->propositionManager->createProposition($subquestion, $lacuneMedia, true);

                if ($question->getTypology()->getName() == "TLCMLDM") {
                    for ($j = 0; $j < $countLacunes; $j++) {
                        if ($j != $i) {
                            $lacune = $lacunes[1][$j];
                            $lacuneMedia = $this->mediaManager->createMedia($questionnaire, "texte", $lacune, $lacune, null, 0, "proposition");
                            $this->propositionManager->createProposition($subquestion, $lacuneMedia, false);
                        }
                    }
                }
                // réinjection des distracteurs.
                if (!empty($distractors[$i])) {
                    foreach ($distractors[$i] as $media) {
                        $this->propositionManager->createProposition($subquestion, $media, false);
                    }
                }

                $em->persist($lacuneMedia);
                $em->refresh($subquestion);
            }
            $em->flush();
        }

        return $questionnaire;
    }

    public function createLacune(Questionnaire $questionnaire)
    {
        $em = $this->entityManager;
        // récupération des indices et syllabes
        $i = 0;
        $clues = array();
        $syllables = array();
        foreach ($questionnaire->getQuestions()[0]->getSubquestions() as $subquestion) {
            $clues[$i] = $subquestion->getClue();
            $syllables[$i] = $subquestion->getMediaSyllable();
            $i++;
        }

        $question = $this->questionManager->removeSubquestions($questionnaire->getQuestions()[0]);
        if ($questionnaire->getMediaBlankText()) {
            $texte = $questionnaire->getMediaBlankText()->getDescription();

            preg_match_all("/#(.*?)#/", $texte, $lacunes);

            $countLacunes = count($lacunes[1]);
            for ($i = 0; $i < $countLacunes; $i++) {
                $lacune = $lacunes[1][$i];
                $subquestion = $this->subquestionManager->createSubquestion($question->getTypology(), $question);
                $lacuneMedia = $this->mediaManager->createMedia($questionnaire, "texte", $lacune, $lacune, null, 0, "proposition");
                $em->persist($lacuneMedia);
                $this->propositionManager->createProposition($subquestion, $lacuneMedia, true);
                $em->refresh($subquestion);

                // réinjection des indices et syllabes
                if (!empty($clues[$i])) {
                    $subquestion->setClue($clues[$i]);
                    $em->persist($subquestion);
                }

                if (!empty($syllables[$i])) {
                    $subquestion->setMediaSyllable($syllables[$i]);
                    $em->persist($subquestion);
                }
            }
            $em->flush();
        }

        return $questionnaire;
    }

    public function createClue(Questionnaire $questionnaire, Subquestion $subquestion, $clueName)
    {
        $em = $this->entityManager;

        if ($clueName == "" && $clue = $subquestion->getClue()) {
            $subquestion->setClue(null);
        } else {
            if (!$clue = $subquestion->getClue()) {
                $clue = new Clue();
                $clue->setClueType($em->getRepository('InnovaSelfBundle:ClueType')->findOneByName("fonctionnel"));

                $subquestion->setClue($clue);
                $em->persist($clue);
                $em->persist($subquestion);
            }

            if (!$media = $subquestion->getClue()->getMedia()) {
                $media = $this->mediaManager->createMedia($questionnaire, "texte", $clueName, $clueName, null, 0, "clue");
                $clue->setMedia($media);
                $em->persist($clue);
            } elseif ($media->getDescription() != $clueName) {
                $media->setDescription($clueName);
                $media->setName($clueName);
                $em->persist($media);
            }
        }
        $em->flush();

        return $questionnaire;
    }

    public function setClueType($clueId, $clueTypeName)
    {
        $em = $this->entityManager;

        $clue = $em->getRepository('InnovaSelfBundle:Clue')->find($clueId);
        $clueType = $em->getRepository('InnovaSelfBundle:ClueType')->findOneByName($clueTypeName);

        $clue->setClueType($clueType);
        $em->persist($clue);
        $em->flush();

        return $clue;
    }

    public function createSyllabe($syllable, Questionnaire $questionnaire, $subquestion)
    {
        $em = $this->entityManager;

        if ($syllable == "") {
            $syllableMedia = null;
        } elseif (!$syllableMedia = $subquestion->getMediaSyllable()) {
            $syllableMedia = $this->mediaManager->createMedia($questionnaire, "texte", $syllable, $syllable, null, 0, "syllable");
        } else {
            $syllableMedia->setDescription($syllable);
            $syllableMedia->setName($syllable);
            $em->persist($syllableMedia);
        }
        $subquestion->setMediaSyllable($syllableMedia);
        $em->persist($subquestion);
        $em->flush();

        return $questionnaire;
    }

    public function addDistractor(Questionnaire $questionnaire)
    {
        $em = $this->entityManager;
        $media = $this->mediaManager->createMedia($questionnaire, "texte", "", "", null, 0, "distractor");

        foreach ($questionnaire->getQuestions()[0]->getSubquestions() as $subquestion) {
            $this->propositionManager->createProposition($subquestion, $media, false);

            $em->persist($subquestion);
            $em->refresh($subquestion);
        }
        $em->flush();

        return $questionnaire;
    }

    public function addDistractorMult(Questionnaire $questionnaire, Subquestion $subquestion)
    {
        $em = $this->entityManager;
        $media = $this->mediaManager->createMedia($questionnaire, "texte", "", "", null, 0, "distractor");

        $this->propositionManager->createProposition($subquestion, $media, false);

        $em->persist($subquestion);
        $em->refresh($subquestion);
        $em->flush();

        return $subquestion;
    }

    public function editDistractor(Media $media, $text)
    {
        $em = $this->entityManager;

        $media->setDescription($text);
        $media->setName($text);
        $em->persist($media);

        $em->flush();

        return $media;
    }

    public function getAnswers(Subquestion $subquestion)
    {
        $propositions = $subquestion->getPropositions();
        $answers = array();

        foreach ($propositions as $proposition) {
            if ($proposition->getMedia()->getMediaPurpose()->getName() == "reponse") {
                $answers[$proposition->getMedia()->getDescription()] = $proposition;
            }
        }

        ksort($answers);

        return $answers;
    }
}
