<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OriginStudent
 *
 * @ORM\Table("originStudent")
 * @ORM\Entity
 */
class OriginStudent
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
    * @ORM\OneToMany(targetEntity="User", mappedBy="originStudent")
    */
    protected $originStudents;

    public function __toString()
    {
        return $this->name;
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
     * @param  string        $name
     * @return OriginStudent
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
        $this->originStudents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add originStudents
     *
     * @param  \Innova\SelfBundle\Entity\User $originStudents
     * @return OriginStudent
     */
    public function addOriginStudent(\Innova\SelfBundle\Entity\User $originStudents)
    {
        $this->originStudents[] = $originStudents;

        return $this;
    }

    /**
     * Remove originStudents
     *
     * @param \Innova\SelfBundle\Entity\User $originStudents
     */
    public function removeOriginStudent(\Innova\SelfBundle\Entity\User $originStudents)
    {
        $this->originStudents->removeElement($originStudents);
    }

    /**
     * Get originStudents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOriginStudents()
    {
        return $this->originStudents;
    }
}
