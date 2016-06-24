<?php

namespace Innova\SelfBundle\Manager\Editor\PhasedTest;

use Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent;
use Innova\SelfBundle\Entity\PhasedTest\Component;

class OrderQuestionnaireComponentManager
{
    protected $entityManager;
    protected $questionnaireManager;

    public function __construct($entityManager, $questionnaireManager)
    {
        $this->entityManager = $entityManager;
        $this->questionnaireManager = $questionnaireManager;
    }

    public function duplicate(OrderQuestionnaireComponent $orderQuestionnaireComponent, Component $component)
    {
        $displayOrder = $orderQuestionnaireComponent->getDisplayOrder();
        $task = $orderQuestionnaireComponent->getQuestionnaire();
        $newTask = $this->questionnaireManager->duplicate($task);

        $newOrderQuestionnaireComponent = new OrderQuestionnaireComponent();
        $newOrderQuestionnaireComponent->setComponent($component);
        $newOrderQuestionnaireComponent->setDisplayOrder($displayOrder);
        $newOrderQuestionnaireComponent->setQuestionnaire($newTask);

        $this->entityManager->persist($newOrderQuestionnaireComponent);
        $this->entityManager->flush();

        return $newOrderQuestionnaireComponent;
    }

    public function toggleIgnoreInScoring(OrderQuestionnaireComponent $orderQuestionnaireComponent)
    {
        $ignore = $orderQuestionnaireComponent->getIgnoreInScoring() ? false : true;
        $orderQuestionnaireComponent->setIgnoreInScoring($ignore);

        $this->entityManager->persist($orderQuestionnaireComponent);
        $this->entityManager->flush();

        return;
    }
}
