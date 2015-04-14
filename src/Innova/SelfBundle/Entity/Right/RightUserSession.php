<?php

namespace Innova\SelfBundle\Entity\Right;

use Doctrine\ORM\Mapping as ORM;

/**
 * RightUserTest
 * @ORM\Table(name="right_user_session")
 * @ORM\Entity
 */
class RightUserSession
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\User")
    */
    protected $user;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Session")
    */
    protected $target;

    /**
     * @var boolean
     *
     * @ORM\Column(name="canCreate", type="boolean")
     *
     */
    private $canCreate = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="canEdit", type="boolean")
     *
     */
    private $canEdit = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="canDelete", type="boolean")
     *
     */
    private $canDelete = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="canList", type="boolean")
     *
     */
    private $canList = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="canExportIndividual", type="boolean")
     *
     */
    private $canExportIndividual = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="canExportCollective", type="boolean")
     *
     */
    private $canExportCollective = 0;

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
     * Set canCreate
     *
     * @param  boolean          $canCreate
     * @return RightUserSession
     */
    public function setCanCreate($canCreate)
    {
        $this->canCreate = $canCreate;

        return $this;
    }

    /**
     * Get canCreate
     *
     * @return boolean
     */
    public function getCanCreate()
    {
        return $this->canCreate;
    }

    /**
     * Set canEdit
     *
     * @param  boolean          $canEdit
     * @return RightUserSession
     */
    public function setCanEdit($canEdit)
    {
        $this->canEdit = $canEdit;

        return $this;
    }

    /**
     * Get canEdit
     *
     * @return boolean
     */
    public function getCanEdit()
    {
        return $this->canEdit;
    }

    /**
     * Set canDelete
     *
     * @param  boolean          $canDelete
     * @return RightUserSession
     */
    public function setCanDelete($canDelete)
    {
        $this->canDelete = $canDelete;

        return $this;
    }

    /**
     * Get canDelete
     *
     * @return boolean
     */
    public function getCanDelete()
    {
        return $this->canDelete;
    }

    /**
     * Set canList
     *
     * @param  boolean          $canList
     * @return RightUserSession
     */
    public function setCanList($canList)
    {
        $this->canList = $canList;

        return $this;
    }

    /**
     * Get canList
     *
     * @return boolean
     */
    public function getCanList()
    {
        return $this->canList;
    }

    /**
     * Set canExportIndividual
     *
     * @param  boolean          $canExportIndividual
     * @return RightUserSession
     */
    public function setCanExportIndividual($canExportIndividual)
    {
        $this->canExportIndividual = $canExportIndividual;

        return $this;
    }

    /**
     * Get canExportIndividual
     *
     * @return boolean
     */
    public function getCanExportIndividual()
    {
        return $this->canExportIndividual;
    }

    /**
     * Set canExportCollective
     *
     * @param  boolean          $canExportCollective
     * @return RightUserSession
     */
    public function setCanExportCollective($canExportCollective)
    {
        $this->canExportCollective = $canExportCollective;

        return $this;
    }

    /**
     * Get canExportCollective
     *
     * @return boolean
     */
    public function getCanExportCollective()
    {
        return $this->canExportCollective;
    }

    /**
     * Set user
     *
     * @param  \Innova\SelfBundle\Entity\User $user
     * @return RightUserSession
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
     * Set session
     *
     * @param  \Innova\SelfBundle\Entity\Session $session
     * @return RightUserSession
     */
    public function setSession(\Innova\SelfBundle\Entity\Session $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return \Innova\SelfBundle\Entity\Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set target
     *
     * @param \Innova\SelfBundle\Entity\Session $target
     * @return RightUserSession
     */
    public function setTarget(\Innova\SelfBundle\Entity\Session $target = null)
    {
        $this->target = $target;
    
        return $this;
    }

    /**
     * Get target
     *
     * @return \Innova\SelfBundle\Entity\Session 
     */
    public function getTarget()
    {
        return $this->target;
    }
}