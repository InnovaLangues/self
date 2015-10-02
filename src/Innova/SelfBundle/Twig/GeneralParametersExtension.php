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

    public function getFunctions()
    {
        return array(
            'isMaintenanceEnabled' => new \Twig_Function_Method($this, 'isMaintenanceEnabled'),
            'isSelfRegistrationEnabled' => new \Twig_Function_Method($this, 'isSelfRegistrationEnabled'),
            );
    }

    public function getName()
    {
        return 'generalParameters';
    }
}
