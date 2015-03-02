<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Proposition;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Typology;
use Innova\SelfBundle\Entity\Media\Media;

class PropositionManager
{
    protected $entityManager;
    protected $mediaManager;

    public function __construct($entityManager, $mediaManager)
    {
        $this->entityManager = $entityManager;
        $this->mediaManager = $mediaManager;
    }

    public function createProposition(Subquestion $subquestion, Media $media, $rightAnswer)
    {
        $em = $this->entityManager;

        $proposition = new Proposition();
        $proposition->setSubquestion($subquestion);
        $proposition->setMedia($media);
        $proposition->setRightAnswer($rightAnswer);
        $em->persist($proposition);
        $em->flush();

        return $proposition;
    }

    public function createVfPropositions(Questionnaire $questionnaire, Subquestion $subquestion, Typology $typology)
    {
        $typologyName = $typology->getName();

        if ($typologyName == "TVF" || $typologyName == "TVFNM") {
            $true = $this->mediaManager->createMedia($questionnaire, "texte", "VRAI", "VRAI", null, 0, "proposition");
            $this->createProposition($subquestion, $true, false);
            $false = $this->mediaManager->createMedia($questionnaire, "texte", "FAUX", "FAUX", null, 0, "proposition");
            $this->createProposition($subquestion, $false, false);
        }
        if ($typologyName == "TVFNM") {
            $nd = $this->mediaManager->createMedia($questionnaire, "texte", "ND", "ND", null, 0, "proposition");
            $this->createProposition($subquestion, $nd, false);
        }

        return $this;
    }

    public function toggleRightAnswer(Proposition $proposition)
    {
        $em = $this->entityManager;

        if ($proposition->getRightAnswer() === true) {
            $proposition->setRightAnswer(false);
        } else {
            $proposition->setRightAnswer(true);
        }

        $em->persist($proposition);
        $em->flush();

        return $proposition;
    }

    public function duplicate(Proposition $proposition, Subquestion $subquestion)
    {
        $questionnaire = $subquestion->getQuestion()->getQuestionnaire();
        $question = $subquestion->getQuestion();
        $this->entityManager->refresh($question);
        $subquestions = $question->getSubquestions();
        $media = $proposition->getMedia();

        if ($question->getTypology()->getName() == "APP" && $subquestions->count() >= 2) {
            $baseSubquestion = $subquestions[0];
            $this->entityManager->refresh($baseSubquestion);
            foreach ($baseSubquestion->getPropositions() as $prop) {
                $propMedia = $prop->getMedia();
                if ($propMedia->getDescription() == $media->getDescription() && $propMedia->getUrl() == $media->getUrl() && $propMedia->getName() == $media->getName()) {
                    $newMedia = $propMedia;
                }
            }
        } else {
            $newMedia = $this->mediaManager->duplicate($media, $questionnaire);
        }

        $newProposition = $this->createProposition($subquestion, $newMedia, $proposition->getRightAnswer());

        return $newProposition;
    }
}
