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
 * Class OrderQuestionnaireTestController
 * @Route(
 *      "admin/editor",
 *      name    = "",
 *      service = "innova_editor_orderquestionnaire"
 * )
 * @ParamConverter("test", isOptional="true", class="InnovaSelfBundle:Test", options={"id" = "testId"})
 * @ParamConverter("questionnaire", isOptional="true", class="InnovaSelfBundle:Questionnaire", options={"id" = "questionnaireId"})
 */
class OrderQuestionnaireTestController
{
    protected $entityManager;
    protected $orderQuestionnaireTestManager;
    protected $questionnaireManager;
    protected $templating;
    protected $securityContext;
    protected $rightManager;
    protected $session;

    public function __construct(
            $entityManager,
            $orderQuestionnaireTestManager,
            $questionnaireManager,
            $templating,
            $securityContext,
            $rightManager,
            $session

    ) {
        $this->entityManager = $entityManager;
        $this->orderQuestionnaireTestManager = $orderQuestionnaireTestManager;
        $this->questionnaireManager = $questionnaireManager;
        $this->templating = $templating;
        $this->securityContext              = $securityContext;
        $this->rightManager                 = $rightManager;
        $this->session                      = $session;
    }

    /**
     * @Route("/order-test-questionnaire/{testId}", name="save-order-test-questionnaire", options={"expose"=true})
     * @Method("POST")
     */
    public function saveOrderAction(Request $request, Test $test)
    {
        $currentUser = $user = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->checkRight("right.reordertasktest", $currentUser, $test)) {
            $newOrderArray = json_decode($request->get('newOrder'));

            $this->orderQuestionnaireTestManager->saveOrder($newOrderArray, $test);
        }

        return new JsonResponse(null);
    }

    /**
     * @Route("/editor_add_task_to_test/{testId}/{questionnaireId}", name="editor_add_task_to_test", options={"expose"=true})
     * @Method("PUT")
     */
    public function addTaskToTestAction(Test $test, Questionnaire $questionnaire)
    {
        $currentUser = $user = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->checkRight("right.addtasktest", $currentUser, $test)) {
            $this->orderQuestionnaireTestManager->createOrderQuestionnaireTest($test, $questionnaire);
        }

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
        $currentUser = $user = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->checkRight("right.addtasktest", $currentUser, $test)) {
            $newQuestionnaire = $this->questionnaireManager->duplicate($questionnaire);
            $this->orderQuestionnaireTestManager->createOrderQuestionnaireTest($test, $newQuestionnaire);
        }

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
        $currentUser = $user = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->checkRight("right.deletetasktest", $currentUser, $test)) {
            $em = $this->entityManager;

            $taskToRemove = $em->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')->findOneBy(array('test' => $test, 'questionnaire' => $questionnaire));
            $em->remove($taskToRemove);
            $em->flush();

            $this->orderQuestionnaireTestManager->recalculateOrder($test);
        }

        return new JsonResponse(null);
    }
}
