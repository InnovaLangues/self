<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Instruction
 *
 * @ORM\Table("questionnaireInstruction")
 * @ORM\Entity
 */
class Instruction
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
    * @ORM\OneToMany(targetEntity="Questionnaire", mappedBy="instruction")
    */
    protected $questionnaires;

    /**
    * @ORM\OneToMany(targetEntity="Question", mappedBy="instruction")
    */
    protected $questions;

    /**
     * To String
     */

    public function __toString() {
        return $this->getName();
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
     * Set name
     *
     * @param string $name
     * @return Instruction
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questionnaires = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add questionnaires
     *
     * @param \Innova\SelfBundle\Entity\Questionnaire $questionnaires
     * @return Instruction
     */
    public function addQuestionnaire(\Innova\SelfBundle\Entity\Questionnaire $questionnaires)
    {
        $this->questionnaires[] = $questionnaires;

        return $this;
    }

    /**
     * Remove questionnaires
     *
     * @param \Innova\SelfBundle\Entity\Questionnaire $questionnaires
     */
    public function removeQuestionnaire(\Innova\SelfBundle\Entity\Questionnaire $questionnaires)
    {
        $this->questionnaires->removeElement($questionnaires);
    }

    /**
     * Get questionnaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionnaires()
    {
        return $this->questionnaires;
    }

    /**
     * Add questions
     *
     * @param \Innova\SelfBundle\Entity\Question $questions
     * @return Instruction
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
}