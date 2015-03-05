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

    public function findDoneByUserByTestBySession($user, $test, $session)
    {
        $dql = "SELECT c FROM Innova\SelfBundle\Entity\PhasedTest\Component c
        WHERE EXISTS (
            SELECT t FROM Innova\SelfBundle\Entity\Trace t
            WHERE t.component = c
            AND t.user = :user
            AND t.session = :session
            AND t.test = :test
        )
        GROUP BY c";

        $query = $this->_em->createQuery($dql)
                ->setParameter('test', $test)
                ->setParameter('session', $session)
                ->setParameter('user', $user);

        return $query->getResult();
    }
}
