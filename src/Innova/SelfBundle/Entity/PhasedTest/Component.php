<?php

namespace Innova\SelfBundle\Entity\PhasedTest;

use Doctrine\ORM\Mapping as ORM;

/**
 * Component
 *
 * @ORM\Table("component")
 * @ORM\Entity
 */
class Component
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
    * @ORM\ManyToOne(targetEntity="ComponentType")
    */
    protected $componentType;

    /**
    * @ORM\ManyToOne(targetEntity="ComponentAlternative")
    */
    protected $componentAlternative;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Test")
    */
    protected $test;

    /**
    * @ORM\OneToMany(targetEntity="OrderQuestionnaireComponent", mappedBy="component", cascade={"persist", "remove"})
    * @ORM\OrderBy({"displayOrder" = "ASC"})
    */
    private $orderQuestionnaireComponents;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orderQuestionnaireComponents = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set componentType
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\ComponentType $componentType
     * @return Component
     */
    public function setComponentType(\Innova\SelfBundle\Entity\PhasedTest\ComponentType $componentType = null)
    {
        $this->componentType = $componentType;
    
        return $this;
    }

    /**
     * Get componentType
     *
     * @return \Innova\SelfBundle\Entity\PhasedTest\ComponentType 
     */
    public function getComponentType()
    {
        return $this->componentType;
    }

    /**
     * Set componentAlternative
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\ComponentAlternative $componentAlternative
     * @return Component
     */
    public function setComponentAlternative(\Innova\SelfBundle\Entity\PhasedTest\ComponentAlternative $componentAlternative = null)
    {
        $this->componentAlternative = $componentAlternative;
    
        return $this;
    }

    /**
     * Get componentAlternative
     *
     * @return \Innova\SelfBundle\Entity\PhasedTest\ComponentAlternative 
     */
    public function getComponentAlternative()
    {
        return $this->componentAlternative;
    }

    /**
     * Set test
     *
     * @param \Innova\SelfBundle\Entity\Test $test
     * @return Component
     */
    public function setTest(\Innova\SelfBundle\Entity\Test $test = null)
    {
        $this->test = $test;
    
        return $this;
    }

    /**
     * Get test
     *
     * @return \Innova\SelfBundle\Entity\Test 
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * Add orderQuestionnaireComponents
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent $orderQuestionnaireComponents
     * @return Component
     */
    public function addOrderQuestionnaireComponent(\Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent $orderQuestionnaireComponents)
    {
        $this->orderQuestionnaireComponents[] = $orderQuestionnaireComponents;
    
        return $this;
    }

    /**
     * Remove orderQuestionnaireComponents
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent $orderQuestionnaireComponents
     */
    public function removeOrderQuestionnaireComponent(\Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent $orderQuestionnaireComponents)
    {
        $this->orderQuestionnaireComponents->removeElement($orderQuestionnaireComponents);
    }

    /**
     * Get orderQuestionnaireComponents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrderQuestionnaireComponents()
    {
        return $this->orderQuestionnaireComponents;
    }
}