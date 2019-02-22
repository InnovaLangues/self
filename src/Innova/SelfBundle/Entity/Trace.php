<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trace
 *
 * @ORM\Table("trace")
 * @ORM\Entity
* @ORM\Entity(repositoryClass="Innova\SelfBundle\Repository\TraceRepository")
 */
class Trace
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
    * @ORM\ManyToOne(targetEntity="Questionnaire", inversedBy="traces")
    */
    protected $questionnaire;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\PhasedTest\Component", inversedBy="traces")
    */
    protected $component = null;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Session", inversedBy="traces")
    */
    protected $session = null;

    /**
    * @ORM\ManyToOne(targetEntity="Test", inversedBy="traces")
    */
    protected $test;

    /**
    * @ORM\OneToMany(targetEntity="Answer", mappedBy="trace", cascade={"persist", "remove"})
    */
    protected $answers;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="traces")
    * @ORM\JoinColumn(onDelete="CASCADE")
    */
    protected $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="totalTime", type="integer")
     */
    private $totalTime;

    /**
     * @var string
     *
     * @ORM\Column(name="userAgent", type="string", length=255)
     */
    private $userAgent;

    /**
     * @var integer
     *
     * @ORM\Column(name="difficulty", type="integer")
     */
    private $difficulty;

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
     * Set date
     *
     * @param  \DateTime $date
     * @return Trace
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set totalTime
     *
     * @param  integer $totalTime
     * @return Trace
     */
    public function setTotalTime($totalTime)
    {
        $this->totalTime = $totalTime;

        return $this;
    }

    /**
     * Get totalTime
     *
     * @return integer
     */
    public function getTotalTime()
    {
        return $this->totalTime;
    }

    /**
     * Set userAgent
     *
     * @param  string $userAgent
     * @return Trace
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Get userAgent
     *
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Set difficulty
     *
     * @param  integer $difficulty
     * @return Trace
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Get difficulty
     *
     * @return integer
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->answers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set questionnaire
     *
     * @param  \Innova\SelfBundle\Entity\Questionnaire $questionnaire
     * @return Trace
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
     * Add answers
     *
     * @param  \Innova\SelfBundle\Entity\Answer $answers
     * @return Trace
     */
    public function addAnswer(\Innova\SelfBundle\Entity\Answer $answers)
    {
        $this->answers[] = $answers;

        return $this;
    }

    /**
     * Remove answers
     *
     * @param \Innova\SelfBundle\Entity\Answer $answers
     */
    public function removeAnswer(\Innova\SelfBundle\Entity\Answer $answers)
    {
        $this->answers->removeElement($answers);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Set user
     *
     * @param  \Innova\SelfBundle\Entity\User $user
     * @return Trace
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
     * Set test
     *
     * @param  \Innova\SelfBundle\Entity\Test $test
     * @return Trace
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
     * Set component
     *
     * @param  \Innova\SelfBundle\Entity\PhasedTest\Component $component
     * @return Trace
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

    /**
     * Set session
     *
     * @param  \Innova\SelfBundle\Entity\Session $session
     * @return Trace
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
}
