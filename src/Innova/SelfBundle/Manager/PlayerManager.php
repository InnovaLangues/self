<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;

class PlayerManager
{
    protected $entityManager;
    protected $securityContext;
    protected $user;

    public function __construct($entityManager, $securityContext)
    {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
        $this->user = $this->securityContext->getToken()->getUser();
    }

    /**
     * Pick a questionnaire entity for a given test not done yet by the user.
     */
    public function findAQuestionnaireWithoutTrace(Test $test)
    {        
        $orderedQuestionnaires = $test->getOrderQuestionnaireTests();
        $questionnaireWithoutTrace = null;

        foreach ($orderedQuestionnaires as $orderedQuestionnaire) {
            $traces = $this->entityManager->getRepository('InnovaSelfBundle:Trace')->findBy(
                array(  'user' => $this->user->getId(),
                        'test' => $test->getId(),
                        'questionnaire' => $orderedQuestionnaire->getQuestionnaire()->getId()
                ));
            if (count($traces) == 0) {
                $questionnaireWithoutTrace = $orderedQuestionnaire->getQuestionnaire();
                break;
            }
        }

        return $questionnaireWithoutTrace;
    }

    public function findPreviousQuestionnaire($test, $questionnaire)
    {
        $previousQuestionnaire = null;

        $currentQuestionnaireOrder = $this->entityManager->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')->findOneBy(
            array(
                    'test' => $test,
                    'questionnaire' => $questionnaire
            ))->getDisplayOrder();

        $displayOrder = $currentQuestionnaireOrder - 1;


        $previousQuestionnaireOrder = $this->entityManager->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')->findOneBy(
            array(
                    'test' => $test,
                    'displayOrder' => $displayOrder
            ));

        if( $previousQuestionnaireOrder ){
            $previousQuestionnaire = $previousQuestionnaireOrder->getQuestionnaire();
        }

        return $previousQuestionnaire;
    }

    public function displayHelp(Test $test, Questionnaire $questionnaire){
        // Il faut afficher l'aide à chaque fois que l'on change d'expression pour le test : CO ou CE ou EEC
        // 1 : recherche de la question précédente
        $previousQuestionnaire = $this->findPreviousQuestionnaire($test, $questionnaire);
        $displayHelp = true;

        if ($previousQuestionnaire !== null ) {
            // 2 : recherche des informations sur la question
            $skillBefore = $previousQuestionnaire->getSkill();
            $skill = $questionnaire->getSkill();
            // 3 : affichage ou non de l'aide. On n'affiche pas l'aide si on a la même compétence
            if ($skillBefore == $skill) $displayHelp = false;
        }

        return $displayHelp;
    }
}
