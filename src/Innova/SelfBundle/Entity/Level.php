<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Level
 * 28/11/2013 : Add "OneToMany" to User.
 *
 * @ORM\Table("questionnaireLevel")
 * @ORM\Entity
 */
class Level
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
    * @ORM\OneToMany(targetEntity="Questionnaire", mappedBy="level")
    */
    protected $questionnaires;

    /**
    * @ORM\OneToMany(targetEntity="User", mappedBy="coLevel")
    */
    protected $coLevels;

    /**
    * @ORM\OneToMany(targetEntity="User", mappedBy="ceLevel")
    */
    protected $ceLevels;

    /**
    * @ORM\OneToMany(targetEntity="User", mappedBy="eeLevel")
    */
    protected $eeLevels;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questionnaires   = new \Doctrine\Common\Collections\ArrayCollection();
        $this->coLevels         = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ceLevels         = new \Doctrine\Common\Collections\ArrayCollection();
        $this->eeLevels         = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * To String
     */

    public function __toString()
    {
        return $this->getName();
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
     * @return Level
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
     * Add questionnaires
     *
     * @param  \Innova\SelfBundle\Entity\Questionnaire $questionnaires
     * @return Level
     */
    public function addQuestionnaire(\Innova\SelfBundle\Entity\Questionnaire $questionnaires)
    {
        $this->questionnaires[] = $questionnaires;

        return $this;
    }

    /**
     * Remove questionnaires
     *
     * @param \Innova\SelfBundle\Entity\Questionnaire $questionnaires
     */
    public function removeQuestionnaire(\Innova\SelfBundle\Entity\Questionnaire $questionnaires)
    {
        $this->questionnaires->removeElement($questionnaires);
    }

    /**
     * Get questionnaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionnaires()
    {
        return $this->questionnaires;
    }

    /**
     * Add coLevels
     *
     * @param  \Innova\SelfBundle\Entity\User $coLevels
     * @return Level
     */
    public function addCoLevel(\Innova\SelfBundle\Entity\User $coLevels)
    {
        $this->coLevels[] = $coLevels;

        return $this;
    }

    /**
     * Remove coLevels
     *
     * @param \Innova\SelfBundle\Entity\User $coLevels
     */
    public function removeCoLevel(\Innova\SelfBundle\Entity\User $coLevels)
    {
        $this->coLevels->removeElement($coLevels);
    }

    /**
     * Get coLevels
     *
     * @return User[]
     */
    public function getCoLevels()
    {
        return $this->coLevels;
    }

    /**
     * Add ceLevels
     *
     * @param  \Innova\SelfBundle\Entity\User $ceLevels
     * @return Level
     */
    public function addCeLevel(\Innova\SelfBundle\Entity\User $ceLevels)
    {
        $this->ceLevels[] = $ceLevels;

        return $this;
    }

    /**
     * Remove ceLevels
     *
     * @param \Innova\SelfBundle\Entity\User $ceLevels
     */
    public function removeCeLevel(\Innova\SelfBundle\Entity\User $ceLevels)
    {
        $this->ceLevels->removeElement($ceLevels);
    }

    /**
     * Get ceLevels
     *
     * @return User[]
     */
    public function getCeLevels()
    {
        return $this->ceLevels;
    }

    /**
     * Add eeLevels
     *
     * @param  \Innova\SelfBundle\Entity\User $eeLevels
     * @return Level
     */
    public function addEeLevel(\Innova\SelfBundle\Entity\User $eeLevels)
    {
        $this->eeLevels[] = $eeLevels;

        return $this;
    }

    /**
     * Remove eeLevels
     *
     * @param \Innova\SelfBundle\Entity\User $eeLevels
     */
    public function removeEeLevel(\Innova\SelfBundle\Entity\User $eeLevels)
    {
        $this->eeLevels->removeElement($eeLevels);
    }

    /**
     * Get eeLevels
     *
     * @return User[]
     */
    public function getEeLevels()
    {
        return $this->eeLevels;
    }
}
