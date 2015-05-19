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
     * @ORM\Column(name="step2_threshold", type="integer")
     */
    private $step2Threshold = 25;

    /**
     * @var integer
     *
     * @ORM\Column(name="step3_threshold", type="integer")
     */
    private $step3Threshold = 50;

    /**
     * @var integer
     *
     * @ORM\Column(name="step4_threshold", type="integer")
     */
    private $step4Threshold = 75;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Level")
    */
    protected $lowerPart1;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Level")
    */
    protected $upperPart1;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Level")
    */
    protected $lowerPart2;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Level")
    */
    protected $upperPart2;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Level")
    */
    protected $lowerPart3;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Level")
    */
    protected $upperPart3;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Level")
    */
    protected $lowerPart4;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Level")
    */
    protected $upperPart4;

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
     * Set step2Threshold
     *
     * @param integer $step2Threshold
     *
     * @return PhasedParams
     */
    public function setStep2Threshold($step2Threshold)
    {
        $this->step2Threshold = $step2Threshold;

        return $this;
    }

    /**
     * Get step2Threshold
     *
     * @return integer
     */
    public function getStep2Threshold()
    {
        return $this->step2Threshold;
    }

    /**
     * Set step3Threshold
     *
     * @param integer $step3Threshold
     *
     * @return PhasedParams
     */
    public function setStep3Threshold($step3Threshold)
    {
        $this->step3Threshold = $step3Threshold;

        return $this;
    }

    /**
     * Get step3Threshold
     *
     * @return integer
     */
    public function getStep3Threshold()
    {
        return $this->step3Threshold;
    }

    /**
     * Set step4Threshold
     *
     * @param integer $step4Threshold
     *
     * @return PhasedParams
     */
    public function setStep4Threshold($step4Threshold)
    {
        $this->step4Threshold = $step4Threshold;

        return $this;
    }

    /**
     * Get step4Threshold
     *
     * @return integer
     */
    public function getStep4Threshold()
    {
        return $this->step4Threshold;
    }

    /**
     * Set lowerPart1
     *
     * @param \Innova\SelfBundle\Entity\Level $lowerPart1
     *
     * @return PhasedParams
     */
    public function setLowerPart1(\Innova\SelfBundle\Entity\Level $lowerPart1 = null)
    {
        $this->lowerPart1 = $lowerPart1;

        return $this;
    }

    /**
     * Get lowerPart1
     *
     * @return \Innova\SelfBundle\Entity\Level
     */
    public function getLowerPart1()
    {
        return $this->lowerPart1;
    }

    /**
     * Set upperPart1
     *
     * @param \Innova\SelfBundle\Entity\Level $upperPart1
     *
     * @return PhasedParams
     */
    public function setUpperPart1(\Innova\SelfBundle\Entity\Level $upperPart1 = null)
    {
        $this->upperPart1 = $upperPart1;

        return $this;
    }

    /**
     * Get upperPart1
     *
     * @return \Innova\SelfBundle\Entity\Level
     */
    public function getUpperPart1()
    {
        return $this->upperPart1;
    }

    /**
     * Set lowerPart2
     *
     * @param \Innova\SelfBundle\Entity\Level $lowerPart2
     *
     * @return PhasedParams
     */
    public function setLowerPart2(\Innova\SelfBundle\Entity\Level $lowerPart2 = null)
    {
        $this->lowerPart2 = $lowerPart2;

        return $this;
    }

    /**
     * Get lowerPart2
     *
     * @return \Innova\SelfBundle\Entity\Level
     */
    public function getLowerPart2()
    {
        return $this->lowerPart2;
    }

    /**
     * Set lowerPart3
     *
     * @param \Innova\SelfBundle\Entity\Level $lowerPart3
     *
     * @return PhasedParams
     */
    public function setLowerPart3(\Innova\SelfBundle\Entity\Level $lowerPart3 = null)
    {
        $this->lowerPart3 = $lowerPart3;

        return $this;
    }

    /**
     * Get lowerPart3
     *
     * @return \Innova\SelfBundle\Entity\Level
     */
    public function getLowerPart3()
    {
        return $this->lowerPart3;
    }

    /**
     * Set upperPart3
     *
     * @param \Innova\SelfBundle\Entity\Level $upperPart3
     *
     * @return PhasedParams
     */
    public function setUpperPart3(\Innova\SelfBundle\Entity\Level $upperPart3 = null)
    {
        $this->upperPart3 = $upperPart3;

        return $this;
    }

    /**
     * Get upperPart3
     *
     * @return \Innova\SelfBundle\Entity\Level
     */
    public function getUpperPart3()
    {
        return $this->upperPart3;
    }

    /**
     * Set lowerPart4
     *
     * @param \Innova\SelfBundle\Entity\Level $lowerPart4
     *
     * @return PhasedParams
     */
    public function setLowerPart4(\Innova\SelfBundle\Entity\Level $lowerPart4 = null)
    {
        $this->lowerPart4 = $lowerPart4;

        return $this;
    }

    /**
     * Get lowerPart4
     *
     * @return \Innova\SelfBundle\Entity\Level
     */
    public function getLowerPart4()
    {
        return $this->lowerPart4;
    }

    /**
     * Set upperPart4
     *
     * @param \Innova\SelfBundle\Entity\Level $upperPart4
     *
     * @return PhasedParams
     */
    public function setUpperPart4(\Innova\SelfBundle\Entity\Level $upperPart4 = null)
    {
        $this->upperPart4 = $upperPart4;

        return $this;
    }

    /**
     * Get upperPart4
     *
     * @return \Innova\SelfBundle\Entity\Level
     */
    public function getUpperPart4()
    {
        return $this->upperPart4;
    }

    /**
     * Set upperPart2
     *
     * @param \Innova\SelfBundle\Entity\Level $upperPart2
     *
     * @return PhasedParams
     */
    public function setUpperPart2(\Innova\SelfBundle\Entity\Level $upperPart2 = null)
    {
        $this->upperPart2 = $upperPart2;

        return $this;
    }

    /**
     * Get upperPart2
     *
     * @return \Innova\SelfBundle\Entity\Level
     */
    public function getUpperPart2()
    {
        return $this->upperPart2;
    }
}
