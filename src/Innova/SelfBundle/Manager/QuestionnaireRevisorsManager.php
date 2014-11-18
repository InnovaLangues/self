<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\EditorLog\EditorLog;
use Innova\SelfBundle\Entity\Questionnaire;

class QuestionnaireRevisorsManager
{
    protected $entityManager;
    private $securityContext;
    private $user;

    public function __construct($entityManager, $securityContext)
    {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
        $this->user = $this->securityContext->getToken()->getUser();
    }

    public function addRevisor(Questionnaire $questionnaire)
    {
         if(!$questionnaire->getRevisors()->contains($this->user)){
            $questionnaire->addRevisor($this->user);
            $this->entityManager->persist($questionnaire);
            $this->entityManager->flush();
        }

        return $this;
    }
}
