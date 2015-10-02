<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\GeneralParameters;

class GeneralParametersManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function initialize()
    {
        $em = $this->entityManager;

        if (!$em->getRepository('InnovaSelfBundle:GeneralParameters')->findAll()) {
            $params = new GeneralParameters();
            $params->setMaintenance(false);
            $params->setSelfRegistration(true);
            $em->persist($params);
            $em->flush();
        }
    }

    public function setMaintenance($enabled)
    {
        $em = $this->entityManager;
        $params = $em->getRepository('InnovaSelfBundle:GeneralParameters')->get();

        $params->setMaintenance($enabled);
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
}
