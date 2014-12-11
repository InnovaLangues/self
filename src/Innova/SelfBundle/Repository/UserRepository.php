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
}
