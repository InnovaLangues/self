<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Language
 *
 * @ORM\Table("language")
 * @ORM\Entity
 */
class Language
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
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     */
    private $color;

    /**
    * @ORM\OneToMany(targetEntity="LevelLansad", mappedBy="language")
    */
    protected $levelLansads;

    /**
    * @ORM\OneToMany(targetEntity="Test", mappedBy="language")
    */
    protected $tests;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->levelLansads = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tests = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param  string   $name
     * @return Language
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
     * Set color
     *
     * @param  string   $color
     * @return Language
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Add levelLansads
     *
     * @param  \Innova\SelfBundle\Entity\LevelLansad $levelLansads
     * @return Language
     */
    public function addLevelLansad(\Innova\SelfBundle\Entity\LevelLansad $levelLansads)
    {
        $this->levelLansads[] = $levelLansads;

        return $this;
    }

    /**
     * Remove levelLansads
     *
     * @param \Innova\SelfBundle\Entity\LevelLansad $levelLansads
     */
    public function removeLevelLansad(\Innova\SelfBundle\Entity\LevelLansad $levelLansads)
    {
        $this->levelLansads->removeElement($levelLansads);
    }

    /**
     * Get levelLansads
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLevelLansads()
    {
        return $this->levelLansads;
    }

    /**
     * Add tests
     *
     * @param  \Innova\SelfBundle\Entity\Test $tests
     * @return Language
     */
    public function addTest(\Innova\SelfBundle\Entity\Test $tests)
    {
        $this->tests[] = $tests;

        return $this;
    }

    /**
     * Remove tests
     *
     * @param \Innova\SelfBundle\Entity\Test $tests
     */
    public function removeTest(\Innova\SelfBundle\Entity\Test $tests)
    {
        $this->tests->removeElement($tests);
    }

    /**
     * Get tests
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTests()
    {
        return $this->tests;
    }
}
