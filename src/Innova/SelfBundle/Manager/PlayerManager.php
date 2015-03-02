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
        $this->propositionRepo = $this->entityManager->getRepository('InnovaSelfBundle:Proposition');
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
                // Sinon on pioche le prochain composant
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
        $score = $this->calculateScore($component->getTest());

        if ($componentType->getName() == "minitest") {
        } else {
            $nextComponent = null;
        }

        return $nextComponent;
    }

    private function calculateScore(Test $test)
    {
        $score = 0;
        $traces = $this->traceRepo->findBy(array('user' => $this->user, 'test' => $test));
        foreach ($traces as $trace) {
            $subquestions = $trace->getQuestionnaire()->getQuestions()[0]->getSubquestions();
            foreach ($subquestions-> as $subquestion) {
                $score = ($this->subquestionCorrect($subquestion)) ? $score++;
            }
        }

        return $score;
    }

    private function subquestionCorrect(subquestion)
    {
        $correct = true;
        // Bonnes réponses attendues
        $rightProps = $this->propositionRepo->findBy(array("subquestion" => $subquestion, "rightAnswer" => true));
        // Choix de l'étudiant
        $choices = $this->propositionRepo->getByUserTraceAndSubquestion($subquestion, $this->$user);

        // Teste si les choix de l'étudiant sont présent dans les bonnes réponses.
        foreach ($choices as $choice) {
           $correct = (!$rightProps->contains($choice)) ? false;
        }

        // Teste si le nombre de réponses équivaut au nombre de réponses attendues.
        $correct = ($rightProps->count() !== $choices->count()) ? false;

        return $correct;
    }
}
