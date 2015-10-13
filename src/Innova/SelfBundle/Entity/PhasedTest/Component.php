<?php

namespace Innova\SelfBundle\Entity\PhasedTest;

use Doctrine\ORM\Mapping as ORM;

/**
 * Component
 *
 * @ORM\Table("component")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Innova\SelfBundle\Repository\ComponentRepository")
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
     * @var integer
     *
     * @ORM\Column(name="alternativeNumber", type="integer")
     */
    private $alternativeNumber;

    /**
    * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Test", inversedBy="components", cascade={"persist"})
    */
    protected $test;

    /**
    * @ORM\OneToMany(targetEntity="OrderQuestionnaireComponent", mappedBy="component", cascade={"persist", "remove"})
    * @ORM\OrderBy({"displayOrder" = "ASC"})
    */
    private $orderQuestionnaireComponents;

    /**
    * @ORM\OneToMany(targetEntity="Innova\SelfBundle\Entity\Trace", mappedBy="component", cascade={"remove"})
    */
    protected $traces;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orderQuestionnaireComponents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->traces                       = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param  \Innova\SelfBundle\Entity\PhasedTest\ComponentType $componentType
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
     * Set test
     *
     * @param  \Innova\SelfBundle\Entity\Test $test
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
     * @param  \Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent $orderQuestionnaireComponents
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

    /**
     * Set alternativeNumber
     *
     * @param  integer   $alternativeNumber
     * @return Component
     */
    public function setAlternativeNumber($alternativeNumber)
    {
        $this->alternativeNumber = $alternativeNumber;

        return $this;
    }

    /**
     * Get alternativeNumber
     *
     * @return integer
     */
    public function getAlternativeNumber()
    {
        return $this->alternativeNumber;
    }

    /**
     * Add traces
     *
     * @param  \Innova\SelfBundle\Entity\Trace $traces
     * @return Component
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
     * @return \Innova\SelfBundle\Entity\Trace[]
     */
    public function getTraces()
    {
        return $this->traces;
    }
}
