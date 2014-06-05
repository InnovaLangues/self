<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Question;
use Innova\SelfBundle\Entity\OrderQuestionnaireTest;


/**
 * OrderQuestionnaireTestController controller for editor
 *
 * @Route("admin/editor")
 */
class OrderQuestionnaireTestController extends Controller
{
    /**
     * @Route("/order-test-questionnaire", name="save-order-test-questionnaire", options={"expose"=true})
     * @Method("POST")
     * @Template("")
     */
    public function saveOrderAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request')->request;

        $testId = $request->get('testId');
        $newOrder = $request->get('newOrder');
        $newOrderArray = json_decode($newOrder);
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);

        $entitiesToRemove = $em->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')->findByTest($test);
        foreach ($entitiesToRemove as $entity) {
            $em->remove($entity);
        }

        $i = 1;
        foreach ($newOrderArray as $questionnaireId) {
            $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
            $orderQuestionnaireTest = new OrderQuestionnaireTest();
            $orderQuestionnaireTest->setTest($test);
            $orderQuestionnaireTest->setQuestionnaire($questionnaire);
            $orderQuestionnaireTest->setDisplayOrder($i);
            $em->persist($orderQuestionnaireTest);
            $i++;
        }
        $em->flush();

        return new JsonResponse(
            array()
        );
    }

    
}