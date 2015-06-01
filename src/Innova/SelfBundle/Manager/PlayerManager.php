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
    protected $scoreManager;
    protected $user;

    public function __construct($entityManager, $securityContext, $scoreManager)
    {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
        $this->scoreManager = $scoreManager;
        $this->user = $this->securityContext->getToken()->getUser();
        $this->traceRepo = $this->entityManager->getRepository('InnovaSelfBundle:Trace');
        $this->componentRepo = $this->entityManager->getRepository('InnovaSelfBundle:PhasedTest\Component');
        $this->componentTypeRepo = $this->entityManager->getRepository('InnovaSelfBundle:PhasedTest\ComponentType');
        $this->orderQCRepo = $this->entityManager->getRepository('InnovaSelfBundle:PhasedTest\OrderQuestionnaireComponent');
        $this->propositionRepo = $this->entityManager->getRepository('InnovaSelfBundle:Proposition');
        $this->generalScoreRepo = $this->entityManager->getRepository('InnovaSelfBundle:PhasedTest\GeneralScoreThreshold');
    }

    /**
     * Pick a questionnaire entity for a given test not done yet by the user.
     */
    public function pickQuestionnaire(Test $test, Session $session)
    {
        if ($test->getPhased()) {
            $orderQuestionnaire = $this->pickQuestionnairePhased($test, $session);
        } else {
            $orderQuestionnaire = $this->pickQuestionnaireClassic($test, $session);
        }

        return $orderQuestionnaire;
    }

    /**
     * Picks orderedQuestionnaire for a classic test
     */
    private function pickQuestionnaireClassic(Test $test, Session $session)
    {
        $orderedQuestionnaires = $test->getOrderQuestionnaireTests();
        $questionnaireWithoutTrace = null;

        foreach ($orderedQuestionnaires as $orderedQuestionnaire) {
            $traces = $this->traceRepo->findBy(
                array(  'user' => $this->user,
                        'test' => $test->getId(),
                        'session' => $session,
                        'questionnaire' => $orderedQuestionnaire->getQuestionnaire(),
                ));
            if (count($traces) == 0) {
                $questionnaireWithoutTrace = $orderedQuestionnaire;
                break;
            }
        }

        return $questionnaireWithoutTrace;
    }

    /**
     * Picks orderedQuestionnaire for a phased test
     */
    private function pickQuestionnairePhased(Test $test, Session $session)
    {
        // On teste si l'utilisateur a déjà des traces pour le test et la session courante
        if ($traces = $this->traceRepo->findBy(array('user' => $this->user, 'test' => $test, 'session' => $session))) {
            $lastTrace = end($traces);
            $questionnaire = $lastTrace->getQuestionnaire();
            $component = $lastTrace->getComponent();
            $orderQC = $this->orderQCRepo->findOneBy(array("questionnaire" => $questionnaire, "component" => $component));

            // on prend la tâche suivante pour le composant courant
            if (!$nextOrderQuestionnaire = $this->pickNextQuestionnaire($component, $orderQC)) {
                // s'elle n'existe pas on prend le prochain composant
                if ($nextComponent = $this->pickNextComponent($test, $session, $component)) {
                    // on récupère le 1er élement du composant
                    $nextOrderQuestionnaire = $this->pickNextQuestionnaire($nextComponent);
                } else {
                    return;
                }
            }
        } else {
            $nextComponent = $this->pickNextComponent($test, $session);
            $nextOrderQuestionnaire = $this->pickNextQuestionnaire($nextComponent);
        }

        return $nextOrderQuestionnaire;
    }

    /**
     * Picks next orderQuestionnaire for a given component
     */
    private function pickNextQuestionnaire(Component $component, OrderQuestionnaireComponent $orderQC = null)
    {
        $displayOrder = ($orderQC !== null) ? $orderQC->getDisplayOrder() + 1 : 1;
        $nextOrderQC = $this->orderQCRepo->findOneBy(array("component" => $component, "displayOrder" => $displayOrder));

        return $nextOrderQC;
    }

    /**
     * Picks next component for a given test / session, depending of a possible previous one
     */
    private function pickNextComponent(Test $test, Session $session, Component $component = null)
    {
        // si on a déjà un composant, faut prendre le suivant dépendament du score et du nombre de composant déjà fait pour la session
        if ($component) {
            $componentsDone = $this->componentRepo->findDoneByUserByTestBySession($this->user, $test, $session);
            $componentType = $component->getComponentType();
            $componentTypeName = $componentType->getName();
            $componentTypeId = $componentType->getId();

            // si on a déjà fait 2 composants -> stop
            if (count($componentsDone) >= 2) {
                return;
            } else {
                if ($componentTypeName == "minitest") {
                    $nextComponentTypeName = $this->scoreManager->orientateToStep($this->user, $session, $component);
                }
            }
        } else {
            // sinon c'est qu'on commence le test alors on lui propose un minitest
            $nextComponentTypeName = "minitest";
        }

        $nextComponentType = $this->componentTypeRepo->findOneByName($nextComponentTypeName);
        $nextComponent = $this->pickComponentAmongAlternatives($nextComponentType, $test);

        return $nextComponent;
    }

    /**
     * Picks a component of a given componentType for a user.
     * Favor not done yet component in another session
     */
    private function pickComponentAmongAlternatives(ComponentType $componentType, Test $test)
    {
        if (!$candidates = $this->componentRepo->findNotDoneByTypeByUserByTest($this->user, $test, $componentType)) {
            $candidates = $this->componentRepo->findBy(array("test" => $test, "componentType" => $componentType));
        }

        $component = $candidates[array_rand($candidates)];

        return $component;
    }
}
