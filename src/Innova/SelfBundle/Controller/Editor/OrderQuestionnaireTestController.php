<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;



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
    protected $templating;
    protected $request;

    public function __construct(
            $entityManager,
            $orderQuestionnaireTestManager,
            $templating
    )
    {
        $this->entityManager = $entityManager;
        $this->orderQuestionnaireTestManager = $orderQuestionnaireTestManager;
        $this->templating = $templating;

    }

    public function setRequest(Request $request = null)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @Route("/order-test-questionnaire", name="save-order-test-questionnaire", options={"expose"=true})
     * @Method("POST")
     * @Template("")
     */
    public function saveOrderAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $newOrderArray = json_decode($request->get('newOrder'));
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));

        $entitiesToRemove = $em->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')->findByTest($test);
        foreach ($entitiesToRemove as $entity) {
            $em->remove($entity);
        }
        $em->flush();

        foreach ($newOrderArray as $questionnaireId) {
            $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
            $this->orderQuestionnaireTestManager->createOrderQuestionnaireTest($test, $questionnaire);
        }

        return new JsonResponse(null);
    }

    /**
     * @Route("/editor_add_task_to_test", name="editor_add_task_to_test", options={"expose"=true})
     * @Method("POST")
     * @Template("")
     */
    public function addTaskToTestAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));

        $this->orderQuestionnaireTestManager->createOrderQuestionnaireTest($test, $questionnaire);

        $orders = $em->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')->findByTest($test);

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:tasksList.html.twig',array('orders' => $orders));
        
        return new Response($template);
    }

    /**
     * @Route("/delete-task", name="delete-task", options={"expose"=true})
     * @Method("POST")
     * @Template("")
     */
    public function deleteTaskAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $testId = $request->get('testId');
        $questionnaireId = $request->get('questionnaireId');

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);

        $taskToRemove = $em->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')->findOneBy(array(
                                                                                            'test' => $test,
                                                                                            'questionnaire' => $questionnaire
                                                                                        ));
        $em->remove($taskToRemove);
        $em->flush();

        $this->orderQuestionnaireTestManager->recalculateOrder($test);

        return new JsonResponse(
            array()
        );
    }

}
