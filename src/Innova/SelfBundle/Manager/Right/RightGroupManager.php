<?php

namespace Innova\SelfBundle\Manager\Right;

use Innova\SelfBundle\Entity\Right\RightGroup;

class RightGroupManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createGroups($groups)
    {
        $em = $this->entityManager;

        foreach ($groups as $g) {
            if (!$em->getRepository("InnovaSelfBundle:Right\RightGroup")->findByName($g)) {
                $group = new RightGroup();
                $group->setName($g);
                $em->persist($group);
            }
        }

        $em->flush();

        return $this;
    }
}
