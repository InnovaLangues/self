<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\PhasedTest\Component;
use Innova\SelfBundle\Entity\PhasedTest\ComponentType;
use Innova\SelfBundle\Entity\PhasedTest\OrderQuestionnaireComponent;

/**
 * PhasedTest controller.
 *
 * @Route("admin/editor")
 * @ParamConverter("test",          isOptional="true", class="InnovaSelfBundle:Test",                     options={"id" = "testId"})
 * @ParamConverter("questionnaire", isOptional="true", class="InnovaSelfBundle:Questionnaire",            options={"id" = "questionnaireId"})
 * @ParamConverter("component",     isOptional="true", class="InnovaSelfBundle:PhasedTest\Component",     options={"id" = "componentId"})
 * @ParamConverter("type",          isOptional="true", class="InnovaSelfBundle:PhasedTest\ComponentType", options={"id" = "typeId"})
 * @ParamConverter("orderQuestionnaireComponent", isOptional="true", class="InnovaSelfBundle:PhasedTest\OrderQuestionnaireComponent", options={"id" = "orderQuestionnaireComponentId"})
 */
class PhasedTestController extends Controller
{
    /**
     * Generate a component for a test entity
     *
     * @Route("/test/{testId}/add/component/{typeId}", name="editor_generate_component")
     * @Method("GET")
     */
    public function generateComponentAction(Test $test, ComponentType $type)
    {
        $this->get("self.phasedtest.manager")->generateComponent($test, $type);

        return $this->redirect($this->generateUrl('editor_test_questionnaires_show', array('testId' => $test->getId())));
    }

    /**
     * Remove a component from a test entity
     *
     * @Route("/test/{testId}/remove/component/{componentId}", name="editor_remove_component")
     * @Method("GET")
     */
    public function removeComponentAction(Test $test, Component $component)
    {
        $this->get("self.phasedtest.manager")->removeComponent($test, $component);

        return $this->redirect($this->generateUrl('editor_test_questionnaires_show', array('testId' => $test->getId())));
    }

    /**
     * Save questionnaire order for a component
     *
     * @Route("/order/component/{componentId}", name="save-order-component-questionnaire", options={"expose"=true})
     * @Method("POST")
     */
    public function saveOrderAction(Component $component)
    {
        $newOrderArray = json_decode($this->get('request')->request->get('newOrder'));
        $this->get("self.phasedtest.manager")->saveOrder($newOrderArray);

        return new Response(null);
    }

    /**
     * Remove a questionnaire from a component
     *
     * @Route("/remove/orderQuestionnaireComponent/{orderQuestionnaireComponentId}", name="remove-component-questionnaire", options={"expose"=true})
     * @Method("POST")
     */
    public function removeQuestionnaireFromComponentAction(OrderQuestionnaireComponent $orderQuestionnaireComponent)
    {
        $this->get("self.phasedtest.manager")->removeQuestionnaireFromComponent($orderQuestionnaireComponent);

        return new Response(null);
    }

    /**
     * Create a questionnaire and add it to a component
     *
     * @Route("/component/{componentId}/add/orderQuestionnaireComponent", name="editor_create_task_component", options={"expose"=true})
     * @Method("GET")
     */
    public function createQuestionnaireToComponentAction(Component $component)
    {
        $questionnaire = $this->get("self.phasedtest.manager")->createQuestionnaireToComponent($component);

        $qId = $questionnaire->getId();

        return $this->redirect($this->generateUrl(
                'editor_questionnaire_show',
                array('questionnaireId' => $qId, 'testId' => $component->getTest()->getId())
            )
        );
    }

     /**
     * Get potential questionnaires to a component
     *
     * @Route("/potentials/{componentId}", name="get-component-potentials", options={"expose"=true})
     * @Method("POST")
     */
    public function getPotentialQuestionnairesAction(Component $component)
    {
        $questionnaires = $this->get("self.phasedtest.manager")->getPotentialQuestionnaires($component);
        $template = $this->renderView('InnovaSelfBundle:Editor/phased:potentials.html.twig', array('questionnaires' => $questionnaires));

        return new Response($template);
    }

    /**
     * Add a questionnaire to a component
     *
     * @Route("/add/component/{componentId}/questionnaire/{questionnaireId}", name="add-component-questionnaire", options={"expose"=true})
     * @Method("POST")
     */
    public function addQuestionnaireToComponentAction(Questionnaire $questionnaire, Component $component)
    {
        $this->get("self.phasedtest.manager")->addQuestionnaireToComponent($questionnaire, $component);
        $template = $this->renderView('InnovaSelfBundle:Editor/phased:tasks.html.twig', array('component' => $component));

        return new Response($template);
    }

    /**
     * Duplicate a questionnaire and add it to a component
     *
     * @Route("/duplicate/component/{componentId}/questionnaire/{questionnaireId}", name="duplicate-component-questionnaire", options={"expose"=true})
     * @Method("POST")
     */
    public function duplicateQuestionnaireToComponentAction(Questionnaire $questionnaire, Component $component)
    {
        $newQuestionnaire = $this->get("self.questionnaire.manager")->duplicate($questionnaire);
        $this->get("self.phasedtest.manager")->addQuestionnaireToComponent($newQuestionnaire, $component);
        $template = $this->renderView('InnovaSelfBundle:Editor/phased:tasks.html.twig', array('component' => $component));

        return new Response($template);
    }
}
