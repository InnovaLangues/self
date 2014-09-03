<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Answer;
use Innova\SelfBundle\Entity\Trace;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Proposition;

class AnswerManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createAnswer(Trace $trace, Subquestion $subquestion, Proposition $proposition)
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
