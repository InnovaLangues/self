<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MediaClick
 *
 * @ORM\Table("mediaClick")
 * @ORM\Entity
 */
class MediaClick
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
    * @ORM\ManyToOne(targetEntity="Media", inversedBy="mediaClicks")
    */
    protected $media;

    /**
    * @ORM\ManyToOne(targetEntity="Test", inversedBy="mediaClicks")
    */
    protected $test;

    /**
    * @ORM\ManyToOne(targetEntity="Questionnaire", inversedBy="mediaClicks")
    */
    protected $questionnaire;

    /**
     * @var integer
     *
     * @ORM\Column(name="clickCount", type="integer")
     */
    private $clickCount;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="mediaClicks")
    */
    protected $user;
}
