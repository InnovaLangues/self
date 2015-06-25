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

    public function getByUserBySessionBySkill($user, $session, $skill)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t
        LEFT JOIN t.questionnaire q
        WHERE t.user = :user
        AND t.session = :session
        AND q.skill = :skill";

        $query = $this->_em->createQuery($dql)
                ->setParameter('user', $user)
                ->setParameter('session', $session)
                ->setParameter('skill', $skill);

        return $query->getResult();
    }
}
