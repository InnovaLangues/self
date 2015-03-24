<?php

namespace Innova\SelfBundle\Manager\Editor\PhasedTest;

use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\PhasedTest\Component;
use Innova\SelfBundle\Entity\PhasedTest\ComponentType;
use Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent;

class PhasedTestManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
        $this->componentRepo = $this->entityManager->getRepository('InnovaSelfBundle:PhasedTest\Component');
        $this->componentTypeRepo = $this->entityManager->getRepository('InnovaSelfBundle:PhasedTest\ComponentType');
        $this->orderQuestionnaireComponentRepo = $this->entityManager->getRepository('InnovaSelfBundle:PhasedTest\OrderQuestionnaireComponent');
        $this->questionnaireRepo = $this->entityManager->getRepository('InnovaSelfBundle:Questionnaire');
    }

    public function generateBaseComponents(Test $test)
    {
        if (!$this->componentRepo->findByTest($test)) {
            $componentTypes = $this->componentTypeRepo->findAll();
            foreach ($componentTypes as $type) {
                $this->generateComponent($test, $type);
            }
        }

        return $test;
    }

    public function generateComponent(Test $test, ComponentType $type)
    {
        $em = $this->entityManager;

        if ($components = $this->componentRepo->findBy(array("test" => $test, "componentType" => $type))) {
            $count = count($components);
        } else {
            $count = 0;
        }

        $component = new Component();
        $component->setComponentType($type);
        $component->setAlternativeNumber($count);
        $component->setTest($test);

        $em->persist($component);
        $em->flush();

        return $this;
    }

    public function removeComponent(Test $test, Component $component)
    {
        $em = $this->entityManager;
        $type = $component->getComponentType();

        $em->remove($component);
        $em->flush();

        $this->reorganizeAlternative($test, $type);

        return $this;
    }

    public function getPotentialQuestionnaires(Component $component)
    {
        $questionnaires = $this->questionnaireRepo->findPotentialByComponent($component);

        return $questionnaires;
    }

    public function addQuestionnaireToComponent(Questionnaire $questionnaire, Component $component)
    {
        $em = $this->entityManager;

        if ($orderedTasks = $this->orderQuestionnaireComponentRepo->findByComponent($component)) {
            $count = count($orderedTasks);
        } else {
            $count = 0;
        }

        $orderedTask = new OrderQuestionnaireComponent();
        $orderedTask->setQuestionnaire($questionnaire);
        $orderedTask->setComponent($component);
        $orderedTask->setDisplayOrder($count + 1);

        $em->persist($orderedTask);
        $em->flush();

        return $this;
    }

    public function removeQuestionnaireFromComponent(OrderQuestionnaireComponent $orderQuestionnaireComponent)
    {
        $component = $orderQuestionnaireComponent->getComponent();

        $em = $this->entityManager;
        $em->remove($orderQuestionnaireComponent);
        $em->flush();

        $this->recalculateOrder($component);

        return $this;
    }

    public function saveOrder($newOrderArray)
    {
        $em = $this->entityManager;

        $i = 0;
        foreach ($newOrderArray as $orderId) {
            $i++;
            $orderQuestionnaireComponent = $this->orderQuestionnaireComponentRepo->find($orderId);
            $orderQuestionnaireComponent->setDisplayOrder($i);
            $em->persist($orderQuestionnaireComponent);
        }
        $em->flush();

        return $this;
    }

    public function recalculateOrder(Component $component)
    {
        $em = $this->entityManager;

        $orderedQuestionnaires = $this->orderQuestionnaireComponentRepo->findByComponent($component);

        $i = 1;
        foreach ($orderedQuestionnaires as $orderedQuestionnaire) {
            $orderedQuestionnaire->setDisplayOrder($i);
            $em->persist($orderedQuestionnaire);
            $i++;
        }
        $em->flush();

        return $this;
    }

    public function reorganizeAlternative(Test $test, ComponentType $type)
    {
        $em = $this->entityManager;

        $i = 0;
        $orderedComponents = $this->componentRepo->findBy(array("test" => $test, "componentType" => $type));
        foreach ($orderedComponents as $orderedComponent) {
            $orderedComponent->setAlternativeNumber($i);
            $em->persist($orderedComponent);
            $i++;
        }
        $em->flush();
    }
}
