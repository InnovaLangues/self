<?php

namespace Innova\SelfBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AnonymousController
{
    /**
     * Display anonymous page
     * 
     * @Route("/", name="show_start")
     * @Template("InnovaSelfBundle:Anonymous:start.html.twig")
     * @Method("GET")
     */
    public function startAction()
    {
        return array();
    }
}
