<?php

namespace Innova\SelfBundle\Entity\Right;

use Doctrine\ORM\Mapping as ORM;

/**
 * Right
 * @ORM\Table(name="rights")
 * @ORM\Entity
 */
class Right
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute", type="string", length=255, nullable=true)
     */
    private $attribute;

    /**
     * @var string
     *
     * @ORM\Column(name="class", type="string", length=255)
     */
    private $class;

    /**
    * @ORM\ManyToMany(targetEntity="Innova\SelfBundle\Entity\User")
    * @ORM\JoinTable(name="right_user")
    */
    protected $users;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Right\RightGroup", inversedBy="rights")
    */
    protected $rightGroup;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param  string $name
     * @return Right
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
     * Add users
     *
     * @param  \Innova\SelfBundle\Entity\Right\User $users
     * @return Right
     */
    public function addUser(\Innova\SelfBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Innova\SelfBundle\Entity\Right\User $users
     */
    public function removeUser(\Innova\SelfBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set rightGroup
     *
     * @param  \Innova\SelfBundle\Entity\Right\RightGroup $rightGroup
     * @return Right
     */
    public function setRightGroup(\Innova\SelfBundle\Entity\Right\RightGroup $rightGroup = null)
    {
        $this->rightGroup = $rightGroup;

        return $this;
    }

    /**
     * Get rightGroup
     *
     * @return \Innova\SelfBundle\Entity\Right\RightGroup
     */
    public function getRightGroup()
    {
        return $this->rightGroup;
    }

    /**
     * Set attribute
     *
     * @param  string $attribute
     * @return Right
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Get attribute
     *
     * @return string
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Set class
     *
     * @param  string $class
     * @return Right
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
}
