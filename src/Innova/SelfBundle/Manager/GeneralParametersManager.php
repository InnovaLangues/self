<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\GeneralParameters;

class GeneralParametersManager
{
    protected $entityManager;
    protected $messageManager;

    public function __construct($entityManager, $messageManager)
    {
        $this->entityManager = $entityManager;
        $this->messageManager = $messageManager;
    }

    public function initialize()
    {
        $em = $this->entityManager;

        if (!$em->getRepository('InnovaSelfBundle:GeneralParameters')->findAll()) {
            $params = new GeneralParameters();
            $params->setMaintenance(false);
            $params->setSelfRegistration(true);
            $params->setMaintenanceText("");
            $em->persist($params);
            $em->flush();
        }
    }

    public function setMaintenance($enabled, $message = "")
    {
        $em = $this->entityManager;
        $params = $em->getRepository('InnovaSelfBundle:GeneralParameters')->get();

        $params->setMaintenance($enabled);
        if ($message) {
            $params->setMaintenanceText($message);
        }

        $em->persist($params);
        $em->flush();

        if ($enabled) {
            $this->messageManager->sendMessage($params->getMaintenanceText(), "all");
        }

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
