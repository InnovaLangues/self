<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Proposition;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Media;

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

    public function createVfPropositions(Questionnaire $questionnaire, Subquestion $subquestion, $questionnaireTypology)
    {
        if($questionnaireTypology == "VF" || $questionnaireTypology == "TVF" || $questionnaireTypology == "TVFNM" || $questionnaireTypology == "VFNM") {
            $true = $this->mediaManager->createMedia($questionnaire, "texte", "VRAI", "VRAI", null, 0, "proposition");
            $this->createProposition($subquestion, $true, false);
            $false = $this->mediaManager->createMedia($questionnaire, "texte", "FAUX", "FAUX", null, 0, "proposition");
            $this->createProposition($subquestion, $false, false);
        }
        if($questionnaireTypology == "TVFNM" || $questionnaireTypology == "VFNM") {
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
}
