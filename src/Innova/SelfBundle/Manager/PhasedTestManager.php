<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\PhasedTest\Component;
use Innova\SelfBundle\Entity\PhasedTest\ComponentType;

class PhasedTestManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function generateBaseComponents(Test $test)
    {
        $em = $this->entityManager;

        if (!$em->getRepository('InnovaSelfBundle:PhasedTest\Component')->findByTest($test)) {
            $componentTypes = $em->getRepository('InnovaSelfBundle:PhasedTest\ComponentType')->findAll();
            foreach ($componentTypes as $type) {
                $this->generateComponent($test, $type);
            }
        }

        return $test;
    }

    public function generateComponent(Test $test, ComponentType $type)
    {
        $em = $this->entityManager;

        if ($components = $em->getRepository('InnovaSelfBundle:PhasedTest\Component')->findBy(array("test" => $test, "componentType" => $type))) {
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

    public function addQuestionnaireToComponent(Questionnaire $questionnaire, Component $component)
    {
        $em = $this->entityManager;

        if ($orderedTasks = $em->getRepository('InnovaSelfBundle:PhasedTest\OrderQuestionnaireComponent')->findByComponent($component)) {
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

    public function removeQuestionnaireFromComponent(Questionnaire $questionnaire, Component $component)
    {
        $em = $this->entityManager;

        $questionnaireToRemove = $em->getRepository('InnovaSelfBundle:PhasedTest\OrderQuestionnaireComponent')->findOneBy(array(
                                                                                            'component' => $component,
                                                                                            'questionnaire' => $questionnaire,
                                                                                        ));
        $em->remove($questionnaireToRemove);
        $em->flush();

        $this->recalculateOrder($component);

        return $this;
    }

    public function saveOrder($newOrderArray, Component $component)
    {
        $em = $this->entityManager;

        $i = 0;
        foreach ($newOrderArray as $questionnaireId) {
            $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
            $i++;
            $orderQuestionnaireComponent = $em->getRepository('InnovaSelfBundle:PhasedTest\OrderQuestionnaireComponent')->findOneBy(array("questionnaire" => $questionnaire, "component" => $component));
            $orderQuestionnaireComponent->setDisplayOrder($i+1);
            $em->persist($orderQuestionnaireComponent);
        }
        $em->flush();

        return $this;
    }

    public function recalculateOrder(Component $component)
    {
        $em = $this->entityManager;

        $orderedQuestionnaires = $em->getRepository('InnovaSelfBundle:PhasedTest\OrderQuestionnaireTest')->findByComponent($component);

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
        $orderedComponents = $em->getRepository('InnovaSelfBundle:PhasedTest\Component')->findBy(array("test" => $test, "componentType" => $type));
        foreach ($orderedComponents as $orderedComponent) {
            $orderedComponent->setAlternativeNumber($i);
            $em->persist($orderedComponent);
            $i++;
        }
        $em->flush();
    }
}
