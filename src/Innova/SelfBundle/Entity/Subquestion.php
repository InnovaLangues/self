<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subquestion
 *
 * @ORM\Table()
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
     * @var string
     *
     * @ORM\Column(name="typology", type="string", length=255)
     */
    private $typology;

    /**
     * @var string
     *
     * @ORM\Column(name="audioUrl", type="string", length=255, nullable=true)
     */
    private $audioUrl;

    /**
    * @ORM\ManyToOne(targetEntity="Question", inversedBy="subquestions")
    */
    protected $question;

    /**
    * @ORM\OneToMany(targetEntity="Proposition", mappedBy="subquestion", cascade={"remove", "persist"})
    */
    protected $propositions;

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
     * Set typology
     *
     * @param string $typology
     * @return Subquestion
     */
    public function setTypology($typology)
    {
        $this->typology = $typology;
    
        return $this;
    }

    /**
     * Get typology
     *
     * @return string 
     */
    public function getTypology()
    {
        return $this->typology;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->propositions = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set question
     *
     * @param \Innova\SelfBundle\Entity\Question $question
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
     * @param \Innova\SelfBundle\Entity\Proposition $propositions
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
     * Set audioUrl
     *
     * @param string $audioUrl
     * @return Subquestion
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
}