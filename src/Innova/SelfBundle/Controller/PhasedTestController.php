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
     * Check level
     *
     * @Route("/test/{testId}/check-level", name="phased-check-level", options={"expose"=true})
     * @Method("POST")
     */
    public function checkLevelAction(Test $test)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.edittasktest", $currentUser, $test)) {
            $tasks = $this->get("self.phasedtest.manager")->checkLevel($test);

            $missingLevelTasks = array();
            foreach ($tasks as $task) {
                $missingLevelTasks[$task->getId()] = $task->getTheme();
            }

            return new JsonResponse($missingLevelTasks);
        }

        return;
    }

    /**
     * Generate a component for a test entity
     *
     * @Route("/test/{testId}/component-type/{typeId}/add", name="editor_generate_component")
     * @Method("GET")
     */
    public function generateComponentAction(Test $test, ComponentType $type)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.addtasktest", $currentUser, $test)) {
            $this->get("self.phasedtest.manager")->generateComponent($test, $type);

            return $this->redirect($this->generateUrl('editor_test_questionnaires_show', array('testId' => $test->getId())));
        }

        return;
    }

    /**
     * Remove a component from a test entity
     *
     * @Route("/test/{testId}/component/{componentId}/remove", name="editor_remove_component", options={"expose"=true})
     * @Method("GET")
     */
    public function removeComponentAction(Test $test, Component $component)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.deletetasktest", $currentUser, $test)) {
            $this->get("self.phasedtest.manager")->removeComponent($test, $component);

            return $this->redirect($this->generateUrl('editor_test_questionnaires_show', array('testId' => $test->getId())));
        }

        return;
    }

    /**
     * Save questionnaire order for a component
     *
     * @Route("/component/{componentId}/order", name="save-order-component-questionnaire", options={"expose"=true})
     * @Method("POST")
     */
    public function saveOrderAction(Component $component)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.reordertasktest", $currentUser, $component->getTest())) {
            $newOrderArray = json_decode($this->get('request')->request->get('newOrder'));
            $this->get("self.phasedtest.manager")->saveOrder($newOrderArray);

            return new Response(null);
        }

        return;
    }

    /**
     * Remove a questionnaire from a component
     *
     * @Route("/orderQuestionnaireComponent/{orderQuestionnaireComponentId}/remove", name="remove-component-questionnaire", options={"expose"=true})
     * @Method("POST")
     */
    public function removeQuestionnaireFromComponentAction(OrderQuestionnaireComponent $orderQuestionnaireComponent)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.deletetasktest", $currentUser, $orderQuestionnaireComponent->getComponent()->getTest())) {
            $this->get("self.phasedtest.manager")->removeQuestionnaireFromComponent($orderQuestionnaireComponent);

            return new Response(null);
        }

        return;
    }

    /**
     * Create a questionnaire and add it to a component
     *
     * @Route("/component/{componentId}/create-task", name="editor_create_task_component", options={"expose"=true})
     * @Method("GET")
     */
    public function createQuestionnaireToComponentAction(Component $component)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.addtasktest", $currentUser, $component->getTest())) {
            $questionnaire = $this->get("self.phasedtest.manager")->createQuestionnaireToComponent($component);

            $qId = $questionnaire->getId();

            return $this->redirect($this->generateUrl(
                    'editor_questionnaire_show',
                    array('questionnaireId' => $qId, 'testId' => $component->getTest()->getId())
                )
            );
        }

        return;
    }

     /**
     * Get potential questionnaires to a component
     *
     * @Route("/component/{componentId}/potentials", name="get-component-potentials", options={"expose"=true})
     * @Method("POST")
     */
    public function getPotentialQuestionnairesAction(Component $component)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.addtasktest", $currentUser, $component->getTest())) {
            $questionnaires = $this->get("self.phasedtest.manager")->getPotentialQuestionnaires($component);
            $template = $this->renderView('InnovaSelfBundle:Editor/phased:potentials.html.twig', array('questionnaires' => $questionnaires));

            return new Response($template);
        }

        return;
    }

    /**
     * Add a questionnaire to a component
     *
     * @Route("/component/{componentId}/questionnaire/{questionnaireId}/add-task", name="add-component-questionnaire", options={"expose"=true})
     * @Method("POST")
     */
    public function addQuestionnaireToComponentAction(Questionnaire $questionnaire, Component $component)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.addtasktest", $currentUser, $component->getTest())) {
            $this->get("self.phasedtest.manager")->addQuestionnaireToComponent($questionnaire, $component);
            $template = $this->renderView('InnovaSelfBundle:Editor/phased:tasks.html.twig', array('component' => $component));

            return new Response($template);
        }

        return;
    }

    /**
     * Duplicate a questionnaire and add it to a component
     *
     * @Route("/duplicate/component/{componentId}/questionnaire/{questionnaireId}", name="duplicate-component-questionnaire", options={"expose"=true})
     * @Method("POST")
     */
    public function duplicateQuestionnaireToComponentAction(Questionnaire $questionnaire, Component $component)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.addtasktest", $currentUser, $component->getTest())) {
            $newQuestionnaire = $this->get("self.questionnaire.manager")->duplicate($questionnaire);
            $this->get("self.phasedtest.manager")->addQuestionnaireToComponent($newQuestionnaire, $component);
            $template = $this->renderView('InnovaSelfBundle:Editor/phased:tasks.html.twig', array('component' => $component));

            return new Response($template);
        }

        return;
    }

    /**
     * Duplicate a questionnaire and add it to a component
     *
     * @Route("/test/{testId}/edit-params", name="editor_phased_params", options={"expose"=true})
     * @Method({"GET", "POST"})
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
                    if ($params->getGeneralScoreThresholds()->contains($threshold) == false) {
                        $em->remove($threshold);
                    }
                }
                foreach ($scoreThresholds as $threshold) {
                    if ($params->getSkillScoreThresholds()->contains($threshold) == false) {
                        $em->remove($threshold);
                    }
                }

                // link thresholds to params
                foreach ($params->getGeneralScoreThresholds() as $threshold) {
                    $threshold->setPhasedParam($params);
                }

                foreach ($params->getSkillScoreThresholds() as $threshold) {
                    $threshold->setPhasedParam($params);
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
