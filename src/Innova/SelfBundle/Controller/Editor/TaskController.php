<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Form\Type\QuestionnaireType;
use Innova\SelfBundle\Form\Type\TaskInfosType;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Language;

/**
 * Class TaskController
 * @Route(
 *      "admin/editor",
 *      name    = "",
 *      service = "innova_editor_task"
 * )
 * @ParamConverter("questionnaire", isOptional="true", class="InnovaSelfBundle:Questionnaire", options={"id" = "questionnaireId"})
 * @ParamConverter("test", isOptional="true", class="InnovaSelfBundle:Test", options={"id" = "testId"})
 * @ParamConverter("language", isOptional="true", class="InnovaSelfBundle:Language", options={"id" = "languageId"})
 */

class TaskController
{
    protected $questionnaireManager;
    protected $questionManager;
    protected $orderQuestionnaireTestManager;
    protected $entityManager;
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
    public function listQuestionnairesByLanguageAction(Language $language)
    {
        $em = $this->entityManager;
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
    public function listTestQuestionnairesAction(Test $test)
    {
        $em = $this->entityManager;

        if ($test->getPhased()) {
            $template = $this->templating->render('InnovaSelfBundle:Editor/phased:test.html.twig', array('test' => $test));
        } else {
            $orders = $test->getOrderQuestionnaireTests();
            $potentialQuestionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->getPotentialByTest($test);
            $template = $this->templating->render('InnovaSelfBundle:Editor:listTestQuestionnaires.html.twig', array('test' => $test, 'orders' => $orders, 'potentialQuestionnaires' => $potentialQuestionnaires));
        }

        return new Response($template);
    }

    /**
     * Get questionnaires not associated yet to a test
     *
     * @Route("/test/{testId}/potentials", name="editor_test_questionnaires_potentials", options={"expose"=true})
     * @Method("GET")
     */
    public function getPotentialQuestionnaires(Test $test)
    {
        $em = $this->entityManager;

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
    public function showAction(Questionnaire $questionnaire, $testId)
    {
        $em = $this->entityManager;

        $typologies = $em->getRepository('InnovaSelfBundle:Typology')->findAll();
        $status = $em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Status')->findAll();
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
     * @Route("/questionnaire/create/{testId}", name="editor_questionnaire_create", options={"expose"=true})
     * @Method("POST")
     */
    public function createQuestionnaireAction(Test $test = null)
    {
        $em = $this->entityManager;

        $questionnaire = $this->questionnaireManager->createQuestionnaire();
        $this->questionManager->createQuestion($questionnaire);

        if ($test) {
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
     * @Route("/delete-task-list/{questionnaireId}", name="delete-task-list", options={"expose"=true})
     * @Method("DELETE")
     */
    public function deleteTaskListAction(Questionnaire $questionnaire)
    {
        $em = $this->entityManager;
        $em->remove($questionnaire);
        $em->flush();

        return new JsonResponse(null);
    }
}
