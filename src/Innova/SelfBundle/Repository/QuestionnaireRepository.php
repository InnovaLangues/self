<?php

namespace Innova\SelfBundle\Repository;
 
use Doctrine\ORM\EntityRepository;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;

class QuestionnaireRepository extends EntityRepository{

	public function findOneNotDoneYetByUserByTest($testId, $userId){
		$dql = "SELECT q FROM Innova\SelfBundle\Entity\Questionnaire q WHERE q NOT IN (SELECT tq FROM Innova\SelfBundle\Entity\Trace t LEFT JOIN t.questionnaire tq WHERE t.user = :userId AND t.test = :testId)";

		$query = $this->_em->createQuery($dql)
				->setParameter('testId', $testId)
				->setParameter('userId', $userId)
				->setMaxResults(1);
		return $query->getOneOrNullResult();
	}


	public function CountDoneYetByUserByTest($testId, $userId){
		$dql = "SELECT t FROM Innova\SelfBundle\Entity\Trace t LEFT JOIN t.questionnaire tq WHERE t.user = :userId AND t.test = :testId";

		$query = $this->_em->createQuery($dql)
				->setParameter('testId', $testId)
				->setParameter('userId', $userId);
		return count($query->getResult());
	}


	public function CountAnswerByUserByTest($testId, $userId){
		$dql = "SELECT a FROM Innova\SelfBundle\Entity\Answer a LEFT JOIN a.trace at WHERE at.user = :userId AND at.test = :testId";

		$query = $this->_em->createQuery($dql)
				->setParameter('testId', $testId)
				->setParameter('userId', $userId);
		return count($query->getResult());
	}

	public function CountRightAnswerByUserByTest($testId, $userId){
		$dql = "SELECT a FROM Innova\SelfBundle\Entity\Answer a LEFT JOIN a.proposition ap LEFT JOIN a.trace at WHERE at.user = :userId AND at.test = :testId AND ap.rightAnswer = 1";

		$query = $this->_em->createQuery($dql)
				->setParameter('testId', $testId)
				->setParameter('userId', $userId);
		return count($query->getResult());
	}



}
