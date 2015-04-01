<?php

namespace Innova\SelfBundle\Entity\Media;

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
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Test", inversedBy="mediaClicks")
    */
    protected $test;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Questionnaire", inversedBy="mediaClicks")
    */
    protected $questionnaire;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Session")
    */
    protected $session;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\PhasedTest\Component")
    */
    protected $component;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\User", inversedBy="mediaClicks")
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
     * Set media
     *
     * @param  \Innova\SelfBundle\Entity\Media\Media $media
     * @return MediaClick
     */
    public function setMedia(\Innova\SelfBundle\Entity\Media\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Innova\SelfBundle\Entity\Media\Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set test
     *
     * @param  \Innova\SelfBundle\Entity\Test $test
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
     * @param  \Innova\SelfBundle\Entity\Questionnaire $questionnaire
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
     * @param  \Innova\SelfBundle\Entity\User $user
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

    /**
     * Set session
     *
     * @param  \Innova\SelfBundle\Entity\Session $session
     * @return MediaClick
     */
    public function setSession(\Innova\SelfBundle\Entity\Session $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return \Innova\SelfBundle\Entity\Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set component
     *
     * @param  \Innova\SelfBundle\Entity\PhasedTest\Component $component
     * @return MediaClick
     */
    public function setComponent(\Innova\SelfBundle\Entity\PhasedTest\Component $component = null)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Get component
     *
     * @return \Innova\SelfBundle\Entity\PhasedTest\Component
     */
    public function getComponent()
    {
        return $this->component;
    }
}
