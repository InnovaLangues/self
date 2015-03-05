<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Session;
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
    public function pickQuestionnaire(Test $test, Session $session)
    {
        if ($test->getPhased()) {
            $questionnaire = $this->pickQuestionnairePhased($test, $session);
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

    private function pickQuestionnairePhased(Test $test, Session $session)
    {
        // On teste si l'utilisateur a déjà des traces pour le test et la session courante
        if ($traces = $this->traceRepo->findBy(array('user' => $this->user, 'test' => $test, 'session' => $session))) {
            $trace = end($traces);
            $questionnaire = $lastTrace->getQuestionnaire();
            $component = $lastTrace->getComponent();
            $orderQC = $this->orderQCRepo->findBy(array("questionnaire" => $questionnaire, "component" => $component));

            // on prend la tâche suivante pour le composant courant
            if (!$nextOrderQuestionnaire = $this->nextInComponent($component, $orderQC)) {
                // s'il n'existe pas on prend le prochain composant
                if ($nextComponent = $this->nextComponent($test, $session, $component)) {
                    // on récupère le 1er élement du composant
                    $nextOrderQuestionnaire = $this->nextInComponent($nextComponent);
                } else {
                    // si pas de composant, c'est la fin
                    return null;
                }
            }
        } else {
            $nextComponent = nextComponent($test, $session);
        }

        return $nextOrderQuestionnaire->getQuestionnaire();
    }

    private function nextInComponent(Component $component, OrderQuestionnaireComponent $orderQC = null)
    {
        $displayOrder = ($orderQC != null) ? $orderQC->getDisplayOrder() + 1 : 1;
        $nextOrderQC = $this->orderQCRepo->findOneBy(array("component" => $component, "displayOrder" => $displayOrder));

        return $nextOrderQC;
    }

    private function nextComponent(Test $test, Session $session, Component $component = null)
    {
        // si on a déjà un composant, faut prendre le suivant dépendament du score et du nombre de composant déjà fait pour la session
        if($component){
            $componentsDone = $this->componentRepo->findDoneByUserByTestBySession($user, $test, $session)
            $componentType = $component->getComponentType();
            if (count($componentsDone) >= 3) {
                return null;   
            }
            else {
               $score = $this->calculateScore($test, $session, $component);
               if ($componentType->getName("minitest")) {
                   if ($score < 20) {
                        $nextComponentTypeName = "step1";
                   } elseif ($score < 40){
                        $nextComponentTypeName = "step2";
                   } elseif ($score < 80){
                        $nextComponentTypeName = "step3";
                   } else {
                        $nextComponentTypeName = "step4";
                   }
               } else {
                    if ($score < 20) {
                        // on choisit un componentType d'un rang inférieur à celui courant si possible (pas possible avec le step1)
                    } elseif ($score > 80) {
                        // on choisit un componentType d'un rang supérieur à celui courant si possible (pas possible avec le step4)
                    } else {
                        return null;
                    }
               }
            }
        } else {
            // sinon un minitest
            $nextComponentTypeName = "minitest";
        }

        $nextComponentType = $this->componentTypeRepo->findByName($nextComponentTypeName);
        $nextComponent = $this->pickComponentAmongAlternatives($nextComponentType, $test, $session);

        return $nextComponent;
    }

    private function pickComponentAmongAlternatives(ComponentType $componentType, Test $test, Session $session){

    }

    private function calculateScore(Test $test, Session $session, Component $component)
    {
        $score = 0;
        $traces = $this->traceRepo->findBy(array('user' => $this->user, 'test' => $test, 'session' => $session, 'component' => $component));
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
        $choices = $this->propositionRepo->getByUserTraceAndSubquestion($subquestion, $this->$user, $component, $session);

        // Teste si les choix de l'étudiant sont présent dans les bonnes réponses.
        foreach ($choices as $choice) {
           $correct = (!$rightProps->contains($choice)) ? false;
        }

        // Teste si le nombre de réponses équivaut au nombre de réponses attendues.
        $correct = ($rightProps->count() !== $choices->count()) ? false;

        return $correct;
    }
}
