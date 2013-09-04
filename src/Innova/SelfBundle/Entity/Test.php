<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Test
 *
 * @ORM\Table("test")
 * @ORM\Entity(repositoryClass="Innova\SelfBundle\Repository\TestRepository")
 */
class Test
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
    * @ORM\ManyToMany(targetEntity="Questionnaire")
    */
    private $questionnaires;

    /**
    * @ORM\ManyToMany(targetEntity="User", inversedBy="tests")
    */
    private $users;

    public function __construct() {
        $this->questionnaires = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString(){
        return $this->nom;
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
     * Add questionnaires
     *
     * @param \Innova\SelfBundle\Entity\Questionnaire $questionnaires
     * @return Session
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
     * Set nom
     *
     * @param string $nom
     * @return Session
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Add users
     *
     * @param \Innova\SelfBundle\Entity\User $users
     * @return Test
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
}