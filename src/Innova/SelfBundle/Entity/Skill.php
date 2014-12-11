<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Skill
 *
 * @ORM\Table("questionnaireSkill")
 * @ORM\Entity
 */
class Skill
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
    * @ORM\OneToMany(targetEntity="Questionnaire", mappedBy="skill")
    */
    protected $questionnaires;

    /**
    * @ORM\ManyToMany(targetEntity="Typology", inversedBy="skills")
    */
    protected $typologys;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questionnaires = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Skill
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
     * @return Skill
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
     * Add users
     *
     * @param  \Innova\SelfBundle\Entity\User $users
     * @return Skill
     */
    public function addUser(\Innova\SelfBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Innova\SelfBundle\Entity\User $users
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
     * Add typologys
     *
     * @param  \Innova\SelfBundle\Entity\Typology $typologys
     * @return Skill
     */
    public function addTypology(\Innova\SelfBundle\Entity\Typology $typologys)
    {
        $this->typologys[] = $typologys;

        return $this;
    }

    /**
     * Remove typologys
     *
     * @param \Innova\SelfBundle\Entity\Typology $typologys
     */
    public function removeTypology(\Innova\SelfBundle\Entity\Typology $typologys)
    {
        $this->typologys->removeElement($typologys);
    }

    /**
     * Get typologys
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTypologys()
    {
        return $this->typologys;
    }
}
