<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Questionnaire.
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

    // FICHE D'IDENTITE

    /**
     * @var string
     *
     * @ORM\Column(name="lisibility", type="string", length=255, nullable=true)
     */
    private $lisibility;

    /**
     * @ORM\ManyToOne(targetEntity="Skill", inversedBy="questionnaires", fetch = "EAGER")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $skill;

    /**
     * @var string
     *
     * @ORM\Column(name="levelProof", type="text", nullable=true)
     */
    private $levelProof;

//    /**
//     * @var string
//     *
//     * @ORM\Column(name="authorRightMore", type="text", nullable=true)
//     */
//    private $authorRightMore;
//
//    /**
//     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\QuestionnaireIdentity\AuthorRight", inversedBy="questionnaires")
//     * @ORM\JoinColumn(onDelete="SET NULL")
//     */
//    protected $authorRight;

//    /**
//     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\QuestionnaireIdentity\Source", inversedBy="questionnaires")
//     * @ORM\JoinColumn(onDelete="SET NULL")
//     */
//    protected $source;

//    /**
//     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\QuestionnaireIdentity\SourceOperation", inversedBy="questionnaires")
//     * @ORM\JoinColumn(onDelete="SET NULL")
//     */
//    protected $sourceOperation;

//    /**
//     * @var string
//     *
//     * @ORM\Column(name="sourceMore", type="text", nullable=true)
//     */
//    private $sourceMore;

    /**
     * @var string
     *
     * @ORM\Column(name="questionnaires_speechType", type="text", nullable=true)
     */
    private $speechType;

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

//    /**
//     * @ORM\ManyToMany(targetEntity="Innova\SelfBundle\Entity\QuestionnaireIdentity\Channel", inversedBy="questionnaires")
//     * @ORM\JoinTable(name="questionnaires_channel")
//     */
//    protected $channels;

//    /**
//     * @ORM\ManyToMany(targetEntity="Innova\SelfBundle\Entity\QuestionnaireIdentity\SocialLocation", inversedBy="questionnaires")
//     * @ORM\JoinTable(name="questionnaires_socialLocation")
//     */
//    protected $socialLocations;

    /**
     * @ORM\ManyToMany(targetEntity="Innova\SelfBundle\Entity\QuestionnaireIdentity\Genre", inversedBy="questionnaires")
     * @ORM\JoinTable(name="questionnaires_genre")
     */
    protected $genres;

//    /**
//     * @ORM\ManyToMany(targetEntity="Innova\SelfBundle\Entity\QuestionnaireIdentity\Variety", inversedBy="questionnaires")
//     * @ORM\JoinTable(name="questionnaires_variety")
//     */
//    protected $varieties;

    /**
     * @var string
     *
     * ORM\Column(name="variety", type="text", nullable=true)
     */
    protected $variety;

//    /**
//     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\QuestionnaireIdentity\Domain", inversedBy="questionnaires")
//     * @ORM\JoinColumn(onDelete="SET NULL")
//     */
//    protected $domain;

//    /**
//     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\QuestionnaireIdentity\ProductionType", inversedBy="questionnaires")
//     * @ORM\JoinColumn(onDelete="SET NULL")
//     */
//    protected $productionType;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\QuestionnaireIdentity\Register", inversedBy="questionnaires")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $register;

//    /**
//     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\QuestionnaireIdentity\Reception", inversedBy="questionnaires")
//     * @ORM\JoinColumn(onDelete="SET NULL")
//     */
//    protected $reception;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\QuestionnaireIdentity\Length", inversedBy="questionnaires")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $length;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\QuestionnaireIdentity\TextLength", inversedBy="questionnaires")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $textLength;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\QuestionnaireIdentity\Flow", inversedBy="questionnaires")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $flow;

    /**
     * @var string
     *
     * ORM\Column(type="text", nullable=true)
     */
    protected $readability;


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

//    /**
//     * Set authorRightMore.
//     *
//     * @param string $authorRightMore
//     *
//     * @return Questionnaire
//     */
//    public function setAuthorRightMore($authorRightMore)
//    {
//        $this->authorRightMore = $authorRightMore;
//
//        return $this;
//    }
//
//    /**
//     * Get authorRightMore.
//     *
//     * @return string
//     */
//    public function getAuthorRightMore()
//    {
//        return $this->authorRightMore;
//    }

//    /**
//     * Set sourceMore.
//     *
//     * @param string $sourceMore
//     *
//     * @return Questionnaire
//     */
//    public function setSourceMore($sourceMore)
//    {
//        $this->sourceMore = $sourceMore;
//
//        return $this;
//    }
//
//    /**
//     * Get sourceMore.
//     *
//     * @return string
//     */
//    public function getSourceMore()
//    {
//        return $this->sourceMore;
//    }

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

//    /**
//     * Set authorRight.
//     *
//     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\AuthorRight $authorRight
//     *
//     * @return Questionnaire
//     */
//    public function setAuthorRight(\Innova\SelfBundle\Entity\QuestionnaireIdentity\AuthorRight $authorRight = null)
//    {
//        $this->authorRight = $authorRight;
//
//        return $this;
//    }
//
//    /**
//     * Get authorRight.
//     *
//     * @return \Innova\SelfBundle\Entity\QuestionnaireIdentity\AuthorRight
//     */
//    public function getAuthorRight()
//    {
//        return $this->authorRight;
//    }

//    /**
//     * Set domain.
//     *
//     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\Domain $domain
//     *
//     * @return Questionnaire
//     */
//    public function setDomain(\Innova\SelfBundle\Entity\QuestionnaireIdentity\Domain $domain = null)
//    {
//        $this->domain = $domain;
//
//        return $this;
//    }
//
//    /**
//     * Get domain.
//     *
//     * @return \Innova\SelfBundle\Entity\QuestionnaireIdentity\Domain
//     */
//    public function getDomain()
//    {
//        return $this->domain;
//    }

    /**
     * Set register.
     *
     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\Register $register
     *
     * @return Questionnaire
     */
    public function setRegister(\Innova\SelfBundle\Entity\QuestionnaireIdentity\Register $register = null)
    {
        $this->register = $register;

        return $this;
    }

    /**
     * Get register.
     *
     * @return \Innova\SelfBundle\Entity\QuestionnaireIdentity\Register
     */
    public function getRegister()
    {
        return $this->register;
    }

//    /**
//     * Set reception.
//     *
//     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\Reception $reception
//     *
//     * @return Questionnaire
//     */
//    public function setReception(\Innova\SelfBundle\Entity\QuestionnaireIdentity\Reception $reception = null)
//    {
//        $this->reception = $reception;
//
//        return $this;
//    }
//
//    /**
//     * Get reception.
//     *
//     * @return \Innova\SelfBundle\Entity\QuestionnaireIdentity\Reception
//     */
//    public function getReception()
//    {
//        return $this->reception;
//    }

    /**
     * Set length.
     *
     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\Length $length
     *
     * @return Questionnaire
     */
    public function setLength(\Innova\SelfBundle\Entity\QuestionnaireIdentity\Length $length = null)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get length.
     *
     * @return \Innova\SelfBundle\Entity\QuestionnaireIdentity\Length
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set flow.
     *
     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\Flow $flow
     *
     * @return Questionnaire
     */
    public function setFlow(\Innova\SelfBundle\Entity\QuestionnaireIdentity\Flow $flow = null)
    {
        $this->flow = $flow;

        return $this;
    }

    /**
     * Get flow.
     *
     * @return \Innova\SelfBundle\Entity\QuestionnaireIdentity\Flow
     */
    public function getFlow()
    {
        return $this->flow;
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

//    /**
//     * Add channels.
//     *
//     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\Channel $channels
//     *
//     * @return Questionnaire
//     */
//    public function addChannel(\Innova\SelfBundle\Entity\QuestionnaireIdentity\Channel $channels)
//    {
//        $this->channels[] = $channels;
//
//        return $this;
//    }
//
//    /**
//     * Add channels collection.
//     */
//    public function addChannels($channels)
//    {
//        foreach ($channels as $channel) {
//            $this->channels[] = $channel;
//        }
//
//        return $this;
//    }
//
//    /**
//     * Remove channels.
//     *
//     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\Channel $channels
//     */
//    public function removeChannel(\Innova\SelfBundle\Entity\QuestionnaireIdentity\Channel $channels)
//    {
//        $this->channels->removeElement($channels);
//    }
//
//    /**
//     * Get channels.
//     *
//     * @return \Doctrine\Common\Collections\Collection
//     */
//    public function getChannels()
//    {
//        return $this->channels;
//    }

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
     * @return string
     */
    public function getVariety()
    {
        return $this->variety;
    }

    /**
     * @param string $variety
     * @return Questionnaire
     */
    public function setVariety($variety)
    {
        $this->variety = $variety;

        return $this;
    }

//    /**
//     * Add varieties.
//     *
//     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\Variety $varieties
//     *
//     * @return Questionnaire
//     */
//    public function addVarietie(\Innova\SelfBundle\Entity\QuestionnaireIdentity\Variety $varieties)
//    {
//        $this->varieties[] = $varieties;
//
//        return $this;
//    }
//
//    /**
//     * Add varieties collection.
//     */
//    public function addVarieties($varieties)
//    {
//        foreach ($varieties as $variety) {
//            $this->varieties[] = $variety;
//        }
//
//        return $this;
//    }
//
//    /**
//     * Remove varieties.
//     *
//     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\Variety $varieties
//     */
//    public function removeVarietie(\Innova\SelfBundle\Entity\QuestionnaireIdentity\Variety $varieties)
//    {
//        $this->varieties->removeElement($varieties);
//    }
//
//    /**
//     * Get varieties.
//     *
//     * @return \Doctrine\Common\Collections\Collection
//     */
//    public function getVarieties()
//    {
//        return $this->varieties;
//    }

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
//        $this->channels = new \Doctrine\Common\Collections\ArrayCollection();
        $this->genres = new \Doctrine\Common\Collections\ArrayCollection();
//        $this->varieties = new \Doctrine\Common\Collections\ArrayCollection();
//        $this->socialLocations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orderQuestionnaireComponents = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set lisibility.
     *
     * @param string $lisibility
     *
     * @return Questionnaire
     */
    public function setLisibility($lisibility)
    {
        $this->lisibility = $lisibility;

        return $this;
    }

    /**
     * Get lisibility.
     *
     * @return string
     */
    public function getLisibility()
    {
        return $this->lisibility;
    }

//    /**
//     * Add socialLocations.
//     *
//     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\SocialLocation $socialLocations
//     *
//     * @return Questionnaire
//     */
//    public function addSocialLocations($socialLocations)
//    {
//        foreach ($socialLocations as $socialLocation) {
//            $this->socialLocations[] = $socialLocation;
//        }
//
//        return $this;
//    }

//    /**
//     * Add socialLocation.
//     *
//     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\SocialLocation $socialLocations
//     *
//     * @return Questionnaire
//     */
//    public function addSocialLocation(\Innova\SelfBundle\Entity\QuestionnaireIdentity\SocialLocation $socialLocations)
//    {
//        $this->socialLocations[] = $socialLocations;
//
//        return $this;
//    }

//    /**
//     * Remove socialLocations.
//     *
//     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\SocialLocation $socialLocations
//     */
//    public function removeSocialLocation(\Innova\SelfBundle\Entity\QuestionnaireIdentity\SocialLocation $socialLocations)
//    {
//        $this->socialLocations->removeElement($socialLocations);
//    }

//    /**
//     * Get socialLocations.
//     *
//     * @return QuestionnaireIdentity\SocialLocation[]
//     */
//    public function getSocialLocations()
//    {
//        return $this->socialLocations;
//    }

    /**
     * Set textLength.
     *
     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\TextLength $textLength
     *
     * @return Questionnaire
     */
    public function setTextLength(\Innova\SelfBundle\Entity\QuestionnaireIdentity\TextLength $textLength = null)
    {
        $this->textLength = $textLength;

        return $this;
    }

    /**
     * Get textLength.
     *
     * @return \Innova\SelfBundle\Entity\QuestionnaireIdentity\TextLength
     */
    public function getTextLength()
    {
        return $this->textLength;
    }

    /**
     * Set speechType.
     *
     * @param string $speechType
     *
     * @return Questionnaire
     */
    public function setSpeechType($speechType)
    {
        $this->speechType = $speechType;

        return $this;
    }

    /**
     * Get speechType.
     *
     * @return string
     */
    public function getSpeechType()
    {
        return $this->speechType;
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

//    /**
//     * Set productionType.
//     *
//     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\ProductionType $productionType
//     *
//     * @return Questionnaire
//     */
//    public function setProductionType(\Innova\SelfBundle\Entity\QuestionnaireIdentity\ProductionType $productionType = null)
//    {
//        $this->productionType = $productionType;
//
//        return $this;
//    }
//
//    /**
//     * Get productionType.
//     *
//     * @return \Innova\SelfBundle\Entity\QuestionnaireIdentity\ProductionType
//     */
//    public function getProductionType()
//    {
//        return $this->productionType;
//    }
//
//    /**
//     * Add varieties.
//     *
//     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\Variety $varieties
//     *
//     * @return Questionnaire
//     */
//    public function addVariety(\Innova\SelfBundle\Entity\QuestionnaireIdentity\Variety $varieties)
//    {
//        $this->varieties[] = $varieties;
//
//        return $this;
//    }
//
//    /**
//     * Remove varieties.
//     *
//     * @param \Innova\SelfBundle\Entity\QuestionnaireIdentity\Variety $varieties
//     */
//    public function removeVariety(\Innova\SelfBundle\Entity\QuestionnaireIdentity\Variety $varieties)
//    {
//        $this->varieties->removeElement($varieties);
//    }


}
