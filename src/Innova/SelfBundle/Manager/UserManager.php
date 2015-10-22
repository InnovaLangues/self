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

    public function __construct($entityManager, $formFactory, $fosUserManager, $session)
    {
        $this->entityManager    = $entityManager;
        $this->formFactory      = $formFactory;
        $this->fosUserManager   = $fosUserManager;
        $this->session          = $session;
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

    public function getConnected()
    {
        $threshold = 300;
        $limit = time() - $threshold;
        $connectedUsers = array();

        $em = $this->entityManager;

        $dql = 'select s from InnovaSelfBundle:PDOSession s
            where s.session_time >= ?1
            order by s.session_time desc';
        $query = $em->createQuery($dql);
        $query->setParameter(1, $limit);
        $sessions = $query->getResult();

        foreach ($sessions as $session) {
            $data = stream_get_contents($session->getSessionValue());

            $data = str_replace('_sf2_attributes|', '', $data);
            $data = unserialize($data);

            // If this is a session belonging to an anonymous user, do nothing
            if (!array_key_exists('_security_main', $data)) {
                continue;
            }

            // Grab security data
            $data = $data['_security_main'];
            $data = unserialize($data);
            $username = $data->getUser()->getUsername();
            $user = $this->entityManager->getRepository('InnovaSelfBundle:User')->findOneByUsername($username);

            if (!in_array($user, $connectedUsers)) {
                $connectedUsers[] = $user;
            }
        }

        return $connectedUsers;
    }

    private function inArrayRecursiv($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->inArrayRecursiv($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }
}
