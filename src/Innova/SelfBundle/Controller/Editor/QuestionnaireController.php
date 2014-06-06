<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Question;
use Innova\SelfBundle\Entity\OrderQuestionnaireTest;

/**
 * Questionnaire controller.
 *
 * @Route("admin/editor")
 */
class QuestionnaireController extends Controller
{
    /**
     * Lists all Questionnaire entities.
     *
     * @Route("/tests", name="editor_tests_show")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:listTests.html.twig")
     */
    public function listTestsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tests = $em->getRepository('InnovaSelfBundle:Test')->findAll();

        return array(
            'tests' => $tests,
        );
    }

    /**
     * Lists all Questionnaire entities.
     *
     * @Route("/test/{testId}/questionnaires", name="editor_test_questionnaires_show")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:listQuestionnaires.html.twig")
     */
    public function listQuestionnairesAction($testId)
    {
        $em = $this->getDoctrine()->getManager();

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);
        $orders = $em->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')->findByTest($testId);

        return array(
            'test' => $test,
            'orders' => $orders
        );
    }

    /**
     * Finds and displays a Questionnaire entity.
     *
     * @Route("/test/{testId}/questionnaire/{questionnaireId}", name="editor_questionnaire_show", requirements={"questionnaireId" = "\d+"})
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:index.html.twig")
     */
    public function showAction($testId, $questionnaireId)
    {

        $em = $this->getDoctrine()->getManager();

        $test = $em->getRepository('InnovaSelfBundle:test')->find($testId);
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);

        if (!$questionnaire) {
            throw $this->createNotFoundException('Unable to find Questionnaire entity ! ');
        }

        return array(
            'test' => $test,
            'questionnaire' => $questionnaire
        );
    }

    /**
     * Creates a new Questionnaire entity.
     *
     * @Route("/test/{testId}/questionnaire/create", name="editor_questionnaire_create")
     * @Method("GET")
     * @Template("")
     */
    public function createQuestionnaireAction($testId)
    {

        $em = $this->getDoctrine()->getManager();

        $questionnaire = new Questionnaire();
        $questionnaire->setTheme("");

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);
        $questionnaire->addTest($test);
        $questionnaire->setListeningLimit(0);
        $questionnaire->setDialogue(0);
        $questionnaire->setFixedOrder(0);
        $em->persist($questionnaire);

        $question = new Question();
        $question->setQuestionnaire($questionnaire);
        $em->persist($question);

        $orderQuestionnaireTest = new OrderQuestionnaireTest();
        $orderQuestionnaireTest->setTest($test);
        $orderQuestionnaireTest->setQuestionnaire($questionnaire);
        $orderMax = count($em->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')->findByTest($test));
        $orderQuestionnaireTest->setDisplayOrder($orderMax + 1);
        $em->persist($orderQuestionnaireTest);

        $em->flush();

        return $this->redirect($this->generateUrl(
                            'editor_questionnaire_show',
                            array(
                                'testId' => $testId,
                                'questionnaireId' => $questionnaire->getId()
                            )
                ));

    }

    /**
     * Updates a Questionnaire entity
     *
     * @Route("/questionnaires/{id}", name="editor_questionnaire_edit")
     * @Method("PUT")
     * @Template("")
     */
    public function editAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($id);

        if (!$questionnaire) {
            throw $this->createNotFoundException('Unable to find Questionnaire entity.');
        }

        $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Le questionnaire a été créé.'
                );

        return $this->redirect($this->generateUrl(
                        'editor_questionnaire_show',
                        array('id' => $entity->getId()))
                    );
    }

     /**
     * Delete a Questionnaire entity
     *
     * @Route("/questionnaires/{id}", name="editor_questionnaire_delete")
     * @Method("DELETE")
     * @Template("")
     */
    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($id);

        if (!$questionnaire) {
            throw $this->createNotFoundException('Unable to find Questionnaire entity.');
        }

        $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Le questionnaire a été supprimé.'
                );

        return $this->redirect($this->generateUrl(
                        'editor_questionnaire_show',
                        array('id' => $entity->getId()))
                    );
    }

}
