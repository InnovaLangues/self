<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subquestion
 *
 * @ORM\Table("subquestion")
 * @ORM\Entity
 */
class Subquestion
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
    * @ORM\ManyToOne(targetEntity="Typology", inversedBy="subquestions")
    */
    protected $typology;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Media\Media")
    */
    protected $media;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Media\Media")
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
    * @ORM\ManyToOne(targetEntity="Clue", cascade={"persist"})
    */
    protected $clue;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Media\Media")
    */
    protected $mediaSyllable;

    /**
    * @ORM\OneToMany(targetEntity="Answer", mappedBy="subquestion")
    */
    protected $answers;

    /**
     *
     * @ORM\Column(name="displayAnswer", type="boolean")
     */
    private $displayAnswer;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->propositions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param  string      $title
     * @return Subquestion
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set typology
     *
     * @param  \Innova\SelfBundle\Entity\Typology $typology
     * @return Subquestion
     */
    public function setTypology(\Innova\SelfBundle\Entity\Typology $typology = null)
    {
        $this->typology = $typology;

        return $this;
    }

    /**
     * Get typology
     *
     * @return \Innova\SelfBundle\Entity\Typology
     */
    public function getTypology()
    {
        return $this->typology;
    }

    /**
     * Set media
     *
     * @param  \Innova\SelfBundle\Entity\Media\Media $media
     * @return Subquestion
     */
    public function setMedia(\Innova\SelfBundle\Entity\Media\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Innova\SelfBundle\Entity\Media\Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set question
     *
     * @param  \Innova\SelfBundle\Entity\Question $question
     * @return Subquestion
     */
    public function setQuestion(\Innova\SelfBundle\Entity\Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \Innova\SelfBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Add propositions
     *
     * @param  \Innova\SelfBundle\Entity\Proposition $propositions
     * @return Subquestion
     */
    public function addProposition(\Innova\SelfBundle\Entity\Proposition $propositions)
    {
        $this->propositions[] = $propositions;

        return $this;
    }

    /**
     * Remove propositions
     *
     * @param \Innova\SelfBundle\Entity\Proposition $propositions
     */
    public function removeProposition(\Innova\SelfBundle\Entity\Proposition $propositions)
    {
        $this->propositions->removeElement($propositions);
    }

    /**
     * Get propositions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPropositions()
    {
        return $this->propositions;
    }

    /**
     * Set mediaText
     *
     * @param  \Innova\SelfBundle\Entity\Media\Media $mediaText
     * @return Subquestion
     */
    public function setMediaText(\Innova\SelfBundle\Entity\Media\Media $mediaText = null)
    {
        $this->mediaText = $mediaText;

        return $this;
    }

    /**
     * Get mediaText
     *
     * @return \Innova\SelfBundle\Entity\Media\Media
     */
    public function getMediaText()
    {
        return $this->mediaText;
    }

    /**
     * Set mediaAmorce
     *
     * @param  \Innova\SelfBundle\Entity\Media\Media $mediaAmorce
     * @return Subquestion
     */
    public function setMediaAmorce(\Innova\SelfBundle\Entity\Media\Media $mediaAmorce = null)
    {
        $this->mediaAmorce = $mediaAmorce;

        return $this;
    }

    /**
     * Get mediaAmorce
     *
     * @return \Innova\SelfBundle\Entity\Media\Media
     */
    public function getMediaAmorce()
    {
        return $this->mediaAmorce;
    }

    /**
     * Add answers
     *
     * @param  \Innova\SelfBundle\Entity\Answer $answers
     * @return Subquestion
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
     * Set mediaSyllable
     *
     * @param \Innova\SelfBundle\Entity\Media\Media $mediaSyllable
     * @return Subquestion
     */
    public function setMediaSyllable(\Innova\SelfBundle\Entity\Media\Media $mediaSyllable = null)
    {
        $this->mediaSyllable = $mediaSyllable;

        return $this;
    }

    /**
     * Get mediaSyllable
     *
     * @return \Innova\SelfBundle\Entity\Media\Media
     */
    public function getMediaSyllable()
    {
        return $this->mediaSyllable;
    }

    /**
     * Set clue
     *
     * @param \Innova\SelfBundle\Entity\Clue $clue
     * @return Subquestion
     */
    public function setClue(\Innova\SelfBundle\Entity\Clue $clue = null)
    {
        $this->clue = $clue;

        return $this;
    }

    /**
     * Get clue
     *
     * @return \Innova\SelfBundle\Entity\Clue
     */
    public function getClue()
    {
        return $this->clue;
    }


    /**
     * Set displayAnswer
     *
     * @param boolean $displayAnswer
     * @return Subquestion
     */
    public function setDisplayAnswer($displayAnswer)
    {
        $this->displayAnswer = $displayAnswer;

        return $this;
    }

    /**
     * Get displayAnswer
     *
     * @return boolean
     */
    public function getDisplayAnswer()
    {
        return $this->displayAnswer;
    }
}