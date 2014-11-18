<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class PropositionController
 * @Route(
 *      "admin/editor",
 *      name    = "",
 *      service = "innova_editor_proposition"
 * )
 */
class PropositionController
{
    protected $propositionManager;
    protected $entityManager;
    protected $templating;
    protected $request;
    protected $questionnaireRevisorsManager;

    public function __construct($propositionManager, $entityManager, $templating, $questionnaireRevisorsManager) 
    {
        $this->propositionManager = $propositionManager;
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
     * @Route("/questionnaires/toggle_right_answer", name="editor_questionnaire_toggle_right_anwser", options={"expose"=true})
     * @Method("PUT")
     */
    public function toggleRightAnswserAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->get('questionnaireId'));
        $propositionId = $request->get('propositionId');
        $proposition = $em->getRepository('InnovaSelfBundle:Proposition')->find($propositionId);

        $proposition = $this->propositionManager->toggleRightAnswer($proposition);

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:proposition.html.twig', array('questionnaire' => $questionnaire, 'proposition' => $proposition));

        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        return new Response($template);
    }
}
