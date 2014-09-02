<?php

namespace Innova\SelfBundle\Manager;
use Innova\SelfBundle\Entity\Test;

class TestManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getQuestionnaires(Test $test)
    {
        $orders = $test->getOrderQuestionnaireTests();
        $questionnaires = array();

        foreach ($orders as $order) {
            $questionnaires[] = $order->getQuestionnaire();
        }

        return $questionnaires;
    }
}
