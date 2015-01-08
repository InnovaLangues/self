<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Typology;
use Innova\SelfBundle\Entity\Question;
use Innova\SelfBundle\Entity\Clue;

class SubquestionManager
{
    protected $entityManager;
    protected $mediaManager;
    protected $propositionManager;

    public function __construct(
        $entityManager,
        $mediaManager,
        $propositionManager
    ) {
        $this->entityManager = $entityManager;
        $this->mediaManager = $mediaManager;
        $this->propositionManager = $propositionManager;
    }

    public function createSubquestion(Typology $typology = null, Question $question)
    {
        $em = $this->entityManager;

        $subquestion = new Subquestion();
        $subquestion->setTypology($typology);
        $subquestion->setQuestion($question);
        $subquestion->setDisplayAnswer(false);

        $em->persist($subquestion);
        $em->flush();

        return $subquestion;
    }

    public function duplicate(Subquestion $subquestion, Question $question)
    {
        $em = $this->entityManager;
        $questionnaire = $question->getQuestionnaire();

        $newSubquestion = $this->createSubquestion($subquestion->getTypology(), $question);
        $newSubquestion->setTitle($subquestion->getTitle());
        $newSubquestion->setMedia($this->mediaManager->duplicate($subquestion->getMedia(), $questionnaire));
        $newSubquestion->setMediaAmorce($this->mediaManager->duplicate($subquestion->getMediaAmorce(), $questionnaire));
        $newSubquestion->setMediaSyllable($this->mediaManager->duplicate($subquestion->getMediaSyllable(), $questionnaire));
        $newSubquestion->setDisplayAnswer($subquestion->getDisplayAnswer());
        $newSubquestion->addFocuses($subquestion->getFocuses());
        $newSubquestion->addCognitiveOpsMains($subquestion->getCognitiveOpsMain());
        $newSubquestion->addCognitiveOpsSecondarys($subquestion->getCognitiveOpsSecondary());

        if ($clue = $subquestion->getClue()) {
            $newClue = new Clue();
            $newClue->setClueType($clue->getClueType());
            $newClue->setMedia($this->mediaManager->duplicate($clue->getMedia(), $questionnaire));
            $em->persist($newClue);
            $newSubquestion->setClue($newClue);
        }

        $propositions = $em->getRepository('InnovaSelfBundle:Proposition')->getBySubquestionExcludingAnswers($subquestion->getId());
        foreach ($propositions as $proposition) {
            $this->propositionManager->duplicate($proposition, $newSubquestion);
        }
        $em->persist($newSubquestion);
        $em->flush();

        return $newSubquestion;
    }
}
