<?php

namespace Innova\SelfBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
    protected $request;

    public function __construct($entityManager, $testManager)
    {
        $this->entityManager = $entityManager;
        $this->testManager = $testManager;
    }

    public function setRequest(Request $request = null)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @Route("/student/", name="show_tests")
     * @Template()
     * @Method("GET")
     */
    public function showTestsAction()
    {
        $tests = $this->entityManager->getRepository('InnovaSelfBundle:Test')->findWithOpenSession();
        //$testsProgress = $this->testManager->getTestsProgress($tests);

        return array(
            'tests' => $tests,
            //'testsProgress' => $testsProgress,
        );
    }

    /**
     * @Route("/favorite/toggle", name="test_favorite_toggle" , options={"expose"=true}))
     * @Method("GET")
     */
    public function toggleFavoriteAction()
    {
        $test = $this->entityManager->getRepository('InnovaSelfBundle:Test')->find($this->request->get('testId'));
        $isFavorite = $this->testManager->toggleFavorite($test);

        return new JsonResponse(
            array(
                'isFavorite' => $isFavorite,
                'favoriteName' => $test->getName(),
                )
        );
    }
}
