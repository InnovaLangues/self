<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Question;

class QuestionManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createQuestion($questionnaire)
    {
        $em = $this->entityManager;

        $question = new Question();
        $question->setQuestionnaire($questionnaire);
        $em->persist($question);
        $em->flush();

        return $question;
    }
}
