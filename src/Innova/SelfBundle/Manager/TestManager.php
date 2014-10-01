<?php

namespace Innova\SelfBundle\Manager;

class TestManager
{
    protected $entityManager;
    protected $securityContext;

    public function __construct($entityManager, $securityContext)
    {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
    }

    public function getTestsProgress($tests)
    {
        $userId = $this->securityContext->getToken()->getUser()->getId();

        $testsProgress = array();
        foreach ($tests as $test) {
            $countDone = $this->entityManager->getRepository('InnovaSelfBundle:Questionnaire')->countDoneYetByUserByTest($test->getId(), $userId);
            $countTotal = count($test->getOrderQuestionnaireTests());
            if ($countTotal < 1) $countTotal=1;
            $number = $countDone/$countTotal*100;

            $testsProgress[] = number_format($number, 2, '.', ' ');
        }

        return $testsProgress;
    }
}
