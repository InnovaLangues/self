<?php

namespace Innova\SelfBundle\Entity\Right;

use Doctrine\ORM\Mapping as ORM;

/**
 * RightUserTest.
 *
 * @ORM\Table(name="right_user_test")
 * @ORM\Entity
 */
class RightUserTest
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
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Test")
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
     * @ORM\Column(name="canDuplicate", type="boolean")
     */
    private $canDuplicate = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="canManageSession", type="boolean")
     */
    private $canManageSession = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="canManageTask", type="boolean")
     */
    private $canManageTask = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="canAddTask", type="boolean")
     */
    private $canAddTask = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="canReorderTasks", type="boolean")
     */
    private $canReorderTasks = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="canDeleteTask", type="boolean")
     */
    private $canDeleteTask = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="canEditorReadOnlyTasks", type="boolean")
     */
    private $canEditorReadOnlyTasks = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="canEditTask", type="boolean")
     */
    private $canEditTask = 0;

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
     * @return RightUserTest
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
     * @return RightUserTest
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
     * Set canList.
     *
     * @param bool $canList
     *
     * @return RightUserTest
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
     * Set canDuplicate.
     *
     * @param bool $canDuplicate
     *
     * @return RightUserTest
     */
    public function setCanDuplicate($canDuplicate)
    {
        $this->canDuplicate = $canDuplicate;

        return $this;
    }

    /**
     * Get canDuplicate.
     *
     * @return bool
     */
    public function getCanDuplicate()
    {
        return $this->canDuplicate;
    }

    /**
     * Set canManageSession.
     *
     * @param bool $canManageSession
     *
     * @return RightUserTest
     */
    public function setCanManageSession($canManageSession)
    {
        $this->canManageSession = $canManageSession;

        return $this;
    }

    /**
     * Get canManageSession.
     *
     * @return bool
     */
    public function getCanManageSession()
    {
        return $this->canManageSession;
    }

    /**
     * Set canManageTask.
     *
     * @param bool $canManageTask
     *
     * @return RightUserTest
     */
    public function setCanManageTask($canManageTask)
    {
        $this->canManageTask = $canManageTask;

        return $this;
    }

    /**
     * Get canManageTask.
     *
     * @return bool
     */
    public function getCanManageTask()
    {
        return $this->canManageTask;
    }

    /**
     * Set user.
     *
     * @param \Innova\SelfBundle\Entity\User $user
     *
     * @return RightUserTest
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
     * Set test.
     *
     * @param \Innova\SelfBundle\Entity\Test $test
     *
     * @return RightUserTest
     */
    public function setTest(\Innova\SelfBundle\Entity\Test $test = null)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Get test.
     *
     * @return \Innova\SelfBundle\Entity\Test
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * Set canDelete.
     *
     * @param bool $canDelete
     *
     * @return RightUserTest
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
     * Set target.
     *
     * @param \Innova\SelfBundle\Entity\Test $target
     *
     * @return RightUserTest
     */
    public function setTarget(\Innova\SelfBundle\Entity\Test $target = null)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target.
     *
     * @return \Innova\SelfBundle\Entity\Test
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set canAddTask.
     *
     * @param bool $canAddTask
     *
     * @return RightUserTest
     */
    public function setCanAddTask($canAddTask)
    {
        $this->canAddTask = $canAddTask;

        return $this;
    }

    /**
     * Get canAddTask.
     *
     * @return bool
     */
    public function getCanAddTask()
    {
        return $this->canAddTask;
    }

    /**
     * Set canReorderTasks.
     *
     * @param bool $canReorderTasks
     *
     * @return RightUserTest
     */
    public function setCanReorderTasks($canReorderTasks)
    {
        $this->canReorderTasks = $canReorderTasks;

        return $this;
    }

    /**
     * Get canReorderTasks.
     *
     * @return bool
     */
    public function getCanReorderTasks()
    {
        return $this->canReorderTasks;
    }

    /**
     * Set canDeleteTask.
     *
     * @param bool $canDeleteTask
     *
     * @return RightUserTest
     */
    public function setCanDeleteTask($canDeleteTask)
    {
        $this->canDeleteTask = $canDeleteTask;

        return $this;
    }

    /**
     * Get canDeleteTask.
     *
     * @return bool
     */
    public function getCanDeleteTask()
    {
        return $this->canDeleteTask;
    }

    /**
     * Set canEditTask.
     *
     * @param bool $canEditTask
     *
     * @return RightUserTest
     */
    public function setCanEditTask($canEditTask)
    {
        $this->canEditTask = $canEditTask;

        return $this;
    }

    /**
     * Get canEditTask.
     *
     * @return bool
     */
    public function getCanEditTask()
    {
        return $this->canEditTask;
    }

    /**
     * Set canEditorReadOnlyTasks
     *
     * @param boolean $canEditorReadOnlyTasks
     *
     * @return RightUserTest
     */
    public function setCanEditorReadOnlyTasks($canEditorReadOnlyTasks)
    {
        $this->canEditorReadOnlyTasks = $canEditorReadOnlyTasks;

        return $this;
    }

    /**
     * Get canEditorReadOnlyTasks
     *
     * @return boolean
     */
    public function getCanEditorReadOnlyTasks()
    {
        return $this->canEditorReadOnlyTasks;
    }
}
