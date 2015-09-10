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
        if ($component) {
            $dql = "SELECT p FROM Innova\SelfBundle\Entity\Proposition p
                WHERE p.subquestion = :subquestion
                AND EXISTS (
                    SELECT a FROM Innova\SelfBundle\Entity\Answer a
                    LEFT JOIN a.trace t
                    WHERE a.subquestion = :subquestion
                    AND a.proposition = p
                    AND t.user = :user
                    AND t.session = :session
                    AND t.component = :component
                )
            ";

            $query = $this->_em->createQuery($dql)
                ->setParameter('subquestion', $subquestion)
                ->setParameter('session', $session)
                ->setParameter('component', $component)
                ->setParameter('user', $user);
        } else {
            $dql = "SELECT p FROM Innova\SelfBundle\Entity\Proposition p
                WHERE p.subquestion = :subquestion
                AND EXISTS (
                    SELECT a FROM Innova\SelfBundle\Entity\Answer a
                    LEFT JOIN a.trace t
                    WHERE a.subquestion = :subquestion
                    AND a.proposition = p
                    AND t.user = :user
                    AND t.session = :session
                )
            ";

            $query = $this->_em->createQuery($dql)
                ->setParameter('subquestion', $subquestion)
                ->setParameter('session', $session)
                ->setParameter('user', $user);
        }

        return $query->getResult();
    }
}
