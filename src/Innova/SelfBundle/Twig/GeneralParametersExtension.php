<?php

namespace Innova\SelfBundle\Twig;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class TaskController
 * @Route("", name = "", service = "innova.twig.parameters"
 * )
 */
class GeneralParametersExtension extends \Twig_Extension
{
    protected $entityManager;

    public function __construct(
            $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function isMaintenanceEnabled()
    {
        $em = $this->entityManager;

        $maintenance = $em->getRepository('InnovaSelfBundle:GeneralParameters')->isMaintenanceEnabled();

        return $maintenance;
    }

    public function isSelfRegistrationEnabled()
    {
        $em = $this->entityManager;

        $selfRegistrationEnabled = $em->getRepository('InnovaSelfBundle:GeneralParameters')->isSelfRegistrationEnabled();

        return $selfRegistrationEnabled;
    }

    public function getMaintenanceText()
    {
        $em = $this->entityManager;

        $maintenanceText = $em->getRepository('InnovaSelfBundle:GeneralParameters')->getMaintenanceText();

        return $maintenanceText;
    }

    public function getFunctions()
    {
        return array(
            'isMaintenanceEnabled' => new \Twig_Function_Method($this, 'isMaintenanceEnabled'),
            'isSelfRegistrationEnabled' => new \Twig_Function_Method($this, 'isSelfRegistrationEnabled'),
            'getMaintenanceText' => new \Twig_Function_Method($this, 'getMaintenanceText'),
            );
    }

    public function getName()
    {
        return 'generalParameters';
    }
}
