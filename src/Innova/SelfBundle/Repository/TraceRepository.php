<?php

namespace Innova\SelfBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TraceRepository extends EntityRepository
{

    public function getByUserAndTestAndQuestionnaire($userId, $testId, $questionnaireId)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t
        WHERE t.user = :userId
        AND t.test = :testId
        AND t.questionnaire = :questionnaireId";

        $query = $this->_em->createQuery($dql)
                ->setParameter('userId', $userId)
                ->setParameter('testId', $testId)
                ->setParameter('questionnaireId', $questionnaireId);

        return $query->getResult();
    }

    public function getByUserAndTest($userId, $testId)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t
        WHERE t.user = :userId
        AND t.test = :testId";

        $query = $this->_em->createQuery($dql)
                ->setParameter('userId', $userId)
                ->setParameter('testId', $testId);

        return $query->getResult();
    }

    public function getByTestAndQuestionnaire($testId, $questionnaireId)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t
        WHERE t.questionnaire = :questionnaireId
        AND t.test = :testId";

        $query = $this->_em->createQuery($dql)
                ->setParameter('questionnaireId', $questionnaireId)
                ->setParameter('testId', $testId);

        return $query->getResult();
    }
   
}
