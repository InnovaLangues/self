<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Group
 * @ORM\Table(name="general_parameters")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Innova\SelfBundle\Repository\GeneralParametersRepository")
 */
class GeneralParameters
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="maintenance", type="boolean")
     */
    private $maintenance;

    /**
     * @var boolean
     *
     * @ORM\Column(name="self_registration", type="boolean")
     */
    private $selfRegistration;

    /**
     * @var string
     *
     * @ORM\Column(name="maintenance_text", type="text", nullable=true)
     */
    private $maintenanceText;

    /**
     * Set maintenance
     *
     * @param boolean $maintenance
     *
     * @return GeneralParameters
     */
    public function setMaintenance($maintenance)
    {
        $this->maintenance = $maintenance;

        return $this;
    }

    /**
     * Get maintenance
     *
     * @return boolean
     */
    public function getMaintenance()
    {
        return $this->maintenance;
    }

    /**
     * Set selfRegistration
     *
     * @param boolean $selfRegistration
     *
     * @return GeneralParameters
     */
    public function setSelfRegistration($selfRegistration)
    {
        $this->selfRegistration = $selfRegistration;

        return $this;
    }

    /**
     * Get selfRegistration
     *
     * @return boolean
     */
    public function getSelfRegistration()
    {
        return $this->selfRegistration;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set maintenanceText
     *
     * @param string $maintenanceText
     *
     * @return GeneralParameters
     */
    public function setMaintenanceText($maintenanceText)
    {
        $this->maintenanceText = $maintenanceText;

        return $this;
    }

    /**
     * Get maintenanceText
     *
     * @return string
     */
    public function getMaintenanceText()
    {
        return $this->maintenanceText;
    }
}
