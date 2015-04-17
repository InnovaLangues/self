<?php

namespace Innova\SelfBundle\Entity\Right;

use Doctrine\ORM\Mapping as ORM;

/**
 * RightGroup
 * @ORM\Table(name="right_group")
 * @ORM\Entity
 */
class RightGroup
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
    * @ORM\OneToMany(targetEntity="Innova\SelfBundle\Entity\Right\Right", mappedBy="rightGroup")
    */
    protected $rights;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rights = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param string $name
     * @return RightGroup
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
     * Add rights
     *
     * @param \Innova\SelfBundle\Entity\Right\Right $rights
     * @return RightGroup
     */
    public function addRight(\Innova\SelfBundle\Entity\Right\Right $rights)
    {
        $this->rights[] = $rights;
    
        return $this;
    }

    /**
     * Remove rights
     *
     * @param \Innova\SelfBundle\Entity\Right\Right $rights
     */
    public function removeRight(\Innova\SelfBundle\Entity\Right\Right $rights)
    {
        $this->rights->removeElement($rights);
    }

    /**
     * Get rights
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRights()
    {
        return $this->rights;
    }
}