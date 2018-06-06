<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\Common\Collections\ArrayCollection;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\PhasedTest\Component;
use Innova\SelfBundle\Entity\PhasedTest\ComponentType;
use Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent;
use Innova\SelfBundle\Form\Type\PhasedParamsType;

/**
 * PhasedTest controller.
 *
 * @Route("/admin")
 * @ParamConverter("test",          isOptional="true", class="InnovaSelfBundle:Test",                     options={"id" = "testId"})
 * @ParamConverter("questionnaire", isOptional="true", class="InnovaSelfBundle:Questionnaire",            options={"id" = "questionnaireId"})
 * @ParamConverter("component",     isOptional="true", class="InnovaSelfBundle:PhasedTest\Component",     options={"id" = "componentId"})
 * @ParamConverter("type",          isOptional="true", class="InnovaSelfBundle:PhasedTest\ComponentType", options={"id" = "typeId"})
 * @ParamConverter("orderQuestionnaireComponent", isOptional="true", class="InnovaSelfBundle:PhasedTest\OrderQuestionnaireComponent", options={"id" = "orderQuestionnaireComponentId"})
 */
class PhasedTestController extends Controller
{
    /**
     * Check level.
     *
     * @Route("/test/{testId}/check-level", name="phased-check-level", options={"expose"=true})
     * @Method("GET")
     */
    public function checkLevelAction(Test $test)
    {
        $this->get('innova_voter')->isAllowed('right.edittasktest', $test);

        $tasks = $this->get('self.phasedtest.manager')->checkLevel($test);

        $missingLevelTasks = array();
        foreach ($tasks as $task) {
            $missingLevelTasks[$task->getId()] = $task->getTheme();
        }

        return new JsonResponse($missingLevelTasks);
    }

    /**
     * Generate a component for a test entity.
     *
     * @Route("/test/{testId}/component-type/{typeId}/add", name="editor_generate_component")
     * @Method("GET")
     */
    public function generateComponentAction(Test $test, ComponentType $type)
    {
        $this->get('innova_voter')->isAllowed('right.addtasktest', $test);

        $this->get('self.phasedtest.manager')->generateComponent($test, $type);

        return $this->redirect($this->generateUrl('editor_test_questionnaires_show', array('testId' => $test->getId())));
    }

    /**
     * Remove a component from a test entity.
     *
     * @Route("/test/{testId}/component/{componentId}/remove", name="editor_remove_component", options={"expose"=true})
     * @Method("GET")
     */
    public function removeComponentAction(Test $test, Component $component)
    {
        $this->get('innova_voter')->isAllowed('right.deletetasktest', $test);

        $this->get('self.phasedtest.manager')->removeComponent($test, $component);

        return $this->redirect($this->generateUrl('editor_test_questionnaires_show', array('testId' => $test->getId())));
    }

    /**
     * Remove a component from a test entity.
     *
     * @Route("/orderQuestionnaireComponent/{orderQuestionnaireComponentId}/toggleignore", name="editor_questionnaire_ignore_in_scoring", options={"expose"=true})
     * @Method("GET")
     */
    public function toggleIgnoreInScoringAction(OrderQuestionnaireComponent $orderQuestionnaireComponent)
    {
        $test = $orderQuestionnaireComponent->getComponent()->getTest();
        $this->get('innova_voter')->isAllowed('right.edittasktest', $test);

        $this->get('self.orderquestionnairecomponent.manager')->toggleIgnoreInScoring($orderQuestionnaireComponent);

        return $this->redirect($this->generateUrl('editor_test_questionnaires_show', array('testId' => $test->getId())));
    }

    /**
     * Save questionnaire order for a component.
     *
     * @Route("/component/{componentId}/order", name="save-order-component-questionnaire", options={"expose"=true})
     * @Method("PUT")
     */
    public function saveOrderAction(Component $component)
    {
        $this->get('innova_voter')->isAllowed('right.reordertasktest', $component->getTest());

        $newOrderArray = json_decode($this->get('request')->request->get('newOrder'));
        $this->get('self.phasedtest.manager')->saveOrder($newOrderArray);

        return new Response(null);
    }

    /**
     * Remove a questionnaire from a component.
     *
     * @Route("/orderQuestionnaireComponent/{orderQuestionnaireComponentId}/remove", name="remove-component-questionnaire", options={"expose"=true})
     * @Method("DELETE")
     */
    public function removeQuestionnaireFromComponentAction(OrderQuestionnaireComponent $orderQuestionnaireComponent)
    {
        $this->get('innova_voter')->isAllowed('right.deletetasktest', $orderQuestionnaireComponent->getComponent()->getTest());

        $this->get('self.phasedtest.manager')->removeQuestionnaireFromComponent($orderQuestionnaireComponent);

        return new Response(null);
    }

    /**
     * Create a questionnaire and add it to a component.
     *
     * @Route("/component/{componentId}/create-task", name="editor_create_task_component", options={"expose"=true})
     * @Method("GET")
     */
    public function createQuestionnaireToComponentAction(Component $component)
    {
        $this->get('innova_voter')->isAllowed('right.addtasktest', $component->getTest());

        $questionnaire = $this->get('self.phasedtest.manager')->createQuestionnaireToComponent($component);
        $qId = $questionnaire->getId();

        return $this->redirect($this->generateUrl(
                'editor_questionnaire_show',
                array('questionnaireId' => $qId, 'testId' => $component->getTest()->getId())
            )
        );
    }

    /**
     * Get potential questionnaires to a component.
     *
     * @Route("/component/{componentId}/potentials", name="get-component-potentials", options={"expose"=true})
     * @Method("GET")
     */
    public function getPotentialQuestionnairesAction(Component $component)
    {
        $this->get('innova_voter')->isAllowed('right.addtasktest', $component->getTest());

        $questionnaires = $this->get('self.phasedtest.manager')->getPotentialQuestionnaires($component);

        $template = $this->renderView('InnovaSelfBundle:Editor/phased:potentials.html.twig', [
            'component' => $component,
            'questionnaires' => $questionnaires
        ]);

        return new Response($template);
    }

    /**
     * Add a questionnaire to a component.
     *
     * @Route("/component/{componentId}/questionnaire/{questionnaireId}/add-task", name="add-component-questionnaire", options={"expose"=true})
     * @Method("POST")
     */
    public function addQuestionnaireToComponentAction(Questionnaire $questionnaire, Component $component)
    {
        $this->get('innova_voter')->isAllowed('right.addtasktest', $component->getTest());

        $this->get('self.phasedtest.manager')->addQuestionnaireToComponent($questionnaire, $component);
        $template = $this->renderView('InnovaSelfBundle:Editor/phased:tasks.html.twig', array('component' => $component));

        return new Response($template);
    }

    /**
     * Duplicate a questionnaire and add it to a component.
     *
     * @Route("/duplicate/component/{componentId}/questionnaire/{questionnaireId}", name="duplicate-component-questionnaire", options={"expose"=true})
     * @Method("POST")
     */
    public function duplicateQuestionnaireToComponentAction(Questionnaire $questionnaire, Component $component)
    {
        $this->get('innova_voter')->isAllowed('right.addtasktest', $component->getTest());

        $newQuestionnaire = $this->get('self.questionnaire.manager')->duplicate($questionnaire);
        $this->get('self.phasedtest.manager')->addQuestionnaireToComponent($newQuestionnaire, $component);
        $template = $this->renderView('InnovaSelfBundle:Editor/phased:tasks.html.twig', array('component' => $component));

        return new Response($template);
    }

    /**
     * Duplicate a questionnaire and add it to a component.
     *
     * @Route("/test/{testId}/edit-params", name="editor_phased_params", options={"expose"=true})
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:Editor:phased/editParams.html.twig")
     */
    public function editParamsAction(Test $test, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $params = $test->getPhasedParams();

        $thresholds = new ArrayCollection();
        foreach ($params->getGeneralScoreThresholds() as $threshold) {
            $thresholds->add($threshold);
        }

        $ignoredLevels = new ArrayCollection();
        foreach ($params->getIgnoredLevels() as $ignoredLevel) {
            $ignoredLevels->add($ignoredLevel);
        }

        $scoreThresholds = new ArrayCollection();
        foreach ($params->getSkillScoreThresholds() as $threshold) {
            $scoreThresholds->add($threshold);
        }

        $form = $this->get('form.factory')->createBuilder(new PhasedParamsType(), $params)->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                // remove unused thresholds
                foreach ($thresholds as $threshold) {
                    if ($params->getGeneralScoreThresholds()->contains($threshold) === false) {
                        $em->remove($threshold);
                    }
                }
                foreach ($scoreThresholds as $threshold) {
                    if ($params->getSkillScoreThresholds()->contains($threshold) === false) {
                        $em->remove($threshold);
                    }
                }
                foreach ($ignoredLevels as $ignoredLevel) {
                    if ($params->getIgnoredLevels()->contains($ignoredLevel) === false) {
                        $em->remove($ignoredLevel);
                    }
                }

                // link thresholds to params
                foreach ($params->getGeneralScoreThresholds() as $threshold) {
                    $threshold->setPhasedParam($params);
                }

                foreach ($params->getSkillScoreThresholds() as $threshold) {
                    $threshold->setPhasedParam($params);
                }
                foreach ($params->getIgnoredLevels() as $ignoredLevel) {
                    $ignoredLevel->setPhasedParam($params);
                }

                $em->persist($params);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'Les paramètres ont bien été modifiés.');
            } else {
                $this->get('session')->getFlashBag()->add('warning', 'error.');
            }
        }

        return array('form' => $form->createView(), 'test' => $test);
    }
}
