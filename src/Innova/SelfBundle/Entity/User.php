<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 * @ORM\Table(name="self_user")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Innova\SelfBundle\Repository\UserRepository")
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
    * @ORM\OneToMany(targetEntity="Trace", mappedBy="user", cascade={"remove"})
    */
    protected $traces;

    /**
    * @ORM\OneToMany(targetEntity="Questionnaire", mappedBy="author")
    */
    protected $questionnaires;

    /**
    * @ORM\ManyToMany(targetEntity="Questionnaire", mappedBy="revisors")
    */
    protected $revisedQuestionnaires;

    /**
     * @var string
     * @Assert\NotBlank(message="Title must not be empty")
     * @ORM\Column(name="lastName", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     * @ORM\Column(name="locale", type="string", length=2, nullable=true)
     */
    private $locale;

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
    * @ORM\OneToMany(targetEntity="Innova\SelfBundle\Entity\Media\MediaClick", mappedBy="user", cascade={"remove"})
    */
    protected $mediaClicks;

    /**
    * @ORM\OneToMany(targetEntity="Comment", mappedBy="user", cascade={"remove"})
    */
    private $comments;

     /**
    * @ORM\OneToMany(targetEntity="Innova\SelfBundle\Entity\EditorLog\EditorLog", mappedBy="user", cascade={"remove"})
    */
    private $editorLogs;

    /**
    * @ORM\ManyToMany(targetEntity="Test")
    * @ORM\JoinTable(name="user_test_favorites")
    */
    protected $favoritesTests;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->traces = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tests = new \Doctrine\Common\Collections\ArrayCollection();
        $this->locale = "fr";
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
     * @param  string $lastName
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
     * @param  string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

  
    /**
     * Set password
     *
     * @param  string $password
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
     * @param  \Innova\SelfBundle\Entity\Trace $traces
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
     * @param  \Innova\SelfBundle\Entity\Test $tests
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
     * @param  string $salt
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
     * @param  \Innova\SelfBundle\Entity\Questionnaire $questionnaires
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
     * @param  \Innova\SelfBundle\Entity\Level $coLevel
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
     * @param  \Innova\SelfBundle\Entity\Level $ceLevel
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
     * @param  \Innova\SelfBundle\Entity\Level $eeLevel
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
     * Set originStudent
     *
     * @param  \Innova\SelfBundle\Entity\OriginStudent $originStudent
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
     * Set levelLansad
     *
     * @param  \Innova\SelfBundle\Entity\LevelLansad $levelLansad
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

    /**
     * Set locale
     *
     * @param string $locale
     * @return User
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    
        return $this;
    }

    /**
     * Get locale
     *
     * @return string 
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Add mediaClicks
     *
     * @param \Innova\SelfBundle\Entity\Media\MediaClick $mediaClicks
     * @return User
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
     * Add comments
     *
     * @param \Innova\SelfBundle\Entity\Comment $comments
     * @return User
     */
    public function addComment(\Innova\SelfBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;
    
        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Innova\SelfBundle\Entity\Comment $comments
     */
    public function removeComment(\Innova\SelfBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add revisedQuestionnaires
     *
     * @param \Innova\SelfBundle\Entity\Questionnaire $revisedQuestionnaires
     * @return User
     */
    public function addRevisedQuestionnaire(\Innova\SelfBundle\Entity\Questionnaire $revisedQuestionnaires)
    {
        $this->revisedQuestionnaires[] = $revisedQuestionnaires;
    
        return $this;
    }

    /**
     * Remove revisedQuestionnaires
     *
     * @param \Innova\SelfBundle\Entity\Questionnaire $revisedQuestionnaires
     */
    public function removeRevisedQuestionnaire(\Innova\SelfBundle\Entity\Questionnaire $revisedQuestionnaires)
    {
        $this->revisedQuestionnaires->removeElement($revisedQuestionnaires);
    }

    /**
     * Get revisedQuestionnaires
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRevisedQuestionnaires()
    {
        return $this->revisedQuestionnaires;
    }

    /**
     * Add editorLogs
     *
     * @param \Innova\SelfBundle\Entity\EditorLog\EditorLog $editorLogs
     * @return User
     */
    public function addEditorLog(\Innova\SelfBundle\Entity\EditorLog\EditorLog $editorLogs)
    {
        $this->editorLogs[] = $editorLogs;
    
        return $this;
    }

    /**
     * Remove editorLogs
     *
     * @param \Innova\SelfBundle\Entity\EditorLog\EditorLog $editorLogs
     */
    public function removeEditorLog(\Innova\SelfBundle\Entity\EditorLog\EditorLog $editorLogs)
    {
        $this->editorLogs->removeElement($editorLogs);
    }

    /**
     * Get editorLogs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEditorLogs()
    {
        return $this->editorLogs;
    }

    /**
     * Add favoritesTests
     *
     * @param \Innova\SelfBundle\Entity\Test $favoritesTests
     * @return User
     */
    public function addFavoritesTest(\Innova\SelfBundle\Entity\Test $favoritesTests)
    {
        $this->favoritesTests[] = $favoritesTests;
    
        return $this;
    }

    /**
     * Remove favoritesTests
     *
     * @param \Innova\SelfBundle\Entity\Test $favoritesTests
     */
    public function removeFavoritesTest(\Innova\SelfBundle\Entity\Test $favoritesTests)
    {
        $this->favoritesTests->removeElement($favoritesTests);
    }

    /**
     * Get favoritesTests
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFavoritesTests()
    {
        return $this->favoritesTests;
    }
}