<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table("question")
 * @ORM\Entity
 */
class Question
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
    * @ORM\ManyToOne(targetEntity="Questionnaire", inversedBy="questions", cascade={"remove"})
    */
    protected $questionnaire;


    /**
    * @ORM\ManyToOne(targetEntity="Typology", inversedBy="questions")
    */
    protected $typology;
    
    /**
    * @ORM\OneToMany(targetEntity="Subquestion", mappedBy="question", cascade={"remove", "persist"})
    */
    protected $subquestions;

    /**
    * @ORM\ManyToOne(targetEntity="Instruction", inversedBy="questions")
    */
    protected $instruction;

    /**
     * @var string
     *
     * @ORM\Column(name="audioUrl", type="string", length=255, nullable=true)
     */
    private $audioUrl;
    
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
     * Constructor
     */
    public function __construct()
    {
        $this->subquestions = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set questionnaire
     *
     * @param \Innova\SelfBundle\Entity\Questionnaire $questionnaire
     * @return Question
     */
    public function setQuestionnaire(\Innova\SelfBundle\Entity\Questionnaire $questionnaire = null)
    {
        $this->questionnaire = $questionnaire;
    
        return $this;
    }

    /**
     * Get questionnaire
     *
     * @return \Innova\SelfBundle\Entity\Questionnaire 
     */
    public function getQuestionnaire()
    {
        return $this->questionnaire;
    }

   

    /**
     * Add subquestions
     *
     * @param \Innova\SelfBundle\Entity\Subquestion $subquestions
     * @return Question
     */
    public function addSubquestion(\Innova\SelfBundle\Entity\Subquestion $subquestions)
    {
        $this->subquestions[] = $subquestions;
    
        return $this;
    }

    /**
     * Remove subquestions
     *
     * @param \Innova\SelfBundle\Entity\Subquestion $subquestions
     */
    public function removeSubquestion(\Innova\SelfBundle\Entity\Subquestion $subquestions)
    {
        $this->subquestions->removeElement($subquestions);
    }

    /**
     * Get subquestions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubquestions()
    {
        return $this->subquestions;
    }



    /**
     * Set audioUrl
     *
     * @param string $audioUrl
     * @return Question
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
     * Set instruction
     *
     * @param \Innova\SelfBundle\Entity\Instruction $instruction
     * @return Question
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
     * Set typology
     *
     * @param \Innova\SelfBundle\Entity\Typology $typology
     * @return Question
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
}