<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Subquestion.
 *
 * @ORM\Table("subquestion")
 * @ORM\Entity
 */
class Subquestion
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
     * @ORM\ManyToOne(targetEntity="Typology", inversedBy="subquestions", fetch = "EAGER")
     */
    protected $typology;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Level")
     */
    protected $level;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Media\Media", fetch = "EAGER")
     */
    protected $media;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Media\Media", fetch = "EAGER")
     */
    protected $mediaAmorce;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="subquestions")
     */
    protected $question;

    /**
     * @ORM\OneToMany(targetEntity="Proposition", mappedBy="subquestion", cascade={"persist", "remove"})
     */
    protected $propositions;

    /**
     * @ORM\ManyToOne(targetEntity="Clue", cascade={"persist"}, fetch = "EAGER")
     */
    protected $clue;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Media\Media", fetch = "EAGER")
     */
    protected $mediaSyllable;

    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="subquestion")
     */
    protected $answers;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $focuses;

    const FOCUS_SOCIO_PRAGMA = 'socio_pragma';
    const FOCUS_MORPH = 'morph';
    const FOCUS_LEXIC_GENERAL = 'lexic_general';
    const FOCUS_LEXIC_SPEC = 'lexic_spec';
    const FOCUS_LEXIC_EXPR = 'lexic_expr';
    const FOCUS_PHONOLOGIC = 'lexic_phono';
    const FOCUS_DISCURSIVE = 'discursive';
    const FOCUS_METALINGUISTIC = 'metalinguistic';

    /**
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $goals;

    const GOAL_UNDERSTAND_GEN = 'understand_gen';
    const GOAL_UNDERSTAND_SPEC = 'understand_spec';
    const GOAL_INFER_SPEC = 'infer_spec';
    const GOAL_ORAL_INTER = 'oral_inter';
    const GOAL_PROD_STATMNT = 'prod_statmnt';
    const GOAL_REPHRASE_MSG = 'rephrase_msg';
    const GOAL_WRITE_INTER = 'write_inter';
    const GOAL_FIX_STATMNT = 'fix_statmnt';

    /**
     * @var string
     *
     * @ORM\Column(name="difficultyIndex", type="string", length=255, nullable=true)
     */
    private $difficultyIndex;

    /**
     * @var string
     *
     * @ORM\Column(name="discriminationIndex", type="string", length=255, nullable=true)
     */
    private $discriminationIndex;

    /**
     * @ORM\Column(name="displayAnswer", type="boolean")
     */
    private $displayAnswer;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $redundancy = self::REDUNDANCY_ABSENT;

    const REDUNDANCY_PRESENT = 'present';
    const REDUNDANCY_ABSENT = 'absent';

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->propositions = new ArrayCollection();
        $this->focuses = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     *
     * @return Subquestion
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param \Innova\SelfBundle\Entity\Typology $typology
     *
     * @return Subquestion
     */
    public function setTypology(\Innova\SelfBundle\Entity\Typology $typology = null)
    {
        $this->typology = $typology;

        return $this;
    }

    /**
     * @return \Innova\SelfBundle\Entity\Typology
     */
    public function getTypology()
    {
        return $this->typology;
    }

    /**
     * @param \Innova\SelfBundle\Entity\Media\Media $media
     *
     * @return Subquestion
     */
    public function setMedia(\Innova\SelfBundle\Entity\Media\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * @return \Innova\SelfBundle\Entity\Media\Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set question.
     *
     * @param \Innova\SelfBundle\Entity\Question $question
     *
     * @return Subquestion
     */
    public function setQuestion(\Innova\SelfBundle\Entity\Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question.
     *
     * @return \Innova\SelfBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Add propositions.
     *
     * @param \Innova\SelfBundle\Entity\Proposition $propositions
     *
     * @return Subquestion
     */
    public function addProposition(\Innova\SelfBundle\Entity\Proposition $propositions)
    {
        $this->propositions[] = $propositions;

        return $this;
    }

    /**
     * Remove propositions.
     *
     * @param \Innova\SelfBundle\Entity\Proposition $propositions
     */
    public function removeProposition(\Innova\SelfBundle\Entity\Proposition $propositions)
    {
        $this->propositions->removeElement($propositions);
    }

    /**
     * Get propositions.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPropositions()
    {
        return $this->propositions;
    }

    /**
     * Set mediaAmorce.
     *
     * @param \Innova\SelfBundle\Entity\Media\Media $mediaAmorce
     *
     * @return Subquestion
     */
    public function setMediaAmorce(\Innova\SelfBundle\Entity\Media\Media $mediaAmorce = null)
    {
        $this->mediaAmorce = $mediaAmorce;

        return $this;
    }

    /**
     * Get mediaAmorce.
     *
     * @return \Innova\SelfBundle\Entity\Media\Media
     */
    public function getMediaAmorce()
    {
        return $this->mediaAmorce;
    }

    /**
     * Add answers.
     *
     * @param \Innova\SelfBundle\Entity\Answer $answers
     *
     * @return Subquestion
     */
    public function addAnswer(\Innova\SelfBundle\Entity\Answer $answers)
    {
        $this->answers[] = $answers;

        return $this;
    }

    /**
     * Remove answers.
     *
     * @param \Innova\SelfBundle\Entity\Answer $answers
     */
    public function removeAnswer(\Innova\SelfBundle\Entity\Answer $answers)
    {
        $this->answers->removeElement($answers);
    }

    /**
     * Get answers.
     *
     * @return Answer[]
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Set mediaSyllable.
     *
     * @param \Innova\SelfBundle\Entity\Media\Media $mediaSyllable
     *
     * @return Subquestion
     */
    public function setMediaSyllable(\Innova\SelfBundle\Entity\Media\Media $mediaSyllable = null)
    {
        $this->mediaSyllable = $mediaSyllable;

        return $this;
    }

    /**
     * Get mediaSyllable.
     *
     * @return \Innova\SelfBundle\Entity\Media\Media
     */
    public function getMediaSyllable()
    {
        return $this->mediaSyllable;
    }

    /**
     * Set clue.
     *
     * @param \Innova\SelfBundle\Entity\Clue $clue
     *
     * @return Subquestion
     */
    public function setClue(\Innova\SelfBundle\Entity\Clue $clue = null)
    {
        $this->clue = $clue;

        return $this;
    }

    /**
     * Get clue.
     *
     * @return \Innova\SelfBundle\Entity\Clue
     */
    public function getClue()
    {
        return $this->clue;
    }

    /**
     * Set displayAnswer.
     *
     * @param bool $displayAnswer
     *
     * @return Subquestion
     */
    public function setDisplayAnswer($displayAnswer)
    {
        $this->displayAnswer = $displayAnswer;

        return $this;
    }

    /**
     * Get displayAnswer.
     *
     * @return bool
     */
    public function getDisplayAnswer()
    {
        return $this->displayAnswer;
    }

    /**
     * @param array $focuses
     */
    public function setFocuses($focuses)
    {
        $this->focuses = $focuses;
    }

    /**
     * @return array
     */
    public function getFocuses()
    {
        return $this->focuses;
    }

    /**
     * Set level.
     *
     * @param \Innova\SelfBundle\Entity\Level $level
     *
     * @return Subquestion
     */
    public function setLevel(\Innova\SelfBundle\Entity\Level $level = null)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level.
     *
     * @return \Innova\SelfBundle\Entity\Level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set difficultyIndex.
     *
     * @param string $difficultyIndex
     *
     * @return Subquestion
     */
    public function setDifficultyIndex($difficultyIndex)
    {
        $this->difficultyIndex = $difficultyIndex;

        return $this;
    }

    /**
     * Get difficultyIndex.
     *
     * @return string
     */
    public function getDifficultyIndex()
    {
        return $this->difficultyIndex;
    }

    /**
     * Set discriminationIndex.
     *
     * @param string $discriminationIndex
     *
     * @return Subquestion
     */
    public function setDiscriminationIndex($discriminationIndex)
    {
        $this->discriminationIndex = $discriminationIndex;

        return $this;
    }

    /**
     * Get discriminationIndex.
     *
     * @return string
     */
    public function getDiscriminationIndex()
    {
        return $this->discriminationIndex;
    }

    /**
     * @return string
     */
    public function getRedundancy()
    {
        return $this->redundancy;
    }

    /**
     * @param string $redundancy
     */
    public function setRedundancy($redundancy)
    {
        $this->redundancy = $redundancy;
    }

    public static function getRedundancyValues()
    {
        return [
            self::REDUNDANCY_ABSENT,
            self::REDUNDANCY_PRESENT
        ];
    }

    /**
     * @return array
     */
    public function getGoals()
    {
        return $this->goals;
    }

    /**
     * @param array $goals
     */
    public function setGoals(array $goals = [])
    {
        $this->goals = $goals;
    }

    public static function getGoalsValues()
    {
        return [
            self::GOAL_UNDERSTAND_GEN,
            self::GOAL_UNDERSTAND_SPEC,
            self::GOAL_INFER_SPEC,
            self::GOAL_ORAL_INTER,
            self::GOAL_PROD_STATMNT,
            self::GOAL_REPHRASE_MSG,
            self::GOAL_WRITE_INTER,
            self::GOAL_FIX_STATMNT
        ];
    }

    public static function getFocusesValues()
    {
        return [
            self::FOCUS_SOCIO_PRAGMA,
            self::FOCUS_MORPH,
            self::FOCUS_LEXIC_GENERAL,
            self::FOCUS_LEXIC_SPEC,
            self::FOCUS_LEXIC_EXPR,
            self::FOCUS_PHONOLOGIC,
            self::FOCUS_DISCURSIVE,
            self::FOCUS_METALINGUISTIC,
        ];
    }
}
