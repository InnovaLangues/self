<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;
use JsonSerializable;

/**
 * User.
 *
 * @ORM\Table(name="self_user")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Innova\SelfBundle\Repository\UserRepository")
 */
class User extends BaseUser implements JsonSerializable
{
    /**
     * @var int
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
     * @var string
     *
     * @ORM\Column(name="motherTongue", type="string", length=255, nullable=true)
     */
    private $motherTongue;

    /**
     * @var string
     *
     * @ORM\Column(name="motherTongueOther", type="string", length=255, nullable=true)
     */
    private $motherTongueOther;

    /**
     * @ORM\ManyToMany(targetEntity="Test", inversedBy="users")
     */
    private $tests;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Institution\Institution")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $institution;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Institution\Course")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $course;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Institution\Subcourse")
     * @ORM\JoinColumn(onDelete="SET NULL", nullable=true)
     */
    private $subcourse;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Institution\Year")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity="Language", inversedBy="users")
     */
    protected $preferedLanguage;

    /**
     * @ORM\OneToMany(targetEntity="Innova\SelfBundle\Entity\Media\MediaClick", mappedBy="user", cascade={"remove"})
     */
    protected $mediaClicks;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user", cascade={"remove"})
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="Test")
     * @ORM\JoinTable(name="user_test_favorites")
     */
    protected $favoritesTests;

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'username' => $this->__toString(),
        );
    }

    public function __toString()
    {
        return $this->getUsername().' ('.$this->getLastName().' '.$this->getFirstName().')';
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->traces = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tests = new \Doctrine\Common\Collections\ArrayCollection();
        $this->favoritesTests = new \Doctrine\Common\Collections\ArrayCollection();
        $this->locale = 'fr';
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Add traces.
     *
     * @param \Innova\SelfBundle\Entity\Trace $traces
     *
     * @return User
     */
    public function addTrace(\Innova\SelfBundle\Entity\Trace $traces)
    {
        $this->traces[] = $traces;

        return $this;
    }

    /**
     * Remove traces.
     *
     * @param \Innova\SelfBundle\Entity\Trace $traces
     */
    public function removeTrace(\Innova\SelfBundle\Entity\Trace $traces)
    {
        $this->traces->removeElement($traces);
    }

    /**
     * Get traces.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTraces()
    {
        return $this->traces;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Add tests.
     *
     * @param \Innova\SelfBundle\Entity\Test $tests
     *
     * @return User
     */
    public function addTest(\Innova\SelfBundle\Entity\Test $tests)
    {
        $this->tests[] = $tests;

        return $this;
    }

    /**
     * Remove tests.
     *
     * @param \Innova\SelfBundle\Entity\Test $tests
     */
    public function removeTest(\Innova\SelfBundle\Entity\Test $tests)
    {
        $this->tests->removeElement($tests);
    }

    /**
     * Get tests.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTests()
    {
        return $this->tests;
    }

    /**
     * Set salt.
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt.
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Add questionnaires.
     *
     * @param \Innova\SelfBundle\Entity\Questionnaire $questionnaires
     *
     * @return User
     */
    public function addQuestionnaire(\Innova\SelfBundle\Entity\Questionnaire $questionnaires)
    {
        $this->questionnaires[] = $questionnaires;

        return $this;
    }

    /**
     * Remove questionnaires.
     *
     * @param \Innova\SelfBundle\Entity\Questionnaire $questionnaires
     */
    public function removeQuestionnaire(\Innova\SelfBundle\Entity\Questionnaire $questionnaires)
    {
        $this->questionnaires->removeElement($questionnaires);
    }

    /**
     * Get questionnaires.
     *
     * @return Questionnaire[]
     */
    public function getQuestionnaires()
    {
        return $this->questionnaires;
    }

    /**
     * Set locale.
     *
     * @param string $locale
     *
     * @return User
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Add mediaClicks.
     *
     * @param \Innova\SelfBundle\Entity\Media\MediaClick $mediaClicks
     *
     * @return User
     */
    public function addMediaClick(\Innova\SelfBundle\Entity\Media\MediaClick $mediaClicks)
    {
        $this->mediaClicks[] = $mediaClicks;

        return $this;
    }

    /**
     * Remove mediaClicks.
     *
     * @param \Innova\SelfBundle\Entity\Media\MediaClick $mediaClicks
     */
    public function removeMediaClick(\Innova\SelfBundle\Entity\Media\MediaClick $mediaClicks)
    {
        $this->mediaClicks->removeElement($mediaClicks);
    }

    /**
     * Get mediaClicks.
     *
     * @return Media\MediaClick[]
     */
    public function getMediaClicks()
    {
        return $this->mediaClicks;
    }

    /**
     * Add comments.
     *
     * @param \Innova\SelfBundle\Entity\Comment $comments
     *
     * @return User
     */
    public function addComment(\Innova\SelfBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments.
     *
     * @param \Innova\SelfBundle\Entity\Comment $comments
     */
    public function removeComment(\Innova\SelfBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments.
     *
     * @return Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add revisedQuestionnaires.
     *
     * @param \Innova\SelfBundle\Entity\Questionnaire $revisedQuestionnaires
     *
     * @return User
     */
    public function addRevisedQuestionnaire(\Innova\SelfBundle\Entity\Questionnaire $revisedQuestionnaires)
    {
        $this->revisedQuestionnaires[] = $revisedQuestionnaires;

        return $this;
    }

    /**
     * Remove revisedQuestionnaires.
     *
     * @param \Innova\SelfBundle\Entity\Questionnaire $revisedQuestionnaires
     */
    public function removeRevisedQuestionnaire(\Innova\SelfBundle\Entity\Questionnaire $revisedQuestionnaires)
    {
        $this->revisedQuestionnaires->removeElement($revisedQuestionnaires);
    }

    /**
     * Get revisedQuestionnaires.
     *
     * @return Questionnaire[]
     */
    public function getRevisedQuestionnaires()
    {
        return $this->revisedQuestionnaires;
    }

    /**
     * Add favoritesTests.
     *
     * @param \Innova\SelfBundle\Entity\Test $favoritesTests
     *
     * @return User
     */
    public function addFavoritesTest(\Innova\SelfBundle\Entity\Test $favoritesTests)
    {
        $this->favoritesTests[] = $favoritesTests;

        return $this;
    }

    /**
     * Remove favoritesTests.
     *
     * @param \Innova\SelfBundle\Entity\Test $favoritesTests
     */
    public function removeFavoritesTest(\Innova\SelfBundle\Entity\Test $favoritesTests)
    {
        $this->favoritesTests->removeElement($favoritesTests);
    }

    /**
     * Get favoritesTests.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFavoritesTests()
    {
        return $this->favoritesTests;
    }

    /**
     * Set preferedLanguage.
     *
     * @param \Innova\SelfBundle\Entity\Language $preferedLanguage
     *
     * @return User
     */
    public function setPreferedLanguage(\Innova\SelfBundle\Entity\Language $preferedLanguage = null)
    {
        $this->preferedLanguage = $preferedLanguage;

        return $this;
    }

    /**
     * Get preferedLanguage.
     *
     * @return \Innova\SelfBundle\Entity\Language
     */
    public function getPreferedLanguage()
    {
        return $this->preferedLanguage;
    }

    /**
     * Set institution.
     *
     * @param \Innova\SelfBundle\Entity\Institution\Institution $institution
     *
     * @return User
     */
    public function setInstitution(\Innova\SelfBundle\Entity\Institution\Institution $institution = null)
    {
        $this->institution = $institution;

        return $this;
    }

    /**
     * Get institution.
     *
     * @return \Innova\SelfBundle\Entity\Institution\Institution
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * Set course.
     *
     * @param \Innova\SelfBundle\Entity\Institution\Course $course
     *
     * @return User
     */
    public function setCourse(\Innova\SelfBundle\Entity\Institution\Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course.
     *
     * @return \Innova\SelfBundle\Entity\Institution\Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set year.
     *
     * @param \Innova\SelfBundle\Entity\Institution\Year $year
     *
     * @return User
     */
    public function setYear(\Innova\SelfBundle\Entity\Institution\Year $year = null)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year.
     *
     * @return \Innova\SelfBundle\Entity\Institution\Year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set motherTongue.
     *
     * @param string $motherTongue
     *
     * @return User
     */
    public function setMotherTongue($motherTongue)
    {
        $this->motherTongue = $motherTongue;

        return $this;
    }

    /**
     * Get motherTongue.
     *
     * @return string
     */
    public function getMotherTongue()
    {
        return $this->motherTongue;
    }

    /**
     * Set motherTongueOther.
     *
     * @param string $motherTongueOther
     *
     * @return User
     */
    public function setMotherTongueOther($motherTongueOther)
    {
        $this->motherTongueOther = $motherTongueOther;

        return $this;
    }

    /**
     * Get motherTongueOther.
     *
     * @return string
     */
    public function getMotherTongueOther()
    {
        return $this->motherTongueOther;
    }

    /**
     * Set subcourse
     *
     * @param \Innova\SelfBundle\Entity\Institution\Subcourse $subcourse
     *
     * @return User
     */
    public function setSubcourse(\Innova\SelfBundle\Entity\Institution\Subcourse $subcourse = null)
    {
        $this->subcourse = $subcourse;

        return $this;
    }

    /**
     * Get subcourse
     *
     * @return \Innova\SelfBundle\Entity\Institution\Subcourse
     */
    public function getSubcourse()
    {
        return $this->subcourse;
    }

    public function isAdmin($strict = false): bool
    {
        return $this->hasRole('ROLE_ADMIN') || ($strict || $this->isSuperAdmin());
    }
}
