<?php

namespace Innova\SelfBundle\Manager\Editor\PhasedTest;

use Innova\SelfBundle\Entity\PhasedTest\ComponentType;

class ComponentTypeManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create($array)
    {
        $em = $this->entityManager;

        foreach ($array as $el) {
            if (!$this->findByName($el)) {
                $r = new ComponentType();
                $r->setName($el);
                $em->persist($r);
            }
        }

        $em->flush();

        return true;
    }

    public function delete($array)
    {
        $em = $this->entityManager;

        foreach ($array as $el) {
            if ($r = $this->findByName($el)) {
                $existingComponents = $em->getRepository('InnovaSelfBundle:PhasedTest\Component')->findByComponentType($r);
                foreach ($existingComponents as $existingComponent) {
                    $em->remove($existingComponent);
                }
                $em->remove($r);
            }
        }

        $em->flush();

        return true;
    }

    private function findByName($name)
    {
        $em = $this->entityManager;

        return $em->getRepository('InnovaSelfBundle:PhasedTest\ComponentType')->findOneByName($name);
    }
}
