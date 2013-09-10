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

}
