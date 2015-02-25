<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\PhasedTest\Component;
use Innova\SelfBundle\Entity\PhasedTest\ComponentType;

/**
 * PhasedTest controller.
 *
 * @Route("admin/editor")
 * @ParamConverter("test",          isOptional="true", class="InnovaSelfBundle:Test",                     options={"id" = "testId"})
 * @ParamConverter("questionnaire", isOptional="true", class="InnovaSelfBundle:Questionnaire",            options={"id" = "questionnaireId"})
 * @ParamConverter("component",     isOptional="true", class="InnovaSelfBundle:PhasedTest\Component",     options={"id" = "componentId"})
 * @ParamConverter("type",          isOptional="true", class="InnovaSelfBundle:PhasedTest\ComponentType", options={"id" = "typeId"})
 */
class PhasedTestController extends Controller
{
    /**
     * Toggle phased attribute of a test entity.
     *
     * @Route("/phase/test/{testId}", name="editor_test_phase")
     * @Method("GET")
     */
    public function phaseTestAction(Test $test)
    {
        $this->get("self.test.manager")->togglePhased($test);

        return $this->redirect($this->generateUrl('editor_tests_show'));
    }

    /**
     * Generate a component for a test entity
     *
     * @Route("/test/{testId}/add/component/{typeId}", name="editor_generate_component")
     * @Method("GET")
     */
    public function generateComponent(Test $test, ComponentType $type)
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
    public function removeComponent(Test $test, Component $component)
    {
        $this->get("self.phasedtest.manager")->removeComponent($test, $component);

        return $this->redirect($this->generateUrl('editor_test_questionnaires_show', array('testId' => $test->getId())));
    }

    /**
     * Save questionnaire order for a component
     *
     * @Route("/order/{componentId}", name="save-order-component-questionnaire", options={"expose"=true})
     * @Method("POST")
     */
    public function saveOrder(Component $component)
    {
        $newOrderArray = json_decode($this->get('request')->request->get('newOrder'));
        $this->get("self.phasedtest.manager")->saveOrder($newOrder, $component);

        return new JsonResponse(null);
    }

    /**
     * Remove a questionnaire from a component
     *
     * @Route("/remove/component/{componentId}/questionnaire/{questionnaireId}", name="remove-component-questionnaire", options={"expose"=true})
     * @Method("POST")
     */
    public function removeQuestionnaireFromComponent(Questionnaire $questionnaire, Component $component)
    {
        $this->get("self.phasedtest.manager")->removeQuestionnaireFromComponent($questionnaire, $component);

        return new JsonResponse(null);
    }

    /**
     * Add a questionnaire to a component
     *
     * @Route("/add/component/{componentId}/questionnaire/{questionnaireId}", name="add-component-questionnaire", options={"expose"=true})
     * @Method("POST")
     */
    public function addQuestionnaireToComponent(Questionnaire $questionnaire, Component $component)
    {
        $this->get("self.phasedtest.manager")->addQuestionnaireToComponent($questionnaire, $component);

        return new JsonResponse(null);
    }
}
