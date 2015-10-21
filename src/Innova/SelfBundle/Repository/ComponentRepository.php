<?php

namespace Innova\SelfBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;

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
        )";

        $query = $this->_em->createQuery($dql)
                ->setParameter('test', $test)
                ->setParameter('session', $session)
                ->setParameter('user', $user);

        return $query->getResult();
    }

    public function findNotDoneByTypeByUserByTest($user, $test, $type)
    {
        $dql = "SELECT c FROM Innova\SelfBundle\Entity\PhasedTest\Component c
        WHERE NOT EXISTS (
            SELECT t FROM Innova\SelfBundle\Entity\Trace t
            WHERE t.component = c
            AND t.user = :user
            AND t.test = :test
        )
        AND c.componentType = :type
        AND c.test = :test
        ";

        $query = $this->_em->createQuery($dql)
                ->setParameter('test', $test)
                ->setParameter('type', $type)
                ->setParameter('user', $user);

        return $query->getResult();
    }

    public function getByTestAndQuestionnaire(Test $test, Questionnaire $questionnaire)
    {
        $dql = "SELECT c FROM Innova\SelfBundle\Entity\PhasedTest\Component c
                LEFT JOIN c.orderQuestionnaireComponents o
                WHERE o.questionnaire = :questionnaire
                AND c.test = :test
            ";

        $query = $this->_em->createQuery($dql)
                ->setParameter('test', $test)
                ->setParameter('questionnaire', $questionnaire);

        return $query->getOneOrNullResult();

    }
}
