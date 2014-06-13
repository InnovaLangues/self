<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Main controller.
 */
class AnonymousController extends Controller
{

    /**
     * @Route("/", name="show_start")
     * @Template()
     * @Method("GET")
     */
    public function startAction()
    {
        $securityContext = $this->container->get('security.context');

        if ( $securityContext->isGranted('IS_AUTHENTICATED_FULLY') ) {
            return $this->redirect($this->generateUrl('show_tests'));
        }

        return array();
    }

}
