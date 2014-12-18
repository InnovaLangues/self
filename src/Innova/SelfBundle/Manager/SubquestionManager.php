<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Typology;
use Innova\SelfBundle\Entity\Question;

class SubquestionManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createSubquestion(Typology $typology, Question $question)
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
}
