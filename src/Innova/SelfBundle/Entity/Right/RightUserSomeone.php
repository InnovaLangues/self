<?php

namespace Innova\SelfBundle\Entity\Right;

use Doctrine\ORM\Mapping as ORM;

/**
 * RightUserTest
 * @ORM\Table(name="right_user_someone")
 * @ORM\Entity
 */
class RightUserSomeone
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
    * @ORM\JoinColumn(onDelete="CASCADE")
    */
    protected $user;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\User")
    * @ORM\JoinColumn(onDelete="CASCADE")
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
     * @ORM\Column(name="canDeleteTrace", type="boolean")
     *
     */
    private $canDeleteTrace = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="canEditPassword", type="boolean")
     *
     */
    private $canEditPassword = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="canEditRights", type="boolean")
     *
     */
    private $canEditRights = 0;

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
     * @return RightUserSomeone
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
     * @return RightUserSomeone
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
     * @return RightUserSomeone
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
     * Set canDeleteTrace
     *
     * @param  boolean          $canDeleteTrace
     * @return RightUserSomeone
     */
    public function setCanDeleteTrace($canDeleteTrace)
    {
        $this->canDeleteTrace = $canDeleteTrace;

        return $this;
    }

    /**
     * Get canDeleteTrace
     *
     * @return boolean
     */
    public function getCanDeleteTrace()
    {
        return $this->canDeleteTrace;
    }

    /**
     * Set canEditPassword
     *
     * @param  boolean          $canEditPassword
     * @return RightUserSomeone
     */
    public function setCanEditPassword($canEditPassword)
    {
        $this->canEditPassword = $canEditPassword;

        return $this;
    }

    /**
     * Get canEditPassword
     *
     * @return boolean
     */
    public function getCanEditPassword()
    {
        return $this->canEditPassword;
    }

    /**
     * Set user
     *
     * @param  \Innova\SelfBundle\Entity\User $user
     * @return RightUserSomeone
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
     * Set someone
     *
     * @param  \Innova\SelfBundle\Entity\User $someone
     * @return RightUserSomeone
     */
    public function setSomeone(\Innova\SelfBundle\Entity\User $someone = null)
    {
        $this->someone = $someone;

        return $this;
    }

    /**
     * Get someone
     *
     * @return \Innova\SelfBundle\Entity\User
     */
    public function getSomeone()
    {
        return $this->someone;
    }

    /**
     * Set canEditRights
     *
     * @param  boolean          $canEditRights
     * @return RightUserSomeone
     */
    public function setCanEditRights($canEditRights)
    {
        $this->canEditRights = $canEditRights;

        return $this;
    }

    /**
     * Get canEditRights
     *
     * @return boolean
     */
    public function getCanEditRights()
    {
        return $this->canEditRights;
    }

    /**
     * Set target
     *
     * @param  \Innova\SelfBundle\Entity\User $target
     * @return RightUserSomeone
     */
    public function setTarget(\Innova\SelfBundle\Entity\User $target = null)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return \Innova\SelfBundle\Entity\User
     */
    public function getTarget()
    {
        return $this->target;
    }
}
