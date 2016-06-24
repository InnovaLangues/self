<?php

namespace Innova\SelfBundle\Entity\Right;

use Doctrine\ORM\Mapping as ORM;

/**
 * RightUserTest.
 *
 * @ORM\Table(name="right_user_session")
 * @ORM\Entity
 */
class RightUserSession
{
    /**
     * @var int
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
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Session")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $target;

    /**
     * @var bool
     *
     * @ORM\Column(name="canCreate", type="boolean")
     */
    private $canCreate = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="canEdit", type="boolean")
     */
    private $canEdit = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="canDelete", type="boolean")
     */
    private $canDelete = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="canList", type="boolean")
     */
    private $canList = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="canExportIndividual", type="boolean")
     */
    private $canExportIndividual = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="canExportCollective", type="boolean")
     */
    private $canExportCollective = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="canDeleteTrace", type="boolean")
     */
    private $canDeleteTrace = 0;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set canCreate.
     *
     * @param bool $canCreate
     *
     * @return RightUserSession
     */
    public function setCanCreate($canCreate)
    {
        $this->canCreate = $canCreate;

        return $this;
    }

    /**
     * Get canCreate.
     *
     * @return bool
     */
    public function getCanCreate()
    {
        return $this->canCreate;
    }

    /**
     * Set canEdit.
     *
     * @param bool $canEdit
     *
     * @return RightUserSession
     */
    public function setCanEdit($canEdit)
    {
        $this->canEdit = $canEdit;

        return $this;
    }

    /**
     * Get canEdit.
     *
     * @return bool
     */
    public function getCanEdit()
    {
        return $this->canEdit;
    }

    /**
     * Set canDelete.
     *
     * @param bool $canDelete
     *
     * @return RightUserSession
     */
    public function setCanDelete($canDelete)
    {
        $this->canDelete = $canDelete;

        return $this;
    }

    /**
     * Get canDelete.
     *
     * @return bool
     */
    public function getCanDelete()
    {
        return $this->canDelete;
    }

    /**
     * Set canList.
     *
     * @param bool $canList
     *
     * @return RightUserSession
     */
    public function setCanList($canList)
    {
        $this->canList = $canList;

        return $this;
    }

    /**
     * Get canList.
     *
     * @return bool
     */
    public function getCanList()
    {
        return $this->canList;
    }

    /**
     * Set canExportIndividual.
     *
     * @param bool $canExportIndividual
     *
     * @return RightUserSession
     */
    public function setCanExportIndividual($canExportIndividual)
    {
        $this->canExportIndividual = $canExportIndividual;

        return $this;
    }

    /**
     * Get canExportIndividual.
     *
     * @return bool
     */
    public function getCanExportIndividual()
    {
        return $this->canExportIndividual;
    }

    /**
     * Set canExportCollective.
     *
     * @param bool $canExportCollective
     *
     * @return RightUserSession
     */
    public function setCanExportCollective($canExportCollective)
    {
        $this->canExportCollective = $canExportCollective;

        return $this;
    }

    /**
     * Get canExportCollective.
     *
     * @return bool
     */
    public function getCanExportCollective()
    {
        return $this->canExportCollective;
    }

    /**
     * Set user.
     *
     * @param \Innova\SelfBundle\Entity\User $user
     *
     * @return RightUserSession
     */
    public function setUser(\Innova\SelfBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \Innova\SelfBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set session.
     *
     * @param \Innova\SelfBundle\Entity\Session $session
     *
     * @return RightUserSession
     */
    public function setSession(\Innova\SelfBundle\Entity\Session $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session.
     *
     * @return \Innova\SelfBundle\Entity\Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set target.
     *
     * @param \Innova\SelfBundle\Entity\Session $target
     *
     * @return RightUserSession
     */
    public function setTarget(\Innova\SelfBundle\Entity\Session $target = null)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target.
     *
     * @return \Innova\SelfBundle\Entity\Session
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set canEditRights.
     *
     * @param bool $canEditRights
     *
     * @return RightUserSession
     */
    public function setCanEditRights($canEditRights)
    {
        $this->canEditRights = $canEditRights;

        return $this;
    }

    /**
     * Get canEditRights.
     *
     * @return bool
     */
    public function getCanEditRights()
    {
        return $this->canEditRights;
    }

    /**
     * Set canDeleteTrace
     *
     * @param boolean $canDeleteTrace
     *
     * @return RightUserSession
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
}
