<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\OrderQuestionnaireTest;

class OrderQuestionnaireTestManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createOrderQuestionnaireTest($test, $questionnaire)
    {
        $em = $this->entityManager;

        $orderQuestionnaireTest = new OrderQuestionnaireTest();
        $orderQuestionnaireTest->setTest($test);
        $orderQuestionnaireTest->setQuestionnaire($questionnaire);
        $orderMax = count($em->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')->findByTest($test));
        $orderQuestionnaireTest->setDisplayOrder($orderMax + 1);
        $em->persist($orderQuestionnaireTest);

        $em->flush();

        return $orderQuestionnaireTest;
    }

}
