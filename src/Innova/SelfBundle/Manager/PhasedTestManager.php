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
        if (!$this->entityManager->getRepository('InnovaSelfBundle:PhasedTest\Component')->findByTest($test)) {
            $componentTypes = $this->entityManager->getRepository('InnovaSelfBundle:PhasedTest\ComponentType')->findAll();
            foreach ($componentTypes as $type) {
                $this->generateComponent($test, $type);
            }
        }

        return $test;
    }

    public function generateComponent(Test $test, ComponentType $type)
    {
        if ($components = $this->entityManager->getRepository('InnovaSelfBundle:PhasedTest\Component')->findBy(array("test" => $test, "componentType" => $type))) {
            $count = count($components);
        } else {
            $count = 0;
        }

        $component = new Component();
        $component->setComponentType($type);
        $component->setAlternativeNumber($count);
        $component->setTest($test);

        $this->entityManager->persist($component);
        $this->entityManager->flush();

        return $this;
    }
}
