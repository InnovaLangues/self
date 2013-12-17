<?php

namespace Innova\SelfBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Trace;
use Innova\SelfBundle\Entity\Questionnaire;

class QuestionnaireRepository extends EntityRepository{

    /**
     * To have the next Question for one test and one user
     *
     */
	public function findOneNotDoneYetByUserByTest($testId, $userId){

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
//				->setMaxResults(1);
//		return $query->getOneOrNullResult();
		return $query->getResult();
	}


	public function CountDoneYetByUserByTest($testId, $userId){
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
     * Count Trace By user/test/questionnaire
     *
     */
	public function CountTraceByUserByTestByQuestionnaire($testId, $questionnaireId, $userId){
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
     * Trace By user/test/questionnaire
     *
     */
	public function findOneByUserByTestByQuestionnaire($testId, $questionnaireId, $userId){
		$dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t
		WHERE t.user = :userId
		AND t.test = :testId
		AND t.questionnaire = :questionnaireId";

		$query = $this->_em->createQuery($dql)
				->setParameter('testId', $testId)
				->setParameter('questionnaireId', $questionnaireId)
				->setParameter('userId', $userId);

		return $query->getResult();
	}


	public function CountAnswerByUserByTest($testId, $userId){
		$dql = "SELECT a FROM Innova\SelfBundle\Entity\Answer a
		LEFT JOIN a.trace at
		WHERE at.user = :userId AND at.test = :testId";

		$query = $this->_em->createQuery($dql)
				->setParameter('testId', $testId)
				->setParameter('userId', $userId);
		return count($query->getResult());
	}

	public function CountRightAnswerByUserByTest($testId, $userId){
		$dql = "SELECT a FROM Innova\SelfBundle\Entity\Answer a
		LEFT JOIN a.proposition ap
		LEFT JOIN a.trace at
		WHERE at.user = :userId AND at.test = :testId AND ap.rightAnswer = 1";

		$query = $this->_em->createQuery($dql)
				->setParameter('testId', $testId)
				->setParameter('userId', $userId);
		return count($query->getResult());
	}
}