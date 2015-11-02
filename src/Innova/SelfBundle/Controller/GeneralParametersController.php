<?php

namespace Innova\SelfBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * General Parameters controller.
 *
 * @Route("/admin", service="innova_general_parameters")
 */
class GeneralParametersController
{
    protected $entityManager;
    protected $voter;
    protected $generalParamsManager;
    protected $router;


    public function __construct($entityManager, $voter, $generalParamsManager, $router)
    {
        $this->entityManager            = $entityManager;
        $this->voter                    = $voter;
        $this->generalParamsManager     = $generalParamsManager;
        $this->router                   = $router;
    }


    /**
     * Edit general parameters
     *
     * @Route("/parameters", name="parameters")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Parameters:new.html.twig")
     */
    public function editAction(Request $request)
    {
        $this->voter->isAllowed("right.generalParameters");

        $parameters = $this->entityManager->getRepository('InnovaSelfBundle:GeneralParameters')->get();
        $form = $this->generalParamsManager->handleForm($parameters, $request);
        if (!$form) {
            return new RedirectResponse($this->router->generate('parameters', array()));
        }

        return array('form' => $form->createView(), 'parameters' => $parameters);
    }
}
