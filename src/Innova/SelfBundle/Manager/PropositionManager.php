<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Proposition;

class PropositionManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createProposition($subquestion, $media, $rightAnswer)
    {
        $em = $this->entityManager;

        $proposition = new Proposition();
        $proposition->setSubquestion($subquestion);
        $proposition->setMedia($media);
        $proposition->setRightAnswer($rightAnswer);
        $em->persist($proposition);
        $em->flush();

        return $proposition;
    }
}
