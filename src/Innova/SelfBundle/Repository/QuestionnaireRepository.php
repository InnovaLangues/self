<?php

namespace Innova\SelfBundle\Repository;

use Doctrine\ORM\EntityRepository;

class QuestionnaireRepository extends EntityRepository
{

    /**
     * findOneNotDoneYetByUserByTest description]
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
     * countDoneYetByUserByTest count traces for test and for user
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
     * countTraceByUserByTestByQuestionnaire Count Trace By user/test/questionnaire
     * @param id $testId
     * @param id $questionnaireId
     * @param id $userId
     *
     * @return int number of traces for the test and the questionnaire and the user
     */
    public function countTraceByUserByTestByQuestionnaire($testId, $questionnaireId, $userId)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t
        WHERE t.user = :userId
        AND t.test = :testId
        AND t.questionnaire = :questionnaireId";

        $query = $this->_em->createQuery($dql)
                ->setParameter('testId', $testId)
                ->setParameter('questionnaireId', $questionnaireId)
                ->setParameter('userId', $userId);

        return count($query->getResult());
    }


    /**
     * countAnswerByUserByTest Count Answer By user/test
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
     * countRightAnswerByUserByTest Count right answer by test/user
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


    public function getPotentialByTest($test){
        $dql  = "SELECT q FROM Innova\SelfBundle\Entity\Questionnaire q
        WHERE NOT EXISTS (
            SELECT otq FROM Innova\SelfBundle\Entity\orderQuestionnaireTest otq
            WHERE otq.questionnaire = q 
            AND otq.test = :test
        )
        ";

        $query = $this->_em->createQuery($dql)
                ->setParameter('test', $test);

         return $query->getResult();
    }
}
