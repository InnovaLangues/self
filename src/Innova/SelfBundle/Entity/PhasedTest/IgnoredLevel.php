<?php

namespace Innova\SelfBundle\Entity\PhasedTest;

use Doctrine\ORM\Mapping as ORM;

/**
 * IgnoredLevel
 *
 * @ORM\Table("ignoredLevel")
 * @ORM\Entity
 */
class IgnoredLevel
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
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Skill")
    */
    protected $skill;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\PhasedTest\ComponentType")
    */
    protected $componentType;

    /**
    * @ORM\ManyToMany(targetEntity="Innova\SelfBundle\Entity\Level")
    * @ORM\JoinTable(name="phasedParams_levels")
    */
    protected $levels;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\PhasedTest\PhasedParams", inversedBy="ignoredLevels")
    */
    protected $phasedParam;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->levels = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set skill
     *
     * @param \Innova\SelfBundle\Entity\Skill $skill
     *
     * @return IgnoredLevel
     */
    public function setSkill(\Innova\SelfBundle\Entity\Skill $skill = null)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Get skill
     *
     * @return \Innova\SelfBundle\Entity\Skill
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * Set componentType
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\ComponentType $componentType
     *
     * @return IgnoredLevel
     */
    public function setComponentType(\Innova\SelfBundle\Entity\PhasedTest\ComponentType $componentType = null)
    {
        $this->componentType = $componentType;

        return $this;
    }

    /**
     * Get componentType
     *
     * @return \Innova\SelfBundle\Entity\PhasedTest\ComponentType
     */
    public function getComponentType()
    {
        return $this->componentType;
    }

    /**
     * Add level
     *
     * @param \Innova\SelfBundle\Entity\Level $level
     *
     * @return IgnoredLevel
     */
    public function addLevel(\Innova\SelfBundle\Entity\Level $level)
    {
        $this->levels[] = $level;

        return $this;
    }

    /**
     * Remove level
     *
     * @param \Innova\SelfBundle\Entity\Level $level
     */
    public function removeLevel(\Innova\SelfBundle\Entity\Level $level)
    {
        $this->levels->removeElement($level);
    }

    /**
     * Get levels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLevels()
    {
        return $this->levels;
    }

    /**
     * Set phasedParam
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\PhasedParams $phasedParam
     *
     * @return IgnoredLevel
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
