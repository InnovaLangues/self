<?php

namespace Innova\SelfBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getByTraceOnTest($testId)
    {
        $dql = "SELECT u FROM Innova\SelfBundle\Entity\User u
        LEFT JOIN u.traces ut
        WHERE ut.test = :testId";

        $query = $this->_em->createQuery($dql)
                ->setParameter('testId', $testId);

        return $query->getResult();
    }

    public function getByTraceOnSession($sessionId)
    {
        $dql = "SELECT u FROM Innova\SelfBundle\Entity\User u
        LEFT JOIN u.traces ut
        WHERE ut.session = :sessionId";

        $query = $this->_em->createQuery($dql)
                ->setParameter('sessionId', $sessionId);

        return $query->getResult();
    }

    public function findBySession($session)
    {
        $dql = "SELECT u FROM Innova\SelfBundle\Entity\User u
    	WHERE EXISTS (
            SELECT t FROM Innova\SelfBundle\Entity\Trace t
            WHERE t.user = u
            AND t.session = :session
        )";

        $query = $this->_em->createQuery($dql)
                ->setParameter('session', $session);

        return $query->getResult();
    }

    public function findAnotherByEmail($user)
    {
        $dql = "SELECT u FROM Innova\SelfBundle\Entity\User u
        WHERE u.email = :email
        ";

        if ($user->getId()) {
            $dql .= " AND u.id != ".$user->getId();
        }

        $query = $this->_em->createQuery($dql)
                ->setParameter('email', $user->getEmail());

        return $query->getResult();
    }

    public function findAnotherByUsername($user)
    {
        $dql = "SELECT u FROM Innova\SelfBundle\Entity\User u
        WHERE u.username = :username
        ";

        if ($user->getId()) {
            $dql .= " AND u.id != ".$user->getId();
        }

        $query = $this->_em->createQuery($dql)
                ->setParameter('username', $user->getUsername());

        return $query->getResult();
    }

    public function groupWithUserAndSession($user, $session)
    {
        $dql = "SELECT g FROM Innova\SelfBundle\Entity\Group g
        WHERE :user MEMBER OF g.users AND :session MEMBER OF g.sessions
        ";

        $query = $this->_em->createQuery($dql)
                ->setParameter('session', $session)
                ->setParameter('user', $user);

        return $query->getResult();
    }

    public function findAuthorized($user)
    {
        $dql = "SELECT u FROM Innova\SelfBundle\Entity\User u
        WHERE EXISTS (
            SELECT r FROM Innova\SelfBundle\Entity\Right\RightUserSomeone r
            WHERE r.user = :user
            AND r.target = u
            AND (
                r.canDelete = 1 OR
                r.canDeleteTrace = 1 OR
                r.canEdit = 1 OR
                r.canDeleteTrace = 1 OR
                r.canEditRights = 1
                )
            )
        ";

        $query = $this->_em->createQuery($dql)
                                ->setParameter('user', $user);

        return $query->getResult();
    }
}
