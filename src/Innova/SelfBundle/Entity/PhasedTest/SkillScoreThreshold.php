<?php

namespace Innova\SelfBundle\Entity\PhasedTest;

use Doctrine\ORM\Mapping as ORM;

/**
 * Phased Params
 *
 * @ORM\Table("skillScoreThreshold")
 * @ORM\Entity
 */
class SkillScoreThreshold
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
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Skill")
    */
    protected $skill;

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
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\PhasedTest\PhasedParams", inversedBy="skillScoreThresholds")
    */
    protected $phasedParam;

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
     * @return SkillScoreThreshold
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
     * @return SkillScoreThreshold
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
     * Set skill
     *
     * @param \Innova\SelfBundle\Entity\Skill $skill
     *
     * @return SkillScoreThreshold
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
     * Set phasedParam
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\PhasedParams $phasedParam
     *
     * @return SkillScoreThreshold
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

    /**
     * Set level
     *
     * @param \Innova\SelfBundle\Entity\Level $level
     *
     * @return SkillScoreThreshold
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
     * @return SkillScoreThreshold
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
}
