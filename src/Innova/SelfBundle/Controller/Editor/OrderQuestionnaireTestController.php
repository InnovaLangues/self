<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class OrderQuestionnaireTestController
 * @Route(
 *      "admin/editor",
 *      name    = "",
 *      service = "innova_editor_orderquestionnaire"
 * )
 */
class OrderQuestionnaireTestController
{
    protected $entityManager;
    protected $orderQuestionnaireTestManager;
    protected $questionnaireManager;
    protected $templating;

    public function __construct(
            $entityManager,
            $orderQuestionnaireTestManager,
            $questionnaireManager,
            $templating
    ) {
        $this->entityManager = $entityManager;
        $this->orderQuestionnaireTestManager = $orderQuestionnaireTestManager;
        $this->questionnaireManager = $questionnaireManager;
        $this->templating = $templating;
    }

    /**
     * @Route("/order-test-questionnaire", name="save-order-test-questionnaire", options={"expose"=true})
     * @Method("POST")
     */
    public function saveOrderAction(Request $request)
    {
        $em = $this->entityManager;

        $newOrderArray = json_decode($request->get('newOrder'));
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));

        $this->orderQuestionnaireTestManager->saveOrder($newOrderArray, $test);

        return new JsonResponse(null);
    }

    /**
     * @Route("/editor_add_task_to_test", name="editor_add_task_to_test", options={"expose"=true})
     * @Method("PUT")
     */
    public function addTaskToTestAction(Request $request)
    {
        $em = $this->entityManager;

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));

        $this->orderQuestionnaireTestManager->createOrderQuestionnaireTest($test, $questionnaire);
        $orders = $test->getOrderQuestionnaireTests();

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:tasksList.html.twig', array('orders' => $orders));

        return new Response($template);
    }

    /**
     * @Route("/editor_duplicate_task_to_test", name="editor_duplicate_task_to_test", options={"expose"=true})
     * @Method("PUT")
     */
    public function duplicateTaskToTestAction(Request $request)
    {
        $em = $this->entityManager;

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));

        $newQuestionnaire = $this->questionnaireManager->duplicate($questionnaire);

        $this->orderQuestionnaireTestManager->createOrderQuestionnaireTest($test, $newQuestionnaire);
        $orders = $test->getOrderQuestionnaireTests();

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:tasksList.html.twig', array('orders' => $orders));

        return new Response($template);
    }

    /**
     * @Route("/delete-task", name="delete-task", options={"expose"=true})
     * @Method("POST")
     */
    public function deleteTaskAction(Request $request)
    {
        $em = $this->entityManager;

        $testId = $request->get('testId');
        $questionnaireId = $request->get('questionnaireId');

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);

        $taskToRemove = $em->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')->findOneBy(array(
                                                                                            'test' => $test,
                                                                                            'questionnaire' => $questionnaire,
                                                                                        ));
        $em->remove($taskToRemove);
        $em->flush();

        $this->orderQuestionnaireTestManager->recalculateOrder($test);

        return new JsonResponse(
            array()
        );
    }
}
