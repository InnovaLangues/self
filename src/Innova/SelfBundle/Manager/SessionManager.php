<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Session;
use Innova\SelfBundle\Entity\User;

class SessionManager
{
    protected $entityManager;
    protected $session;
    protected $securityContext;
    protected $rightManager;
    protected $currentUser;
    protected $sessionRepo;

    public function __construct($entityManager, $session, $securityContext, $rightManager)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->securityContext = $securityContext;
        $this->rightManager = $rightManager;
        $this->currentUser = $this->securityContext->getToken()->getUser();
        $this->sessionRepo = $this->entityManager->getRepository('InnovaSelfBundle:Session');
    }

    public function createSession(Test $test, $name, $actif, $passwd, $save)
    {
        $session = new Session();

        $session->setName($name);
        $session->setActif($actif);
        $session->setTest($test);
        $session->setPasswd($passwd);
        $session->setGlobalScoreShow(true);
        $session->setCreateDate(new \Datetime());

        if ($save) {
            $session = $this->saveSession($session);
        }

        return $session;
    }

    public function saveSession(Session $session)
    {
        $this->entityManager->persist($session);
        $this->entityManager->flush();

        return $session;
    }

    public function deleteSession(Session $session)
    {
        $this->entityManager->remove($session);
        $this->entityManager->flush();

        $this->session->getFlashBag()->set('info', 'La session a bien été supprimée');

        return;
    }

    public function createSessionforExport(Test $test)
    {
        if ($test->getSessions()->isEmpty()) {
            $session = $this->createSession($test, 'Session '.$test->getId(), false, 'passwd', true);
            $traces = $this->entityManager->getRepository('InnovaSelfBundle:Trace')->findBy(array('session' => null, 'test' => $test));
            foreach ($traces as $trace) {
                $trace->setSession($session);
                $this->entityManager->persist($trace);
            }
            $this->entityManager->flush();
        }

        $this->session->getFlashBag()->set('info', 'La session a bien été créée à partir des traces');

        return;
    }

    public function listSessionByActivity($isActive)
    {
        if ($this->rightManager->checkRight('right.listsession', $this->currentUser)) {
            $sessions = ($language = $this->currentUser->getPreferedLanguage())
                ? $this->sessionRepo->findByLanguageByActivity($language, $isActive)
                : $this->sessionRepo->findBy(array('actif' => $isActive), array('name' => 'ASC'));
        } else {
            $sessions = $this->sessionRepo->findAllAuthorizedByActivity($this->currentUser, $isActive);
        }

        return $sessions;
    }

    public function listSessionByTest(Test $test)
    {
        $sessions = ($this->rightManager->checkRight('right.listsession', $this->currentUser, $test))
            ? $test->getSessions()
            : $this->sessionRepo->findAuthorized($test, $this->currentUser);

        return $sessions;
    }

    public function invalidateResults(Session $session)
    {
        $results = $this->entityManager->getRepository('InnovaSelfBundle:UserResult')->findBySession($session);
        foreach ($results as $result) {
            $this->entityManager->remove($result);
        }
        $this->entityManager->flush();

        $this->session->getFlashBag()->set('info', 'Les résultats ont bien été invalidés. Ils seront recalculés au prochain export.');

        return $session;
    }

    public function invalidateUserResults(Session $session, User $user)
    {
        $results = $this->entityManager->getRepository('InnovaSelfBundle:UserResult')->findBy(array('session' => $session, 'user' => $user));
        foreach ($results as $result) {
            $this->entityManager->remove($result);
        }
        $this->entityManager->flush();

        $this->session->getFlashBag()->set('info', 'Les résultats pour l\'utilisateur ont bien été invalidés. Ils seront recalculés au prochain export.');

        return $session;
    }
}
