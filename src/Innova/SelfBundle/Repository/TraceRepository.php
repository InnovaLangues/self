<?php

namespace Innova\SelfBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Innova\SelfBundle\Entity\Session;

class TraceRepository extends EntityRepository
{
    public function findBySession(Session $session)
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.session', 's')
            ->addSelect('s')
            ->leftJoin('t.user', 'u')
            ->addSelect('u')
            ->where('s = :session')
            ->setParameter('session', $session)
            ->getQuery()
                ->getResult()
        ;
    }

    public function getByUserAndSession($userId, $sessionId)
    {
        $qb = $this->createQueryBuilder('t')
            ->where('t.user = :userId')
            ->andWhere('t.session = :sessionId')
            ->setParameter('userId', $userId)
            ->setParameter('sessionId', $sessionId)
        ;

        return $qb->getQuery()->getResult();
    }

    public function getBySessionAndQuestionnaire($sessionId, $questionnaireId)
    {
        $qb = $this->createQueryBuilder('t')
            ->leftJoin('t.user', 'u')
            ->addSelect('u')
            ->where('t.session = :sessionId')
            ->andWhere('t.questionnaire = :questionnaireId')
            ->setParameter('sessionId', $sessionId)
            ->setParameter('questionnaireId', $questionnaireId)
        ;

        return $qb->getQuery()->getResult();
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

    public function getFirstForSecondStep($session, $user)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t
        LEFT JOIN t.component c
        LEFT JOIN c.componentType ct
        WHERE t.user = :user
        AND t.session = :session
        AND ct.name != 'minitest'";

        $query = $this->_em->createQuery($dql)
                ->setMaxResults(1)
                ->setParameter('user', $user)
                ->setParameter('session', $session);

        return $query->getOneOrNullResult();
    }

    public function getLastBySession($session)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t
        WHERE t.session = :session
        order by t.id DESC";

        $query = $this->_em->createQuery($dql)
                ->setMaxResults(1)
                ->setParameter('session', $session);

        return $query->getOneOrNullResult();
    }

    public function getByUserBySessionByComponent($user, $session, $component)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t
        LEFT JOIN t.session s
        LEFT JOIN t.questionnaire q
        WHERE t.user = :user
        AND t.component = :component
        AND s = :session
        AND (
            EXISTS (
            SELECT oqc FROM Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent oqc
            LEFT JOIN oqc.component c
            WHERE c.test = s.test
            AND oqc.questionnaire = q
            AND oqc.ignoreInScoring = 0)
            OR
            EXISTS (
            SELECT oqt FROM Innova\SelfBundle\Entity\OrderQuestionnaireTest oqt
            WHERE oqt.questionnaire = q
            AND oqt.test = s.test)
        )";

        $query = $this->_em->createQuery($dql)
                ->setParameter('user', $user)
                ->setParameter('session', $session)
                ->setParameter('component', $component);

        return $query->getResult();
    }

    public function getByUserBySessionBySkill($user, $session, $skill)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t
        LEFT JOIN t.session s
        LEFT JOIN t.questionnaire q
        WHERE t.user = :user
        AND s = :session
        AND q.skill = :skill
        AND (
            EXISTS (
            SELECT oqc FROM Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent oqc
            LEFT JOIN oqc.component c
            WHERE c.test = s.test
            AND oqc.questionnaire = q
            AND oqc.ignoreInScoring = 0)
            OR
            EXISTS (
            SELECT oqt FROM Innova\SelfBundle\Entity\OrderQuestionnaireTest oqt
            WHERE oqt.questionnaire = q
            AND oqt.test = s.test)
        )";

        $query = $this->_em->createQuery($dql)
                ->setParameter('user', $user)
                ->setParameter('session', $session)
                ->setParameter('skill', $skill);

        return $query->getResult();
    }

    public function getByUserBySession($user, $session)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t
        LEFT JOIN t.session s
        LEFT JOIN t.questionnaire q
        WHERE t.user = :user
        AND s = :session
        AND (
            EXISTS (
            SELECT oqc FROM Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent oqc
            LEFT JOIN oqc.component c
            WHERE c.test = s.test
            AND oqc.questionnaire = q
            AND oqc.ignoreInScoring = 0)
            OR
            EXISTS (
            SELECT oqt FROM Innova\SelfBundle\Entity\OrderQuestionnaireTest oqt
            WHERE oqt.questionnaire = q
            AND oqt.test = s.test)
        )";

        $query = $this->_em->createQuery($dql)
                ->setParameter('user', $user)
                ->setParameter('session', $session);

        return $query->getResult();
    }

    /**
     * countTraceByUserByTestByQuestionnaire Count Trace By user/test/questionnaire.
     *
     * @param id $test
     * @param id $questionnaire
     * @param id $user
     *
     * @return int number of traces for the test and the questionnaire and the user
     */
    public function findByUserByTestByQuestionnaire($test, $questionnaire, $user, $component, $session)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t
        WHERE t.user = :user
        AND t.test = :test
        AND t.session = :session
        AND t.questionnaire = :questionnaire";

        if ($component) {
            $dql .= ' AND t.component = :component';
        }

        $query = $this->_em->createQuery($dql)
                ->setParameter('test', $test)
                ->setParameter('questionnaire', $questionnaire)
                ->setParameter('user', $user)
                ->setParameter('session', $session);

        if ($component) {
            $query->setParameter('component', $component);
        }

        return $query->getResult();
    }

    public function findByWithJoins($user, $test, $session, $component)
    {
        $dql = "SELECT t, tq, qs, sqs FROM Innova\SelfBundle\Entity\Trace t
        JOIN t.questionnaire tq
        JOIN tq.questions qs
        JOIN qs.subquestions sqs
        WHERE t.user = :user
        AND t.test = :test
        AND t.session = :session
        AND t.component = :component
        AND (
            EXISTS (
              SELECT oqc FROM Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent oqc
              LEFT JOIN oqc.component c
              WHERE c.test = :test
              AND oqc.questionnaire = tq
              AND oqc.ignoreInScoring = 0
            )
            OR EXISTS (
              SELECT oqt FROM Innova\SelfBundle\Entity\OrderQuestionnaireTest oqt
              WHERE oqt.questionnaire = tq
              AND oqt.test = :test
            )
        )";

        $query = $this->_em->createQuery($dql)
              ->setParameters(['user' => $user, 'test' => $test, 'session' => $session, 'component' => $component]);

        return $query->getResult();
    }
}
