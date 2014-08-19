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

        $session = $this->container->get('request')->getSession();
        $session->set('item', 0);
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.context')->getToken()->getUser();
        $userTests = $em->getRepository('InnovaSelfBundle:Test')->findAll();

        $testsProgress = array();
        foreach ($userTests as $test) {
            $countDone = $em->getRepository('InnovaSelfBundle:Questionnaire')->countDoneYetByUserByTest($test->getId(), $user->getId());
            $countTotal = count($em->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')->findByTest($test));
            if ($countTotal < 1) $countTotal=1;
            $number = $countDone/$countTotal*100;

            $testsProgress[] = number_format($number, 2, '.', ' ');
        }

        return array(
            'user' => $user,
            'tests' => $userTests,
            'testsProgress' => $testsProgress
        );
    }
}
