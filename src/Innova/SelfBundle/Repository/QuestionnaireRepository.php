<?php

namespace Innova\SelfBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Innova\SelfBundle\Entity\Language;

class QuestionnaireRepository extends EntityRepository
{
    /**
     * findOneNotDoneYetByUserByTest description].
     *
     * @param id $testId
     * @param id $userId
     *
     * @return test+questionnaires
     */
    public function findOneNotDoneYetByUserByTest($testId, $userId)
    {
        $dql = "SELECT test, ttq.theme, ttq.originText, ttq.listeningLimit
        FROM Innova\SelfBundle\Entity\Test test
         LEFT JOIN test.questionnaires ttq
        WHERE test = :testId
        AND ttq NOT IN (
            SELECT tq
            FROM Innova\SelfBundle\Entity\Trace t
            LEFT JOIN t.questionnaire tq
            WHERE t.user = :userId AND t.test = :testId
        )";

        $query = $this->_em->createQuery($dql)
                ->setParameter('testId', $testId)
                ->setParameter('userId', $userId);

        return $query->getResult();
    }

    /**
     * countDoneYetByUserByTest count traces for test and for user.
     *
     * @param id $testId
     * @param id $userId
     *
     * @return int number of traces for the test and the user
     */
    public function countDoneYetByUserByTest($testId, $userId)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t
        LEFT JOIN t.questionnaire tq
        WHERE t.user = :userId
        AND t.test = :testId";

        $query = $this->_em->createQuery($dql)
                ->setParameter('testId', $testId)
                ->setParameter('userId', $userId);

        return count($query->getResult());
    }

    /**
     * Returns orphan tasks. Not associate to a testQuestionnaire or testComponent.
     */
    public function findOrphans()
    {
        $dql = "SELECT q FROM Innova\SelfBundle\Entity\Questionnaire q
        WHERE NOT EXISTS (
            SELECT otc FROM Innova\SelfBundle\Entity\PhasedTest\orderQuestionnaireComponent otc
            WHERE otc.questionnaire = q
        ) AND NOT EXISTS (
            SELECT otq FROM Innova\SelfBundle\Entity\orderQuestionnaireTest otq
            WHERE otq.questionnaire = q
        )
        ";

        $query = $this->_em->createQuery($dql);

        return $query->getResult();
    }

    /**
     * countDoneYetByUserByTest count traces for test and for user.
     *
     * @param id $testId
     * @param id $userId
     *
     * @return int number of traces for the test and the user
     */
    public function countDoneYetByUserByTestBySession($testId, $userId, $sessionId)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t
        LEFT JOIN t.questionnaire tq
        WHERE t.user = :userId
        AND t.test = :testId
        AND t.session = :sessionId";

        $query = $this->_em->createQuery($dql)
                ->setParameter('testId', $testId)
                ->setParameter('sessionId', $sessionId)
                ->setParameter('userId', $userId);

        return count($query->getResult());
    }

    /**
     * countDoneYetByUserByTestByComponent count traces for test, session, and component.
     *
     * @param id $test
     * @param id $user
     *
     * @return int number of traces for the test and the user
     */
    public function countDoneYetByUserByTestByComponent($test, $user, $session, $component)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t
        LEFT JOIN t.questionnaire tq
        WHERE t.user = :user
        AND t.test = :test
        AND t.component = :component
        AND t.session = :session";

        $query = $this->_em->createQuery($dql)
                ->setParameter('test', $test)
                ->setParameter('session', $session)
                ->setParameter('component', $component)
                ->setParameter('user', $user);

        return count($query->getResult());
    }

    /**
     * getQuestionnairesDoneYetByUserByTest questionnairre done for an user and a test.
     *
     * @param id $testId
     * @param id $userId
     *
     * @return int number of traces for the test and the user
     */
    public function getQuestionnairesDoneYetByUserByTest($testId, $userId)
    {
        $dql = "SELECT q FROM Innova\SelfBundle\Entity\Questionnaire q
        LEFT JOIN q.traces t
        WHERE t.user = :userId
        AND t.test = :testId";

        $query = $this->_em->createQuery($dql)
                ->setParameter('testId', $testId)
                ->setParameter('userId', $userId);

        return $query->getResult();
    }

    /**
     * countAnswerByUserByTest Count Answer By user/test.
     *
     * @param id $testId
     * @param id $userId
     *
     * @return int number of answers for the test and the user
     */
    public function countAnswerByUserByTest($testId, $userId)
    {
        $dql = "SELECT a FROM Innova\SelfBundle\Entity\Answer a
        LEFT JOIN a.trace at
        WHERE at.user = :userId AND at.test = :testId";

        $query = $this->_em->createQuery($dql)
                ->setParameter('testId', $testId)
                ->setParameter('userId', $userId);

        return count($query->getResult());
    }

    /**
     * countRightAnswerByUserByTest Count right answer by test/user.
     *
     * @param id $testId
     * @param id $userId
     *
     * @return int number of right answer for the test and the user
     */
    public function countRightAnswerByUserByTest($testId, $userId)
    {
        $dql = "SELECT a FROM Innova\SelfBundle\Entity\Answer a
        LEFT JOIN a.proposition ap
        LEFT JOIN a.trace at
        WHERE at.user = :userId AND at.test = :testId AND ap.rightAnswer = 1";

        $query = $this->_em->createQuery($dql)
                ->setParameter('testId', $testId)
                ->setParameter('userId', $userId);

        return count($query->getResult());
    }

    public function getPotentialByTest($test)
    {
        $dql = "SELECT q FROM Innova\SelfBundle\Entity\Questionnaire q
        WHERE NOT EXISTS (
            SELECT otq FROM Innova\SelfBundle\Entity\orderQuestionnaireTest otq
            WHERE otq.questionnaire = q
            AND otq.test = :test
        ) AND (q.language = :language OR q.language is NULL)
        ";

        $query = $this->_em->createQuery($dql)
                ->setParameter('test', $test)
                ->setParameter('language', $test->getLanguage());

        return $query->getResult();
    }

    public function getByTest($test)
    {
        $dql = "SELECT q, qq, sq, p, m FROM Innova\SelfBundle\Entity\Questionnaire q
        LEFT JOIN q.orderQuestionnaireTests qot
        LEFT JOIN q.orderQuestionnaireComponents qoc
        LEFT JOIN qoc.component c
        LEFT JOIN c.componentType ct
        LEFT JOIN q.questions qq
        LEFT JOIN qq.subquestions sq
        LEFT JOIN sq.propositions p
        LEFT JOIN p.media m
        WHERE qot.test = :test OR c.test = :test
        ORDER BY
        ";

        $dql .= (!$test->getPhased()) ? 'qot.displayOrder' : 'ct.id, qoc.displayOrder';

        $query = $this->_em->createQuery($dql)
                ->setParameter('test', $test);

        return $query->getResult();
    }

    public function findPotentialByComponent($component)
    {
        $dql = "SELECT q FROM Innova\SelfBundle\Entity\Questionnaire q
        WHERE NOT EXISTS (
            SELECT otc FROM Innova\SelfBundle\Entity\PhasedTest\orderQuestionnaireComponent otc
            LEFT JOIN otc.component c
            WHERE otc.questionnaire = q
            AND (otc.component = :component
            OR c.componentType != :type)
        )
        ";

        $query = $this->_em->createQuery($dql)
                ->setParameter('component', $component)
                ->setParameter('type', $component->getComponentType());

        return $query->getResult();
    }

    public function findAllLight($languageId = null)
    {
        $builder = $this->createQueryBuilder('q');
        $builder->select('q', 'qo', 'qs', 'ql', 'qsk', 'qq', 'qot');
        $builder->join('q.orderQuestionnaireTests', 'qo');
        $builder->join('q.status', 'qs');
        $builder->join('q.level', 'ql');
        $builder->join('q.skill', 'qsk');
        $builder->join('q.questions', 'qq');
        $builder->join('qo.test', 'qot');

        if ($languageId) {
            $builder->andWhere('q.language = :language');
            $builder->setParameter('language', $languageId);
        }

        return $builder->getQuery()->getResult();
    }

    public function findByTestAndMissingLevel($test)
    {
        $dql = "SELECT q FROM Innova\SelfBundle\Entity\Questionnaire q
        LEFT JOIN q.orderQuestionnaireTests qot
        LEFT JOIN q.orderQuestionnaireComponents qoc
        LEFT JOIN qoc.component c
        LEFT JOIN q.questions qq
        LEFT JOIN qq.subquestions qqs
        WHERE (qot.test = :test OR c.test = :test)
        AND qqs.level IS NULL
        AND q.level IS NULL
        ";

        $query = $this->_em->createQuery($dql)
                ->setParameter('test', $test);

        return $query->getResult();
    }

    public function findAll()
    {
        $qb = $this->createQueryBuilder('q')
            ->leftJoin('q.questions', 'qq')
            ->addSelect('qq')

            ->leftJoin('q.orderQuestionnaireComponents', 'oqc')
            ->addSelect('oqc')

            ->leftJoin('q.orderQuestionnaireTests', 'oqt')
            ->addSelect('oqt')
        ;

        return $qb->getQuery()->getResult();
    }

    public function findByLanguage(Language $language)
    {
        $qb = $this->createQueryBuilder('q')
            ->where('q.language = :language')
            ->setParameter('language', $language)

            ->leftJoin('q.questions', 'qq')
            ->addSelect('qq')

            ->leftJoin('q.orderQuestionnaireComponents', 'oqc')
            ->addSelect('oqc')

            ->leftJoin('q.orderQuestionnaireTests', 'oqt')
            ->addSelect('oqt')

            ->leftJoin('oqt.test', 't')
            ->addSelect('t')
        ;

        return $qb->getQuery()->getResult();
    }
}
