<?php

namespace Innova\SelfBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Innova\SelfBundle\Entity\User;

class TestRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }

    public function findAuthorized($user)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Test t
        WHERE EXISTS (
            SELECT r FROM Innova\SelfBundle\Entity\Right\RightUserTest r
            WHERE r.user = :user
            AND r.target = t
            AND (
                r.canEdit = 1 OR
                r.canManageSession = 1 OR
                r.canManageTask = 1
            )
        )";

        $query = $this->_em->createQuery($dql)->setParameter('user', $user);

        return $query->getResult();
    }

    public function findAuthorizedByLanguage($user, $language)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Test t
        WHERE EXISTS (
            SELECT r FROM Innova\SelfBundle\Entity\Right\RightUserTest r
            WHERE r.user = :user
            AND r.target = t
            AND (
                r.canEdit = 1 OR
                r.canManageSession = 1 OR
                r.canManageTask = 1
            )
        ) AND t.language = :language";

        $query = $this->_em->createQuery($dql)
                ->setParameter('user', $user)
                ->setParameter('language', $language);

        return $query->getResult();
    }

    public function findByArchivedByLanguage($archived, $language)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Test t
        WHERE t.archived = :archived
        AND t.language = :language";

        $query = $this->_em->createQuery($dql)
                ->setParameter('archived', $archived)
                ->setParameter('language', $language);

        return $query->getResult();
    }

    public function findByTask($task)
    {
        $dql = "SELECT t FROM Innova\SelfBundle\Entity\Test t
        WHERE EXISTS (
            SELECT oqt FROM Innova\SelfBundle\Entity\OrderQuestionnaireTest oqt
            WHERE oqt.test = t
            AND oqt.questionnaire = :task
        )
        OR EXISTS (
            SELECT oqc FROM Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent oqc
            LEFT JOIN oqc.component c
            WHERE c.test = t
            AND oqc.questionnaire = :task
        )";

        $query = $this->_em->createQuery($dql)
                ->setParameter('task', $task);

        return $query->getResult();
    }

    public function findOneWithOrderQuestionnaires($testId)
    {
        $dql = "SELECT t, o FROM Innova\SelfBundle\Entity\Test t
        LEFT JOIN t.orderQuestionnaireTests o
        WHERE t.id = :id";

        $query = $this->_em->createQuery($dql)
            ->setParameter('id', $testId);

        return $query->getOneOrNullResult();

    }
}
