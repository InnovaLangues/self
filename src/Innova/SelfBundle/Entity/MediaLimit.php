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
     * Set listeningLimit
     *
     * @param  integer    $listeningLimit
     * @return MediaLimit
     */
    public function setListeningLimit($listeningLimit)
    {
        $this->listeningLimit = $listeningLimit;

        return $this;
    }

    /**
     * Get listeningLimit
     *
     * @return integer
     */
    public function getListeningLimit()
    {
        return $this->listeningLimit;
    }

    /**
     * Set media
     *
     * @param  \Innova\SelfBundle\Entity\Media $media
     * @return MediaLimit
     */
    public function setMedia(\Innova\SelfBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Innova\SelfBundle\Entity\Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set test
     *
     * @param  \Innova\SelfBundle\Entity\Test $test
     * @return MediaLimit
     */
    public function setTest(\Innova\SelfBundle\Entity\Test $test = null)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Get test
     *
     * @return \Innova\SelfBundle\Entity\Test
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * Set questionnaire
     *
     * @param  \Innova\SelfBundle\Entity\Questionnaire $questionnaire
     * @return MediaLimit
     */
    public function setQuestionnaire(\Innova\SelfBundle\Entity\Questionnaire $questionnaire = null)
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    /**
     * Get questionnaire
     *
     * @return \Innova\SelfBundle\Entity\Questionnaire
     */
    public function getQuestionnaire()
    {
        return $this->questionnaire;
    }
}
