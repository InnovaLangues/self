<?php

namespace Innova\SelfBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TraceRepository extends EntityRepository
{
    public function getByUserAndSession($userId, $sessionId)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t
        WHERE t.user = :userId
        AND t.session = :sessionId";

        $query = $this->_em->createQuery($dql)
                ->setParameter('userId', $userId)
                ->setParameter('sessionId', $sessionId);

        return $query->getResult();
    }

    public function getBySessionAndQuestionnaire($sessionId, $questionnaireId)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t
        WHERE t.questionnaire = :questionnaireId
        AND t.session = :sessionId";

        $query = $this->_em->createQuery($dql)
                ->setParameter('questionnaireId', $questionnaireId)
                ->setParameter('sessionId', $sessionId);

        return $query->getResult();
    }

    public function getByUserAndSessionAndQuestionnaire($userId, $sessionId, $questionnaireId)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t
        WHERE t.user = :userId
        AND t.session = :sessionId
        AND t.questionnaire = :questionnaireId";

        $query = $this->_em->createQuery($dql)
                ->setParameter('userId', $userId)
                ->setParameter('sessionId', $sessionId)
                ->setParameter('questionnaireId', $questionnaireId);

        return $query->getResult();
    }
}
