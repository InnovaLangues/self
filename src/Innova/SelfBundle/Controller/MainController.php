<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Test;

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
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.context')->getToken()->getUser();
/*
        $tests = $em->getRepository('InnovaSelfBundle:Test')->findAll();

        foreach ($tests as $test) {
            $testUsers = $test->getUsers();
            if (in_array($user->getId(), $testUsers))
            {
                echo "Trouvé";
            }
            else
            {
                echo "Non trouvé";
            }
        }
*/

        $userTests = $user->getTests(); // Tous les tests de l'utilisateur X.

        return array(
        'user' => $user,
        'tests' => $userTests,
        );
    }

}
