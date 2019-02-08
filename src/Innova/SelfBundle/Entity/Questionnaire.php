<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Questionnaire
 *
 * Aussi appelée Task (tâche)
 *
 * @ORM\Table("questionnaire")
 * @ORM\Entity(repositoryClass="Innova\SelfBundle\Repository\QuestionnaireRepository")
 */
class Questionnaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Level", inversedBy="questionnaires")
     */
    protected $level;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="questionnaires")
     */
    protected $author;

    /**
     * @var string
     *
     * @ORM\Column(name="authorMore", type="text", nullable=true)
     */
    private $authorMore;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="revisedQuestionnaires")
     * @ORM\JoinTable(name="questionnaires_revisors")
     */
    protected $revisors;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\QuestionnaireIdentity\Status", inversedBy="questionnaires")
     */
    protected $status;

    /**
     * @ORM\OneToMany(targetEntity="Innova\SelfBundle\Entity\Media\MediaLimit", mappedBy="questionnaire", cascade={"persist", "remove"})
     */
    private $mediaLimits;

    /**
     * @ORM\OneToMany(targetEntity="Innova\SelfBundle\Entity\Media\MediaClick", mappedBy="questionnaire", cascade={"persist", "remove"})
     */
    private $mediaClicks;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="questionnaire", cascade={"persist", "remove"})
     */
    private $comments;

    /**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=255)
     */
    private $theme = 'Tâche sans nom';

    /**
     * @var string
     *
     * @ORM\Column(name="textTitle", type="string", length=255, nullable=true)
     */
    private $textTitle;

    /**
     * @var int
     *
     * @ORM\Column(name="dialogue", type="integer")
     */
    private $dialogue = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="fixedOrder", type="boolean")
     */
    private $fixedOrder = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Media\Media")
     */
    protected $mediaInstruction;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Media\Media")
     */
    protected $mediaContext;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Media\Media")
     */
    protected $mediaText;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Media\Media")
     */
    protected $mediaBlankText;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Media\Media")
     */
    protected $mediaFunctionalInstruction;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Media\Media")
     */
    protected $mediaFeedback;

    /**
     * @ORM\OneToMany(targetEntity="Question", mappedBy="questionnaire", cascade={"persist", "remove"})
     */
    protected $questions;

    /**
     * @ORM\OneToMany(targetEntity="Trace", mappedBy="questionnaire", cascade={"persist", "remove"})
     */
    protected $traces;

    /**
     * @ORM\OneToMany(targetEntity="OrderQuestionnaireTest", mappedBy="questionnaire")
     */
    private $orderQuestionnaireTests;

    /**
     * @ORM\OneToMany(targetEntity="Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent", mappedBy="questionnaire")
     */
    private $orderQuestionnaireComponents;

    /**
     * @ORM\ManyToOne(targetEntity="Language", inversedBy="questionnaires")
     */
    protected $language;

    /**
     * @ORM\ManyToOne(targetEntity="Skill", inversedBy="questionnaires", fetch = "EAGER")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $skill;

    // FICHE D'IDENTITE

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $levelProof;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $context;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $textType;

    /**
     * @Assert\Count(
     *      min = 1,
     *      minMessage = "Vous devez faire au moins un choix.",
     * )
     *
     * @ORM\ManyToMany(targetEntity="Innova\SelfBundle\Entity\QuestionnaireIdentity\SourceType", inversedBy="questionnaires")
     * @ORM\JoinTable(name="questionnaires_sourceType")
     */
    protected $sourceTypes;

    /**
     * @Assert\Count(min=1, minMessage="Vous devez faire au moins un choix.")
     * @ORM\ManyToMany(targetEntity="Innova\SelfBundle\Entity\QuestionnaireIdentity\Genre", inversedBy="questionnaires")
     * @ORM\JoinTable(name="questionnaires_genre")
     */
    protected $genres;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    protected $register;

    const REGISTER_FAMILIAR = 'familiar';
    const REGISTER_NEUTRAL = 'neutral';
    const REGISTER_SUSTAINED = 'sustained';
    const REGISTER_MIXED = 'mixed';
    const REGISTER_JP_FORMAL = 'jp_formal';
    const REGISTER_JP_IMPERSONAL = 'jp_impersonal';
    const REGISTER_JP_PERSO_POLITE = 'jp_perso_polite';
    const REGISTER_JP_PERSO_FAMILIAR = 'jp_perso_familiar';

    /**
     * @var array
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $length;

    const LENGTH_AUDIO_SHORT = 'audio_short';
    const LENGTH_AUDIO_MEDIUM = 'audio_medium';
    const LENGTH_AUDIO_LONG = 'audio_long';
    const LENGTH_TEXT_SHORT = 'text_short';
    const LENGTH_TEXT_MEDIUM = 'text_medium';
    const LENGTH_TEXT_LONG = 'text_long';

    /**
     * @var array
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    protected $flow;

    const FLOW_SLOW = 'slow';
    const FLOW_MEDIUM = 'medium';
    const FLOW_FAST = 'fast';

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $flowComment;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $readability;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $variety;

    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 4
     * )
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $speakers;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\Choice(callback="getAuthorRightValues")
     */
    protected $authorRight = self::AUTHOR_RIGHT_TO_ASK;

    const AUTHOR_RIGHT_NOT_NEEDED = 'not_needed';
    const AUTHOR_RIGHT_TO_ASK = 'to_ask';
    const AUTHOR_RIGHT_PENDING = 'pending';
    const AUTHOR_RIGHT_AUTHORIZED = 'authorized';

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $createdBySelf = false;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $freeLicence = false;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $freeLicenceComment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $authorizationRequestedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $authorizationGrantedAt;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $sourceContacts;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $sourceUrl;

    /**
     * @var string
     *
     * ORM\Column(type="text", nullable=true)
     */
    protected $sourceStorage;


    public function __toString()
    {
        return $this->theme;
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
     * Set level.
     *
     * @param string $level
     *
     * @return Questionnaire
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level.
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set theme.
     *
     * @param string $theme
     *
     * @return Questionnaire
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme.
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param \Innova\SelfBundle\Entity\Question $questions
     *
     * @return Questionnaire
     */
    public function addQuestion(\Innova\SelfBundle\Entity\Question $questions)
    {
        $this->questions[] = $questions;

        return $this;
    }

    /**
     * Remove questions.
     *
     * @param \Innova\SelfBundle\Entity\Question $questions
     */
    public function removeQuestion(\Innova\SelfBundle\Entity\Question $questions)
    {
        $this->questions->removeElement($questions);
    }

    /**
     * Get questions.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Add traces.
     *
     * @param \Innova\SelfBundle\Entity\Trace $traces
     *
     * @return Questionnaire
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
     * Set skill.
     *
     * @param \Innova\SelfBundle\Entity\Skill $skill
     *
     * @return Questionnaire
     */
    public function setSkill($skill = null)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Get skill.
     *
     * @return \Innova\SelfBundle\Entity\Skill
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * Set author.
     *
     * @param \Innova\SelfBundle\Entity\User $author
     *
     * @return Questionnaire
     */
    public function setAuthor(\Innova\SelfBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author.
     *
     * @return \Innova\SelfBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set dialogue.
     *
     * @param int $dialogue
     *
     * @return Questionnaire
     */
    public function setDialogue($dialogue)
    {
        $this->dialogue = $dialogue;

        return $this;
    }

    /**
     * Get dialogue.
     *
     * @return int
     */
    public function getDialogue()
    {
        return $this->dialogue;
    }

    /**
     * Set mediaInstruction.
     *
     * @param \Innova\SelfBundle\Entity\Media\Media $mediaInstruction
     *
     * @return Questionnaire
     */
    public function setMediaInstruction(\Innova\SelfBundle\Entity\Media\Media $mediaInstruction = null)
    {
        $this->mediaInstruction = $mediaInstruction;

        return $this;
    }

    /**
     * Get mediaInstruction.
     *
     * @return \Innova\SelfBundle\Entity\Media\Media
     */
    public function getMediaInstruction()
    {
        return $this->mediaInstruction;
    }

    /**
     * Set mediaContext.
     *
     * @param \Innova\SelfBundle\Entity\Media\Media $mediaContext
     *
     * @return Questionnaire
     */
    public function setMediaContext(\Innova\SelfBundle\Entity\Media\Media $mediaContext = null)
    {
        $this->mediaContext = $mediaContext;

        return $this;
    }

    /**
     * Get mediaContext.
     *
     * @return \Innova\SelfBundle\Entity\Media\Media
     */
    public function getMediaContext()
    {
        return $this->mediaContext;
    }

    /**
     * Set mediaText.
     *
     * @param \Innova\SelfBundle\Entity\Media\Media $mediaText
     *
     * @return Questionnaire
     */
    public function setMediaText(\Innova\SelfBundle\Entity\Media\Media $mediaText = null)
    {
        $this->mediaText = $mediaText;

        return $this;
    }

    /**
     * Get mediaText.
     *
     * @return \Innova\SelfBundle\Entity\Media\Media
     */
    public function getMediaText()
    {
        return $this->mediaText;
    }

    /**
     * Set fixedOrder.
     *
     * @param bool $fixedOrder
     *
     * @return Questionnaire
     */
    public function setFixedOrder($fixedOrder)
    {
        $this->fixedOrder = $fixedOrder;

        return $this;
    }

    /**
     * Get fixedOrder.
     *
     * @return bool
     */
    public function getFixedOrder()
    {
        return $this->fixedOrder;
    }

    /**
     * Add mediaLimits.
     *
     * @param \Innova\SelfBundle\Entity\Media\MediaLimit $mediaLimits
     *
     * @return Questionnaire
     */
    public function addMediaLimit(\Innova\SelfBundle\Entity\Media\MediaLimit $mediaLimits)
    {
        $this->mediaLimits[] = $mediaLimits;

        return $this;
    }

    /**
     * Remove mediaLimits.
     *
     * @param \Innova\SelfBundle\Entity\Media\MediaLimit $mediaLimits
     */
    public function removeMediaLimit(\Innova\SelfBundle\Entity\Media\MediaLimit $mediaLimits)
    {
        $this->mediaLimits->removeElement($mediaLimits);
    }

    /**
     * Get mediaLimits.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMediaLimits()
    {
        return $this->mediaLimits;
    }

    /**
     * Add mediaClicks.
     *
     * @param \Innova\SelfBundle\Entity\Media\MediaClick $mediaClicks
     *
     * @return Questionnaire
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMediaClicks()
    {
        return $this->mediaClicks;
    }

    /**
     * Add orderQuestionnaireTests.
     *
     * @param \Innova\SelfBundle\Entity\OrderQuestionnaireTest $orderQuestionnaireTests
     *
     * @return Questionnaire
     */
    public function addOrderQuestionnaireTest(\Innova\SelfBundle\Entity\OrderQuestionnaireTest $orderQuestionnaireTests)
    {
        $this->orderQuestionnaireTests[] = $orderQuestionnaireTests;

        return $this;
    }

    /**
     * Remove orderQuestionnaireTests.
     *
     * @param \Innova\SelfBundle\Entity\OrderQuestionnaireTest $orderQuestionnaireTests
     */
    public function removeOrderQuestionnaireTest(\Innova\SelfBundle\Entity\OrderQuestionnaireTest $orderQuestionnaireTests)
    {
        $this->orderQuestionnaireTests->removeElement($orderQuestionnaireTests);
    }

    /**
     * Get orderQuestionnaireTests.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderQuestionnaireTests()
    {
        return $this->orderQuestionnaireTests;
    }

    /**
     * Set mediaFunctionalInstruction.
     *
     * @param \Innova\SelfBundle\Entity\Media\Media $mediaFunctionalInstruction
     *
     * @return Questionnaire
     */
    public function setMediaFunctionalInstruction(\Innova\SelfBundle\Entity\Media\Media $mediaFunctionalInstruction = null)
    {
        $this->mediaFunctionalInstruction = $mediaFunctionalInstruction;

        return $this;
    }

    /**
     * Get mediaFunctionalInstruction.
     *
     * @return \Innova\SelfBundle\Entity\Media\Media
     */
    public function getMediaFunctionalInstruction()
    {
        return $this->mediaFunctionalInstruction;
    }

    /**
     * Add comments.
     *
     * @param \Innova\SelfBundle\Entity\Comment $comments
     *
     * @return Questionnaire
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set mediaFeedback.
     *
     * @param \Innova\SelfBundle\Entity\Media\Media $mediaFeedback
     *
     * @return Questionnaire
     */
    public function setMediaFeedback(\Innova\SelfBundle\Entity\Media\Media $mediaFeedback = null)
    {
        $this->mediaFeedback = $mediaFeedback;

        return $this;
    }

    /**
     * Get mediaFeedback.
     *
     * @return \Innova\SelfBundle\Entity\Media\Media
     */
    public function getMediaFeedback()
    {
        return $this->mediaFeedback;
    }

    /**
     * Set mediaBlankText.
     *
     * @param \Innova\SelfBundle\Entity\Media\Media $mediaBlankText
     *
     * @return Questionnaire
     */
    public function setMediaBlankText(\Innova\SelfBundle\Entity\Media\Media $mediaBlankText = null)
    {
        $this->mediaBlankText = $mediaBlankText;

        return $this;
    }

    /**
     * Get mediaBlankText.
     *
     * @return \Innova\SelfBundle\Entity\Media\Media
     */
    public function getMediaBlankText()
    {
        return $this->mediaBlankText;
    }

    /**
     * Set language.
     *
     * @param \Innova\SelfBundle\Entity\Language $language
     *
     * @return Questionnaire
     */
    public function setLanguage(\Innova\SelfBundle\Entity\Language $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language.
     *
     * @return \Innova\SelfBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set textTitle.
     *
     * @param string $textTitle
     *
     * @return Questionnaire
     */
    public function setTextTitle($textTitle)
    {
        $this->textTitle = $textTitle;

        return $this;
    }

    /**
     * Get textTitle.
     *
     * @return string
     */
    public function getTextTitle()
    {
        return $this->textTitle;
    }

    /**
     * Set levelProof.
     *
     * @param string $levelProof
     *
     * @return Questionnaire
     */
    public function setLevelProof($levelProof)
    {
        $this->levelProof = $levelProof;

        return $this;
    }

    /**
     * Get levelProof.
     *
     * @return string
     */
    public function getLevelProof()
    {
        return $this->levelProof;
    }

    /**
     * Add revisors.
     *
     * @param \Innova\SelfBundle\Entity\User $revisors
     *
     * @return Questionnaire
     */
    public function addRevisor(\Innova\SelfBundle\Entity\User $revisors)
    {
        $this->revisors[] = $revisors;

        return $this;
    }

    /**
     * Remove revisors.
     *
     * @param \Innova\SelfBundle\Entity\User $revisors
     */
    public function removeRevisor(\Innova\SelfBundle\Entity\User $revisors)
    {
        $this->revisors->removeElement($revisors);
    }

    /**
     * Get revisors.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRevisors()
    {
        return $this->revisors;
    }

    /**
     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\Status $status
     *
     * @return Questionnaire
     */
    public function setStatus(\Innova\SelfBundle\Entity\QuestionnaireIdentity\Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return \Innova\SelfBundle\Entity\QuestionnaireIdentity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $register
     *
     * @return Questionnaire
     */
    public function setRegister($register = null)
    {
        $this->register = $register;

        return $this;
    }

    /**
     * @return string
     */
    public function getRegister()
    {
        return $this->register;
    }

    /**
     * @param string $length
     *
     * @return Questionnaire
     */
    public function setLength($length = null)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param array|null $flow
     *
     * @return Questionnaire
     */
    public function setFlow($flow = null)
    {
        $this->flow = $flow;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getFlow()
    {
        return $this->flow;
    }

    /**
     * @return string
     */
    public function getFlowComment()
    {
        return $this->flowComment;
    }

    /**
     * @param string $flowComment
     */
    public function setFlowComment($flowComment)
    {
        $this->flowComment = $flowComment;
    }

    /**
     * Set authorMore.
     *
     * @param string $authorMore
     *
     * @return Questionnaire
     */
    public function setAuthorMore($authorMore)
    {
        $this->authorMore = $authorMore;

        return $this;
    }

    /**
     * Get authorMore.
     *
     * @return string
     */
    public function getAuthorMore()
    {
        return $this->authorMore;
    }

    /**
     * Add sourceTypes.
     *
     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\SourceType $sourceTypes
     *
     * @return Questionnaire
     */
    public function addSourceType(\Innova\SelfBundle\Entity\QuestionnaireIdentity\SourceType $sourceTypes)
    {
        $this->sourceTypes[] = $sourceTypes;

        return $this;
    }

    /**
     * Add sourceTypes collection.
     */
    public function addSourceTypes($sourceTypes)
    {
        foreach ($sourceTypes as $sourceType) {
            $this->sourceTypes[] = $sourceType;
        }

        return $this;
    }

    /**
     * Remove sourceTypes.
     *
     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\SourceType $sourceTypes
     */
    public function removeSourceType(\Innova\SelfBundle\Entity\QuestionnaireIdentity\SourceType $sourceTypes)
    {
        $this->sourceTypes->removeElement($sourceTypes);
    }

    /**
     * Get sourceTypes.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSourceTypes()
    {
        return $this->sourceTypes;
    }

    /**
     * Add genres.
     *
     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\Genre $genres
     *
     * @return Questionnaire
     */
    public function addGenre(\Innova\SelfBundle\Entity\QuestionnaireIdentity\Genre $genres)
    {
        $this->genres[] = $genres;

        return $this;
    }

    /**
     * Add genres collection.
     */
    public function addGenres($genres)
    {
        foreach ($genres as $genre) {
            $this->genres[] = $genre;
        }

        return $this;
    }

    /**
     * Remove genres.
     *
     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\Genre $genres
     */
    public function removeGenre(\Innova\SelfBundle\Entity\QuestionnaireIdentity\Genre $genres)
    {
        $this->genres->removeElement($genres);
    }

    /**
     * Get genres.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->revisors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mediaLimits = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mediaClicks = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->traces = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orderQuestionnaireTests = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sourceTypes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->genres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orderQuestionnaireComponents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->genres = new ArrayCollection();
    }

    /**
     * Add orderQuestionnaireComponents.
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent $orderQuestionnaireComponents
     *
     * @return Questionnaire
     */
    public function addOrderQuestionnaireComponent(\Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent $orderQuestionnaireComponents)
    {
        $this->orderQuestionnaireComponents[] = $orderQuestionnaireComponents;

        return $this;
    }

    /**
     * Remove orderQuestionnaireComponents.
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent $orderQuestionnaireComponents
     */
    public function removeOrderQuestionnaireComponent(\Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent $orderQuestionnaireComponents)
    {
        $this->orderQuestionnaireComponents->removeElement($orderQuestionnaireComponents);
    }

    /**
     * Get orderQuestionnaireComponents.
     *
     * @return PhasedTest\OrderQuestionnaireComponent[]
     */
    public function getOrderQuestionnaireComponents()
    {
        return $this->orderQuestionnaireComponents;
    }

    /**
     * @return string
     */
    public function getReadability()
    {
        return $this->readability;
    }

    /**
     * @param string $readability
     */
    public function setReadability($readability)
    {
        $this->readability = $readability;
    }

    /**
     * @return string
     */
    public function getVariety()
    {
        return $this->variety;
    }

    /**
     * @param string $variety
     */
    public function setVariety($variety)
    {
        $this->variety = $variety;
    }

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param string $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * @return string
     */
    public function getTextType()
    {
        return $this->textType;
    }

    /**
     * @param string $textType
     */
    public function setTextType($textType)
    {
        $this->textType = $textType;
    }

    /**
     * @param string $authorRightMore
     *
     * @return Questionnaire
     */
    public function setAuthorRight($authorRight)
    {
        $this->authorRight = $authorRight;
        return $this;
    }
    /**
     * @return string
     */
    public function getAuthorRight()
    {
        return empty($this->authorRight) ? self::AUTHOR_RIGHT_TO_ASK : $this->authorRight;
    }

    /**
     * @return bool
     */
    public function isCreatedBySelf()
    {
        return $this->createdBySelf;
    }

    /**
     * @param bool $createdBySelf
     */
    public function setCreatedBySelf($createdBySelf)
    {
        $this->createdBySelf = $createdBySelf;
    }

    /**
     * @return bool
     */
    public function isFreeLicence()
    {
        return $this->freeLicence;
    }

    /**
     * @param bool $freeLicence
     */
    public function setFreeLicence($freeLicence)
    {
        $this->freeLicence = $freeLicence;
    }

    /**
     * @return string
     */
    public function getFreeLicenceComment()
    {
        return $this->freeLicenceComment;
    }

    /**
     * @param string $freeLicenceComment
     */
    public function setFreeLicenceComment($freeLicenceComment)
    {
        $this->freeLicenceComment = $freeLicenceComment;
    }

    /**
     * @return \DateTime
     */
    public function getAuthorizationRequestedAt()
    {
        return $this->authorizationRequestedAt;
    }

    /**
     * @param \DateTime $authorizationRequestedAt
     */
    public function setAuthorizationRequestedAt($authorizationRequestedAt)
    {
        $this->authorizationRequestedAt = $authorizationRequestedAt;
    }

    /**
     * @return \DateTime
     */
    public function getAuthorizationGrantedAt()
    {
        return $this->authorizationGrantedAt;
    }

    /**
     * @param \DateTime $authorizationGrantedAt
     */
    public function setAuthorizationGrantedAt($authorizationGrantedAt)
    {
        $this->authorizationGrantedAt = $authorizationGrantedAt;
    }

    /**
     * @return string
     */
    public function getSourceContacts()
    {
        return $this->sourceContacts;
    }

    /**
     * @param string $sourceContacts
     */
    public function setSourceContacts($sourceContacts)
    {
        $this->sourceContacts = $sourceContacts;
    }

    /**
     * @return string
     */
    public function getSourceUrl()
    {
        return $this->sourceUrl;
    }

    /**
     * @param string $sourceUrl
     */
    public function setSourceUrl($sourceUrl)
    {
        $this->sourceUrl = $sourceUrl;
    }

    /**
     * @return string
     */
    public function getSourceStorage()
    {
        return $this->sourceStorage;
    }

    /**
     * @param string $sourceStorage
     */
    public function setSourceStorage($sourceStorage)
    {
        $this->sourceStorage = $sourceStorage;
    }

    /**
     * @return int
     */
    public function getSpeakers()
    {
        return $this->speakers;
    }

    /**
     * @param int $speakers
     */
    public function setSpeakers($speakers)
    {
        $this->speakers = $speakers;
    }

    public static function getAuthorRightValues()
    {
        return [
            self::AUTHOR_RIGHT_NOT_NEEDED,
            self::AUTHOR_RIGHT_TO_ASK,
            self::AUTHOR_RIGHT_PENDING,
            self::AUTHOR_RIGHT_AUTHORIZED,
        ];
    }

    public static function getLengthValues()
    {
        return [
            self::LENGTH_AUDIO_SHORT,
            self::LENGTH_AUDIO_MEDIUM,
            self::LENGTH_AUDIO_LONG,
            self::LENGTH_TEXT_SHORT,
            self::LENGTH_TEXT_MEDIUM,
            self::LENGTH_TEXT_LONG
        ];
    }

    public static function getFlowValues()
    {
        return [
            self::FLOW_SLOW,
            self::FLOW_MEDIUM,
            self::FLOW_FAST
        ];
    }

    public static function getRegisterValues()
    {
        return [
            self::REGISTER_FAMILIAR,
            self::REGISTER_NEUTRAL,
            self::REGISTER_SUSTAINED,
            self::REGISTER_MIXED,
            self::REGISTER_JP_FORMAL,
            self::REGISTER_JP_IMPERSONAL,
            self::REGISTER_JP_PERSO_POLITE,
            self::REGISTER_JP_PERSO_FAMILIAR,
        ];
    }
}
