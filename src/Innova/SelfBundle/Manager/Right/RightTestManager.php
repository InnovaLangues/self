<?php

namespace Innova\SelfBundle\Manager\Right;

use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Right\RightUserTest;

class RightTestManager
{
    protected $entityManager;
    protected $rightManager;

    public function __construct($entityManager, $rightManager)
    {
        $this->entityManager = $entityManager;
        $this->rightManager = $rightManager;
    }

    public function toggleAll(User $user, Test $test, $giveRight)
    {
        $em = $this->entityManager;

        $r = $em->getRepository("InnovaSelfBundle:Right\RightUserTest")->findOneBy(array("user" => $user, "target" => $test));

        if (!$r) {
            $r = new RightUserTest();
            $r->setUser($user);
            $r->settarget($test);
        }
        $r->setCanCreate($giveRight);
        $r->setCanEdit($giveRight);
        $r->setCanDelete($giveRight);
        $r->setCanList($giveRight);
        $r->setCanDuplicate($giveRight);
        $r->setCanManageSession($giveRight);
        $r->setCanManageTask($giveRight);
        $r->setCanAddTask($giveRight);
        $r->setCanReorderTasks($giveRight);
        $r->setCanDeleteTask($giveRight);
        $r->setCanEditTask($giveRight);

        $em->persist($r);
        $em->flush();

        $this->rightManager->adminToggle($user);

        return $giveRight;
    }
}
