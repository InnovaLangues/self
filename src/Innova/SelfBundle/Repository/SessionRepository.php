<?php

namespace Innova\SelfBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SessionRepository extends EntityRepository
{
    public function findAuthorized($test, $user)
    {
        $dql = "SELECT s FROM Innova\SelfBundle\Entity\Session s
        WHERE s.test = :test
        AND EXISTS (
            SELECT r FROM Innova\SelfBundle\Entity\Right\RightUserSession r
            WHERE r.user = :user
            AND r.target = s
            AND (
                r.canDelete = 1 OR
                r.canEdit = 1 OR
                r.canExportIndividual = 1 OR
                r.canExportCollective = 1
                )
            )
        ORDER BY s.name ASC
        ";

        $query = $this->_em->createQuery($dql)
                                ->setParameter('user', $user)
                                ->setParameter('test', $test);

        return $query->getResult();
    }

    public function findAllAuthorized($user)
    {
        $dql = "SELECT s FROM Innova\SelfBundle\Entity\Session s
        WHERE EXISTS (
            SELECT r FROM Innova\SelfBundle\Entity\Right\RightUserSession r
            WHERE r.user = :user
            AND r.target = s
            AND (
                r.canDelete = 1 OR
                r.canEdit = 1 OR
                r.canExportIndividual = 1 OR
                r.canExportCollective = 1
                )
            )
        ORDER BY s.name ASC
        ";

        $query = $this->_em->createQuery($dql)
                                ->setParameter('user', $user);

        return $query->getResult();
    }

    public function findAllAuthorizedByActivity($user, $active)
    {
        $dql = "SELECT s FROM Innova\SelfBundle\Entity\Session s
        WHERE s.actif = :active
        AND EXISTS (
            SELECT r FROM Innova\SelfBundle\Entity\Right\RightUserSession r
            WHERE r.user = :user
            AND r.target = s
            AND (
                r.canDelete = 1 OR
                r.canEdit = 1 OR
                r.canExportIndividual = 1 OR
                r.canExportCollective = 1
                )
            )
        ORDER BY s.name ASC
        ";

        $query = $this->_em->createQuery($dql)
                                ->setParameter('active', $active)
                                ->setParameter('user', $user);

        return $query->getResult();
    }

    public function findByLanguageByActivity($language, $active)
    {
        $dql = "SELECT s FROM Innova\SelfBundle\Entity\Session s
        LEFT JOIN s.test t
        WHERE s.actif = :active
        AND t.language = :language
        ORDER BY s.name ASC
         ";

        $query = $this->_em->createQuery($dql)
                                ->setParameter('active', $active)
                                ->setParameter('language', $language);

        return $query->getResult();
    }
}
