<?php

namespace Innova\SelfBundle\Entity\Institution;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Media.
 *
 * @ORM\Table("institution")
 * @ORM\Entity
 */
class Institution
{
    /**
     * @var int
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
     * @ORM\OneToMany(targetEntity="Course", mappedBy="institution", cascade={"persist", "remove"})
     */
    protected $courses;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * @Assert\Image()
     */
    public $file;

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->courses = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name.
     *
     * @param string $name
     *
     * @return Institution
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add courses.
     *
     * @param \Innova\SelfBundle\Entity\Institution\Course $courses
     *
     * @return Institution
     */
    public function addCourse(\Innova\SelfBundle\Entity\Institution\Course $courses)
    {
        $this->courses[] = $courses;

        return $this;
    }

    /**
     * Remove courses.
     *
     * @param \Innova\SelfBundle\Entity\Institution\Course $courses
     */
    public function removeCourse(\Innova\SelfBundle\Entity\Institution\Course $courses)
    {
        $this->courses->removeElement($courses);
    }

    /**
     * Get courses.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return Institution
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
