<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Innova\SelfBundle\Form\Type\QuestionnaireType;

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
    protected $templating;
    protected $questionnaireRevisorsManager;
    protected $formFactory;

    public function __construct(
            $questionnaireManager,
            $orderQuestionnaireTestManager,
            $entityManager,
            $templating,
            $questionnaireRevisorsManager,
            $formFactory
    ) {
        $this->questionnaireManager = $questionnaireManager;
        $this->orderQuestionnaireTestManager = $orderQuestionnaireTestManager;
        $this->entityManager = $entityManager;
        $this->templating = $templating;
        $this->questionnaireRevisorsManager = $questionnaireRevisorsManager;
        $this->formFactory = $formFactory;
    }

    /**
     *
     * @Route("/questionnaires/set-text-title", name="editor_questionnaire_set-text-title", options={"expose"=true})
     * @Method("POST")
     */
    public function setTextTitleAction(Request $request)
    {
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
     * @Route("/questionnaires/set-text-type", name="set-text-type", options={"expose"=true})
     * @Method("PUT")
     */
    public function setTextTypeAction(Request $request)
    {
        $em = $this->entityManager;

        $questionnaireId = $request->request->get('questionnaireId');
        $textType = $request->request->get('textType');

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        $questionnaire->setDialogue($textType);
        $em->persist($questionnaire);
        $em->flush();

        $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:texte.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     *
     * @Route("/questionnaires/set-identity-field", name="set-identity-field", options={"expose"=true})
     * @Method("POST")
     */
    public function setIdentityFieldAction(Request $request)
    {
        $em = $this->entityManager;

        $requestForm = $request->get("questionnaire");
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($requestForm["id"]);

        $form = $this->formFactory->createBuilder(new QuestionnaireType(), $questionnaire)->getForm();
        $form->bind($request);

        if ($form->isValid()) {
            $em->persist($questionnaire);
            $em->flush();

            $this->questionnaireRevisorsManager->addRevisor($questionnaire);
        }

        return new JsonResponse();
    }

     /**
    *
    * @Route("/questionnaires/set-general-info-field", name="set-general-info-field", options={"expose"=true})
    * @Method("POST")
    */
    public function setGeneralInfoFieldAction(Request $request)
    {
        $em = $this->entityManager;
        $field = $request->request->get('field');
        $value = $request->request->get('value');

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->request->get('questionnaireId'));
        $response = $this->questionnaireManager->setIdentityField($questionnaire, $field, $value);

        return $response;
    }
}
