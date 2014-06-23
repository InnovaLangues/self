<?php

namespace Innova\SelfBundle\Manager;


class UserManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function setLocale($user, $locale)
    {
        $em = $this->entityManager;

        $user->setLocale($locale);
        
        $em->persist($user);
        $em->flush();

        return $user;
    }
}
