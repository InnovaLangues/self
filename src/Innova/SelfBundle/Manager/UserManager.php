<?php

namespace Innova\SelfBundle\Manager;
use Innova\SelfBundle\Entity\User;

class UserManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function setLocale(User $user, $locale)
    {
        $em = $this->entityManager;

        $user->setLocale($locale);

        $em->persist($user);
        $em->flush();

        return $user;
    }

    public function deleteUser(User $user)
    {
        $em = $this->entityManager;
        
        $em->remove($user);
        $em->flush();

        return $this;
    }
}
