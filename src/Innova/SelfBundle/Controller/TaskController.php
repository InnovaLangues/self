<?php

namespace Innova\SelfBundle\Controller;

use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Manager\TaskManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
 * Class TaskController.
 *
 * @Route(
 *      "/admin",
 *      service = "innova_editor_task"
 * )
 * @ParamConverter("questionnaire", isOptional="true", class="InnovaSelfBundle:Questionnaire",  options={"id" = "questionnaireId"})
 * @ParamConverter("test",          isOptional="true", class="InnovaSelfBundle:Test",           options={"id" = "testId"})
 * @ParamConverter("language",      isOptional="true", class="InnovaSelfBundle:Language",       options={"id" = "languageId"})
 */
class TaskController
{
    protected $taskManager;
    protected $questionnaireManager;
    protected $questionManager;
    protected $orderQuestionnaireTestManager;
    protected $entityManager;
    protected $formFactory;
    protected $securityContext;
    protected $voter;
    protected $rightManager;

    public function __construct(
        TaskManager $taskManager,
        $questionnaireManager,
        $questionManager,
        $orderQuestionnaireTestManager,
        $entityManager,
        $formFactory,
        $securityContext,
        $voter,
        $rightManager
    ) {
        $this->taskManager = $taskManager;
        $this->questionnaireManager = $questionnaireManager;
        $this->questionManager = $questionManager;
        $this->orderQuestionnaireTestManager = $orderQuestionnaireTestManager;
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->securityContext = $securityContext;
        $this->voter = $voter;
        $this->rightManager = $rightManager;
    }

    /**
     * Lists all Questionnaire entities.
     *
     * @Route("/tasks", name="editor_questionnaires_show")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:listQuestionnaires.html.twig")
     */
    public function listQuestionnairesAction()
    {
        $this->voter->isAllowed('right.listtask');

        $questionnaires = $this->taskManager->listQuestionnaires();

        return array('questionnaires' => $questionnaires);
    }

    /**
     * Lists all Questionnaire entities for a given language.
     *
     * @Route("/tasks/language/{languageId}", name="editor_questionnaires_by_language_show")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:listQuestionnaires.html.twig")
     */
    public function listQuestionnairesByLanguageAction(Language $language)
    {
        $this->voter->isAllowed('right.listtask');

        $questionnaires = $this->taskManager->listQuestionnairesByLanguage($language);

        return [
            'questionnaires' => $questionnaires,
            'language' => $language
        ];
    }

    /**
     * Lists all Questionnaire entities for a given author.
     *
     * @Route("/tasks/author/{id}", name="editor_questionnaires_by_author")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:listQuestionnaires_byAuthor.html.twig")
     */
    public function listQuestionnairesByAuthorAction(User $author)
    {
        $this->voter->isAllowed('right.listtask');

        $questionnaires = $this->taskManager->listQuestionnairesByAuthor($author);

        return [
            'questionnaires' => $questionnaires,
            'author' => $author
        ];
    }

    /**
     * Lists all Questionnaire entities for a given author.
     *
     * @Route("/tasks/revisor/{id}", name="editor_questionnaires_by_revisor")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:listQuestionnaires_byRevisor.html.twig")
     */
    public function listQuestionnairesByRevisorAction(Request $request, User $revisor)
    {
        $this->voter->isAllowed('right.listtask');

        $questionnaires = $this->taskManager->listQuestionnairesByRevisor($revisor);

        return [
            'questionnaires' => $questionnaires,
            'revisor' => $revisor
        ];
    }

    /**
     * Lists all Questionnaire entities for a test (ordered).
     *
     * @Route("/test/{testId}/tasks", name="editor_test_questionnaires_show", options={"expose"=true})
     * @Method("GET")
     */
    public function listTestQuestionnairesAction(Test $test)
    {
        $this->voter->isAllowed('right.managetaskstest', $test);

        $template = $this->taskManager->listTestQuestionnaires($test);

        return new Response($template);
    }

    /**
     * Lists all Questionnaire entities.
     *
     * @Route("/tasks/orphans", name="editor_questionnaires_orphan_show")
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Editor:listQuestionnaires.html.twig")
     */
    public function listOrphansAction()
    {
        $this->voter->isAllowed('right.listtask');

        $questionnaires = $this->taskManager->listOrphans();

        return array('questionnaires' => $questionnaires);
    }

    /**
     * Get questionnaires not associated yet to a test.
     *
     * @Route("/test/{testId}/potentials", name="editor_test_questionnaires_potentials", options={"expose"=true})
     * @Method("GET")
     */
    public function getPotentialQuestionnairesAction(Test $test)
    {
        $template = $this->taskManager->getPotentialQuestionnaires($test);

        return new Response($template);
    }

    /**
     * @Route("/delete-task-list/{questionnaireId}", name="delete-task-list", options={"expose"=true})
     * @Method("DELETE")
     */
    public function deleteTaskListAction(Questionnaire $questionnaire)
    {
        $this->voter->isAllowed('right.deletetask');

        $this->taskManager->deleteTask($questionnaire);

        return new JsonResponse(null);
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
        $currentUser = $this->securityContext->getToken()->getUser();
        $em = $this->entityManager;

        $test = ($testId)
            ? $em->getRepository('InnovaSelfBundle:Test')->find($testId)
            : null;

        $readOnly = ($this->rightManager->checkRight('right.editorreadonlytest', $currentUser, $test))
            ? true
            : false;

        $canEdit = ($this->rightManager->canEditTask($currentUser, $questionnaire))
            ? true
            : false;

        if ($readOnly || $canEdit) {
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
                'canEdit' => $canEdit,
            );
        }

        return;
    }

    /**
     * @Route("/questionnaire/create/{testId}", name="editor_questionnaire_create", options={"expose"=true})
     * @Method("POST")
     */
    public function createQuestionnaireAction(Request $request, Test $test = null)
    {
        $this->voter->isAllowed('right.createtask');

        $questionnaire = $this->questionnaireManager->createQuestionnaire();

        $languageId = $request->get('language');

        if ($languageId !== null) {
            $language = $this->entityManager->getRepository(Language::class)->findOneById($languageId);
            $questionnaire->setLanguage($language);
        }

        $this->questionManager->createQuestion($questionnaire);

        if ($test) {
            $this->orderQuestionnaireTestManager->createOrderQuestionnaireTest($test, $questionnaire);
            $testId = $test->getId();
        } else {
            $testId = null;
        }

        return new JsonResponse(
            array(
                'questionnaireId' => $questionnaire->getId(),
                'testId' => $testId,
            )
        );
    }
}
