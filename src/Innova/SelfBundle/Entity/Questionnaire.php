<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Questionnaire
 * 15/10/2013 : Add "originText" and "exerciceText" columns. EV.
 * 04/11/2013 : Add "skill" columns and Skill.php (for Entity). EV.
 * 04/04/2014 : Modify "dialogue" type from "boolean" to "integer". EV.
 * 04/04/2014 : Add "fixedOrder" column (for Entity). EV.
 *
 * @ORM\Table("questionnaire")
 * @ORM\Entity(repositoryClass="Innova\SelfBundle\Repository\QuestionnaireRepository")
 */
class Questionnaire
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
    * @ORM\ManyToOne(targetEntity="Level", inversedBy="questionnaires")
    */
    protected $level;

    /**
    * @ORM\ManyToOne(targetEntity="SourceType", inversedBy="questionnaires")
    */
    protected $sourceType;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="questionnaires")
    */
    protected $author;

    /**
    * @ORM\ManyToOne(targetEntity="Instruction", inversedBy="questionnaires")
    */
    protected $instruction;

    /**
    * @ORM\ManyToOne(targetEntity="ReceptionType", inversedBy="questionnaires")
    */
    protected $receptionType;

    /**
    * @ORM\ManyToOne(targetEntity="Source", inversedBy="questionnaires")
    */
    protected $source;

    /**
    * @ORM\ManyToOne(targetEntity="Duration", inversedBy="questionnaires")
    */
    protected $duration;

    /**
    * @ORM\ManyToOne(targetEntity="Domain", inversedBy="questionnaires")
    */
    protected $domain;

    /**
    * @ORM\ManyToOne(targetEntity="FunctionType", inversedBy="questionnaires")
    */
    protected $functionType;

    /**
    * @ORM\ManyToOne(targetEntity="CognitiveOperation", inversedBy="questionnaires")
    */
    protected $cognitiveOperation;

    /**
    * @ORM\ManyToOne(targetEntity="Support", inversedBy="questionnaires")
    */
    protected $support;

    /**
    * @ORM\ManyToOne(targetEntity="Flow", inversedBy="questionnaires")
    */
    protected $flow;

    /**
    * @ORM\ManyToOne(targetEntity="Focus", inversedBy="questionnaires")
    */
    protected $focus;

    /**
    * @ORM\ManyToOne(targetEntity="LanguageLevel", inversedBy="questionnaires")
    */
    protected $languageLevel;

    /**
    * @ORM\ManyToOne(targetEntity="Status", inversedBy="questionnaires")
    */
    protected $status;

    /**
    * @ORM\OneToMany(targetEntity="MediaLimit", mappedBy="questionnaire")
    */
    private $mediaLimits;

    /**
    * @ORM\OneToMany(targetEntity="MediaClick", mappedBy="questionnaire")
    */
    private $mediaClicks;

    /**
    * @ORM\OneToMany(targetEntity="Comment", mappedBy="questionnaire")
    */
    private $comments;

    /**
    * @ORM\OneToMany(targetEntity="EditorLog", mappedBy="questionnaire")
    * @ORM\OrderBy({"date" = "DESC"})
    */
    private $editorLogs;


    /**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=255)
     */
    private $theme;

     /**
     * @var string
     *
     * @ORM\Column(name="listeningLimit", type="integer")
     */
    private $listeningLimit;

     /**
     * @var string
     *
     * @ORM\Column(name="dialogue", type="integer")
     */
    private $dialogue;

     /**
     * @var string
     *
     * @ORM\Column(name="fixedOrder", type="boolean")
     *
     */
    private $fixedOrder;

    /**
    * @ORM\ManyToOne(targetEntity="Media")
    */
    protected $mediaInstruction;

    /**
    * @ORM\ManyToOne(targetEntity="Media")
    */
    protected $mediaContext;

    /**
    * @ORM\ManyToOne(targetEntity="Media")
    */
    protected $mediaText;

    /**
    * @ORM\ManyToOne(targetEntity="Media")
    */
    protected $mediaFunctionalInstruction;

    /**
    * @ORM\ManyToOne(targetEntity="Media")
    */
    protected $mediaFeedback;

    /**
     * @var string
     *
     * @ORM\Column(name="originText", type="string", length=255, nullable=true)
     */
    private $originText;

    /**
     * @var string
     *
     * @ORM\Column(name="exerciceText", type="string", length=255, nullable=true)
     */
    private $exerciceText;

    /**
    * @ORM\ManyToOne(targetEntity="Skill", inversedBy="questionnaires")
    */
    protected $skill;

    /**
    * @ORM\OneToMany(targetEntity="Question", mappedBy="questionnaire", cascade={"remove", "persist"})
    */
    protected $questions;

    /**
    * @ORM\OneToMany(targetEntity="Trace", mappedBy="questionnaire", cascade={"remove", "persist"})
    */
    protected $traces;

    /**
    * @ORM\ManyToMany(targetEntity="Test", mappedBy="questionnaires")
    */
    private $tests;

    /**
    * @ORM\OneToMany(targetEntity="OrderQuestionnaireTest", mappedBy="questionnaire")
    */
    private $orderQuestionnaireTests;

    public function __construct()
    {
        $this->tests = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->theme;
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
     * Set level
     *
     * @param  string        $level
     * @return Questionnaire
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set theme
     *
     * @param  string        $theme
     * @return Questionnaire
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set originText
     *
     * @param  string        $originText
     * @return Questionnaire
     */
    public function setOriginText($originText)
    {
        $this->originText = $originText;

        return $this;
    }

    /**
     * Get originText
     *
     * @return string
     */
    public function getOriginText()
    {
        return $this->originText;
    }

    /**
     * Set exerciceText
     *
     * @param  string        $exerciceText
     * @return Questionnaire
     */
    public function setExerciceText($exerciceText)
    {
        $this->exerciceText = $exerciceText;

        return $this;
    }

    /**
     * Get exerciceText
     *
     * @return string
     */
    public function getExerciceText()
    {
        return $this->exerciceText;
    }

    /**
     * Add questions
     *
     * @param  \Innova\SelfBundle\Entity\Question $questions
     * @return Questionnaire
     */
    public function addQuestion(\Innova\SelfBundle\Entity\Question $questions)
    {
        $this->questions[] = $questions;

        return $this;
    }

    /**
     * Remove questions
     *
     * @param \Innova\SelfBundle\Entity\Question $questions
     */
    public function removeQuestion(\Innova\SelfBundle\Entity\Question $questions)
    {
        $this->questions->removeElement($questions);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Add traces
     *
     * @param  \Innova\SelfBundle\Entity\Trace $traces
     * @return Questionnaire
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
     * Add tests
     *
     * @param  \Innova\SelfBundle\Entity\Test $tests
     * @return Questionnaire
     */
    public function addTest(\Innova\SelfBundle\Entity\Test $tests)
    {
        $this->tests[] = $tests;
        $tests->addQuestionnaire($this);

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
     * Set duration
     *
     * @param  \Innova\SelfBundle\Entity\Duration $duration
     * @return Questionnaire
     */
    public function setDuration(\Innova\SelfBundle\Entity\Duration $duration = null)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return \Innova\SelfBundle\Entity\Duration
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set focus
     *
     * @param  \Innova\SelfBundle\Entity\Focus $focus
     * @return Questionnaire
     */
    public function setFocus(\Innova\SelfBundle\Entity\Focus $focus = null)
    {
        $this->focus = $focus;

        return $this;
    }

    /**
     * Get focus
     *
     * @return \Innova\SelfBundle\Entity\Focus
     */
    public function getFocus()
    {
        return $this->focus;
    }

    /**
     * Set support
     *
     * @param  \Innova\SelfBundle\Entity\Support $support
     * @return Questionnaire
     */
    public function setSupport(\Innova\SelfBundle\Entity\Support $support = null)
    {
        $this->support = $support;

        return $this;
    }

    /**
     * Get support
     *
     * @return \Innova\SelfBundle\Entity\Support
     */
    public function getSupport()
    {
        return $this->support;
    }

    /**
     * Set functionType
     *
     * @param  \Innova\SelfBundle\Entity\FunctionType $functionType
     * @return Questionnaire
     */
    public function setFunctionType(\Innova\SelfBundle\Entity\FunctionType $functionType = null)
    {
        $this->functionType = $functionType;

        return $this;
    }

    /**
     * Get functionType
     *
     * @return \Innova\SelfBundle\Entity\FunctionType
     */
    public function getFunctionType()
    {
        return $this->functionType;
    }

    /**
     * Set source
     *
     * @param  \Innova\SelfBundle\Entity\Source $source
     * @return Questionnaire
     */
    public function setSource(\Innova\SelfBundle\Entity\Source $source = null)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return \Innova\SelfBundle\Entity\Source
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set cognitiveOperation
     *
     * @param  \Innova\SelfBundle\Entity\CognitiveOperation $cognitiveOperation
     * @return Questionnaire
     */
    public function setCognitiveOperation(\Innova\SelfBundle\Entity\CognitiveOperation $cognitiveOperation = null)
    {
        $this->cognitiveOperation = $cognitiveOperation;

        return $this;
    }

    /**
     * Get cognitiveOperation
     *
     * @return \Innova\SelfBundle\Entity\CognitiveOperation
     */
    public function getCognitiveOperation()
    {
        return $this->cognitiveOperation;
    }

    /**
     * Set languageLevel
     *
     * @param  \Innova\SelfBundle\Entity\LanguageLevel $languageLevel
     * @return Questionnaire
     */
    public function setLanguageLevel(\Innova\SelfBundle\Entity\LanguageLevel $languageLevel = null)
    {
        $this->languageLevel = $languageLevel;

        return $this;
    }

    /**
     * Get languageLevel
     *
     * @return \Innova\SelfBundle\Entity\LanguageLevel
     */
    public function getLanguageLevel()
    {
        return $this->languageLevel;
    }

    /**
     * Set sourceType
     *
     * @param  \Innova\SelfBundle\Entity\SourceType $sourceType
     * @return Questionnaire
     */
    public function setSourceType(\Innova\SelfBundle\Entity\SourceType $sourceType = null)
    {
        $this->sourceType = $sourceType;

        return $this;
    }

    /**
     * Get sourceType
     *
     * @return \Innova\SelfBundle\Entity\SourceType
     */
    public function getSourceType()
    {
        return $this->sourceType;
    }

    /**
     * Set flow
     *
     * @param  \Innova\SelfBundle\Entity\Flow $flow
     * @return Questionnaire
     */
    public function setFlow(\Innova\SelfBundle\Entity\Flow $flow = null)
    {
        $this->flow = $flow;

        return $this;
    }

    /**
     * Get flow
     *
     * @return \Innova\SelfBundle\Entity\Flow
     */
    public function getFlow()
    {
        return $this->flow;
    }

    /**
     * Set skill
     *
     * @param  \Innova\SelfBundle\Entity\Skill $skill
     * @return Questionnaire
     */
    public function setSkill($skill = null)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Get skill
     *
     * @return \Innova\SelfBundle\Entity\Skill
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * Set domain
     *
     * @param  \Innova\SelfBundle\Entity\Domain $domain
     * @return Questionnaire
     */
    public function setDomain(\Innova\SelfBundle\Entity\Domain $domain = null)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return \Innova\SelfBundle\Entity\Domain
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set receptionType
     *
     * @param  \Innova\SelfBundle\Entity\ReceptionType $receptionType
     * @return Questionnaire
     */
    public function setReceptionType(\Innova\SelfBundle\Entity\ReceptionType $receptionType = null)
    {
        $this->receptionType = $receptionType;

        return $this;
    }

    /**
     * Get receptionType
     *
     * @return \Innova\SelfBundle\Entity\ReceptionType
     */
    public function getReceptionType()
    {
        return $this->receptionType;
    }

    /**
     * Set author
     *
     * @param  \Innova\SelfBundle\Entity\User $author
     * @return Questionnaire
     */
    public function setAuthor(\Innova\SelfBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Innova\SelfBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set instruction
     *
     * @param  \Innova\SelfBundle\Entity\Instruction $instruction
     * @return Questionnaire
     */
    public function setInstruction(\Innova\SelfBundle\Entity\Instruction $instruction = null)
    {
        $this->instruction = $instruction;

        return $this;
    }

    /**
     * Get instruction
     *
     * @return \Innova\SelfBundle\Entity\Instruction
     */
    public function getInstruction()
    {
        return $this->instruction;
    }

    /**
     * Set listeningLimit
     *
     * @param  integer       $listeningLimit
     * @return Questionnaire
     */
    public function setListeningLimit($listeningLimit)
    {
        $this->listeningLimit = $listeningLimit;

        return $this;
    }

    /**
     * Get listeningLimit
     *
     * @return integer
     */
    public function getListeningLimit()
    {
        return $this->listeningLimit;
    }

    /**
     * Set dialogue
     *
     * @param  boolean       $dialogue
     * @return Questionnaire
     */
    public function setDialogue($dialogue)
    {
        $this->dialogue = $dialogue;

        return $this;
    }

    /**
     * Get dialogue
     *
     * @return boolean
     */
    public function getDialogue()
    {
        return $this->dialogue;
    }

    /**
     * Set mediaInstruction
     *
     * @param  \Innova\SelfBundle\Entity\Media $mediaInstruction
     * @return Questionnaire
     */
    public function setMediaInstruction(\Innova\SelfBundle\Entity\Media $mediaInstruction = null)
    {
        $this->mediaInstruction = $mediaInstruction;

        return $this;
    }

    /**
     * Get mediaInstruction
     *
     * @return \Innova\SelfBundle\Entity\Media
     */
    public function getMediaInstruction()
    {
        return $this->mediaInstruction;
    }

    /**
     * Set mediaContext
     *
     * @param  \Innova\SelfBundle\Entity\Media $mediaContext
     * @return Questionnaire
     */
    public function setMediaContext(\Innova\SelfBundle\Entity\Media $mediaContext = null)
    {
        $this->mediaContext = $mediaContext;

        return $this;
    }

    /**
     * Get mediaContext
     *
     * @return \Innova\SelfBundle\Entity\Media
     */
    public function getMediaContext()
    {
        return $this->mediaContext;
    }

    /**
     * Set mediaText
     *
     * @param  \Innova\SelfBundle\Entity\Media $mediaText
     * @return Questionnaire
     */
    public function setMediaText(\Innova\SelfBundle\Entity\Media $mediaText = null)
    {
        $this->mediaText = $mediaText;

        return $this;
    }

    /**
     * Get mediaText
     *
     * @return \Innova\SelfBundle\Entity\Media
     */
    public function getMediaText()
    {
        return $this->mediaText;
    }

    /**
     * Set fixedOrder
     *
     * @param  boolean       $fixedOrder
     * @return Questionnaire
     */
    public function setFixedOrder($fixedOrder)
    {
        $this->fixedOrder = $fixedOrder;

        return $this;
    }

    /**
     * Get fixedOrder
     *
     * @return boolean
     */
    public function getFixedOrder()
    {
        return $this->fixedOrder;
    }

    /**
     * Add mediaLimits
     *
     * @param  \Innova\SelfBundle\Entity\MediaLimit $mediaLimits
     * @return Questionnaire
     */
    public function addMediaLimit(\Innova\SelfBundle\Entity\MediaLimit $mediaLimits)
    {
        $this->mediaLimits[] = $mediaLimits;

        return $this;
    }

    /**
     * Remove mediaLimits
     *
     * @param \Innova\SelfBundle\Entity\MediaLimit $mediaLimits
     */
    public function removeMediaLimit(\Innova\SelfBundle\Entity\MediaLimit $mediaLimits)
    {
        $this->mediaLimits->removeElement($mediaLimits);
    }

    /**
     * Get mediaLimits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMediaLimits()
    {
        return $this->mediaLimits;
    }

    /**
     * Add mediaClicks
     *
     * @param  \Innova\SelfBundle\Entity\MediaClick $mediaClicks
     * @return Questionnaire
     */
    public function addMediaClick(\Innova\SelfBundle\Entity\MediaClick $mediaClicks)
    {
        $this->mediaClicks[] = $mediaClicks;

        return $this;
    }

    /**
     * Remove mediaClicks
     *
     * @param \Innova\SelfBundle\Entity\MediaClick $mediaClicks
     */
    public function removeMediaClick(\Innova\SelfBundle\Entity\MediaClick $mediaClicks)
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
     * @return Questionnaire
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
     * Set status
     *
     * @param \Innova\SelfBundle\Entity\Status $status
     * @return Questionnaire
     */
    public function setStatus(\Innova\SelfBundle\Entity\Status $status = null)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return \Innova\SelfBundle\Entity\Status 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set mediaFunctionalInstruction
     *
     * @param \Innova\SelfBundle\Entity\Media $mediaFunctionalInstruction
     * @return Questionnaire
     */
    public function setMediaFunctionalInstruction(\Innova\SelfBundle\Entity\Media $mediaFunctionalInstruction = null)
    {
        $this->mediaFunctionalInstruction = $mediaFunctionalInstruction;
    
        return $this;
    }

    /**
     * Get mediaFunctionalInstruction
     *
     * @return \Innova\SelfBundle\Entity\Media 
     */
    public function getMediaFunctionalInstruction()
    {
        return $this->mediaFunctionalInstruction;
    }

    /**
     * Add comments
     *
     * @param \Innova\SelfBundle\Entity\Comment $comments
     * @return Questionnaire
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
     * Set mediaFeedback
     *
     * @param \Innova\SelfBundle\Entity\Media $mediaFeedback
     * @return Questionnaire
     */
    public function setMediaFeedback(\Innova\SelfBundle\Entity\Media $mediaFeedback = null)
    {
        $this->mediaFeedback = $mediaFeedback;
    
        return $this;
    }

    /**
     * Get mediaFeedback
     *
     * @return \Innova\SelfBundle\Entity\Media 
     */
    public function getMediaFeedback()
    {
        return $this->mediaFeedback;
    }

    /**
     * Add editorLogs
     *
     * @param \Innova\SelfBundle\Entity\EditorLog $editorLogs
     * @return Questionnaire
     */
    public function addEditorLog(\Innova\SelfBundle\Entity\EditorLog $editorLogs)
    {
        $this->editorLogs[] = $editorLogs;
    
        return $this;
    }

    /**
     * Remove editorLogs
     *
     * @param \Innova\SelfBundle\Entity\EditorLog $editorLogs
     */
    public function removeEditorLog(\Innova\SelfBundle\Entity\EditorLog $editorLogs)
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
}