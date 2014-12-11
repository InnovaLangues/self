<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\OrderQuestionnaireTest;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;

class OrderQuestionnaireTestManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createOrderQuestionnaireTest(Test $test, Questionnaire $questionnaire)
    {
        $em = $this->entityManager;

        $orderQuestionnaireTest = new OrderQuestionnaireTest();
        $orderQuestionnaireTest->setTest($test);
        $orderQuestionnaireTest->setQuestionnaire($questionnaire);

        if ($orderQuestionnaireTests = $em->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')->findByTest($test)) {
            $orderMax = count($orderQuestionnaireTests);
        } else {
            $orderMax = 0;
        }

        $questionnaire->setLanguage($test->getLanguage());
        $em->persist($questionnaire);

        $orderQuestionnaireTest->setDisplayOrder($orderMax + 1);
        $em->persist($orderQuestionnaireTest);

        $em->flush();

        return $orderQuestionnaireTest;
    }

    public function recalculateOrder(Test $test)
    {
        $em = $this->entityManager;

        $orderedQuestionnaires = $em->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')->findByTest($test);

        $i = 1;
        foreach ($orderedQuestionnaires as $orderedQuestionnaire) {
            $orderedQuestionnaire->setDisplayOrder($i);
            $em->persist($orderedQuestionnaire);
            $i++;
        }
        $em->flush();
    }
}
