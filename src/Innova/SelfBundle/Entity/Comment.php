<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Duration
 *
 * @ORM\Table("questionnaireComment")
 * @ORM\Entity
 */
class Comment
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
    * @ORM\ManyToOne(targetEntity="Questionnaire", inversedBy="comments")
    */
    protected $questionnaire;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
    */
    protected $user;

    /**
    * @ORM\ManyToOne(targetEntity="Media")
    */
    protected $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

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
     * Set date
     *
     * @param \DateTime $date
     * @return Comment
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set questionnaire
     *
     * @param \Innova\SelfBundle\Entity\Questionnaire $questionnaire
     * @return Comment
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
     * Set user
     *
     * @param \Innova\SelfBundle\Entity\User $user
     * @return Comment
     */
    public function setUser(\Innova\SelfBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Innova\SelfBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set mediaInstruction
     *
     * @param \Innova\SelfBundle\Entity\Media $mediaInstruction
     * @return Comment
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
     * Set description
     *
     * @param \Innova\SelfBundle\Entity\Media $description
     * @return Comment
     */
    public function setDescription(\Innova\SelfBundle\Entity\Media $description = null)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return \Innova\SelfBundle\Entity\Media 
     */
    public function getDescription()
    {
        return $this->description;
    }
}