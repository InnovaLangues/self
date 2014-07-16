<?php

namespace Innova\SelfBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TypologyRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }
}
