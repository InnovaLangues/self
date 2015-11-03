<?php

namespace Innova\SelfBundle\Controller;

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
 *      "/admin",
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
    protected $securityContext;
    protected $voter;
    protected $rightManager;
    protected $session;
    protected $router;

    public function __construct(
            $questionnaireManager,
            $questionManager,
            $orderQuestionnaireTestManager,
            $entityManager,
            $templating,
            $formFactory,
            $securityContext,
            $voter,
            $rightManager,
            $session,
            $router
    ) {
        $this->questionnaireManager         = $questionnaireManager;
        $this->questionManager              = $questionManager;
        $this->orderQuestionnaireTestManager    = $orderQuestionnaireTestManager;
        $this->entityManager                = $entityManager;
        $this->templating                   = $templating;
        $this->formFactory                  = $formFactory;
        $this->securityContext              = $securityContext;
        $this->voter                        = $voter;
        $this->rightManager                 = $rightManager;
        $this->session                      = $session;
        $this->router                       = $router;
    }

    /**
     * Lists all Questionnaire entities.
     *
     * @Route("/tasks", name="editor_questionnaires_show")
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Editor:listQuestionnaires.html.twig")
     */
    public function listQuestionnairesAction()
    {
        $this->voter->isAllowed("right.listtask");

        $currentUser = $this->securityContext->getToken()->getUser();
        $em = $this->entityManager;
        if ($currentUser->getPreferedLanguage()) {
            $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->findByLanguage($currentUser->getPreferedLanguage());
        } else {
            $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->findAll();
        }

        return array('questionnaires' => $questionnaires);
    }

    /**
     * Lists all Questionnaire entities.
     *
     * @Route("/tasks/language/{languageId}", name="editor_questionnaires_by_language_show")
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Editor:listQuestionnaires.html.twig")
     */
    public function listQuestionnairesByLanguageAction(Language $language)
    {
        $this->voter->isAllowed("right.listtask");

        $questionnaires = $this->entityManager->getRepository('InnovaSelfBundle:Questionnaire')->findByLanguage($language);

        return array('questionnaires' => $questionnaires);
    }

    /**
     * Lists all Questionnaire entities for a test (ordered)
     *
     * @Route("/test/{testId}/tasks", name="editor_test_questionnaires_show", options={"expose"=true})
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Editor:listTestQuestionnaires.html.twig")
     */
    public function listTestQuestionnairesAction(Test $test)
    {
        $this->voter->isAllowed("right.managetaskstest", $test);
        
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
     * Lists all Questionnaire entities.
     *
     * @Route("/tasks/orphans", name="editor_questionnaires_orphan_show")
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Editor:listQuestionnaires.html.twig")
     */
    public function listOrphansAction()
    {
        $this->voter->isAllowed("right.listtask");

        $questionnaires = $this->entityManager->getRepository('InnovaSelfBundle:Questionnaire')->findOrphans();

        return array('questionnaires' => $questionnaires);
    }

    /**
     * Get questionnaires not associated yet to a test
     *
     * @Route("/test/{testId}/potentials", name="editor_test_questionnaires_potentials", options={"expose"=true})
     * @Method("GET")
     *
     */
    public function getPotentialQuestionnairesAction(Test $test)
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
     *
     * @Template("InnovaSelfBundle:Editor:index.html.twig")
     */
    public function showAction(Questionnaire $questionnaire, $testId)
    {
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
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

        return;
    }

    /**
     *
     * @Route("/questionnaire/create/{testId}", name="editor_questionnaire_create", options={"expose"=true})
     * @Method("POST")
     *
     */
    public function createQuestionnaireAction(Test $test = null)
    {
        $this->voter->isAllowed("right.createtask");

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
     *
     */
    public function deleteTaskListAction(Questionnaire $questionnaire)
    {
        $this->voter->isAllowed("right.deletetask");

        $em = $this->entityManager;
        $em->remove($questionnaire);
        $em->flush();

        return new JsonResponse(null);
    }
}
