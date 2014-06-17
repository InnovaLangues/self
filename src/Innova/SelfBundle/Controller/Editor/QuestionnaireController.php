<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Question;
use Innova\SelfBundle\Entity\OrderQuestionnaireTest;

/**
 * Class QuestionnaireController
 * @Route(
 *      "admin/editor",
 *      name    = "",
 *      service = "innova_editor_questionnaire"
 * )
 */

class QuestionnaireController
{

    protected $questionnaireManager;
    protected $questionManager;
    protected $orderQuestionnaireTestManager;
    protected $entityManager;
    protected $request;
    protected $templating;

    public function __construct(
            $questionnaireManager,
            $questionManager,
            $orderQuestionnaireTestManager,
            $entityManager,
            $templating
    )
    {
        $this->questionnaireManager = $questionnaireManager;
        $this->questionManager = $questionManager;
        $this->orderQuestionnaireTestManager = $orderQuestionnaireTestManager;
        $this->entityManager = $entityManager;
        $this->templating = $templating;

    }

    public function setRequest(Request $request = null)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Lists all Questionnaire entities.
     *
     * @Route("/tests", name="editor_tests_show")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:listTests.html.twig")
     */
    public function listTestsAction()
    {
        $em = $this->entityManager;

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
        $em = $this->entityManager;

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
     * @Route("/test/{testId}/questionnaire/{questionnaireId}", name="editor_questionnaire_show", options={"expose"=true})
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:index.html.twig")
     */
    public function showAction($testId, $questionnaireId)
    {

        $em = $this->entityManager;

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
     *
     * @Route("questionnaire/create", name="editor_questionnaire_create", options={"expose"=true})
     * @Method("POST")
     */
    public function createQuestionnaireAction()
    {

        $em = $this->entityManager;
        $request = $this->request->request;
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));

        $questionnaire = $this->questionnaireManager->createQuestionnaire($test);
        $question = $this->questionManager->createQuestion($questionnaire);
        $orderQuestionnaireTest = $this->orderQuestionnaireTestManager->createOrderQuestionnaireTest($test, $questionnaire);

        return new JsonResponse(
            array(
                'questionnaireId' =>  $questionnaire->getId(),
                'testId' => $test->getId()
            )
        );

    }

    /**
     *
     * @Route("/questionnaires/set-theme", name="editor_questionnaire_set-theme", options={"expose"=true})
     * @Method("POST")
     */
    public function setThemeAction()
    {
        $request = $this->request;
        $em = $this->entityManager;
        $questionnaireId = $request->request->get('questionnaireId');
        $theme = $request->request->get('theme');

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        $questionnaire->setTheme($theme);
        $em->persist($questionnaire);
        $em->flush();

        return new JsonResponse(
            array(
                'theme' => $questionnaire->getTheme(),
            )
        );
    }

    /**
     *
     * @Route("/questionnaires/set-fixed-order", name="editor_questionnaire_set-fixed-order", options={"expose"=true})
     * @Method("POST")
     */
    public function setFixedOrderAction()
    {
        $request = $this->request;
        $em = $this->entityManager;
        $questionnaireId = $request->request->get('questionnaireId');
        $isChecked = $request->request->get('isChecked');

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        $questionnaire->setFixedOrder($isChecked);
        $em->persist($questionnaire);
        $em->flush();

        return new JsonResponse(
            array()
        );
    }

    /**
     *
     * @Route("/questionnaires/set-skill", name="editor_questionnaire_set-skill", options={"expose"=true})
     * @Method("POST")
     */
    public function setSkillAction()
    {
        $request = $this->request;
        $em = $this->entityManager;
        $questionnaireId = $request->request->get('questionnaireId');
        $skillName = $request->request->get('skill');

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        if (!$skill = $em->getRepository('InnovaSelfBundle:Skill')->findOneByName($skillName)) {
            $skill = null;
        }

        $questionnaire->setSkill($skill);
        $em->persist($questionnaire);
        $em->flush();

        return new JsonResponse(
            array(
                'skill' => $skill,
            )
        );
    }

    /**
     *
     * @Route("/questionnaires/set-level", name="editor_questionnaire_set-level", options={"expose"=true})
     * @Method("POST")
     */
    public function setLevelAction()
    {
        $request = $this->request;
        $em = $this->entityManager;
        $questionnaireId = $request->request->get('questionnaireId');
        $levelName = $request->request->get('level');

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        if (!$level = $em->getRepository('InnovaSelfBundle:Level')->findOneByName($levelName)) {
            $level = null;
        }
        $questionnaire->setLevel($level);
        $em->persist($questionnaire);
        $em->flush();

        return new JsonResponse(
            array(
                'level' => $level,
            )
        );
    }

    /**
     *
     * @Route("/questionnaires/set-typology", name="editor_questionnaire_set-typology", options={"expose"=true})
     * @Method("POST")
     */
    public function setTypologyAction()
    {
        $request = $this->request;
        $questionnaireId = $request->request->get('questionnaireId');
        $testId = $request->request->get('testId');
        $typologyName = $request->request->get('typology');

        $em = $this->entityManager;
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);

        $typology = $this->questionnaireManager->setTypology($questionnaire, $typologyName);

        $typologyName = "-";
        if ($typology = $questionnaire->getQuestions()[0]->getTypology()) {
            $typologyName = $typology->getName();
        }

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('test' => $test, 'questionnaire' => $questionnaire));

        return new JsonResponse(
            array(
                'typology'=> $typologyName,
                'subquestions' => $template
            )
        );
    }

}
