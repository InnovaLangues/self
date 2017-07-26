<?php

namespace Innova\SelfBundle\Entity\Institution;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/** *
 * @ORM\Table("subcourse")
 * @ORM\Entity
 */
class Subcourse implements JsonSerializable
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
    * @ORM\ManyToOne(targetEntity="Course", inversedBy="subcourses")
    */
    protected $course;

    public function __toString()
    {
        return $this->name;
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'name'=> $this->name,
        );
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
     * @return Course
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
     * Set course
     *
     * @param \Innova\SelfBundle\Entity\Institution\Course $course
     * @return Course
     */
    public function setCourse(\Innova\SelfBundle\Entity\Institution\Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return \Innova\SelfBundle\Entity\Institution\Course
     */
    public function getCourse()
    {
        return $this->course;
    }
}
