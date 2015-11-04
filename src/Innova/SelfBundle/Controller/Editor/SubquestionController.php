<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Typology;

/**
 * Class MediaController.
 *
 * @Route(
 *      "/admin",
 *      service = "innova_editor_subquestion"
 * )
 * @ParamConverter("questionnaire", isOptional="true", class="InnovaSelfBundle:Questionnaire", options={"id" = "questionnaireId"})
 * @ParamConverter("typology",      isOptional="true", class="InnovaSelfBundle:Typology", options={"id" = "typologyId"})
 * @ParamConverter("subquestion",   isOptional="true", class="InnovaSelfBundle:Subquestion", options={"id" = "subquestionId"})
 */
class SubquestionController
{
    protected $subquestionManager;
    protected $templating;
    protected $voter;

    public function __construct($subquestionManager, $templating, $voter)
    {
        $this->subquestionManager = $subquestionManager;
        $this->templating = $templating;
        $this->voter = $voter;
    }

    /**
     * @Route("/questionnaire/create-subquestion/{questionnaireId}/{typologyId}", name="editor_questionnaire_create-subquestion", options={"expose"=true})
     * @Method("PUT")
     */
    public function createSubquestionAction(Questionnaire $questionnaire, Typology $typology)
    {
        $this->voter->canEditTask($questionnaire);

        $questionnaire = $this->subquestionManager->generateSubquestion($questionnaire, $typology);
        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     * @Route("/questionnaire/{questionnaireId}/delete-subquestion/{subquestionId}", name="editor_questionnaire_delete_subquestion", options={"expose"=true})
     * @Method("DELETE")
     */
    public function deleteSubquestionAction(Questionnaire $questionnaire, Subquestion $subquestion)
    {
        $this->voter->canEditTask($questionnaire);

        $this->subquestionManager->removeSubquestion($subquestion, $questionnaire);
        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     * @Route("/subquestion/{subquestionId}/display-identity-form", name="editor_subquestion-identity-form", options={"expose"=true})
     * @Method("GET")
     */
    public function displayIdentityFormAction(Subquestion $subquestion)
    {
        $this->voter->canEditTask($subquestion->getQuestion()->getQuestionnaire());

        $template = $this->subquestionManager->displayIdentityForm($subquestion);

        return new Response($template);
    }

    /**
     * @Route("/subquestion/{subquestionId}/set-identity-field/", name="set-subquestion-identity-field", options={"expose"=true})
     * @Method("POST")
     */
    public function setIdentityFieldAction(Request $request, Subquestion $subquestion)
    {
        $this->voter->canEditTask($subquestion->getQuestion()->getQuestionnaire());

        $this->subquestionManager->setIdentityField($request, $subquestion);

        return new JsonResponse();
    }
}
