<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Proposition;

/**
 * Class AnswerController
 * @Route(
 *      "/admin",
 *      service = "innova_editor_answer"
 * )
 * @ParamConverter("subquestion", isOptional="true", class="InnovaSelfBundle:Subquestion", options={"id" = "subquestionId"})
 * @ParamConverter("proposition", isOptional="true", class="InnovaSelfBundle:Proposition", options={"id" = "propositionId"})
 */
class AnswerController
{
    protected $eecManager;
    protected $propositionManager;
    protected $templating;
    protected $voter;

    public function __construct(
        $eecManager,
        $propositionManager,
        $templating,
        $voter
    ) {
        $this->eecManager           = $eecManager;
        $this->propositionManager   = $propositionManager;
        $this->templating           = $templating;
        $this->voter                = $voter;
    }

    /**
     *
     * @Route("/questionnaires/ecc_get_answer/{subquestionId}", name="editor_questionnaire_get_answers", options={"expose"=true})
     * @Method("GET")
     *
     */
    public function getAnswersAction(Subquestion $subquestion)
    {
        $this->voter->canEditTask($subquestion->getQuestion()->getQuestionnaire());

        $answers = $this->eecManager->getAnswers($subquestion);
        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:eec_answers.html.twig', array('answers' => $answers, 'subquestion' => $subquestion));

        return new Response($template);
    }

    /**
     *
     * @Route("/questionnaires/ecc_add_answer/{subquestionId}", name="editor_questionnaire_add-eec-answer", options={"expose"=true})
     * @Method("POST")
     *
     */
    public function addAnswersAction(Request $request, Subquestion $subquestion)
    {
        $this->voter->canEditTask($subquestion->getQuestion()->getQuestionnaire());

        $this->eecManager->addAnswer($subquestion, $request->get('answer'));

        return new Response();
    }

    /**
     *
     * @Route("/questionnaires/ecc_toggle_answer/{propositionId}", name="ecc_toggle_answer", options={"expose"=true})
     * @Method("PUT")
     *
     */
    public function toggleRightAnswerAction(Proposition $proposition)
    {
        $this->voter->canEditTask($proposition->getSubquestion()->getQuestion()->getQuestionnaire());

        $proposition = $this->propositionManager->toggleRightAnswer($proposition);
        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:eec_answer.html.twig', array('answer' => $proposition));

        return new Response($template);
    }
}
