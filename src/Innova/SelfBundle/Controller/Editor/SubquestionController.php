<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Innova\SelfBundle\Form\Type\SubquestionType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Typology;

/**
 * Class MediaController
 * @Route(
 *      service = "innova_editor_subquestion"
 * )
 * @ParamConverter("questionnaire", isOptional="true", class="InnovaSelfBundle:Questionnaire", options={"id" = "questionnaireId"})
 * @ParamConverter("typology",      isOptional="true", class="InnovaSelfBundle:Typology", options={"id" = "typologyId"})
 * @ParamConverter("subquestion",   isOptional="true", class="InnovaSelfBundle:Subquestion", options={"id" = "subquestionId"})
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
    protected $rightManager;
    protected $securityContext;

    public function __construct(
            $mediaManager,
            $propositionManager,
            $subquestionManager,
            $entityManager,
            $templating,
            $questionnaireRevisorsManager,
            $formFactory,
            $rightManager,
            $securityContext
    ) {
        $this->mediaManager                 = $mediaManager;
        $this->propositionManager           = $propositionManager;
        $this->subquestionManager           = $subquestionManager;
        $this->entityManager                = $entityManager;
        $this->templating                   = $templating;
        $this->questionnaireRevisorsManager = $questionnaireRevisorsManager;
        $this->formFactory                  = $formFactory;
        $this->rightManager                 = $rightManager;
        $this->securityContext              = $securityContext;
    }

    /**
     *
     * @Route("/questionnaire/create-subquestion/{questionnaireId}/{typologyId}", name="editor_questionnaire_create-subquestion", options={"expose"=true})
     * @Method("PUT")
     * @Cache(sMaxAge=0)
     */
    public function createSubquestionAction(Questionnaire $questionnaire, Typology $typology)
    {
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $em = $this->entityManager;

            $question = $questionnaire->getQuestions()[0];
            $subquestion = $this->subquestionManager->createSubquestion($typology, $question);
            $this->propositionManager->createVfPropositions($questionnaire, $subquestion, $typology);

            $em->persist($subquestion);

            $this->questionnaireRevisorsManager->addRevisor($questionnaire);

            $em->flush();
            $em->refresh($subquestion);

            $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

            return new Response($template);
        }

        return;
    }

    /**
     *
     * @Route("/questionnaire/{questionnaireId}/delete-subquestion/{subquestionId}", name="editor_questionnaire_delete_subquestion", options={"expose"=true})
     * @Method("DELETE")
     * @Cache(sMaxAge=0)
     */
    public function deleteSubquestionAction(Questionnaire $questionnaire, Subquestion $subquestion)
    {
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $em = $this->entityManager;

            $this->questionnaireRevisorsManager->addRevisor($questionnaire);
            $em->remove($subquestion);

            $em->flush();

            $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));

            return new Response($template);
        }

        return;
    }

    /**
     *
     * @Route("/subquestion/{subquestionId}/display-identity-form", name="editor_subquestion-identity-form", options={"expose"=true})
     * @Method("GET")
     * @Cache(sMaxAge=0)
     */
    public function displayIdentityFormAction(Subquestion $subquestion)
    {
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $subquestion->getQuestion()->getQuestionnaire())) {
            $subquestionId = $subquestion->getId();
            $form = $this->formFactory->createBuilder(new SubquestionType(), $subquestion)->getForm();

            $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestion-identity.html.twig',
                                                                            array(
                                                                                    'form' => $form->createView(),
                                                                                    'subquestionId' => $subquestionId,
                                                                                )
                                                                    );

            return new Response($template);
        }

        return;
    }

    /**
     *
     * @Route("/subquestion/{subquestionId}/set-identity-field/", name="set-subquestion-identity-field", options={"expose"=true})
     * @Method("POST")
     * @Cache(sMaxAge=0)
     */
    public function setIdentityFieldAction(Request $request, Subquestion $subquestion)
    {
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $subquestion->getQuestion()->getQuestionnaire())) {
            $em = $this->entityManager;

            $form = $this->formFactory->createBuilder(new SubquestionType(), $subquestion)->getForm();
            $form->bind($request);

            if ($form->isValid()) {
                $em->persist($subquestion);
                $em->flush();
            }

            return new JsonResponse();
        }

        return;
    }
}
