<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class TestController extends Controller
{
    /**
     * @Route("/student/", name="show_tests")
     * @Template()
     * @Method("GET")
     */
    public function showTestsAction()
    {

        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.context')->getToken()->getUser();
        $tests = $em->getRepository('InnovaSelfBundle:Test')->findAll();

        $testsProgress = array();
        foreach ($tests as $test) {
            $countDone = $em->getRepository('InnovaSelfBundle:Questionnaire')->countDoneYetByUserByTest($test->getId(), $user->getId());
            $countTotal = count($test->getOrderQuestionnaireTests());
            if ($countTotal < 1) $countTotal=1;
            $number = $countDone/$countTotal*100;

            $testsProgress[] = number_format($number, 2, '.', ' ');
        }

        return array(
            'user' => $user,
            'tests' => $tests,
            'testsProgress' => $testsProgress
        );
    }
}
