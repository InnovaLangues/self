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

        $subquestion = new SubQuestion();
        $subquestion->setTypology($typology);
        $subquestion->setQuestion($question);
        // Initialisation de cette zone à FALSE et non pas à TRUE fix #519
        $subquestion->setDisplayAnswer(false);

        $em->persist($subquestion);
        $em->flush();

        return $subquestion;
    }
}
