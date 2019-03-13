<?php

namespace Innova\SelfBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Innova\SelfBundle\Entity\Session;

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

    public function findAllLight()
    {
        $dql = "SELECT u.id, u.username, u.lastName, u.firstName, u.email, u.roles FROM Innova\SelfBundle\Entity\User u";

        $query = $this->_em->createQuery($dql);

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

    public function getBySomethingLike($something)
    {
        $dql = "SELECT u FROM Innova\SelfBundle\Entity\User u
         WHERE u.username LIKE :something
         OR u.email LIKE :something
         OR u.lastName LIKE :something
         OR u.firstName LIKE :something
         ";

        $query = $this->_em->createQuery($dql)
                ->setParameter('something', '%'.$something.'%');

        return $query->getResult();
    }

    public function findLightByInstitution($institution)
    {
        $dql = "SELECT u.id FROM Innova\SelfBundle\Entity\User u
        WHERE u.institution = :institution";

        $query = $this->_em->createQuery($dql)
                 ->setParameter('institution', $institution);

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

    public function countBySession(Session $session, \DateTime $createdAfter = null): int
    {
        $dql = "
            SELECT COUNT(DISTINCT u.id) as total FROM Innova\SelfBundle\Entity\User u
            JOIN u.traces ut
            JOIN ut.session s
            WHERE ut.session = :session
        ";

        $parameters = ['session' => $session];

        if ($createdAfter !== null) {
            $dql .= ' AND ut.date > :createdAfter';
            $parameters['createdAfter'] = $createdAfter;
        }

        $query = $this->_em->createQuery($dql)
            ->setParameters($parameters);

        return (int) $query->getSingleResult()['total'];
    }

    public function findBySessionAndDates($session, $startDate, $endDate)
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->leftJoin('u.traces', 't')
            ->where('t.session = :session')
            ->setParameter('session', $session)
        ;

        if ($startDate !== null) {
            $qb
                ->andWhere('t.date >= :startDate')
                ->setParameter('startDate', $startDate)
            ;
        }

        if ($endDate !== null) {
            $qb
                ->andWhere('t.date <= :endDate')
                ->setParameter('endDate', $endDate)
            ;
        }

        return $qb->getQuery()->getResult();
    }

    public function findLightBySessionAndDates($session, $startDate, $endDate)
    {
        $dql = "SELECT DISTINCT u.id FROM Innova\SelfBundle\Entity\User u
        LEFT JOIN u.traces ut
        WHERE ut.session = :session
        AND (ut.date >= :startDate AND ut.date <= :endDate)";

        $query = $this->_em->createQuery($dql)
                ->setParameter('session', $session)
                ->setParameter('startDate', $startDate)
                ->setParameter('endDate', $endDate);

        return $query->getResult();
    }

    public function findAnotherByEmail($user)
    {
        $dql = "SELECT u FROM Innova\SelfBundle\Entity\User u
        WHERE u.email = :email
        ";

        if ($user->getId()) {
            $dql .= ' AND u.id != '.$user->getId();
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
            $dql .= ' AND u.id != '.$user->getId();
        }

        $query = $this->_em->createQuery($dql)
                ->setParameter('username', $user->getUsername());

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

    public function hasAnyGlobalRight($user)
    {
        $dql = "SELECT r FROM Innova\SelfBundle\Entity\Right\Right r
        LEFT JOIN r.users u
        WHERE u = :user";

        $query = $this->_em->createQuery($dql)
                ->setParameter('user', $user);

        $count = count($query->getResult());

        if ($count > 0) {
            return true;
        }

        return false;
    }

    public function getTestWithRights($user)
    {
        $dql = "SELECT r FROM Innova\SelfBundle\Entity\Right\RightUserTest r
        WHERE r.user = :user";

        $query = $this->_em->createQuery($dql)
                ->setParameter('user', $user);

        return $query->getResult();
    }

    public function getSessionsWithRights($user)
    {
        $dql = "SELECT r FROM Innova\SelfBundle\Entity\Right\RightUserSession r
        WHERE r.user = :user";

        $query = $this->_em->createQuery($dql)
                ->setParameter('user', $user);

        return $query->getResult();
    }

    public function getRegisteredCount()
    {
        $dql = 'SELECT COUNT(u.id)from Innova\SelfBundle\Entity\User u';
        $query = $this->_em->createQuery($dql);
        $count = $query->getSingleScalarResult();

        return $count;
    }

    public function findByRole($role)
    {
        $dql = "SELECT u FROM Innova\SelfBundle\Entity\User u
         WHERE u.roles LIKE :role";

        $query = $this->_em->createQuery($dql)
                ->setParameter('role', '%'.$role.'%');

        return $query->getResult();
    }

    public function findByIds(array $ids): array
    {
        $qb = $this->createQueryBuilder('u')
            ->where('u.id IN (:ids)')
            ->setParameter('ids', $ids)
        ;

        return $qb->getQuery()->getScalarResult();
    }

    public function remove(array $ids)
    {
        $query = $this->getEntityManager()
            ->createQuery('DELETE FROM Innova\SelfBundle\Entity\User u WHERE u.id IN (:ids)');

        $query->execute(['ids' => $ids]);
    }
}
