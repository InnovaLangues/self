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
}
