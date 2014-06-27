<?php

namespace Innova\SelfBundle\Manager;

class AppManager
{
    protected $entityManager;
    protected $propositionManager;

    public function __construct($entityManager, $propositionManager)
    {
        $this->entityManager = $entityManager;
        $this->propositionManager = $propositionManager;
    }

    public function createAppFakeAnswer($currentProposition)
    {
        $currentSubquestion = $currentProposition->getSubquestion();
        $question = $currentSubquestion->getQuestion();
        $subquestions = $question->getSubquestions();

        $propositions = array();

        // on ajoute aux autres subquestions des propositions
        foreach ($subquestions as $subquestion) {
            if ($subquestion != $currentSubquestion) {
                $propositions = $subquestion->getPropositions();
                $proposition = $this->propositionManager->createProposition($subquestion, $currentProposition->getMedia(), false);
            }
        }

        // reste à ajouter les propositions des autres à la subquestion courante.
        foreach ($propositions as $proposition) {
            $mediaId = $proposition->getMedia()->getId();
            $media = $proposition->getMedia();
            $found = false;
            foreach ($currentSubquestion->getPropositions() as $currentSubquestionProposition) {
                $currentMediaId = $currentSubquestionProposition->getMedia()->getId();
                if ($mediaId == $currentMediaId) {
                    $found = true;
                }
            }
            if ($found == false) {
                $proposition = $this->propositionManager->createProposition($currentSubquestion, $media, false);
            }
        }

        return true;
    }

    public function appDeletePropositions($media, $question)
    {
        $em = $this->entityManager;

        $subquestions = $question->getSubquestions();
        foreach ($subquestions as $subquestion) {
            $propositionToDelete = $em->getRepository('InnovaSelfBundle:Proposition')->findOneBy(array("subquestion" => $subquestion, "media" => $media));
            $em->remove($propositionToDelete);
        }
        $em->flush();

        return true;
    }
}
