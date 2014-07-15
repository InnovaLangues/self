<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Clue;



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
    protected $propositionManager;
    protected $mediaManager;
    protected $entityManager;
    protected $request;
    protected $templating;

    public function __construct(
            $mediaManager,
            $propositionManager,
            $entityManager,
            $templating
    ) {
        $this->mediaManager = $mediaManager;
        $this->propositionManager = $propositionManager;
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

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));

        $questionnaireId = $request->get('questionnaireId');
        $questionnaireTypology = $request->get('questionnaireTypology');

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        $question = $questionnaire->getQuestions()[0];
        $arrayLikeTypos = array("TQRU", "TQRM", "TVFNM", "TVF");

        $subquestion = new Subquestion();
        if (!in_array($questionnaireTypology, $arrayLikeTypos)) {
            $typology = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($questionnaireTypology);
        } else {
            $typology = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName(mb_substr($questionnaireTypology, 1));
        }
        $subquestion->setTypology($typology);
        $subquestion->setQuestion($question);

        // création automatique en cas de vrai/faux/(nd)?
        if($questionnaireTypology == "VF" || $questionnaireTypology == "TVF" || $questionnaireTypology == "TVFNM" || $questionnaireTypology == "VFNM") {
            $true = $this->mediaManager->createMedia($test, $questionnaire, "texte", "VRAI", "VRAI", null, 0, "proposition");
            $this->propositionManager->createProposition($subquestion, $true, false);
            $false = $this->mediaManager->createMedia($test, $questionnaire, "texte", "FAUX", "FAUX", null, 0, "proposition");
            $this->propositionManager->createProposition($subquestion, $false, false);
        }
        if($questionnaireTypology == "TVFNM" || $questionnaireTypology == "VFNM") {
            $nd = $this->mediaManager->createMedia($test, $questionnaire, "texte", "ND", "ND", null, 0, "proposition");
            $this->propositionManager->createProposition($subquestion, $nd, false);
        }

        $em->persist($subquestion);
        $em->flush();
        $em->refresh($subquestion);
        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('test' => $test, 'questionnaire' => $questionnaire));

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

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->get('testId'));

        $subquestionId = $request->get('subquestionId');
        $questionnaireId = $request->get('questionnaireId');

        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($subquestionId);
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);

        $em->remove($subquestion);
        $em->flush();

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('test'=> $test, 'questionnaire' => $questionnaire));

        return new Response($template);
    }
}
