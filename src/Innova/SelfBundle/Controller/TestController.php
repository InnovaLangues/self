<?php

namespace Innova\SelfBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Innova\SelfBundle\Entity\Test;

/**
 * ClassTestController
 *
 * @Route(
 *      "",
 *      name = "",
 *      service = "innova_test"
 * )
 * @ParamConverter("test", isOptional="true", class="InnovaSelfBundle:Test",  options={"id" = "testId"})
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
     * @Method("GET")
     * @Template()
     */
    public function showTestsAction()
    {
        $tests = $this->entityManager->getRepository('InnovaSelfBundle:Test')->findWithOpenSession();

        return array(
            'tests' => $tests,
        );
    }

    /**
     * @Route("/favorite/toggle/{testId}", name="test_favorite_toggle" , options={"expose"=true}))
     * @Method("GET")
     */
    public function toggleFavoriteAction(Test $test)
    {
        $this->testManager->toggleFavorite($test);

        return new JsonResponse();
    }
}
