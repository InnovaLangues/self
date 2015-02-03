<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Proposition;
use Innova\SelfBundle\Entity\Media\Media;
use Innova\SelfBundle\Entity\Question;

class AppManager
{
    protected $entityManager;
    protected $propositionManager;

    public function __construct($entityManager, $propositionManager)
    {
        $this->entityManager = $entityManager;
        $this->propositionManager = $propositionManager;
    }

    public function createAppFakeAnswer(Proposition $currentProposition)
    {
        $currentSubquestion = $currentProposition->getSubquestion();
        $subquestions = $currentSubquestion->getQuestion()->getSubquestions();

        // on ajoute aux autres subquestions des propositions fausses
        foreach ($subquestions as $subquestion) {
            if ($subquestion != $currentSubquestion) {
                $proposition = $this->propositionManager->createProposition($subquestion, $currentProposition->getMedia(), false);
                $otherPropositions = $subquestion->getPropositions();
            }
        }

        // reste à ajouter les propositions des autres à la subquestion courante.
        foreach ($otherPropositions as $otherProposition) {
            $media = $otherProposition->getMedia();
            $found = false;
            foreach ($currentSubquestion->getPropositions() as $currentSubProposition) {
                $currentMedia = $currentSubProposition->getMedia();
                if ($media == $currentMedia) {
                    $found = true;
                }
            }
            if ($found === false) {
                $this->propositionManager->createProposition($currentSubquestion, $media, false);
            }
        }

        return $this;
    }

    public function appDeletePropositions(Media $media, Question $question)
    {
        $em = $this->entityManager;

        $subquestions = $question->getSubquestions();
        foreach ($subquestions as $subquestion) {
            if ($propositionToDelete = $em->getRepository('InnovaSelfBundle:Proposition')->findOneBy(array("subquestion" => $subquestion, "media" => $media))) {
                $em->remove($propositionToDelete);
            }
        }
        $em->flush();

        return true;
    }
}
