<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class MediaController
 * @Route(
 *      "admin/editor",
 *      name    = "",
 *      service = "innova_editor_subquestion"
 * )
 */
class SubquestionController
{
    protected $mediaManager;
    protected $propositionManager;
    protected $subquestionManager;
    protected $entityManager;
    protected $request;
    protected $templating;

    public function __construct(
            $mediaManager,
            $propositionManager,
            $subquestionManager,
            $entityManager,
            $templating
    ) {
        $this->mediaManager = $mediaManager;
        $this->propositionManager = $propositionManager;
        $this->subquestionManager = $subquestionManager;
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
     * @Route("/questionnaires/create-subquestion", name="editor_questionnaire_create-subquestion", options={"expose"=true})
     * @Method("PUT")
     */
    public function createSubquestionAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $questionnaireId = $request->get('questionnaireId');
        $questionnaireTypology = $request->get('questionnaireTypology');

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        $question = $questionnaire->getQuestions()[0];
        $arrayLikeTypos = array("TQRU", "TQRM", "TVFNM", "TVF");

        if (!in_array($questionnaireTypology, $arrayLikeTypos)) {
            $typology = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($questionnaireTypology);
        } else {
            $typology = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName(mb_substr($questionnaireTypology, 1));
        }
        $subquestion = $this->subquestionManager->createSubquestion($typology, $question);

        $this->propositionManager->createVfPropositions($questionnaire, $subquestion, $questionnaireTypology);

        $em->persist($subquestion);
        $em->flush();
        $em->refresh($subquestion);
        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     *
     * @Route("/questionnaires/delete-subquestion", name="editor_questionnaire_delete_subquestion", options={"expose"=true})
     * @Method("DELETE")
     */
    public function deleteSubquestionAction()
    {
        $em = $this->entityManager;
        $request = $this->request->request;

        $subquestionId = $request->get('subquestionId');
        $questionnaireId = $request->get('questionnaireId');

        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($subquestionId);
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);

        $em->remove($subquestion);
        $em->flush();

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('questionnaire' => $questionnaire));

        return new Response($template);
    }
}
