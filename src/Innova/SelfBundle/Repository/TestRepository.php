<?php

namespace Innova\SelfBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TestRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }

    public function findWithOpenSession()
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Test t
        WHERE EXISTS (
        	SELECT s FROM Innova\SelfBundle\Entity\Session s
        	WHERE s.test = t
        	AND s.actif = 1
        )";

        $query = $this->_em->createQuery($dql);

        return $query->getResult();
    }
}
