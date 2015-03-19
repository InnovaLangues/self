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

    public function checkExistingUsername(User $user)
    {
        $user = $this->entityManager->getRepository('InnovaSelfBundle:User')->findAnotherByUsername($user);
        if ($user) {
            return "Existing user with this username";
        }

        return;
    }

    public function checkExistingEmail(User $user)
    {
        $user = $this->entityManager->getRepository('InnovaSelfBundle:User')->findAnotherByEmail($user);
        if ($user) {
            return "Existing user with this email";
        }

        return;
    }
}
