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
        AND pmp.name != 'reponse'";

        $query = $this->_em->createQuery($dql)
                ->setParameter('subquestionId', $subquestionId);

        return $query->getResult();
    }
}
