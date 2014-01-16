<?php

namespace Innova\SelfBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TestRepository extends EntityRepository
{
    public function exportCsvByTest($testId)
    {
        $dql = '
            SELECT t, tq, tr, tu, ta, tp

            FROM Innova\SelfBundle\Entity\Test t

            JOIN t.questionnaires tq
            JOIN tq.traces tr
            JOIN tr.user tu
            JOIN tr.answers ta
            JOIN ta.proposition tp


            WHERE t.id = :testId
        ';
        $query = $this->_em->createQuery($dql)
                ->setParameter('testId', $testId);

        return $query->getOneOrNullResult();
    }
}
