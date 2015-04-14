<?php

namespace Innova\SelfBundle\Entity\Right;

use Doctrine\ORM\Mapping as ORM;

/**
 * RightUserTest
 * @ORM\Table(name="right_user_group")
 * @ORM\Entity
 */
class RightUserGroup
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
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Group")
    */
    protected $group;

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
     * @ORM\Column(name="canImportCsv", type="boolean")
     *
     */
    private $canImportCsv = 0;

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
     * @param boolean $canCreate
     * @return RightUserGroup
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
     * @param boolean $canEdit
     * @return RightUserGroup
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
     * @param boolean $canDelete
     * @return RightUserGroup
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
     * @param boolean $canList
     * @return RightUserGroup
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
     * Set canImportCsv
     *
     * @param boolean $canImportCsv
     * @return RightUserGroup
     */
    public function setCanImportCsv($canImportCsv)
    {
        $this->canImportCsv = $canImportCsv;
    
        return $this;
    }

    /**
     * Get canImportCsv
     *
     * @return boolean 
     */
    public function getCanImportCsv()
    {
        return $this->canImportCsv;
    }

    /**
     * Set user
     *
     * @param \Innova\SelfBundle\Entity\User $user
     * @return RightUserGroup
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
     * Set group
     *
     * @param \Innova\SelfBundle\Entity\Group $group
     * @return RightUserGroup
     */
    public function setGroup(\Innova\SelfBundle\Entity\Group $group = null)
    {
        $this->group = $group;
    
        return $this;
    }

    /**
     * Get group
     *
     * @return \Innova\SelfBundle\Entity\Group 
     */
    public function getGroup()
    {
        return $this->group;
    }
}