<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LevelLansad
 *
 * @ORM\Table("levelLansad")
 * @ORM\Entity
 */
class LevelLansad
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
    * @ORM\ManyToOne(targetEntity="Language", inversedBy="levelLansads")
    */
    protected $language;

    /**
    * @ORM\OneToMany(targetEntity="User", mappedBy="levelLansad")
    */
    protected $levelLansads;

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
     * @param  string      $name
     * @return LevelLansad
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
     * Set language
     *
     * @param  \Innova\SelfBundle\Entity\Language $language
     * @return LevelLansad
     */
    public function setLanguage(\Innova\SelfBundle\Entity\Language $language = null)
    {
        $this->language = $language;
        if (!empty($language)) {
            $language->addLevelLansad($this);
        } else {
            $language->removeLevelLansad($this);
        }

        return $this;
    }

    /**
     * Get language
     *
     * @return \Innova\SelfBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->levelLansads = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add levelLansads
     *
     * @param  \Innova\SelfBundle\Entity\User $levelLansads
     * @return LevelLansad
     */
    public function addLevelLansad(\Innova\SelfBundle\Entity\User $levelLansads)
    {
        $this->levelLansads[] = $levelLansads;

        return $this;
    }

    /**
     * Remove levelLansads
     *
     * @param \Innova\SelfBundle\Entity\User $levelLansads
     */
    public function removeLevelLansad(\Innova\SelfBundle\Entity\User $levelLansads)
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
}