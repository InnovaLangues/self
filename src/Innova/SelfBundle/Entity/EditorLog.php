<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EditorLog
 *
 * @ORM\Table("editorLog")
 * @ORM\Entity
 */
class EditorLog
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
    * @ORM\ManyToOne(targetEntity="Questionnaire", inversedBy="editorLogs")
    */
    protected $questionnaire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="editorLogs")
    */
    protected $user;
    
    /**
    * @ORM\ManyToOne(targetEntity="EditorLogAction")
    */
    protected $action;

    /**
    * @ORM\ManyToOne(targetEntity="EditorLogObject")
    */
    protected $object;


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
     * @return EditorLog
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
     * @return EditorLog
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
     * Set action
     *
     * @param \Innova\SelfBundle\Entity\EditorLogAction $action
     * @return EditorLog
     */
    public function setAction(\Innova\SelfBundle\Entity\EditorLogAction $action = null)
    {
        $this->action = $action;
    
        return $this;
    }

    /**
     * Get action
     *
     * @return \Innova\SelfBundle\Entity\EditorLogAction 
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set object
     *
     * @param \Innova\SelfBundle\Entity\EditorLogObject $object
     * @return EditorLog
     */
    public function setObject(\Innova\SelfBundle\Entity\EditorLogObject $object = null)
    {
        $this->object = $object;
    
        return $this;
    }

    /**
     * Get object
     *
     * @return \Innova\SelfBundle\Entity\EditorLogObject 
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set user
     *
     * @param \Innova\SelfBundle\Entity\User $user
     * @return EditorLog
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
}
