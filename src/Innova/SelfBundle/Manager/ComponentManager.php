<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\PhasedTest\Component;
use Innova\SelfBundle\Entity\Test;

class ComponentManager
{
    protected $entityManager;
    protected $orderquestionnairecomponentManager;

    public function __construct($entityManager, $orderquestionnairecomponentManager)
    {
        $this->entityManager = $entityManager;
        $this->orderquestionnairecomponentManager = $orderquestionnairecomponentManager;
    }

    public function duplicate(Component $component, Test $test)
    {
        $type = $component->getComponentType();
        $alternativeNumber = $component->getAlternativeNumber();
        $orderQuestionnaireComponents = $component->getOrderQuestionnaireComponents();

        $newComponent = new Component();
        $newComponent->setComponentType($type);
        $newComponent->setTest($test);
        $newComponent->setAlternativeNumber($alternativeNumber);

        foreach ($orderQuestionnaireComponents as $orderQuestionnaireComponent) {
            $newOrderQuestionnaireComponent = $this->orderquestionnairecomponentManager->duplicate($orderQuestionnaireComponent, $newComponent);
            $newComponent->addOrderQuestionnaireComponent($newOrderQuestionnaireComponent);
            echo "+1orderQ";
        }

        $this->entityManager->persist($newComponent);
        $this->entityManager->flush();

        return $newComponent;
    }
}
