<?php

namespace Innova\SelfBundle\Entity\QuestionnaireIdentity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuthorRight
 *
 * @ORM\Table("questionnaireCognitiveOperation")
 * @ORM\Entity
 */
class CognitiveOperation
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
     * @var text
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
    * @ORM\ManyToMany(targetEntity="Innova\SelfBundle\Entity\Subquestion", mappedBy="cognitiveOpsMain")
    */
    protected $subquestionsMain;

    /**
    * @ORM\ManyToMany(targetEntity="Innova\SelfBundle\Entity\Subquestion", mappedBy="cognitiveOpsSecondary")
    */
    protected $subquestionsSecondary;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subquestionsMain = new \Doctrine\Common\Collections\ArrayCollection();
        $this->subquestionsSecondary = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return CognitiveOperation
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
     * Set description
     *
     * @param string $description
     * @return CognitiveOperation
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add subquestionsMain
     *
     * @param \Innova\SelfBundle\Entity\Subquestion $subquestionsMain
     * @return CognitiveOperation
     */
    public function addSubquestionsMain(\Innova\SelfBundle\Entity\Subquestion $subquestionsMain)
    {
        $this->subquestionsMain[] = $subquestionsMain;
    
        return $this;
    }

    /**
     * Remove subquestionsMain
     *
     * @param \Innova\SelfBundle\Entity\Subquestion $subquestionsMain
     */
    public function removeSubquestionsMain(\Innova\SelfBundle\Entity\Subquestion $subquestionsMain)
    {
        $this->subquestionsMain->removeElement($subquestionsMain);
    }

    /**
     * Get subquestionsMain
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubquestionsMain()
    {
        return $this->subquestionsMain;
    }

    /**
     * Add subquestionsSecondary
     *
     * @param \Innova\SelfBundle\Entity\Subquestion $subquestionsSecondary
     * @return CognitiveOperation
     */
    public function addSubquestionsSecondary(\Innova\SelfBundle\Entity\Subquestion $subquestionsSecondary)
    {
        $this->subquestionsSecondary[] = $subquestionsSecondary;
    
        return $this;
    }

    /**
     * Remove subquestionsSecondary
     *
     * @param \Innova\SelfBundle\Entity\Subquestion $subquestionsSecondary
     */
    public function removeSubquestionsSecondary(\Innova\SelfBundle\Entity\Subquestion $subquestionsSecondary)
    {
        $this->subquestionsSecondary->removeElement($subquestionsSecondary);
    }

    /**
     * Get subquestionsSecondary
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubquestionsSecondary()
    {
        return $this->subquestionsSecondary;
    }
}