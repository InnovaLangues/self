<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\ClueType;

class ClueTypeManager
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
            $name = $el[0];
            $color = $el[1];
            if (!$clueType = $this->findByName($name)) {
                $clueType = new ClueType();
                $clueType->setName($name);
                $clueType->setColor($color);
                $em->persist($clueType);
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
                $em->remove($r);
            }
        }

        $em->flush();

        return true;
    }

    private function findByName($name)
    {
        $em = $this->entityManager;

        return $em->getRepository('InnovaSelfBundle:ClueType')->findOneByName($name);
    }
}
