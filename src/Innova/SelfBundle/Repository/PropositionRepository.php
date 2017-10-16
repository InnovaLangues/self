<?php

namespace Innova\SelfBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PropositionRepository extends EntityRepository
{
    public function getBySubquestionExcludingAnswers($subquestionId)
    {
        $dql = "SELECT p FROM Innova\SelfBundle\Entity\Proposition p
        LEFT JOIN p.media pm
        LEFT JOIN pm.mediaPurpose pmp
        WHERE p.subquestion = :subquestionId
        AND (pmp.id is NULL OR (pmp.name != 'reponse' OR (pmp.name = 'reponse' AND p.rightAnswer = 1)))";

        $query = $this->_em->createQuery($dql)
                ->setParameter('subquestionId', $subquestionId);

        return $query->getResult();
    }

    public function getByUserTraceAndSubquestion($subquestion, $user, $component, $session)
    {
        $dql = "SELECT p FROM Innova\SelfBundle\Entity\Proposition p
                INNER JOIN p.answers a
                LEFT JOIN a.trace t
                WHERE p.subquestion = :subquestion
                AND t.user = :user
                AND t.session = :session";

        if ($component) {
            $dql .= " AND t.component = :component";
        }

        $query = $this->_em->createQuery($dql)
                ->setParameter('subquestion', $subquestion)
                ->setParameter('session', $session)
                ->setParameter('user', $user);

        if ($component) {
            $query->setParameter('component', $component);
        }

        return $query->getResult();
    }
}
