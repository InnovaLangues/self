<?php

namespace Innova\SelfBundle\Entity\Right;

use Doctrine\ORM\Mapping as ORM;

/**
 * RightUserTest
 * @ORM\Table(name="right_user_test")
 * @ORM\Entity
 */
class RightUserTest
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
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Test")
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
     * @ORM\Column(name="canList", type="boolean")
     *
     */
    private $canList = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="canDuplicate", type="boolean")
     *
     */
    private $canDuplicate = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="canManageSession", type="boolean")
     *
     */
    private $canManageSession = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="canManageTask", type="boolean")
     *
     */
    private $canManageTask = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="canAddTask", type="boolean")
     *
     */
    private $canAddTask = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="canReorderTasks", type="boolean")
     *
     */
    private $canReorderTasks = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="canDeleteTask", type="boolean")
     *
     */
    private $canDeleteTask = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="canEditTask", type="boolean")
     *
     */
    private $canEditTask = 0;

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
     * @param  boolean       $canCreate
     * @return RightUserTest
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
     * @param  boolean       $canEdit
     * @return RightUserTest
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
     * Set canList
     *
     * @param  boolean       $canList
     * @return RightUserTest
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
     * Set canDuplicate
     *
     * @param  boolean       $canDuplicate
     * @return RightUserTest
     */
    public function setCanDuplicate($canDuplicate)
    {
        $this->canDuplicate = $canDuplicate;

        return $this;
    }

    /**
     * Get canDuplicate
     *
     * @return boolean
     */
    public function getCanDuplicate()
    {
        return $this->canDuplicate;
    }

    /**
     * Set canManageSession
     *
     * @param  boolean       $canManageSession
     * @return RightUserTest
     */
    public function setCanManageSession($canManageSession)
    {
        $this->canManageSession = $canManageSession;

        return $this;
    }

    /**
     * Get canManageSession
     *
     * @return boolean
     */
    public function getCanManageSession()
    {
        return $this->canManageSession;
    }

    /**
     * Set canManageTask
     *
     * @param  boolean       $canManageTask
     * @return RightUserTest
     */
    public function setCanManageTask($canManageTask)
    {
        $this->canManageTask = $canManageTask;

        return $this;
    }

    /**
     * Get canManageTask
     *
     * @return boolean
     */
    public function getCanManageTask()
    {
        return $this->canManageTask;
    }

    /**
     * Set user
     *
     * @param  \Innova\SelfBundle\Entity\User $user
     * @return RightUserTest
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
     * Set test
     *
     * @param  \Innova\SelfBundle\Entity\Test $test
     * @return RightUserTest
     */
    public function setTest(\Innova\SelfBundle\Entity\Test $test = null)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Get test
     *
     * @return \Innova\SelfBundle\Entity\Test
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * Set canDelete
     *
     * @param  boolean       $canDelete
     * @return RightUserTest
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
     * Set target
     *
     * @param  \Innova\SelfBundle\Entity\Test $target
     * @return RightUserTest
     */
    public function setTarget(\Innova\SelfBundle\Entity\Test $target = null)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return \Innova\SelfBundle\Entity\Test
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set canAddTask
     *
     * @param  boolean       $canAddTask
     * @return RightUserTest
     */
    public function setCanAddTask($canAddTask)
    {
        $this->canAddTask = $canAddTask;

        return $this;
    }

    /**
     * Get canAddTask
     *
     * @return boolean
     */
    public function getCanAddTask()
    {
        return $this->canAddTask;
    }

    /**
     * Set canReorderTasks
     *
     * @param  boolean       $canReorderTasks
     * @return RightUserTest
     */
    public function setCanReorderTasks($canReorderTasks)
    {
        $this->canReorderTasks = $canReorderTasks;

        return $this;
    }

    /**
     * Get canReorderTasks
     *
     * @return boolean
     */
    public function getCanReorderTasks()
    {
        return $this->canReorderTasks;
    }

    /**
     * Set canDeleteTask
     *
     * @param  boolean       $canDeleteTask
     * @return RightUserTest
     */
    public function setCanDeleteTask($canDeleteTask)
    {
        $this->canDeleteTask = $canDeleteTask;

        return $this;
    }

    /**
     * Get canDeleteTask
     *
     * @return boolean
     */
    public function getCanDeleteTask()
    {
        return $this->canDeleteTask;
    }

    /**
     * Set canEditTask
     *
     * @param  boolean       $canEditTask
     * @return RightUserTest
     */
    public function setCanEditTask($canEditTask)
    {
        $this->canEditTask = $canEditTask;

        return $this;
    }

    /**
     * Get canEditTask
     *
     * @return boolean
     */
    public function getCanEditTask()
    {
        return $this->canEditTask;
    }
}
