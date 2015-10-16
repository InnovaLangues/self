<?php

namespace Innova\SelfBundle\Manager\Right;

use Innova\SelfBundle\Entity\Right\Right;
use Innova\SelfBundle\Entity\User;
use FOS\UserBundle\Util\UserManipulator;

class RightManager
{
    protected $entityManager;
    protected $manipulator;

    public function __construct($entityManager, UserManipulator $manipulator)
    {
        $this->entityManager = $entityManager;
        $this->manipulator = $manipulator;
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

    /**  
     * @param string $rightName
     */
    public function checkRight($rightName, User $user, $entity = null)
    {
        $em = $this->entityManager;

        $right = $em->getRepository("InnovaSelfBundle:Right\Right")->findOneByName($rightName);

        if ($right) {
            if ($right->getUsers()->contains($user)) {
                return true;
            }

            if ($entity && $right->getAttribute()) {
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
            echo "Le droit testé n'existe pas (".$rightName.")";
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

        $this->adminToggle($user);

        return $this;
    }

    public function hasAnyRight(User $user)
    {
        if ($this->hasAnyGlobalRight($user) || $this->hasAnyLimitedRight($user)) {
            return true;
        }

        return false;
    }

    public function adminToggle(User $user)
    {
        if ($this->hasAnyRight($user)) {
            $this->manipulator->addRole($user->getUsername(), "ROLE_SUPER_ADMIN");
        } else {
            $this->manipulator->removeRole($user->getUsername(), "ROLE_SUPER_ADMIN");
        }
    }

    public function hasAnyGlobalRight(User $user)
    {
        $em = $this->entityManager;

        $hasAnyGlobalRight = $em->getRepository("InnovaSelfBundle:User")->hasAnyGlobalRight($user);

        return $hasAnyGlobalRight;
    }

    public function hasAnyLimitedRight(User $user)
    {
        $em = $this->entityManager;

        if (count($em->getRepository("InnovaSelfBundle:Right\RightUserSession")->findByUser($user)) > 0) {
            return true;
        };

        if (count($em->getRepository("InnovaSelfBundle:Right\RightUserTest")->findByUser($user)) > 0) {
            return true;
        };

        if (count($em->getRepository("InnovaSelfBundle:Right\RightUserGroup")->findByUser($user)) > 0) {
            return true;
        };

        return false;
    }

    public function hasRightsOnGroup($groupClass, $user)
    {
        $em = $this->entityManager;

        switch ($groupClass) {
            case 'RightUserTest':
                $authorized = $em->getRepository("InnovaSelfBundle:Test")->findAuthorized($user);
                break;

            case 'RightUserSomeone':
                $authorized = $em->getRepository("InnovaSelfBundle:User")->findAuthorized($user);
                break;

            case 'RightUserSession':
                $authorized = $em->getRepository("InnovaSelfBundle:Session")->findAllAuthorized($user);
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
