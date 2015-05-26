<?php

namespace Innova\SelfBundle\Entity\PhasedTest;

use Doctrine\ORM\Mapping as ORM;

/**
 * Phased Params
 *
 * @ORM\Table("phasedParams")
 * @ORM\Entity
 */
class PhasedParams
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
     * @ORM\Column(name="thresholdToStep2", type="integer")
     */
    private $thresholdToStep2 = 33;

    /**
     * @var integer
     *
     * @ORM\Column(name="thresholdToStep2Leveled", type="integer")
     */
    private $thresholdToStep2Leveled = 50;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Level")
    */
    protected $thresholdToStep2Level;

    /**
     * @var integer
     *
     * @ORM\Column(name="thresholdToStep3", type="integer")
     */
    private $thresholdToStep3 = 66;

    /**
     * @var integer
     *
     * @ORM\Column(name="thresholdToStep3Leveled", type="integer")
     */
    private $thresholdToStep3Leveled = 50;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Level")
    */
    protected $thresholdToStep3Level;

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
     * Set thresholdToStep2
     *
     * @param integer $thresholdToStep2
     *
     * @return PhasedParams
     */
    public function setThresholdToStep2($thresholdToStep2)
    {
        $this->thresholdToStep2 = $thresholdToStep2;

        return $this;
    }

    /**
     * Get thresholdToStep2
     *
     * @return integer
     */
    public function getThresholdToStep2()
    {
        return $this->thresholdToStep2;
    }

    /**
     * Set thresholdToStep2Leveled
     *
     * @param integer $thresholdToStep2Leveled
     *
     * @return PhasedParams
     */
    public function setThresholdToStep2Leveled($thresholdToStep2Leveled)
    {
        $this->thresholdToStep2Leveled = $thresholdToStep2Leveled;

        return $this;
    }

    /**
     * Get thresholdToStep2Leveled
     *
     * @return integer
     */
    public function getThresholdToStep2Leveled()
    {
        return $this->thresholdToStep2Leveled;
    }

    /**
     * Set thresholdToStep3
     *
     * @param integer $thresholdToStep3
     *
     * @return PhasedParams
     */
    public function setThresholdToStep3($thresholdToStep3)
    {
        $this->thresholdToStep3 = $thresholdToStep3;

        return $this;
    }

    /**
     * Get thresholdToStep3
     *
     * @return integer
     */
    public function getThresholdToStep3()
    {
        return $this->thresholdToStep3;
    }

    /**
     * Set thresholdToStep3Leveled
     *
     * @param integer $thresholdToStep3Leveled
     *
     * @return PhasedParams
     */
    public function setThresholdToStep3Leveled($thresholdToStep3Leveled)
    {
        $this->thresholdToStep3Leveled = $thresholdToStep3Leveled;

        return $this;
    }

    /**
     * Get thresholdToStep3Leveled
     *
     * @return integer
     */
    public function getThresholdToStep3Leveled()
    {
        return $this->thresholdToStep3Leveled;
    }

    /**
     * Set thresholdToStep2Level
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
     * Get thresholdToStep2Level
     *
     * @return \Innova\SelfBundle\Entity\Level
     */
    public function getThresholdToStep2Level()
    {
        return $this->thresholdToStep2Level;
    }

    /**
     * Set thresholdToStep3Level
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
     * Get thresholdToStep3Level
     *
     * @return \Innova\SelfBundle\Entity\Level
     */
    public function getThresholdToStep3Level()
    {
        return $this->thresholdToStep3Level;
    }
}
