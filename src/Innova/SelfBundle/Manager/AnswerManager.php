<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Answer;

class AnswerManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createAnswer($trace, $subquestion, $proposition)
    {
        $em = $this->entityManager;

        $answer = new Answer();
        $answer->setTrace($trace);
        $answer->setSubquestion($subquestion);
        $answer->setProposition($proposition);
       
        $em->persist($answer);
        $em->flush();

        return $answer;
    }
}
