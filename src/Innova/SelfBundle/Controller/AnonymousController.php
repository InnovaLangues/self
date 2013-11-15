<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * Main controller.
 */
class AnonymousController extends Controller
{

    /**
     * @Route("/", name="show_start")
     * @Template()
     */
    public function startAction()
    {
        $securityContext = $this->container->get('security.context');

		if( $securityContext->isGranted('IS_AUTHENTICATED_FULLY') ){
		    return $this->redirect($this->generateUrl('show_tests'));
		}

        //return $this->redirect($this->generateUrl('fos_user_security_login'), 301);
        return array();
    }

}
