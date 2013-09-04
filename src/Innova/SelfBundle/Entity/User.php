<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;


/**
 * User
 *
 * @ORM\Table(name="self_user")
 * @ORM\Entity
 */
class User extends BaseUser
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
    * @ORM\OneToMany(targetEntity="Trace", mappedBy="user")
    */
    protected $traces;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;



    /**
     * @ORM\ManyToMany(targetEntity="Test", mappedBy="users")
     */
    private $tests;


	/**
	 * Constructor
	 */
    public function __construct()
    {
    	parent::__construct();
        $this->traces = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     * @return User
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
     * Set prenom
     *
     * @param string $prenom
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    
        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;
    
        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    
    /**
     * Add traces
     *
     * @param \Innova\SelfBundle\Entity\Trace $traces
     * @return User
     */
    public function addTrace(\Innova\SelfBundle\Entity\Trace $traces)
    {
        $this->traces[] = $traces;
    
        return $this;
    }

    /**
     * Remove traces
     *
     * @param \Innova\SelfBundle\Entity\Trace $traces
     */
    public function removeTrace(\Innova\SelfBundle\Entity\Trace $traces)
    {
        $this->traces->removeElement($traces);
    }

    /**
     * Get traces
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTraces()
    {
        return $this->traces;
    }

    /**
     * Add tests
     *
     * @param \Innova\SelfBundle\Entity\Test $tests
     * @return User
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