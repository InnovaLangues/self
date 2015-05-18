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
    * @ORM\OneToOne(targetEntity="Innova\SelfBundle\Entity\Test", inversedBy="phasedParams")
    */
    protected $test;

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
}
