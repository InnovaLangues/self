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
     * @Route("/", name="show_help")
     * @Template()
     */
    public function showHelpAction()
    {
        return array();
    }

        return array('entities' => $entities);
    }
   
}
