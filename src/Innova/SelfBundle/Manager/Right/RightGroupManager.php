<?php

namespace Innova\SelfBundle\Manager\Right;

use Innova\SelfBundle\Entity\Right\RightGroup;
use Innova\SelfBundle\Entity\User;

class RightGroupManager
{
    protected $entityManager;
    protected $rightManager;
    protected $manipulator;

    public function __construct($entityManager, $rightManager, $manipulator)
    {
        $this->entityManager = $entityManager;
        $this->rightManager = $rightManager;
        $this->manipulator = $manipulator;
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

    public function toggleAll(User $user, RightGroup $rightGroup)
    {
        $em = $this->entityManager;

        $rights = $rightGroup->getRights();
        $toggle = ($rights[0]->getUsers()->contains($user)) ? false : true;
        $rm = ;

        foreach ($rights as $right) {
            if ($toggle) {
                if (!$right->getUsers()->contains($user)) {
                    $right->addUser($user);
                }
            } else {
                if ($right->getUsers()->contains($user)) {
                    $right->removeUser($user);
                }
            }
            $em->persist($right);
        }

        $em->flush();

        $this->rightManager->adminToggle($user)
    }
}
