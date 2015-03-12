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
}
