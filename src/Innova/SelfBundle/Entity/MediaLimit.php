<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MediaLimit
 *
 * @ORM\Table("mediaLimit")
 * @ORM\Entity
 */
class MediaLimit
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
    * @ORM\ManyToOne(targetEntity="Media", inversedBy="mediaLimits")
    */
    protected $media;

    /**
    * @ORM\ManyToOne(targetEntity="Test", inversedBy="mediaLimits")
    */
    protected $test;

    /**
    * @ORM\ManyToOne(targetEntity="Questionnaire", inversedBy="mediaLimits")
    */
    protected $questionnaire;

    /**
     * @var integer
     *
     * @ORM\Column(name="listeningLimit", type="integer")
     */
    private $listeningLimit;
}
