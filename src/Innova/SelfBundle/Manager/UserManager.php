<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Group;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Innova\SelfBundle\Form\Type\UserType;

class UserManager
{
    protected $entityManager;
    protected $formFactory;

    public function __construct($entityManager, $formFactory)
    {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
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

    /**
     * Handles session form
     */
    public function handleForm(User $user, Request $request)
    {
        $form = $this->formFactory->createBuilder(new UserType(), $user)->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $hasError = false;
                if ($error = $this->checkExistingUsername($user)) {
                    $form->addError(new FormError($error));
                    $hasError = true;
                }
                if ($error = $this->checkExistingEmail($user)) {
                    $form->addError(new FormError($error));
                    $hasError = true;
                }

                if ($hasError) {
                    return $form;
                }
                $user->setEnabled(true);
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                return;
            }
        }

        return $form;
    }

    public function importCsv(Group $group, $completePath)
    {
        $file = fopen($completePath, 'r');
        while (($row = fgetcsv($file, 0, ';')) !== FALSE) {
            var_dump($row);
            // create_user
        }
    }
}
