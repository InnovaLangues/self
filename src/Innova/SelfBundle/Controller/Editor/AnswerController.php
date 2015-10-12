<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Proposition;
use Innova\SelfBundle\Entity\Media\Media;

/**
 * Class AnswerController
 * @Route(
 *      "/admin",
 *      service = "innova_editor_answer"
 * )
 * @ParamConverter("questionnaire", isOptional="true", class="InnovaSelfBundle:Questionnaire", options={"id" = "questionnaireId"})
 * @ParamConverter("subquestion", isOptional="true", class="InnovaSelfBundle:Subquestion", options={"id" = "subquestionId"})
 * @ParamConverter("proposition", isOptional="true", class="InnovaSelfBundle:Proposition", options={"id" = "propositionId"})
 * @ParamConverter("media", isOptional="true", class="InnovaSelfBundle:Media\Media", options={"id" = "mediaId"})
 */
class AnswerController
{
    protected $eecManager;
    protected $propositionManager;
    protected $templating;
    protected $securityContext;
    protected $rightManager;

    public function __construct(
        $eecManager,
        $propositionManager,
        $templating,
        $securityContext,
        $rightManager
    ) {
        $this->eecManager           = $eecManager;
        $this->propositionManager   = $propositionManager;
        $this->templating           = $templating;
        $this->securityContext      = $securityContext;
        $this->rightManager         = $rightManager;
    }

    /**
     *
     * @Route("/questionnaires/ecc_get_answer/{subquestionId}", name="editor_questionnaire_get_answers", options={"expose"=true})
     * @Method("GET")
     *
     */
    public function getAnswersAction(Subquestion $subquestion)
    {
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $subquestion->getQuestion()->getQuestionnaire())) {
            $answers = $this->eecManager->getAnswers($subquestion);
            $template = $this->templating->render('InnovaSelfBundle:Editor/partials:eec_answers.html.twig', array('answers' => $answers, 'subquestion' => $subquestion));

            return new Response($template);
        }

        return;
    }

    /**
     *
     * @Route("/questionnaires/ecc_add_answer/{subquestionId}", name="editor_questionnaire_add-eec-answer", options={"expose"=true})
     * @Method("POST")
     *
     */
    public function addAnswersAction(Request $request, Subquestion $subquestion)
    {
        $currentUser = $this->securityContext->getToken()->getUser();
        $questionnaire = $subquestion->getQuestion()->getQuestionnaire();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $this->eecManager->addAnswer($subquestion, $request->get('answer'));
        }

        return;
    }

    /**
     *
     * @Route("/questionnaires/ecc_toggle_answer/{propositionId}", name="ecc_toggle_answer", options={"expose"=true})
     * @Method("PUT")
     *
     */
    public function toggleRightAnswerAction(Proposition $proposition)
    {
        $currentUser = $this->securityContext->getToken()->getUser();
        $questionnaire = $proposition->getSubquestion()->getQuestion()->getQuestionnaire();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $proposition = $this->propositionManager->toggleRightAnswer($proposition);
            $template = $this->templating->render('InnovaSelfBundle:Editor/partials:eec_answer.html.twig', array('answer' => $proposition));

            return new Response($template);
        }

        return;
    }
}
