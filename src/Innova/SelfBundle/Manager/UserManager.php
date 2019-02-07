<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Innova\SelfBundle\Form\Type\UserType;

class UserManager
{
    protected $entityManager;
    protected $formFactory;
    protected $fosUserManager;
    protected $session;
    protected $securityContext;
    protected $translator;
    protected $redis;

    public function __construct($entityManager, $formFactory, $fosUserManager, $session, $securityContext, $translator, $redis)
    {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->fosUserManager = $fosUserManager;
        $this->session = $session;
        $this->securityContext = $securityContext;
        $this->translator = $translator;
        $this->redis = $redis;
    }

    public function setLocale(User $user, $locale)
    {
        $user->setLocale($locale);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function deleteUser(User $user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        $this->session->getFlashBag()->set('success', "L'utilisateur a bien été supprimé.");

        return $this;
    }

    public function checkExistingUsername(User $user)
    {
        $user = $this->entityManager->getRepository('InnovaSelfBundle:User')->findAnotherByUsername($user);
        if ($user) {
            return 'Existing user with this username';
        }

        return;
    }

    public function checkExistingEmail(User $user)
    {
        $user = $this->entityManager->getRepository('InnovaSelfBundle:User')->findAnotherByEmail($user);
        if ($user) {
            return 'Existing user with this email';
        }

        return;
    }

    public function handleForm(User $user, Request $request)
    {
        $form = $this->formFactory->createBuilder(new UserType($this->entityManager), $user)->getForm();

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

    public function getConnected(bool $full = false)
    {
        $connectedUsers = [];

        foreach ($this->redis->keys('*') as $key) {
            if (strpos($key, ".lock")) {
                continue;
            }

            $sessionData = $this->redis->get($key);
            $sessionData = str_replace('_sf2_attributes|', '', $sessionData);
            $sessionData = unserialize($sessionData);

            // If this is a session belonging to an anonymous user, do nothing
            if (!array_key_exists('_security_main', $sessionData)) {
                continue;
            }

            // Grab security data
            $sessionData = $sessionData['_security_main'];
            $sessionData = unserialize($sessionData);
            $username = $sessionData->getUser()->getUsername();

            $user = (!$full)
              ? $username
              : $this->entityManager->getRepository('InnovaSelfBundle:User')->findOneByUsername($username);

            if (\in_array($user, $connectedUsers, true)) {
                continue;
            }

            $connectedUsers[] = $user;
        }

        return $connectedUsers;
    }

    public function getAuthCount()
    {
        $connectedUsers = $this->getConnected();

        return count($connectedUsers);
    }

    public function checkCourse()
    {
        $user = $this->securityContext->getToken()->getUser();

        if (!$user->getCourse()) {
            $this->session->getFlashBag()->set('warning', $this->translator->trans('warning_message_course'));
        }
    }
}
