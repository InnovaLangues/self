<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Test;



class MainController extends Controller
{

    /**
     * @Route("/display", name="display_test")
     * @Template("InnovaSelfBundle::main.html.twig")
     */
    public function displayTestAction()
    {
       
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('InnovaSelfBundle:Test')->findAll();

        return array('entities' => $entities);
    }
   
}
