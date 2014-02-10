<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Main controller.
 *
 * @Route("/student")
 */
class MainController extends Controller
{

    /**
     * @Route("/help", name="show_help")
     * @Template()
     */
    public function showHelpAction()
    {

        $user = $this->get('security.context')->getToken()->getUser();

        return array(
        'user' => $user,
        );
    }

    /**
     * @Route("/", name="show_tests")
     * @Template()
     */
    public function showTestsAction()
    {

        $session = $this->container->get('request')->getSession();
        $session->set('item', 0);
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.context')->getToken()->getUser();

//      $userTests = $user->getTests(); // Tous les tests de l'utilisateur X.
        $userTests = $em->getRepository('InnovaSelfBundle:Test')->findAll();

        $testsProgress = array();
        foreach ($userTests as $test) {
            $countDone = $em->getRepository('InnovaSelfBundle:Questionnaire')
            ->countDoneYetByUserByTest($test->getId(), $user->getId());
            $countTotal = count($test->getQuestionnaires());
            if ($countTotal < 1) $countTotal=1;
            $number = $countDone/$countTotal*100;

            $testsProgress[] = number_format($number, 2, '.', ' ');
        }

//var_dump($userTests);die();
        return array(
            'user' => $user,
            'tests' => $userTests,
            'testsProgress' => $testsProgress
        );
    }

}
