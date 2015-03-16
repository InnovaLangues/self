<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Innova\SelfBundle\Form\Type\SubquestionType;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    protected $templating;
    protected $questionnaireRevisorsManager;
    protected $formFactory;

    public function __construct(
            $mediaManager,
            $propositionManager,
            $subquestionManager,
            $entityManager,
            $templating,
            $questionnaireRevisorsManager,
            $formFactory
    ) {
        $this->mediaManager = $mediaManager;
        $this->propositionManager = $propositionManager;
        $this->subquestionManager = $subquestionManager;
        $this->entityManager = $entityManager;
        $this->templating = $templating;
        $this->questionnaireRevisorsManager = $questionnaireRevisorsManager;
        $this->formFactory = $formFactory;
    }

    /**
     *
     * @Route("/questionnaires/create-subquestion", name="editor_questionnaire_create-subquestion", options={"expose"=true})
     * @Method("PUT")
     */
    public function createSubquestionAction(Request $request)
    {
        $em = $this->entityManager;

        $questionnaireId = $request->get('questionnaireId');
        $questionnaireTypology = $request->get('questionnaireTypology');

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        $question = $questionnaire->getQuestions()[0];
        $typology = $em->getRepository('InnovaSelfBundle:Typology')->find($questionnaireTypology);

        $subquestion = $this->subquestionManager->createSubquestion($typology, $question);

        $this->propositionManager->createVfPropositions($questionnaire, $subquestion, $typology);

        $em->persist($subquestion);

        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

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
    public function deleteSubquestionAction(Request $request)
    {
        $em = $this->entityManager;

        $subquestionId = $request->get('subquestionId');
        $questionnaireId = $request->get('questionnaireId');

        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($subquestionId);
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);

        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        $em->remove($subquestion);
        $em->flush();

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     *
     * @Route("/subquestion/display-identity-form", name="editor_subquestion-identity-form", options={"expose"=true})
     * @Method("POST")
     */
    public function displayIdentityFormAction(Request $request)
    {
        $em = $this->entityManager;

        $subquestionId = $request->get('subquestionId');

        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($subquestionId);
        $form = $this->formFactory->createBuilder(new SubquestionType(), $subquestion)->getForm();

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestion-identity.html.twig',
                                                                        array(
                                                                                'form' => $form->createView(),
                                                                                'subquestionId' => $subquestionId,
                                                                            )
                                                                );

        return new Response($template);
    }

    /**
     *
     * @Route("/subquestion/set-identity-field", name="set-subquestion-identity-field", options={"expose"=true})
     * @Method("POST")
     */
    public function setIdentityFieldAction(Request $request)
    {
        $em = $this->entityManager;

        $requestForm = $request->get("subquestion");
        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($requestForm["id"]);

        $form = $this->formFactory->createBuilder(new SubquestionType(), $subquestion)->getForm();
        $form->bind($request);

        if ($form->isValid()) {
            $em->persist($subquestion);
            $em->flush();
        }

        return new JsonResponse();
    }
}
