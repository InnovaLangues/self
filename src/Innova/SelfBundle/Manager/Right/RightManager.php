<?php

namespace Innova\SelfBundle\Manager\Right;

use Innova\SelfBundle\Entity\Right\Right;
use Innova\SelfBundle\Entity\User;

class RightManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createRights($rights)
    {
        $em = $this->entityManager;

        foreach ($rights as $r) {
            if (!$em->getRepository("InnovaSelfBundle:Right\Right")->findOneByName($r[0])) {
                $right = new Right();
                $right->setName($r[0]);
                $right->setAttribute($r[2]);
                $right->setClass($r[3]);
                $right->setRightGroup($em->getRepository("InnovaSelfBundle:Right\RightGroup")->findOneByName($r[1]));
                $em->persist($right);
            }
        }

        $em->flush();

        return $this;
    }

    public function checkRight($rightName, User $user, $entity = null)
    {
        $em = $this->entityManager;

        $right = $em->getRepository("InnovaSelfBundle:Right\Right")->findOneByName($rightName);

        if ($right) {
            if ($right->getUsers()->contains($user)) {
                return true;
            }

            if ($entity &&  $right->getAttribute()) {
                $attribute = $right->getAttribute();
                $repoName = "InnovaSelfBundle:Right\\".$right->getClass();

                if ($em->getRepository($repoName)->findOneBy(array(
                    "target" => $entity,
                    $attribute => true,
                ))) {
                    return true;
                }
            }

            return false;
        } else {
            echo "probleme avec ".$rightName;
        }
    }

    public function toggleRight(Right $right, User $user)
    {
        $em = $this->entityManager;

        if ($right->getUsers()->contains($user)) {
            $right->removeUser($user);
        } else {
            $right->addUser($user);
        }
        $em->persist($right);
        $em->flush();

        return $this;
    }

    public function hasRightsOnGroup($groupClass, $user)
    {
        $em = $this->entityManager;
        $repoName = "InnovaSelfBundle:Right\\".$groupClass;

        switch ($groupClass) {
            case 'RightUserTest':
                $authorized = $em->getRepository("InnovaSelfBundle:Test")->findAuthorized($user);
                break;

            case 'RightUserSomeone':
                $authorized = $em->getRepository("InnovaSelfBundle:User")->findAuthorized($user);
                break;

            case 'RightUserGroup':
                $authorized = $em->getRepository("InnovaSelfBundle:Group")->findAuthorized($user);
                break;

            case 'RightUserSession':
                $authorized = $em->getRepository("InnovaSelfBundle:Session")->findAuthorized($user);
                break;
        }

        if ($authorized) {
            return true;
        }

        return false;
    }

    public function canEditTask(User $user, $task)
    {
        $em = $this->entityManager;
        // on vérifie d'abord que l'utilisateur à des droits globaux sur l'édition de tâche ou les droits sur la tâche en question
        if ($this->checkRight("right.edittask", $user, $task)) {
            return true;
        } else {
            // au besoin on vérifie que l'utlisateur à des droits d'édition sur les possibles tests liés à la tâche
            if ($tests = $em->getRepository("InnovaSelfBundle:Test")->findByTask($task)) {
                foreach ($tests as $test) {
                    if ($this->checkRight("right.edittasktest", $user, $test)) {
                        return true;
                    }
                }
            };
        }

        return false;
    }
}