<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Questionnaire
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
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=255)
     */
    private $theme;

    /**
     * @var string
     *
     * @ORM\Column(name="audioInstruction", type="string", length=255)
     */
    private $audioInstruction;

    /**
     * @var string
     *
     * @ORM\Column(name="audioContext", type="string", length=255)
     */
    private $audioContext;

    /**
     * @var string
     *
     * @ORM\Column(name="audioItem", type="string", length=255)
     */
    private $audioItem;

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

    public function __construct() {
        $this->tests = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString(){
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
     * @param string $level
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
     * @param string $theme
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
     * Set audioInstruction
     *
     * @param string $audioInstruction
     * @return Questionnaire
     */
    public function setAudioInstruction($audioInstruction)
    {
        $this->audioInstruction = $audioInstruction;

        return $this;
    }

    /**
     * Get audioInstruction
     *
     * @return string
     */
    public function getAudioInstruction()
    {
        return $this->audioInstruction;
    }

    /**
     * Set audioContext
     *
     * @param string $audioContext
     * @return Questionnaire
     */
    public function setAudioContext($audioContext)
    {
        $this->audioContext = $audioContext;

        return $this;
    }

    /**
     * Get audioContext
     *
     * @return string
     */
    public function getAudioContext()
    {
        return $this->audioContext;
    }

    /**
     * Set audioItem
     *
     * @param string $audioItem
     * @return Questionnaire
     */
    public function setAudioItem($audioItem)
    {
        $this->audioItem = $audioItem;

        return $this;
    }

    /**
     * Get audioItem
     *
     * @return string
     */
    public function getAudioItem()
    {
        return $this->audioItem;
    }

    /**
     * Add questions
     *
     * @param \Innova\SelfBundle\Entity\Question $questions
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
     * @param \Innova\SelfBundle\Entity\Trace $traces
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
     * @param \Innova\SelfBundle\Entity\Test $tests
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
     * @param \Innova\SelfBundle\Entity\Duration $duration
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
     * @param \Innova\SelfBundle\Entity\Focus $focus
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
     * @param \Innova\SelfBundle\Entity\Support $support
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
     * @param \Innova\SelfBundle\Entity\FunctionType $functionType
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
     * @param \Innova\SelfBundle\Entity\Source $source
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
     * @param \Innova\SelfBundle\Entity\CognitiveOperation $cognitiveOperation
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
     * @param \Innova\SelfBundle\Entity\LanguageLevel $languageLevel
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
     * @param \Innova\SelfBundle\Entity\SourceType $sourceType
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
     * @param \Innova\SelfBundle\Entity\Flow $flow
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
     * Set domain
     *
     * @param \Innova\SelfBundle\Entity\Domain $domain
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
     * @param \Innova\SelfBundle\Entity\ReceptionType $receptionType
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
     * @param \Innova\SelfBundle\Entity\User $author
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
     * @param \Innova\SelfBundle\Entity\Instruction $instruction
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
}