<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\PhasedTest\Component;
use Innova\SelfBundle\Entity\PhasedTest\ComponentType;
use Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent;

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
        $this->traceRepo = $this->entityManager->getRepository('InnovaSelfBundle:Trace');
        $this->componentRepo = $this->entityManager->getRepository('InnovaSelfBundle:PhasedTest\Component');
        $this->componentTypeRepo = $this->entityManager->getRepository('InnovaSelfBundle:PhasedTest\ComponentType');
        $this->orderQCRepo = $this->entityManager->getRepository('InnovaSelfBundle:PhasedTest\OrderQuestionnaireComponent');
    }

    /**
     * Pick a questionnaire entity for a given test not done yet by the user.
     */
    public function pickQuestionnaire(Test $test)
    {
        if ($test->getPhased()) {
            $questionnaire = $this->pickQuestionnairePhased($test);
        } else {
            $questionnaire = $this->pickQuestionnaireClassic($test);
        }

        return $questionnaire;
    }

    private function pickQuestionnaireClassic(Test $test)
    {
        $orderedQuestionnaires = $test->getOrderQuestionnaireTests();
        $questionnaireWithoutTrace = null;

        foreach ($orderedQuestionnaires as $orderedQuestionnaire) {
            $traces = $this->traceRepo->findBy(
                array(  'user' => $this->user->getId(),
                        'test' => $test->getId(),
                        'questionnaire' => $orderedQuestionnaire->getQuestionnaire()->getId(),
                ));
            if (count($traces) == 0) {
                $questionnaireWithoutTrace = $orderedQuestionnaire->getQuestionnaire();
                break;
            }
        }

        return $questionnaireWithoutTrace;
    }

    private function pickQuestionnairePhased(Test $test)
    {
        $pickedQuestionnaire = null;

        // On teste si l'utilisateur a déjà des traces pour le test courant
        if ($traces = $this->traceRepo->findBy(array('user' => $this->user, 'test' => $test))) {
            $trace = end($traces);
            $questionnaire = $lastTrace->getQuestionnaire();
            $component = $this->componentRepo->findByTrace($lastTrace);
            $orderQC = $this->orderQCRepo->findBy(array("questionnaire" => $questionnaire, "component" => $component));

            // On teste s'il existe une prochaine question pour le composant courant
            $nextInComponent = $this->nextInComponent($orderQC);
            if ($nextInComponent == null) {
                $nextComponent = $this->pickNextComponent($component);
            } else {
                $pickedQuestionnaire = $nextInComponent;
            }
        } else {
        }

        return $pickedQuestionnaire;
    }

    private function nextInComponent(OrderQuestionnaireComponent $orderQC)
    {
        $questionnaire = $orderQC->getQuestionnaire();
        $component = $orderQC->getComponent();
        $displayOrder = $orderQC->getDisplayOrder() + 1;

        if ($nextOrderQC = $this->orderQCRepo->findOneBy(array("questionnaire" => $questionnaire, "component" => $component, "displayOrder" => $displayOrder))) {
            return $nextOrderQC;
        } else {
            return;
        }
    }

    private function pickNextComponent(Component $component)
    {
        $componentType = $component->getComponentType();

        if ($componentType->getName() == "minitest") {
        } else {
            $nextComponent = null;
        }

        return $nextComponent;
    }

    private function calculateScore()
    {
        $traces = $this->traceRepo->findBy(array('user' => $this->user, 'test' => $test));
        foreach ($traces as $trace) {
        }
    }
}
