<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Session;
use Innova\SelfBundle\Entity\UserResult;

class UserResultManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get(User $user, Session $session)
    {
        $em = $this->entityManager;

        if (!$userResult = $em->getRepository('InnovaSelfBundle:UserResult')->findOneBy(array('user' => $user, 'session' => $session))) {
            $userResult = new UserResult();
            $userResult->setSession($session);
            $userResult->setUser($user);
            $userResult = $this->save($userResult);
        }

        return $userResult;
    }

    public function setGeneralScore($score, User $user, Session $session)
    {
        $userResult = $this->get($user, $session);
        $userResult->setGeneralScore($score);
        $this->save($userResult);

        return;
    }

    public function setSkillScore($score, User $user, Session $session, $skill)
    {
        $userResult = $this->get($user, $session);

        switch ($skill) {
            case 'CO':
                $userResult->setCoScore($score);
                break;
            case 'CE':
                $userResult->setCeScore($score);
                break;
            case 'EEC':
                $userResult->setEecScore($score);
                break;
        }

        $this->save($userResult);

        return;
    }

    public function save(UserResult $userResult)
    {
        $em = $this->entityManager;

        $em->persist($userResult);
        $em->flush();

        return $userResult;
    }
}
