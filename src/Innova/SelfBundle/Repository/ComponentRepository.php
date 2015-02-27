<?php

namespace Innova\SelfBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ComponentRepository extends EntityRepository
{
    public function findByTrace($trace)
    {
        $dql = "SELECT c FROM Innova\SelfBundle\Entity\PhasedTest\Component c
        LEFT JOIN c.orderQuestionnaireComponents co
        WHERE c.test = :test
        WHERE EXISTS (
            SELECT oqc FROM Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent oqc
            WHERE oqc.component = c
            AND oqc.questionnaire = :questionnaire
        )
        ";

        $query = $this->_em->createQuery($dql)
                ->setParameter('test', $trace->getTest())
                ->setParameter('questionnaire', $trace->getQuestionnaire());

        return $query->getSingleResult();
    }
}
