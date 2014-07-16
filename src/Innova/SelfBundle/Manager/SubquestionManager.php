<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Subquestion;

class SubquestionManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createSubquestion($typology, $question)
    {
        $em = $this->entityManager;

        $subquestion = new SubQuestion();
        $subquestion->setTypology($typology);
        $subquestion->setQuestion($question);

        $em->persist($subquestion);
        $em->flush();

        return $subquestion;
    }
}
