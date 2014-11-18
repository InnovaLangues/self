<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Questionnaire;

class QuestionnaireManager
{
    protected $entityManager;
    protected $securityContext;
    protected $user;
    protected $questionnaireRevisorsManager;

    public function __construct($entityManager, $securityContext, $questionnaireRevisorsManager)
    {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
        $this->user = $this->securityContext->getToken()->getUser();
        $this->questionnaireRevisorsManager = $questionnaireRevisorsManager;
    }

    public function createQuestionnaire()
    {
        $em = $this->entityManager;

        $questionnaire = new Questionnaire();
        $questionnaire->setTheme("");
        $questionnaire->setTextTitle("");
        $questionnaire->setListeningLimit(0);
        $questionnaire->setDialogue(0);
        $questionnaire->setFixedOrder(0);
        $questionnaire->setStatus($em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Status')->find(1));
        $questionnaire->setAuthor($this->user);

        $em->persist($questionnaire);
        $em->flush();

        return $questionnaire;
    }

    public function setTypology(Questionnaire $questionnaire, $typologyName)
    {
        $em = $this->entityManager;

        if (!$typology = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($typologyName)) {
            $typology = null;
            foreach ($questionnaire->getQuestions()[0]->getSubquestions() as $subquestion) {
                $subquestion->setTypology(null);
                $em->persist($subquestion);
            }
        } else {
            foreach ($questionnaire->getQuestions()[0]->getSubquestions() as $subquestion) {
                $subquestion->setTypology($typology);
                $em->persist($subquestion);
            }
        }

        $questionnaire->getQuestions()[0]->setTypology($typology);
        $em->persist($questionnaire);
        $em->flush();

        return $typology;
    }

    public function isUnique($theme, $language)
    {
        $em = $this->entityManager;

        $isUnique = true;

        if ($em->getRepository('InnovaSelfBundle:Questionnaire')->findBy(array('theme' =>$theme, 'language'=>$language))) {
            $isUnique = false;
        }

        return $isUnique;
    }

    public function setIdentityField($questionnaire, $field, $value)
    {
        $em = $this->entityManager;
        
        switch ($field) {
            case 'authorRightMore':
                $questionnaire->setAuthorRightMore($value);
                break;
            case 'sourceMore':
                $questionnaire->setSourceMore($value);
                break;
            case 'levelProof':
                $questionnaire->setLevelProof($value);
                break;
            case 'authorRight':
                if ($authorRight = $em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\AuthorRight')->find($value)) {
                    $questionnaire->setAuthorRight($authorRight);
                } else { $questionnaire->setAuthorRight(null); }
                break;
            case 'source':
                if ($source = $em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Source')->find($value)) {
                    $questionnaire->setSource($source);
                } else { $questionnaire->setSource(null); }
                break;
            case 'sourceOperation':
                if ($sourceOperation = $em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\SourceOperation')->find($value)) {
                    $questionnaire->setSourceOperation($sourceOperation);
                } else { $questionnaire->setSourceOperation(null); }
                break;
            case 'domain':
                if ($domain = $em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Domain')->find($value)) {
                    $questionnaire->setDomain($domain);
                } else { $questionnaire->setDomain(null); }
                break;
            case 'register':
                if ($register = $em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Register')->find($value)) {
                    $questionnaire->setRegister($register);
                } else { $questionnaire->setRegister(null); }
                break;
            case 'reception':
                if ($reception = $em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Reception')->find($value)) {
                    $questionnaire->setReception($reception);
                } else { $questionnaire->setReception(null); }
                break;
            case 'length':
                if ($length = $em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Length')->find($value)) {
                    $questionnaire->setLength($length);
                } else { $questionnaire->setlength(null); }
                break;
            case 'flow':
                if ($flow = $em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Flow')->find($value)) {
                    $questionnaire->setFlow($flow);
                } else { $questionnaire->setFlow(null); }
                break;
             case 'level':
                if ($level = $em->getRepository('InnovaSelfBundle:Level')->find($value)) {
                    $questionnaire->setLevel($level);
                } else { $questionnaire->setLevel(null); }
                break;
            case 'status':
                if ($status = $em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Status')->find($value)) {
                    $questionnaire->setStatus($status);
                } else { $questionnaire->setStatus(null); }
                break;
            case 'language':
                if ($status = $em->getRepository('InnovaSelfBundle:Language')->find($value)) {
                    $questionnaire->setLanguage($status);
                } else { $questionnaire->setLanguage(null); }
                break;
        }

        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        $em->persist($questionnaire);
        $em->flush();

        return $this;
    }
}
