<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Test
 *
 * @ORM\Table("test")
 * @ORM\Entity(repositoryClass="Innova\SelfBundle\Repository\TestRepository")
 */
class Test
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="actif", type="boolean")
     */
    private $actif;

    /**
    * @ORM\OneToMany(targetEntity="Trace", mappedBy="test", cascade={"remove"})
    */
    private $traces;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="tests")
     */
    private $users;

    /**
    * @ORM\ManyToOne(targetEntity="Language", inversedBy="tests")
    */
    protected $language;

    /**
    * @ORM\OneToMany(targetEntity="Innova\SelfBundle\Entity\Media\MediaClick", mappedBy="test", cascade={"remove"})
    */
    private $mediaClicks;

    /**
    * @ORM\OneToMany(targetEntity="OrderQuestionnaireTest", mappedBy="test", cascade={"persist", "remove"})
    * @ORM\OrderBy({"displayOrder" = "ASC"})
    */
    private $orderQuestionnaireTests;

    public function __construct()
    {
        $this->questionnaires = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->actif = false;
    }

    public function __toString()
    {
        return $this->name;
    }

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
     * Set name
     *
     * @param  string  $name
     * @return Session
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add users
     *
     * @param  \Innova\SelfBundle\Entity\User $users
     * @return Test
     */
    public function addUser(\Innova\SelfBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Innova\SelfBundle\Entity\User $users
     */
    public function removeUser(\Innova\SelfBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add traces
     *
     * @param  \Innova\SelfBundle\Entity\Trace $traces
     * @return Test
     */
    public function addTrace(\Innova\SelfBundle\Entity\Trace $traces)
    {
        $this->traces[] = $traces;

        return $this;
    }

    /**
     * Remove traces
     *
     * @param \Innova\SelfBundle\Entity\Trace $traces
     */
    public function removeTrace(\Innova\SelfBundle\Entity\Trace $traces)
    {
        $this->traces->removeElement($traces);
    }

    /**
     * Get traces
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTraces()
    {
        return $this->traces;
    }

    /**
     * Set language
     *
     * @param  \Innova\SelfBundle\Entity\Language $language
     * @return Test
     */
    public function setLanguage(\Innova\SelfBundle\Entity\Language $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \Innova\SelfBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set actif
     *
     * @param  boolean $actif
     * @return Test
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean
     */

    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Add mediaClicks
     *
     * @param  \Innova\SelfBundle\Entity\Media\MediaClick $mediaClicks
     * @return Test
     */
    public function addMediaClick(\Innova\SelfBundle\Entity\Media\MediaClick $mediaClicks)
    {
        $this->mediaClicks[] = $mediaClicks;

        return $this;
    }

    /**
     * Remove mediaClicks
     *
     * @param \Innova\SelfBundle\Entity\Media\MediaClick $mediaClicks
     */
    public function removeMediaClick(\Innova\SelfBundle\Entity\Media\MediaClick $mediaClicks)
    {
        $this->mediaClicks->removeElement($mediaClicks);
    }

    /**
     * Get mediaClicks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMediaClicks()
    {
        return $this->mediaClicks;
    }

    /**
     * Add orderQuestionnaireTests
     *
     * @param  \Innova\SelfBundle\Entity\OrderQuestionnaireTest $orderQuestionnaireTests
     * @return Test
     */
    public function addOrderQuestionnaireTest(\Innova\SelfBundle\Entity\OrderQuestionnaireTest $orderQuestionnaireTests)
    {
        $this->orderQuestionnaireTests[] = $orderQuestionnaireTests;

        return $this;
    }

    /**
     * Remove orderQuestionnaireTests
     *
     * @param \Innova\SelfBundle\Entity\OrderQuestionnaireTest $orderQuestionnaireTests
     */
    public function removeOrderQuestionnaireTest(\Innova\SelfBundle\Entity\OrderQuestionnaireTest $orderQuestionnaireTests)
    {
        $this->orderQuestionnaireTests->removeElement($orderQuestionnaireTests);
    }

    /**
     * Get orderQuestionnaireTests
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderQuestionnaireTests()
    {
        return $this->orderQuestionnaireTests;
    }
}
