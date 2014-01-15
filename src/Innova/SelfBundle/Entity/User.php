<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 * 27/11/2013 : Add "global", "co", "lansad" columns. EV.
 * 28/11/2013 : Add "studentType" and "*Skill" colums. Delete "global", "co", "lansad" columns. EV.
 * @ORM\Table(name="self_user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @ORM\OneToMany(targetEntity="Trace", mappedBy="user")
    */
    protected $traces;

    /**
    * @ORM\OneToMany(targetEntity="Questionnaire", mappedBy="author")
    */
    protected $questionnaires;

    /**
     * @var string
     * @Assert\NotBlank(message="Title must not be empty")
     * @ORM\Column(name="lastName", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
    * @ORM\ManyToMany(targetEntity="Test", inversedBy="users")
    */
    private $tests;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="OriginStudent", inversedBy="originStudents")
     */
    private $originStudent;

    /**
    * @ORM\ManyToOne(targetEntity="Level", inversedBy="coLevels")
    */
    protected $coLevel;

    /**
    * @ORM\ManyToOne(targetEntity="Level", inversedBy="ceLevels")
    */
    protected $ceLevel;

    /**
    * @ORM\ManyToOne(targetEntity="Level", inversedBy="eeLevels")
    */
    protected $eeLevel;

    /**
    * @ORM\ManyToOne(targetEntity="LevelLansad", inversedBy="levelLansads")
    */
    protected $levelLansad;

	/**
	 * Constructor
	 */
    public function __construct()
    {
    	parent::__construct();
        $this->traces = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tests = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Add traces
     *
     * @param \Innova\SelfBundle\Entity\Trace $traces
     * @return User
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
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Add tests
     *
     * @param \Innova\SelfBundle\Entity\Test $tests
     * @return User
     */
    public function addTest(\Innova\SelfBundle\Entity\Test $tests)
    {
        $this->tests[] = $tests;

        return $this;
    }

    /**
     * Remove tests
     *
     * @param \Innova\SelfBundle\Entity\Test $tests
     */
    public function removeTest(\Innova\SelfBundle\Entity\Test $tests)
    {
        $this->tests->removeElement($tests);
    }

    /**
     * Get tests
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTests()
    {
        return $this->tests;
    }


    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }



    /**
     * Add questionnaires
     *
     * @param \Innova\SelfBundle\Entity\Questionnaire $questionnaires
     * @return User
     */
    public function addQuestionnaire(\Innova\SelfBundle\Entity\Questionnaire $questionnaires)
    {
        $this->questionnaires[] = $questionnaires;

        return $this;
    }

    /**
     * Remove questionnaires
     *
     * @param \Innova\SelfBundle\Entity\Questionnaire $questionnaires
     */
    public function removeQuestionnaire(\Innova\SelfBundle\Entity\Questionnaire $questionnaires)
    {
        $this->questionnaires->removeElement($questionnaires);
    }

    /**
     * Get questionnaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionnaires()
    {
        return $this->questionnaires;
    }

    /**
     * Set coLevel
     *
     * @param \Innova\SelfBundle\Entity\Level $coLevel
     * @return User
     */
    public function setCoLevel(\Innova\SelfBundle\Entity\Level $coLevel = null)
    {
        $this->coLevel = $coLevel;

        return $this;
    }

    /**
     * Get coLevel
     *
     * @return \Innova\SelfBundle\Entity\Level
     */
    public function getCoLevel()
    {
        return $this->coLevel;
    }

    /**
     * Set ceLevel
     *
     * @param \Innova\SelfBundle\Entity\Level $ceLevel
     * @return User
     */
    public function setCeLevel(\Innova\SelfBundle\Entity\Level $ceLevel = null)
    {
        $this->ceLevel = $ceLevel;

        return $this;
    }

    /**
     * Get ceLevel
     *
     * @return \Innova\SelfBundle\Entity\Level
     */
    public function getCeLevel()
    {
        return $this->ceLevel;
    }

    /**
     * Set eeLevel
     *
     * @param \Innova\SelfBundle\Entity\Level $eeLevel
     * @return User
     */
    public function setEeLevel(\Innova\SelfBundle\Entity\Level $eeLevel = null)
    {
        $this->eeLevel = $eeLevel;

        return $this;
    }

    /**
     * Get eeLevel
     *
     * @return \Innova\SelfBundle\Entity\Level
     */
    public function getEeLevel()
    {
        return $this->eeLevel;
    }

    /**
     * Set lastLevel
     *
     * @param \Innova\SelfBundle\Entity\Level $lastLevel
     * @return User
     */
    public function setLastLevel(\Innova\SelfBundle\Entity\Level $lastLevel = null)
    {
        $this->lastLevel = $lastLevel;

        return $this;
    }

    /**
     * Get lastLevel
     *
     * @return \Innova\SelfBundle\Entity\Level
     */
    public function getLastLevel()
    {
        return $this->lastLevel;
    }

    /**
     * Set originStudent
     *
     * @param \Innova\SelfBundle\Entity\OriginStudent $originStudent
     * @return User
     */
    public function setOriginStudent(\Innova\SelfBundle\Entity\OriginStudent $originStudent = null)
    {
        $this->originStudent = $originStudent;

        return $this;
    }

    /**
     * Get originStudent
     *
     * @return \Innova\SelfBundle\Entity\OriginStudent
     */
    public function getOriginStudent()
    {
        return $this->originStudent;
    }

    /**
     * Set lLansad
     *
     * @param \Innova\SelfBundle\Entity\LevelLansad $lLansad
     * @return User
     */
    public function setLLansad(\Innova\SelfBundle\Entity\LevelLansad $lLansad = null)
    {
        $this->lLansad = $lLansad;

        return $this;
    }

    /**
     * Get lLansad
     *
     * @return \Innova\SelfBundle\Entity\LevelLansad
     */
    public function getLLansad()
    {
        return $this->lLansad;
    }

    /**
     * Set levelLansad
     *
     * @param \Innova\SelfBundle\Entity\LevelLansad $levelLansad
     * @return User
     */
    public function setLevelLansad(\Innova\SelfBundle\Entity\LevelLansad $levelLansad = null)
    {
        $this->levelLansad = $levelLansad;

        return $this;
    }

    /**
     * Get levelLansad
     *
     * @return \Innova\SelfBundle\Entity\LevelLansad
     */
    public function getLevelLansad()
    {
        return $this->levelLansad;
    }
}