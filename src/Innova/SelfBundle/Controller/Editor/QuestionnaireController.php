<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
    protected $orderQuestionnaireTestManager;
    protected $editorLogManager;
    protected $entityManager;
    protected $request;
    protected $templating;

    public function __construct(
            $questionnaireManager,
            $orderQuestionnaireTestManager,
            $editorLogManager,
            $entityManager,
            $templating
    )
    {
        $this->questionnaireManager = $questionnaireManager;
        $this->orderQuestionnaireTestManager = $orderQuestionnaireTestManager;
        $this->editorLogManager = $editorLogManager;
        $this->entityManager = $entityManager;
        $this->templating = $templating;
    }

    public function setRequest(Request $request = null)
    {
        $this->request = $request;

        return $this;
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
        $msg = "";

        if ($this->questionnaireManager->isUnique($theme)) {
            $questionnaire->setTheme($theme);
            $em->persist($questionnaire);
            $em->flush();
        } else {
            $msg = "Une tâche avec le même nom existe déja";
        }

        $this->editorLogManager->createEditorLog("editor_edit", "theme", $questionnaire);

        return new JsonResponse(
            array(
               'theme' => $questionnaire->getTheme(),
               'msg' => $msg
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

        if ($isChecked == "true") {
            $isChecked = 1;
        } else {
            $isChecked = 0;
        }
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        $questionnaire->setFixedOrder($isChecked);
        $em->persist($questionnaire);
        $em->flush();

        $this->editorLogManager->createEditorLog("editor_edit", "fixed-order", $questionnaire);

        return new JsonResponse(
            array(
                'id' => $questionnaire->getId(),
                'fixed' => $questionnaire->getFixedOrder()
            )
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

        $this->editorLogManager->createEditorLog("editor_edit", "skill", $questionnaire);

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

        $this->editorLogManager->createEditorLog("editor_edit", "level", $questionnaire);

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
        $typologyName = $request->request->get('typology');

        $em = $this->entityManager;
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);

        $typology = $this->questionnaireManager->setTypology($questionnaire, $typologyName);

        $typologyName = "-";
        if ($typology = $questionnaire->getQuestions()[0]->getTypology()) {
            $typologyName = $typology->getName();
        }

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('questionnaire' => $questionnaire));

        $this->editorLogManager->createEditorLog("editor_edit", "typology", $questionnaire);

        return new JsonResponse(
            array(
                'typology'=> $typologyName,
                'subquestions' => $template
            )
        );
    }

    /**
     *
     * @Route("/questionnaires/set-status", name="editor_questionnaire_set-status", options={"expose"=true})
     * @Method("POST")
     */
    public function setStatusAction()
    {
        $request = $this->request;
        $questionnaireId = $request->request->get('questionnaireId');
        $statusId = $request->request->get('status');

        $em = $this->entityManager;
        $status = $em->getRepository('InnovaSelfBundle:Status')->find($statusId);
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);

        $questionnaire->setStatus($status);
        $em->persist($questionnaire);
        $em->flush();

        $this->editorLogManager->createEditorLog("editor_edit", "status", $questionnaire);

        return new JsonResponse(
            array(
                'status'=> $statusId,
            )
        );
    }

    /**
     *
     * @Route("/questionnaires/set-text-type", name="set-text-type", options={"expose"=true})
     * @Method("POST")
     */
    public function setTextTypeAction()
    {
        $em = $this->entityManager;
        $request = $this->request;

        $questionnaireId = $request->request->get('questionnaireId');
        $textType = $request->request->get('textType');

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        $questionnaire->setDialogue($textType);
        $em->persist($questionnaire);
        $em->flush();

        $this->editorLogManager->createEditorLog("editor_edit", "text-type", $questionnaire);

        $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:texte.html.twig',array('questionnaire' => $questionnaire));

        return new Response($template);
    }

}
