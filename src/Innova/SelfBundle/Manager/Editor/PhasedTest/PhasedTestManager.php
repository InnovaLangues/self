<?php

namespace Innova\SelfBundle\Manager\Editor\PhasedTest;

use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\PhasedTest\Component;
use Innova\SelfBundle\Entity\PhasedTest\ComponentType;
use Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent;
use Innova\SelfBundle\Entity\PhasedTest\PhasedParams;

class PhasedTestManager
{
    protected $entityManager;
    protected $questionnaireManager;
    protected $questionManager;
    protected $componentRepo;
    protected $componentTypeRepo;
    protected $ordertaskCompoRepo;
    protected $questionnaireRepo;

    public function __construct($entityManager, $questionnaireManager, $questionManager)
    {
        $this->entityManager = $entityManager;
        $this->questionnaireManager = $questionnaireManager;
        $this->questionManager = $questionManager;
        $this->componentRepo = $this->entityManager->getRepository('InnovaSelfBundle:PhasedTest\Component');
        $this->componentTypeRepo = $this->entityManager->getRepository('InnovaSelfBundle:PhasedTest\ComponentType');
        $this->ordertaskCompoRepo = $this->entityManager->getRepository('InnovaSelfBundle:PhasedTest\OrderQuestionnaireComponent');
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

    public function checkLevel(Test $test)
    {
        $tasks = $this->questionnaireRepo->findByTestAndMissingLevel($test);

        return $tasks;
    }

    public function generateComponent(Test $test, ComponentType $type)
    {
        $count = ($components = $this->componentRepo->findBy(array('test' => $test, 'componentType' => $type)))
            ? count($components)
            : 0;

        $component = new Component();
        $component->setComponentType($type);
        $component->setAlternativeNumber($count);
        $component->setTest($test);

        $this->entityManager->persist($component);
        $this->entityManager->flush();

        return $this;
    }

    public function removeComponent(Test $test, Component $component)
    {
        $type = $component->getComponentType();

        $this->entityManager->remove($component);
        $this->entityManager->flush();

        $this->reorganizeAlternative($test, $type);

        return $this;
    }

    public function getPotentialQuestionnaires(Component $component)
    {
        $questionnaires = $this->questionnaireRepo->findPotentialByComponent($component);

        return $questionnaires;
    }

    public function createQuestionnaireToComponent(Component $component)
    {
        $questionnaire = $this->questionnaireManager->createQuestionnaire();
        $this->questionManager->createQuestion($questionnaire);

        $this->addQuestionnaireToComponent($questionnaire, $component);

        return $questionnaire;
    }

    public function addQuestionnaireToComponent(Questionnaire $questionnaire, Component $component)
    {
        $count = ($orderedTasks = $this->ordertaskCompoRepo->findByComponent($component))
            ? count($orderedTasks)
            : 0;

        $orderedTask = new OrderQuestionnaireComponent();
        $orderedTask->setQuestionnaire($questionnaire);
        $orderedTask->setComponent($component);
        $orderedTask->setDisplayOrder($count + 1);

        $this->entityManager->persist($orderedTask);
        $this->entityManager->flush();

        return $this;
    }

    public function removeQuestionnaireFromComponent(OrderQuestionnaireComponent $orderQuestionnaireComponent)
    {
        $component = $orderQuestionnaireComponent->getComponent();

        $this->entityManager->remove($orderQuestionnaireComponent);
        $this->entityManager->flush();

        $this->recalculateOrder($component);

        return $this;
    }

    public function saveOrder($newOrderArray)
    {
        $i = 0;
        foreach ($newOrderArray as $orderId) {
            ++$i;
            $orderQuestionnaireComponent = $this->ordertaskCompoRepo->find($orderId);
            $orderQuestionnaireComponent->setDisplayOrder($i);
            $this->entityManager->persist($orderQuestionnaireComponent);
        }
        $this->entityManager->flush();

        return $this;
    }

    public function recalculateOrder(Component $component)
    {
        $orderedQuestionnaires = $this->ordertaskCompoRepo->findByComponent($component);

        $i = 1;
        foreach ($orderedQuestionnaires as $orderedQuestionnaire) {
            $orderedQuestionnaire->setDisplayOrder($i);
            $this->entityManager->persist($orderedQuestionnaire);
            ++$i;
        }
        $this->entityManager->flush();

        return $this;
    }

    public function reorganizeAlternative(Test $test, ComponentType $type)
    {
        $i = 0;
        $orderedComponents = $this->componentRepo->findBy(array('test' => $test, 'componentType' => $type));
        foreach ($orderedComponents as $orderedComponent) {
            $orderedComponent->setAlternativeNumber($i);
            $this->entityManager->persist($orderedComponent);
            ++$i;
        }
        $this->entityManager->flush();
    }

    public function initializeParams()
    {
        $params = new PhasedParams();
        $this->entityManager->persist($params);
        $this->entityManager->flush();

        return $params;
    }
}
