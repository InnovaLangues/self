<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="string", nullable=true)
     */
    private $logoPath;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Image()
     */
    private $logoFile;

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

    /**
     * Set logoPath
     *
     * @param string $logoPath
     *
     * @return GeneralParameters
     */
    public function setLogoPath($logoPath)
    {
        $this->logoPath = $logoPath;

        return $this;
    }

    /**
     * Get logoPath
     *
     * @return string
     */
    public function getLogoPath()
    {
        return $this->logoPath;
    }

    /**
     * Set logoFile
     *
     * @param string $logoFile
     *
     * @return GeneralParameters
     */
    public function setLogoFile($logoFile)
    {
        $this->logoFile = $logoFile;

        return $this;
    }

    /**
     * Get logoFile
     *
     * @return string
     */
    public function getLogoFile()
    {
        return $this->logoFile;
    }
}
