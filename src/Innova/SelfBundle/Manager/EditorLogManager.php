<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\EditorLog;

class EditorLogManager
{
    protected $entityManager;
    private $securityContext;

    public function __construct($entityManager, $securityContext)
    {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
    }

    public function createEditorLog($action, $object, $questionnaire)
    {
        $user = $this->securityContext->getToken()->getUser();
        $em = $this->entityManager;

        $log = new EditorLog();
        $log->setDate(new \Datetime());
        $log->setUser($user);
        $log->setQuestionnaire($questionnaire);
        $log->setAction($em->getRepository('InnovaSelfBundle:EditorLogAction')->findOneByName($action));
        $log->setObject($em->getRepository('InnovaSelfBundle:EditorLogObject')->findOneByName($object));

        $em->persist($log);
        $em->flush();

        return $log;
    }
}
