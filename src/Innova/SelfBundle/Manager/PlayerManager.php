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
        // On teste si l'utilisateur a déjà des traces pour le test courant
        if ($traces = $this->traceRepo->findBy(array('user' => $this->user, 'test' => $test))) {
            $trace = end($traces);
            $questionnaire = $lastTrace->getQuestionnaire();
            $component = $this->componentRepo->findByTrace($lastTrace);
            $orderQC = $this->orderQCRepo->findBy(array("questionnaire" => $questionnaire, "component" => $component));

            // on prend le suivant pour le composant courant
            $nextOrderQuestionnaire = ;
            if (!$nextOrderQuestionnaire = $this->nextInComponent($component, $orderQC)) {
                // s'il n'existe pas on prend le prochain composant
                if ($nextComponent = $this->nextComponent($test, $component)) {
                    // on récupère le 1er élement du composant
                    $nextOrderQuestionnaire = $this->nextInComponent($nextComponent);
                } else {
                    // si pas de composant, c'est la fin
                    return null;
                }
            }
        } else {
            $nextComponent = nextComponent($test);
        }

        return $nextOrderQuestionnaire->getQuestionnaire();
    }

    private function nextInComponent(Component $component, OrderQuestionnaireComponent $orderQC = null)
    {
        $displayOrder = ($orderQC != null) ? $orderQC->getDisplayOrder() + 1 : 1;
        $nextOrderQC = $this->orderQCRepo->findOneBy(array("component" => $component, "displayOrder" => $displayOrder));

        return $nextOrderQC;
    }

    private function nextComponent(Test $test, Component $component = null)
    {
        // si on a déjà un composant, faut prendre le suivant
        if($component){
            $componentType = $component->getComponentType();
            $score = $this->calculateScore($test);
        } else {
            // sinon un minitest
            $componentType = $this->componentTypeRepo->findOneByName("minitest");
            $minitests = $this->componentRepo->findBy(array("test" => $test, "componentType" => $componentType));
        }

        return $nextComponent;
    }


    private function chooseAmongAlternatives()
    {

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
