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
     * @ORM\Column(name="difficulty", type="boolean")
     */
    private $difficulty  = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="phased", type="boolean")
     */
    private $phased;

    /**
    * @ORM\OneToOne(targetEntity="Innova\SelfBundle\Entity\PhasedTest\PhasedParams", cascade={"remove"})
    */
    private $phasedParams;

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

    /**
    * @ORM\ManyToOne(targetEntity="Test", inversedBy="copies" )
    * @ORM\JoinColumn(onDelete="SET NULL")
    */
    protected $testOrigin;

    /**
    * @ORM\OneToMany(targetEntity="Test", mappedBy="testOrigin")
    */
    protected $copies;

    /**
     * @var boolean
     *
     * @ORM\Column(name="archived", type="boolean")
     */
    private $archived = 0;

    /**
    * @ORM\OneToMany(targetEntity="Innova\SelfBundle\Entity\PhasedTest\Component", mappedBy="test", cascade={"remove"})
    */
    protected $components;

    /**
    * @ORM\OneToMany(targetEntity="Session", mappedBy="test", cascade={"remove"})
    */
    protected $sessions;

    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set testOrigin
     *
     * @param  \Innova\SelfBundle\Entity\Test $testOrigin
     * @return Test
     */
    public function setTestOrigin(\Innova\SelfBundle\Entity\Test $testOrigin = null)
    {
        $this->testOrigin = $testOrigin;

        return $this;
    }

    /**
     * Get testOrigin
     *
     * @return \Innova\SelfBundle\Entity\Test
     */
    public function getTestOrigin()
    {
        return $this->testOrigin;
    }

    /**
     * Add copies
     *
     * @param  \Innova\SelfBundle\Entity\Test $copies
     * @return Test
     */
    public function addCopie(\Innova\SelfBundle\Entity\Test $copies)
    {
        $this->copies[] = $copies;

        return $this;
    }

    /**
     * Remove copies
     *
     * @param \Innova\SelfBundle\Entity\Test $copies
     */
    public function removeCopie(\Innova\SelfBundle\Entity\Test $copies)
    {
        $this->copies->removeElement($copies);
    }

    /**
     * Get copies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCopies()
    {
        return $this->copies;
    }

    /**
     * Set archived
     *
     * @param  boolean $archived
     * @return Test
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * Get archived
     *
     * @return boolean
     */
    public function isArchived()
    {
        return $this->archived;
    }

    /**
     * Set phased
     *
     * @param  boolean $phased
     * @return Test
     */
    public function setPhased($phased)
    {
        $this->phased = $phased;

        return $this;
    }

    /**
     * Get phased
     *
     * @return boolean
     */
    public function getPhased()
    {
        return $this->phased;
    }

    /**
     * Get archived
     *
     * @return boolean
     */
    public function getArchived()
    {
        return $this->archived;
    }

    /**
     * Add components
     *
     * @param  \Innova\SelfBundle\Entity\PhasedTest\Component $components
     * @return Test
     */
    public function addComponent(\Innova\SelfBundle\Entity\PhasedTest\Component $components)
    {
        $this->components[] = $components;

        return $this;
    }

    /**
     * Remove components
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\Component $components
     */
    public function removeComponent(\Innova\SelfBundle\Entity\PhasedTest\Component $components)
    {
        $this->components->removeElement($components);
    }

    /**
     * Get components
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * Add sessions
     *
     * @param  \Innova\SelfBundle\Entity\Session $sessions
     * @return Test
     */
    public function addSession(\Innova\SelfBundle\Entity\Session $sessions)
    {
        $this->sessions[] = $sessions;

        return $this;
    }

    /**
     * Remove sessions
     *
     * @param \Innova\SelfBundle\Entity\Session $sessions
     */
    public function removeSession(\Innova\SelfBundle\Entity\Session $sessions)
    {
        $this->sessions->removeElement($sessions);
    }

    /**
     * Get sessions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSessions()
    {
        return $this->sessions;
    }

    /**
     * Set phasedParams
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\PhasedParams $phasedParams
     *
     * @return Test
     */
    public function setPhasedParams(\Innova\SelfBundle\Entity\PhasedTest\PhasedParams $phasedParams = null)
    {
        $this->phasedParams = $phasedParams;

        return $this;
    }

    /**
     * Get phasedParams
     *
     * @return \Innova\SelfBundle\Entity\PhasedTest\PhasedParams
     */
    public function getPhasedParams()
    {
        return $this->phasedParams;
    }

    /**
     * Add copy
     *
     * @param \Innova\SelfBundle\Entity\Test $copy
     *
     * @return Test
     */
    public function addCopy(\Innova\SelfBundle\Entity\Test $copy)
    {
        $this->copies[] = $copy;

        return $this;
    }

    /**
     * Remove copy
     *
     * @param \Innova\SelfBundle\Entity\Test $copy
     */
    public function removeCopy(\Innova\SelfBundle\Entity\Test $copy)
    {
        $this->copies->removeElement($copy);
    }

    /**
     * Set difficulty
     *
     * @param boolean $difficulty
     *
     * @return Test
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Get difficulty
     *
     * @return boolean
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }
}
