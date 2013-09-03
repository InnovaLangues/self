<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proposition
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Proposition
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
    * @ORM\ManyToOne(targetEntity="Subquestion", inversedBy="propositions")
    */
    protected $subquestion;

    /**
    * @ORM\OneToMany(targetEntity="Answer", mappedBy="proposition")
    */
    protected $answers;


    /**
     * @var string
     *
     * @ORM\Column(name="audioUrl", type="string", length=255)
     */
    private $audioUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rightAnswer", type="boolean")
     */
    private $rightAnswer;


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
     * Set audioUrl
     *
     * @param string $audioUrl
     * @return Proposition
     */
    public function setAudioUrl($audioUrl)
    {
        $this->audioUrl = $audioUrl;
    
        return $this;
    }

    /**
     * Get audioUrl
     *
     * @return string 
     */
    public function getAudioUrl()
    {
        return $this->audioUrl;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Proposition
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
     * Set rightAnswer
     *
     * @param boolean $rightAnswer
     * @return Proposition
     */
    public function setRightAnswer($rightAnswer)
    {
        $this->rightAnswer = $rightAnswer;
    
        return $this;
    }

    /**
     * Get rightAnswer
     *
     * @return boolean 
     */
    public function getRightAnswer()
    {
        return $this->rightAnswer;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->answers = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    
    /**
     * Add answers
     *
     * @param \Innova\SelfBundle\Entity\Answer $answers
     * @return Proposition
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
     * Set question
     *
     * @param \Innova\SelfBundle\Entity\Subquestion $question
     * @return Proposition
     */
    public function setQuestion(\Innova\SelfBundle\Entity\Subquestion $question = null)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return \Innova\SelfBundle\Entity\Subquestion 
     */
    public function getQuestion()
    {
        return $this->question;
    }
}