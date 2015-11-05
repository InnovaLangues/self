<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Proposition;

/**
 * Class PropositionController.
 *
 * @Route(
 *      "/admin",
 *      service = "innova_editor_proposition"
 * )
 * @ParamConverter("questionnaire", isOptional="true", class="InnovaSelfBundle:Questionnaire", options={"id" = "questionnaireId"})
 * @ParamConverter("proposition",   isOptional="true", class="InnovaSelfBundle:Proposition",   options={"id" = "propositionId"})
 */
class PropositionController
{
    protected $propositionManager;
    protected $templating;
    protected $voter;

    public function __construct(
        $propositionManager,
        $templating,
        $voter
    ) {
        $this->propositionManager = $propositionManager;
        $this->templating = $templating;
        $this->voter = $voter;
    }

    /**
     * @Route("/toggle_right_answer/{questionnaireId}/{propositionId}", name="editor_questionnaire_toggle_right_anwser", options={"expose"=true})
     * @Method("PUT")
     */
    public function toggleRightAnswserAction(Questionnaire $questionnaire, Proposition $proposition)
    {
        $this->voter->canEditTask($questionnaire);

        $proposition = $this->propositionManager->toggleRightAnswer($proposition);
        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:proposition.html.twig', array('questionnaire' => $questionnaire, 'proposition' => $proposition));

        return new Response($template);
    }
}
