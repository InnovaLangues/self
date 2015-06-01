<?php

namespace Innova\SelfBundle\Entity\PhasedTest;

use Doctrine\ORM\Mapping as ORM;

/**
 * Phased Params
 *
 * @ORM\Table("generalScoreThreshold")
 * @ORM\Entity
 */
class GeneralScoreThreshold
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
     * @var integer
     *
     * @ORM\Column(name="rightAnswers", type="integer")
     */
    protected $rightAnswers = 0;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\PhasedTest\ComponentType")
    */
    protected $componentType;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Level")
    */
    protected $level;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\PhasedTest\PhasedParams", inversedBy="generalScoreThresholds")
    */
    protected $phasedParam;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->componentType = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set rightAnswers
     *
     * @param integer $rightAnswers
     *
     * @return GeneralScoreThreshold
     */
    public function setRightAnswers($rightAnswers)
    {
        $this->rightAnswers = $rightAnswers;

        return $this;
    }

    /**
     * Get rightAnswers
     *
     * @return integer
     */
    public function getRightAnswers()
    {
        return $this->rightAnswers;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return GeneralScoreThreshold
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add componentType
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\ComponentType $componentType
     *
     * @return GeneralScoreThreshold
     */
    public function addComponentType(\Innova\SelfBundle\Entity\PhasedTest\ComponentType $componentType)
    {
        $this->componentType[] = $componentType;

        return $this;
    }

    /**
     * Remove componentType
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\ComponentType $componentType
     */
    public function removeComponentType(\Innova\SelfBundle\Entity\PhasedTest\ComponentType $componentType)
    {
        $this->componentType->removeElement($componentType);
    }

    /**
     * Get componentType
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComponentType()
    {
        return $this->componentType;
    }

    /**
     * Set level
     *
     * @param \Innova\SelfBundle\Entity\Level $level
     *
     * @return GeneralScoreThreshold
     */
    public function setLevel(\Innova\SelfBundle\Entity\Level $level = null)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return \Innova\SelfBundle\Entity\Level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set componentType
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\ComponentType $componentType
     *
     * @return GeneralScoreThreshold
     */
    public function setComponentType(\Innova\SelfBundle\Entity\PhasedTest\ComponentType $componentType = null)
    {
        $this->componentType = $componentType;

        return $this;
    }

    /**
     * Set phasedParam
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\PhasedParams $phasedParam
     *
     * @return GeneralScoreThreshold
     */
    public function setPhasedParam(\Innova\SelfBundle\Entity\PhasedTest\PhasedParams $phasedParam = null)
    {
        $this->phasedParam = $phasedParam;

        return $this;
    }

    /**
     * Get phasedParam
     *
     * @return \Innova\SelfBundle\Entity\PhasedTest\PhasedParams
     */
    public function getPhasedParam()
    {
        return $this->phasedParam;
    }
}
