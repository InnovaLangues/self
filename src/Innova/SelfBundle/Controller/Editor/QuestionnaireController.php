<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Questionnaire;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class QuestionnaireController.
 *
 * @Route(
 *      "/admin",
 *      service = "innova_editor_questionnaire"
 * )
 * @ParamConverter("questionnaire", isOptional="true", class="InnovaSelfBundle:Questionnaire",       options={"id" = "questionnaireId"})
 */
class QuestionnaireController
{
    protected $questionnaireManager;
    protected $templating;
    protected $voter;

    public function __construct($questionnaireManager, $templating, $voter)
    {
        $this->questionnaireManager = $questionnaireManager;
        $this->templating = $templating;
        $this->voter = $voter;
    }

    /**
     * @Route("/questionnaire/{questionnaireId}/check", name="editor_questionnaire_repair", options={"expose"=true})
     * @Method("POST")
     */
    public function repairAction(Questionnaire $questionnaire)
    {
        $this->voter->canEditTask($questionnaire);

        $questionnaire = $this->questionnaireManager->repair($questionnaire);
        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     * @Route("/questionnaire/{questionnaireId}/set-text-title", name="editor_questionnaire_set-text-title", options={"expose"=true})
     * @Method("POST")
     */
    public function setTextTitleAction(Request $request, Questionnaire $questionnaire)
    {
        $this->voter->canEditTask($questionnaire);

        $questionnaire = $this->questionnaireManager->setTextTitle($request, $questionnaire);

        return new JsonResponse(array('title' => $questionnaire->getTextTitle()));
    }

    /**
     * @Route("/questionnaire/{questionnaireId}/set-text-type", name="set-text-type", options={"expose"=true})
     * @Method("PUT")
     */
    public function setTextTypeAction(Request $request, Questionnaire $questionnaire)
    {
        $this->voter->canEditTask($questionnaire);

        $questionnaire = $this->questionnaireManager->setTextType($request, $questionnaire);
        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:texte.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     * @Route("/questionnaire/{questionnaireId}/set-identity-field/", name="set-identity-field", options={"expose"=true})
     * @Method("POST")
     */
    public function setIdentityFieldAction(Request $request, Questionnaire $questionnaire)
    {
        $this->voter->canEditTask($questionnaire);

        try {
            $this->questionnaireManager->setField($request, $questionnaire);
        } catch (BadRequestHttpException $e) {
            return new Response($e->getMessage(), 400, ['Content-Type' => 'text/json']);
        }

        return new JsonResponse();
    }

    /**
     * @Route("/questionnaire/{questionnaireId}/set-general-info-field", name="set-general-info-field", options={"expose"=true})
     * @Method("POST")
     */
    public function setGeneralInfoFieldAction(Request $request, Questionnaire $questionnaire)
    {
        $this->voter->canEditTask($questionnaire);

        $response = $this->questionnaireManager->setIdentityField($questionnaire, $request);

        return $response;
    }
}
