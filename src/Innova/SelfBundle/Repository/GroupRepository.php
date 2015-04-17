<?php

namespace Innova\SelfBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GroupRepository extends EntityRepository
{
    public function findAuthorized($user)
    {
        $dql = "SELECT g FROM Innova\SelfBundle\Entity\Group g
        WHERE EXISTS (
            SELECT r FROM Innova\SelfBundle\Entity\Right\RightUserGroup r
            WHERE r.user = :user
            AND r.target = g
            AND (
                r.canDelete = 1 OR
                r.canImportCsv = 1 OR
                r.canEdit = 1
                )
            )
        ";

        $query = $this->_em->createQuery($dql)
                                ->setParameter('user', $user);

        return $query->getResult();
    }
}
