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
     * Set clickCount
     *
     * @param integer $clickCount
     * @return MediaClick
     */
    public function setClickCount($clickCount)
    {
        $this->clickCount = $clickCount;
    
        return $this;
    }

    /**
     * Get clickCount
     *
     * @return integer 
     */
    public function getClickCount()
    {
        return $this->clickCount;
    }

    /**
     * Set media
     *
     * @param \Innova\SelfBundle\Entity\Media $media
     * @return MediaClick
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
     * @param \Innova\SelfBundle\Entity\Test $test
     * @return MediaClick
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
     * @param \Innova\SelfBundle\Entity\Questionnaire $questionnaire
     * @return MediaClick
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

    /**
     * Set user
     *
     * @param \Innova\SelfBundle\Entity\User $user
     * @return MediaClick
     */
    public function setUser(\Innova\SelfBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Innova\SelfBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}