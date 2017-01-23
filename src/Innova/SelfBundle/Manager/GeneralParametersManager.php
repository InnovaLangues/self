<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\GeneralParameters;
use Innova\SelfBundle\Form\Type\GeneralParametersType;
use Symfony\Component\HttpFoundation\Request;

class GeneralParametersManager
{
    protected $entityManager;
    protected $formFactory;
    protected $session;

    public function __construct($entityManager, $formFactory, $session)
    {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->session = $session;
    }

    public function initialize()
    {
        $em = $this->entityManager;

        if (!$em->getRepository('InnovaSelfBundle:GeneralParameters')->findAll()) {
            $params = new GeneralParameters();
            $params->setMaintenance(false);
            $params->setSelfRegistration(true);
            $params->setMaintenanceText('');
            $em->persist($params);
            $em->flush();
        }
    }

    public function setMaintenance($enabled, $message = '')
    {
        $em = $this->entityManager;
        $params = $em->getRepository('InnovaSelfBundle:GeneralParameters')->get();

        $params->setMaintenance($enabled);
        if ($message) {
            $params->setMaintenanceText($message);
        }

        $em->persist($params);
        $em->flush();

        return $enabled;
    }

    public function setSelfRegistration($enabled)
    {
        $em = $this->entityManager;
        $params = $em->getRepository('InnovaSelfBundle:GeneralParameters')->get();

        $params->setSelfRegistration($enabled);
        $em->persist($params);
        $em->flush();

        return $enabled;
    }

    /**
     * Handles parameters form.
     */
    public function handleForm(GeneralParameters $parameters, Request $request)
    {
        $form = $this->formFactory->createBuilder(new GeneralParametersType(), $parameters)->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->entityManager;
                $em->persist($parameters);
                $em->flush();

                $this->session->getFlashBag()->set('info', 'Les paramètres ont bien été modifiés');

                return;
            }
        }

        return $form;
    }
}
