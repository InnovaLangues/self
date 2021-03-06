<?php

namespace Innova\SelfBundle\Manager\Editor;

use Innova\SelfBundle\Entity\Question;
use Innova\SelfBundle\Entity\Questionnaire;

class QuestionManager
{
    protected $entityManager;
    protected $subquestionManager;

    public function __construct(
        $entityManager,
        $subquestionManager
    ) {
        $this->entityManager = $entityManager;
        $this->subquestionManager = $subquestionManager;
    }

    public function createQuestion(Questionnaire $questionnaire)
    {
        $em = $this->entityManager;

        $question = new Question();
        $question->setQuestionnaire($questionnaire);
        $em->persist($question);
        $em->flush();

        return $question;
    }

    public function removeSubquestions(Question $question)
    {
        $em = $this->entityManager;

        $subquestions = $question->getSubquestions();
        foreach ($subquestions as $subquestion) {
            $em->remove($subquestion);
        }
        $em->flush();
        $em->refresh($question);

        return $question;
    }

    public function duplicate(Question $question, Questionnaire $questionnaire)
    {
        $em = $this->entityManager;

        $newQuestion = $this->createQuestion($questionnaire);
        $newQuestion->setTypology($question->getTypology());
        $em->persist($newQuestion);
        $em->flush();

        $subquestions = $question->getSubquestions();
        foreach ($subquestions as $subquestion) {
            $this->subquestionManager->duplicate($subquestion, $newQuestion);
        }

        return $newQuestion;
    }
}
