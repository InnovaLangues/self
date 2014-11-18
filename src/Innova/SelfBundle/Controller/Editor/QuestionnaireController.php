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
    protected $entityManager;
    protected $request;
    protected $templating;
    protected $questionnaireRevisorsManager;

    public function __construct(
            $questionnaireManager,
            $orderQuestionnaireTestManager,
            $entityManager,
            $templating,
            $questionnaireRevisorsManager
    )
    {
        $this->questionnaireManager = $questionnaireManager;
        $this->orderQuestionnaireTestManager = $orderQuestionnaireTestManager;
        $this->entityManager = $entityManager;
        $this->templating = $templating;
        $this->questionnaireRevisorsManager = $questionnaireRevisorsManager;
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

        if ($questionnaire->getTheme() != $theme) {
            if ($this->questionnaireManager->isUnique($theme, $questionnaire->getLanguage())) {
                $questionnaire->setTheme($theme);
                $em->persist($questionnaire);
                $em->flush();
            } else {
                $msg = "Une tâche avec le même nom existe déja";
            }

            $this->questionnaireRevisorsManager->addRevisor($questionnaire);
        }

        return new JsonResponse(
            array(
               'theme' => $questionnaire->getTheme(),
               'msg' => $msg
           )
        );
    }

    /**
     *
     * @Route("/questionnaires/set-text-title", name="editor_questionnaire_set-text-title", options={"expose"=true})
     * @Method("POST")
     */
    public function setTextTitleAction()
    {
        $request = $this->request;
        $em = $this->entityManager;

        $title = $request->request->get('title');
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->request->get('questionnaireId'));

        $questionnaire->setTextTitle($title);
        $em->persist($questionnaire);
        $em->flush();

        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        return new JsonResponse(
            array(
               'title' => $questionnaire->getTextTitle(),
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

        $this->questionnaireRevisorsManager->addRevisor($questionnaire);


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
        $em->flush();

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:general-infos.html.twig',array('questionnaire' => $questionnaire));

        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        return new JsonResponse(
            array(
                'template' => $template,
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

        $this->questionnaireManager->setTypology($questionnaire, $typologyName);

        $typologyName = "-";
        if ($typology = $questionnaire->getQuestions()[0]->getTypology()) {
            $typologyName = $typology->getName();
        }

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('questionnaire' => $questionnaire));

        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        return new JsonResponse(
            array(
                'typology'=> $typologyName,
                'subquestions' => $template
            )
        );
    }

    /**
     *
     * @Route("/questionnaires/set-text-type", name="set-text-type", options={"expose"=true})
     * @Method("PUT")
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

        $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:texte.html.twig',array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     *
     * @Route("/questionnaires/set-identity-field", name="set-identity-field", options={"expose"=true})
     * @Method("POST")
     */
    public function setIdentityFieldAction()
    {
        $em = $this->entityManager;
        $request = $this->request;

        $field = $request->request->get('field');
        $value = $request->request->get('value');
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->request->get('questionnaireId'));

        $this->questionnaireManager->setIdentityField($questionnaire, $field, $value);

        return new JsonResponse(array());
    }

}
