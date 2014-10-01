<?php

namespace Innova\SelfBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * ClassTestController
 *
 * @Route(
 *      "",
 *      name = "",
 *      service = "innova_test"
 * )
 */
class TestController
{
    protected $entityManager;
    protected $testManager;

    public function __construct($entityManager, $testManager)
    {
        $this->entityManager = $entityManager;
        $this->testManager = $testManager;

    }

    /**
     * @Route("/student/", name="show_tests")
     * @Template()
     * @Method("GET")
     */
    public function showTestsAction()
    {
        $tests = $this->entityManager->getRepository('InnovaSelfBundle:Test')->findAll();
        $testsProgress = $this->testManager->getTestsProgress($tests);
        
        return array(
            'tests' => $tests,
            'testsProgress' => $testsProgress
        );
    }
}
