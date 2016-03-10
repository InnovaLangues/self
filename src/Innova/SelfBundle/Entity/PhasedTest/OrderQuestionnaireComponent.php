<?php

namespace Innova\SelfBundle\Entity\PhasedTest;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderQuestionnaireComponent.
 *
 * @ORM\Table("orderQuestionnaireComponent")
 * @ORM\Entity
 */
class OrderQuestionnaireComponent
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
     * @ORM\ManyToOne(targetEntity="Component", inversedBy="orderQuestionnaireComponents", cascade={"persist"})
     */
    protected $component;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Questionnaire", inversedBy="orderQuestionnaireComponents")
     */
    private $questionnaire;

    /**
     * @var int
     *
     * @ORM\Column(name="displayOrder", type="integer")
     */
    private $displayOrder;

    /**
     * @var int
     *
     * @ORM\Column(name="ignoreInScoring", type="boolean")
     */
    private $ignoreInScoring = false;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setIgnoreInScoring($ignoreInScoring)
    {
        $this->ignoreInScoring = $ignoreInScoring;

        return $this;
    }

    public function getIgnoreInScoring()
    {
        return $this->ignoreInScoring;
    }

    /**
     * Set displayOrder.
     *
     * @param int $displayOrder
     *
     * @return OrderQuestionnaireComponent
     */
    public function setDisplayOrder($displayOrder)
    {
        $this->displayOrder = $displayOrder;

        return $this;
    }

    /**
     * Get displayOrder.
     *
     * @return int
     */
    public function getDisplayOrder()
    {
        return $this->displayOrder;
    }

    /**
     * Set component.
     *
     * @param \Innova\SelfBundle\Entity\PhasedTest\Component $component
     *
     * @return OrderQuestionnaireComponent
     */
    public function setComponent(\Innova\SelfBundle\Entity\PhasedTest\Component $component = null)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Get component.
     *
     * @return \Innova\SelfBundle\Entity\PhasedTest\Component
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * Set questionnaire.
     *
     * @param \Innova\SelfBundle\Entity\Questionnaire $questionnaire
     *
     * @return OrderQuestionnaireComponent
     */
    public function setQuestionnaire(\Innova\SelfBundle\Entity\Questionnaire $questionnaire = null)
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    /**
     * Get questionnaire.
     *
     * @return \Innova\SelfBundle\Entity\Questionnaire
     */
    public function getQuestionnaire()
    {
        return $this->questionnaire;
    }
}
