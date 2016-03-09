<?php

namespace Innova\SelfBundle\Entity\PhasedTest;

use Doctrine\ORM\Mapping as ORM;

/**
 * Phased Params.
 *
 * @ORM\Table("phasedParams")
 * @ORM\Entity
 */
class PhasedParams
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="considerMinitest", type="boolean")
     */
    private $considerMinitest = false;

    /**
     * @var int
     *
     * @ORM\Column(name="thresholdToStep2", type="integer")
     */
    private $thresholdToStep2 = 33;

    /**
     * @var int
     *
     * @ORM\Column(name="thresholdToStep2Leveled", type="integer")
     */
    private $thresholdToStep2Leveled = 50;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Level")
     */
    protected $thresholdToStep2Level;

    /**
     * @var int
     *
     * @ORM\Column(name="thresholdToStep3", type="integer")
     */
    private $thresholdToStep3 = 66;

    /**
     * @var int
     *
     * @ORM\Column(name="thresholdToStep3Leveled", type="integer")
     */
    private $thresholdToStep3Leveled = 50;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Level")
     */
    protected $thresholdToStep3Level;

    /**
     * @ORM\OneToMany(targetEntity="Innova\SelfBundle\Entity\PhasedTest\GeneralScoreThreshold", mappedBy="phasedParam", cascade={"persist"})
     */
    protected $generalScoreThresholds;

    /**
     * @ORM\OneToMany(targetEntity="Innova\SelfBundle\Entity\PhasedTest\SkillScoreThreshold", mappedBy="phasedParam", cascade={"persist"})
     * @ORM\OrderBy({"componentType" = "ASC", "skill" = "ASC", "level" = "ASC"})
     */
    protected $skillScoreThresholds;

    /**
     * @ORM\OneToMany(targetEntity="Innova\SelfBundle\Entity\PhasedTest\IgnoredLevel", mappedBy="phasedParam", cascade={"persist"})
     */
    protected $ignoredLevels;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->generalScoreThresholds = new \Doctrine\Common\Collections\ArrayCollection();
        $this->skillScoreThresholds = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ignoredLevels = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setConsiderMinitest($considerMinitest)
    {
        $this->considerMinitest = $considerMinitest;

        return $this;
    }

    public function getConsiderMinitest()
    {
        return $this->considerMinitest;
    }

    /**
     * Set thresholdToStep2.
     *
     * @param int $thresholdToStep2
     *
     * @return PhasedParams
     */
    public function setThresholdToStep2($thresholdToStep2)
    {
        $this->thresholdToStep2 = $thresholdToStep2;

        return $this;
    }

    /**
     * Get thresholdToStep2.
     *
     * @return int
     */
    public function getThresholdToStep2()
    {
        return $this->thresholdToStep2;
    }

    /**
     * Set thresholdToStep2Leveled.
     *
     * @param int $thresholdToStep2Leveled
     *
     * @return PhasedParams
     */
    public function setThresholdToStep2Leveled($thresholdToStep2Leveled)
    {
        $this->thresholdToStep2Leveled = $thresholdToStep2Leveled;

        return $this;
    }

    /**
     * Get thresholdToStep2Leveled.
     *
     * @return int
     */
    public function getThresholdToStep2Leveled()
    {
        return $this->thresholdToStep2Leveled;
    }

    /**
     * Set thresholdToStep3.
     *
     * @param int $thresholdToStep3
     *
     * @return PhasedParams
     */
    public function setThresholdToStep3($thresholdToStep3)
    {
        $this->thresholdToStep3 = $thresholdToStep3;

        return $this;
    }

    /**
     * Get thresholdToStep3.
     *
     * @return int
     */
    public function getThresholdToStep3()
    {
        return $this->thresholdToStep3;
    }

    /**
     * Set thresholdToStep3Leveled.
     *
     * @param int $thresholdToStep3Leveled
     *
     * @return PhasedParams
     */
    public function setThresholdToStep3Leveled($thresholdToStep3Leveled)
    {
        $this->thresholdToStep3Leveled = $thresholdToStep3Leveled;

        return $this;
    }

    /**
     * Get thresholdToStep3Leveled.
     *
     * @return int
     */
    public function getThresholdToStep3Leveled()
    {
        return $this->thresholdToStep3Leveled;
    }

    /**
     * Set thresholdToStep2Level.
     *
     * @param \Innova\SelfBundle\Entity\Level $thresholdToStep2Level
     *
     * @return PhasedParams
     */
    public function setThresholdToStep2Level(\Innova\SelfBundle\Entity\Level $thresholdToStep2Level = null)
    {
        $this->thresholdToStep2Level = $thresholdToStep2Level;

        return $this;
    }

    /**
     * Get thresholdToStep2Level.
     *
     * @return \Innova\SelfBundle\Entity\Level
     */
    public function getThresholdToStep2Level()
    {
        return $this->thresholdToStep2Level;
    }

    /**
     * Set thresholdToStep3Level.
     *
     * @param \Innova\SelfBundle\Entity\Level $thresholdToStep3Level
     *
     * @return PhasedParams
     */
    public function setThresholdToStep3Level(\Innova\SelfBundle\Entity\Level $thresholdToStep3Level = null)
    {
        $this->thresholdToStep3Level = $thresholdToStep3Level;

        return $this;
    }

    /**
     * Get thresholdToStep3Level.
     *
     * @return \Innova\SelfBundle\Entity\Level
     */
    public function getThresholdToStep3Level()
    {
        return $this->thresholdToStep3Level;
    }

    /**
     * Add generalScoreThreshold.
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\GeneralScoreThreshold $generalScoreThreshold
     *
     * @return PhasedParams
     */
    public function addGeneralScoreThreshold(\Innova\SelfBundle\Entity\PhasedTest\GeneralScoreThreshold $generalScoreThreshold)
    {
        $this->generalScoreThresholds[] = $generalScoreThreshold;

        return $this;
    }

    /**
     * Remove generalScoreThreshold.
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\GeneralScoreThreshold $generalScoreThreshold
     */
    public function removeGeneralScoreThreshold(\Innova\SelfBundle\Entity\PhasedTest\GeneralScoreThreshold $generalScoreThreshold)
    {
        $this->generalScoreThresholds->removeElement($generalScoreThreshold);
    }

    /**
     * Get generalScoreThresholds.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGeneralScoreThresholds()
    {
        return $this->generalScoreThresholds;
    }

    /**
     * Add skillScoreThreshold.
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\SkillScoreThreshold $skillScoreThreshold
     *
     * @return PhasedParams
     */
    public function addSkillScoreThreshold(\Innova\SelfBundle\Entity\PhasedTest\SkillScoreThreshold $skillScoreThreshold)
    {
        $this->skillScoreThresholds[] = $skillScoreThreshold;

        return $this;
    }

    /**
     * Remove skillScoreThreshold.
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\SkillScoreThreshold $skillScoreThreshold
     */
    public function removeSkillScoreThreshold(\Innova\SelfBundle\Entity\PhasedTest\SkillScoreThreshold $skillScoreThreshold)
    {
        $this->skillScoreThresholds->removeElement($skillScoreThreshold);
    }

    /**
     * Get skillScoreThresholds.
     *
     * @return SkillScoreThreshold[]
     */
    public function getSkillScoreThresholds()
    {
        return $this->skillScoreThresholds;
    }

    /**
     * Add ignoredLevel.
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\IgnoredLevel $ignoredLevel
     *
     * @return PhasedParams
     */
    public function addIgnoredLevel(\Innova\SelfBundle\Entity\PhasedTest\IgnoredLevel $ignoredLevel)
    {
        $this->ignoredLevels[] = $ignoredLevel;

        return $this;
    }

    /**
     * Remove ignoredLevel.
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\IgnoredLevel $ignoredLevel
     */
    public function removeIgnoredLevel(\Innova\SelfBundle\Entity\PhasedTest\IgnoredLevel $ignoredLevel)
    {
        $this->ignoredLevels->removeElement($ignoredLevel);
    }

    /**
     * Get ignoredLevels.
     *
     * @return IgnoredLevel[]
     */
    public function getIgnoredLevels()
    {
        return $this->ignoredLevels;
    }
}
