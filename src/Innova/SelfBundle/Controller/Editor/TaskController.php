<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Form\Type\QuestionnaireType;
use Innova\SelfBundle\Form\Type\TaskInfosType;

/**
 * Class TaskController
 * @Route(
 *      "admin/editor",
 *      name    = "",
 *      service = "innova_editor_task"
 * )
 */

class TaskController
{
    protected $questionnaireManager;
    protected $questionManager;
    protected $orderQuestionnaireTestManager;
    protected $entityManager;
    protected $request;
    protected $templating;
    protected $formFactory;

    public function __construct(
            $questionnaireManager,
            $questionManager,
            $orderQuestionnaireTestManager,
            $entityManager,
            $templating,
            $formFactory
    ) {
        $this->questionnaireManager = $questionnaireManager;
        $this->questionManager = $questionManager;
        $this->orderQuestionnaireTestManager = $orderQuestionnaireTestManager;
        $this->entityManager = $entityManager;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
    }

    public function setRequest(Request $request = null)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Lists all Questionnaire entities.
     *
     * @Route("/questionnaires", name="editor_questionnaires_show")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:listQuestionnaires.html.twig")
     */
    public function listQuestionnairesAction()
    {
        $em = $this->entityManager;

        $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->findAll();

        return array(
            'questionnaires' => $questionnaires,
        );
    }

    /**
     * Lists all Questionnaire entities.
     *
     * @Route("/questionnaires/language/{languageId}", name="editor_questionnaires_by_language_show")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:listQuestionnaires.html.twig")
     */
    public function listQuestionnairesByLanguageAction($languageId)
    {
        $em = $this->entityManager;

        $language = $em->getRepository('InnovaSelfBundle:Language')->find($languageId);
        $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->findByLanguage($language);

        return array(
            'questionnaires' => $questionnaires,
        );
    }

    /**
     * Lists all Questionnaire entities for a test (ordered)
     *
     * @Route("/test/{testId}/questionnaires", name="editor_test_questionnaires_show", options={"expose"=true})
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:listTestQuestionnaires.html.twig")
     */
    public function listTestQuestionnairesAction($testId)
    {
        $em = $this->entityManager;

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);
        $orders = $test->getOrderQuestionnaireTests();
        $potentialQuestionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->getPotentialByTest($test);

        return array(
            'test' => $test,
            'orders' => $orders,
            'potentialQuestionnaires' => $potentialQuestionnaires,
        );
    }

    /**
     * Get questionnaires not associated yet to a test
     *
     * @Route("/test/{testId}/potentials", name="editor_test_questionnaires_potentials", options={"expose"=true})
     * @Method("GET")
     */
    public function getPotentialQuestionnaires($testId)
    {
        $em = $this->entityManager;

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);
        $potentialQuestionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->getPotentialByTest($test);

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:potentialQuestionnaires.html.twig', array('test' => $test, 'potentialQuestionnaires' => $potentialQuestionnaires));

        return new Response($template);
    }

    /**
     * Finds and displays a Questionnaire entity.
     *
     * @Route("/questionnaire/{questionnaireId}/{testId}", name="editor_questionnaire_show", options={"expose"=true} , defaults={"testId" = null})
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:index.html.twig")
     */
    public function showAction($questionnaireId, $testId)
    {
        $em = $this->entityManager;

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        $typologies = $em->getRepository('InnovaSelfBundle:Typology')->findAll();
        $status = $em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Status')->findAll();

        if (!$questionnaire) {
            throw $this->createNotFoundException('Unable to find Questionnaire entity ! ');
        }

        $form = $this->formFactory->createBuilder(new QuestionnaireType(), $questionnaire)->getForm();
        $taskInfosForm = $this->formFactory->createBuilder(new TaskInfosType(), $questionnaire)->getForm();

        return array(
            'questionnaire' => $questionnaire,
            'typologies' => $typologies,
            'status' => $status,
            'testId' => $testId,
            'form' => $form->createView(),
            'taskInfosForm' => $taskInfosForm->createView(),
        );
    }

    /**
     *
     * @Route("/questionnaire/create", name="editor_questionnaire_create", options={"expose"=true})
     * @Method("POST")
     */
    public function createQuestionnaireAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $questionnaire = $this->questionnaireManager->createQuestionnaire();
        $this->questionManager->createQuestion($questionnaire);

        if ($test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'))) {
            $this->orderQuestionnaireTestManager->createOrderQuestionnaireTest($test, $questionnaire);
            $testId = $test->getId();
        } else {
            $testId = null;
        }

        return new JsonResponse(
            array(
                'questionnaireId' =>  $questionnaire->getId(),
                'testId' => $testId,
            )
        );
    }

     /**
     * @Route("/delete-task-list", name="delete-task-list", options={"expose"=true})
     * @Method("DELETE")
     * @Template("")
     */
    public function deleteTaskListAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $questionnaireId = $request->get('questionnaireId');

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);

        $em->remove($questionnaire);
        $em->flush();

        return new JsonResponse(
            array()
        );
    }
}
