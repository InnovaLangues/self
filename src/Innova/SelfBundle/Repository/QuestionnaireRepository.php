<?php

namespace Innova\SelfBundle\Repository;
 
use Doctrine\ORM\EntityRepository;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;

class QuestionnaireRepository extends EntityRepository{

	public function findOneNotDoneYetByUserByTest($testId, $userId){

		//$dql = 'SELECT q FROM Innova\SelfBundle\Entity\Questionnaire q WHERE :testId MEMBER OF q.tests';

		$dql = "SELECT q FROM Innova\SelfBundle\Entity\Questionnaire q WHERE q NOT IN (SELECT t FROM Innova\SelfBundle\Entity\Trace t WHERE t.user = :userId AND t.test = :testId AND t.questionnaire = q.id)";

		$query = $this->_em->createQuery($dql)
				->setParameter('testId', $testId)
				->setParameter('userId', $userId)
				->setMaxResults(1);
		return $query->getSingleResult();
	}

}
