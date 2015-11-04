<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;

/**
 * Class OrderQuestionnaireTestController.
 *
 * @Route(
 *      "/admin",
 *      service = "innova_editor_orderquestionnaire"
 * )
 * @ParamConverter("test", isOptional="true", class="InnovaSelfBundle:Test", options={"id" = "testId"})
 * @ParamConverter("questionnaire", isOptional="true", class="InnovaSelfBundle:Questionnaire", options={"id" = "questionnaireId"})
 */
class OrderQuestionnaireTestController
{
    protected $orderQuestionnaireTestManager;
    protected $questionnaireManager;
    protected $templating;
    protected $voter;

    public function __construct(
        $orderQuestionnaireTestManager,
        $questionnaireManager,
        $templating,
        $voter
    ) {
        $this->orderQuestionnaireTestManager = $orderQuestionnaireTestManager;
        $this->questionnaireManager = $questionnaireManager;
        $this->templating = $templating;
        $this->voter = $voter;
    }

    /**
     * @Route("/order-test-questionnaire/{testId}", name="save-order-test-questionnaire", options={"expose"=true})
     * @Method("POST")
     */
    public function saveOrderAction(Request $request, Test $test)
    {
        $this->voter->isAllowed('right.reordertasktest', $test);

        $newOrderArray = json_decode($request->get('newOrder'));
        $this->orderQuestionnaireTestManager->saveOrder($newOrderArray, $test);

        return new JsonResponse(null);
    }

    /**
     * @Route("/editor_add_task_to_test/{testId}/{questionnaireId}", name="editor_add_task_to_test", options={"expose"=true})
     * @Method("PUT")
     */
    public function addTaskToTestAction(Test $test, Questionnaire $questionnaire)
    {
        $this->voter->isAllowed('right.addtasktest', $test);

        $this->orderQuestionnaireTestManager->createOrderQuestionnaireTest($test, $questionnaire);
        $orders = $test->getOrderQuestionnaireTests();

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:tasksList.html.twig', array('orders' => $orders));

        return new Response($template);
    }

    /**
     * @Route("/editor_duplicate_task_to_test/{testId}/{questionnaireId}", name="editor_duplicate_task_to_test", options={"expose"=true})
     * @Method("PUT")
     */
    public function duplicateTaskToTestAction(Test $test, Questionnaire $questionnaire)
    {
        $this->voter->isAllowed('right.addtasktest', $test);

        $newQuestionnaire = $this->questionnaireManager->duplicate($questionnaire);
        $this->orderQuestionnaireTestManager->createOrderQuestionnaireTest($test, $newQuestionnaire);
        $orders = $test->getOrderQuestionnaireTests();

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:tasksList.html.twig', array('orders' => $orders));

        return new Response($template);
    }

    /**
     * @Route("/delete-task/{testId}/{questionnaireId}", name="delete-task", options={"expose"=true})
     * @Method("POST")
     */
    public function deleteTaskAction(Test $test, Questionnaire $questionnaire)
    {
        $this->voter->isAllowed('right.deletetasktest', $test);

        $this->orderQuestionnaireTestManager->deleteTask($test, $questionnaire);

        return new JsonResponse(null);
    }
}
