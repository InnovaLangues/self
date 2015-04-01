<?php

namespace Innova\SelfBundle\Manager\Editor;

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
        $this->propositionRepo = $this->entityManager->getRepository('InnovaSelfBundle:Proposition');
    }

    public function createAppFakeAnswer(Proposition $currentProposition)
    {
        $currentSubquestion = $currentProposition->getSubquestion();
        $subquestions = $currentSubquestion->getQuestion()->getSubquestions();
        $otherPropositions = array();

        // on ajoute aux autres subquestions des propositions fausses
        foreach ($subquestions as $subquestion) {
            if ($subquestion != $currentSubquestion) {
                $this->propositionManager->createProposition($subquestion, $currentProposition->getMedia(), false);
                $otherPropositions = $subquestion->getPropositions();
            }
        }

        // reste à ajouter les propositions des autres à la subquestion courante.
        foreach ($otherPropositions as $otherProposition) {
            $media = $otherProposition->getMedia();
            if (!$this->propositionRepo->findOneBy(array("subquestion" => $currentSubquestion, "media" => $media))) {
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
            if ($propositionToDelete = $this->propositionRepo->findOneBy(array("subquestion" => $subquestion, "media" => $media))) {
                $em->remove($propositionToDelete);
            }
        }
        $em->flush();

        return true;
    }

    public function deleteDistractor(Question $question, Proposition $proposition)
    {
        $media = $proposition->getMedia();
        foreach ($question->getSubquestions() as $subquestion) {
            foreach ($subquestion->getPropositions() as $needle) {
                if ($needle->getMedia() == $media) {
                    $em->remove($needle);
                }
            }
        }
        $em->remove($media);
        $em->flush();

        return $this;
    }
}
