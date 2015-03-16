<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Media\Media;
use Innova\SelfBundle\Entity\Questionnaire;

/**
 * Class MediaController
 * @Route(
 *      "admin/editor",
 *      name    = "",
 *      service = "innova_editor_media"
 * )
 * @ParamConverter("media", isOptional="true", class="InnovaSelfBundle:Media\Media", options={"id" = "mediaId"})
 * @ParamConverter("questionnaire", isOptional="true", class="InnovaSelfBundle:Questionnaire", options={"id" = "questionnaireId"})
 */
class MediaController
{
    protected $mediaManager;
    protected $propositionManager;
    protected $appManager;
    protected $commentManager;
    protected $entityManager;
    protected $templating;
    protected $questionnaireRevisorsManager;
    //protected $cacheManager;
    protected $router;

    public function __construct(
            $mediaManager,
            $propositionManager,
            $appManager,
            $commentManager,
            $entityManager,
            $templating,
            $questionnaireRevisorsManager,
            //$cacheManager,
            $router
    ) {
        $this->mediaManager = $mediaManager;
        $this->propositionManager = $propositionManager;
        $this->appManager = $appManager;
        $this->commentManager = $commentManager;
        $this->entityManager = $entityManager;
        $this->templating = $templating;
        $this->questionnaireRevisorsManager = $questionnaireRevisorsManager;
        //$this->cacheManager = $cacheManager;
        $this->router = $router;
    }

    /**
     * @Route("/set-listening-limit/{questionnaireId}/{mediaId}/{limit}", name="set-listening-limit", options={"expose"=true})
     * @Method("POST")
     */
    public function setListeningLimitAction(Questionnaire $questionnaire, Media $media, $limit)
    {
        $this->mediaManager->updateMediaLimit($questionnaire, $media, $limit);
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        return new JsonResponse();
    }

    /**
     * @Route("/get-media-info/{mediaId}", name="get-media-info", options={"expose"=true})
     * @Method("GET")
     */
    public function getMediaInfoAction(Media $media)
    {
        return new JsonResponse(
            array(
                'url' => $media->getUrl(),
                'name' => $media->getName(),
                'description' => $media->getDescription(),
                'mediaType' => $media->getMediaType()->getName(),
                'id' => $media->getId(),
            )
        );
    }

    /**
     * @Route("/editor_questionnaire_update-media/{questionnaireId}/{mediaId}", name="editor_questionnaire_update-media", options={"expose"=true})
     * @Method("PUT")
     */
    public function updateMediaAction(Request $request, Questionnaire $questionnaire, Media $media)
    {
        // Function to update database in editor
        // In Editor, I choose en task and I want to update it
        $em = $this->entityManager;
        $this->mediaManager->updateMedia($media->getId(),
                                        $request->get('url'),
                                        $request->get('name'),
                                        $request->get('description')
                                        );

        // var toBeReloaded = $("#entity-to-be-reloaded").val();
        switch ($request->get('toBeReloaded')) {
            case 'contexte':
                $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:contexte.html.twig',
                                                array('questionnaire' => $questionnaire));
                break;
            case 'texte':
                $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:texte.html.twig',
                                                array('questionnaire' => $questionnaire));
                break;
            case 'functional-instruction':
                $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:functionalInstruction.html.twig',
                                                array('questionnaire' => $questionnaire));
                break;
            case 'feedback':
                $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:feedback.html.twig',
                                                array('questionnaire' => $questionnaire));
                break;
            case 'subquestion':
                $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig',
                                                array('questionnaire' => $questionnaire));
                break;
            case 'comments':
                $comment = $em->getRepository('InnovaSelfBundle:Comment')->findOneByDescription($media);
                $comment->setEditDate(new \Datetime());
                $em->persist($comment);
                $em->flush();
                $template = $this->templating->render('InnovaSelfBundle:Editor/partials:comments.html.twig', array('questionnaire' => $questionnaire));
                break;
        }

        // I have my mediaIt and ...
        //$mediaId = $media->getId();
        //$this->invalidateMediaAction($mediaId, $request->get('toBeReloaded'));

        // Add revisor
        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        return new Response($template);
    }

    /**
    * Fonction qui invalide le cache de tests et des questionnaires pour un média donné
    */
    private function invalidateMediaAction($mediaId, $typeReloaded)
    {
        // Manager call
        $em = $this->entityManager;

        // Suivant la zone modifiée, appel du questionnaire
        switch ($typeReloaded) {
            case 'contexte':
                // List of questionnaires with THIS media : Contexte
                $questionnairesForMedia = $em->getRepository('InnovaSelfBundle:Questionnaire')->findBymediaContext($mediaId);
                break;
            case 'texte':
                // List of questionnaires with THIS media : Objet de la question
                $questionnairesForMedia = $em->getRepository('InnovaSelfBundle:Questionnaire')->findBymediaText($mediaId);
                break;
            case 'functional-instruction':
                // List of questionnaires with THIS media : Consigne fonctionnelle
                $questionnairesForMedia = $em->getRepository('InnovaSelfBundle:Questionnaire')->findBymediaFunctionalInstruction($mediaId);
                break;
            case 'feedback':
                // List of questionnaires with THIS media : Feedback
                $questionnairesForMedia = $em->getRepository('InnovaSelfBundle:Questionnaire')->findBymediaFeedback($mediaId);
                break;
            case 'subquestion':
                // List of questionnaires with THIS media : Subquestion
                $subquestions = $em->getRepository('InnovaSelfBundle:Subquestion')->findBymediaAmorce($mediaId);
                foreach ($subquestions as $subquestion) {
                    $questions = $em->getRepository('InnovaSelfBundle:Question')->findByQuestionnaire($subquestion->getQuestion());
                    foreach ($questions as $question) {
                        $questionnaireId = $question->getQuestionnaire()->getId();
                        $questionnairesForMedia = $em->getRepository('InnovaSelfBundle:Questionnaire')->findById($questionnaireId);
                    }
                }
                break;
        }

        // A ce niveau, j'ai tous les questionnaires qui ont le média modifié
        foreach ($questionnairesForMedia as $questionnaireForMedia) {
            $questionnaireId = $questionnaireForMedia->getId();

            // Appel des tests qui ont ce questionnaire dans leur liste
            $testsForQuestionnaire = $em->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')->
                                findBy(array('questionnaire' => $questionnaireId));
            foreach ($testsForQuestionnaire as $testForQuestionnaire) {
                $testId = $testForQuestionnaire->getTest()->getId();

                // Now, I will invalidate
                // questionnaire_pick : route définie dans le playerController.
                // admin/test/{testId}/questionnaire/{questionnaireId}",
                // Add router service
                $pathToInvalidate = $this->router->generate('questionnaire_pick',
                                        array(
                                                'testId' => $testId,
                                                'questionnaireId' => $questionnaireId,
                                             )

                 );
                $this->cacheManager->invalidatePath($pathToInvalidate);
            }
        }
    }

    /**
     * @Route("/questionnaires/create-media/{questionnaireId}", name="editor_questionnaire_create-media", options={"expose"=true})
     * @Method("PUT")
     */
    public function createMediaAction(Request $request, Questionnaire $questionnaire)
    {
        $em = $this->entityManager;

        $entityType = $request->get('entityType');
        $entityId = $request->get('entityId');
        $entityField = $request->get('entityField');
        $name = $request->get('name');
        $description = $request->get('description');
        $type = $request->get('type');
        $url = $request->get('url');

        $media = $this->mediaManager->createMedia($questionnaire, $type, $name, $description, $url, 0, $entityField);
        $template = "";

        switch ($entityType) {
            case "questionnaire":
                if ($entityField == "contexte") {
                    $questionnaire->setMediaContext($media);
                    $em->persist($questionnaire);
                    $em->flush();

                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:contexte.html.twig', array('questionnaire' => $questionnaire));
                } elseif ($entityField == "texte") {
                    $questionnaire->setMediaText($media);
                    $em->persist($questionnaire);
                    $em->flush();

                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:texte.html.twig', array('questionnaire' => $questionnaire));
                } elseif ($entityField == "functional-instruction") {
                    $questionnaire->setMediaFunctionalInstruction($media);
                    $em->persist($questionnaire);
                    $em->flush();

                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:functionalInstruction.html.twig', array('questionnaire' => $questionnaire));
                } elseif ($entityField == "feedback") {
                    $questionnaire->setMediaFeedback($media);
                    $em->persist($questionnaire);
                    $em->flush();

                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:feedback.html.twig', array('questionnaire' => $questionnaire));
                } elseif ($entityField == "instruction") {
                    $questionnaire->setMediaInstruction($media);
                    $em->persist($questionnaire);
                    $em->flush();

                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));
                } elseif ($entityField == "blank-text") {
                    $questionnaire->setMediaBlankText($media);
                    $em->persist($questionnaire);
                    $em->flush();

                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));
                } elseif ($entityField == "comment") {
                    $this->commentManager->createComment($questionnaire, $media);
                    $em->refresh($questionnaire);
                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:comments.html.twig', array('questionnaire' => $questionnaire));
                }

                break;
            case "subquestion":
                $entity =  $em->getRepository('InnovaSelfBundle:Subquestion')->findOneById($entityId);
                if ($entityField == "amorce") {
                    $entity->setMediaAmorce($media);
                    $em->persist($entity);
                    $em->flush();

                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:subquestion.html.twig', array('questionnaire' => $questionnaire, 'subquestion' => $entity));
                } elseif ($entityField == "app-media") {
                    $entity->setMedia($media);
                    $em->persist($entity);
                    $em->flush();

                    $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));
                }
                break;
            case "proposition":
                if ($entityField == "app-answer") {
                    $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->findOneById($entityId);
                    $proposition = $this->propositionManager->createProposition($subquestion, $media, true);
                    $this->appManager->createAppFakeAnswer($proposition);

                    $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));
                } elseif ($entityField == "app-distractor") {
                    $subquestions = $questionnaire->getQuestions()[0]->getSubquestions();
                    foreach ($subquestions as $subquestion) {
                        $this->propositionManager->createProposition($subquestion, $media, false);
                    }
                    $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));
                } else {
                    $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->findOneById($entityId);
                    $this->propositionManager->createProposition($subquestion, $media, false);

                    $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestion.html.twig', array('questionnaire' => $questionnaire, 'subquestion' => $subquestion));
                }
                break;
        }

        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        return new Response($template);
    }

    /**
     * Supprime la relation qu'a un media avec un élément (ou supprime l'élément)... il faudrait supprimer le media dans certains cas.
     *
     * @Route("/questionnaires/unlink-media/{questionnaireId}", name="editor_questionnaire_unlink-media", options={"expose"=true})
     * @Method("DELETE")
     */
    public function unlinkMediaAction(Request $request, Questionnaire $questionnaire)
    {
        $em = $this->entityManager;

        $entityType = $request->get('entityType');
        $entityId = $request->get('entityId');
        $entityField = $request->get('entityField');

        $template = "";
        switch ($entityType) {
            case "questionnaire":
                if ($entityField == "contexte") {
                    $questionnaire->setMediaContext(null);
                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:contexte.html.twig', array('questionnaire' => $questionnaire));
                } elseif ($entityField == "texte") {
                    $questionnaire->setMediaText(null);
                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:texte.html.twig', array('questionnaire' => $questionnaire));
                } elseif ($entityField == "feedback") {
                    $questionnaire->setMediaFeedback(null);
                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:feedback.html.twig', array('questionnaire' => $questionnaire));
                } elseif ($entityField == "blank-text") {
                    $questionnaire->setMediaBlankText(null);
                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));
                } elseif ($entityField == "functional-instruction") {
                    $questionnaire->setMediaFunctionalInstruction(null);
                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:functionalInstruction.html.twig', array('questionnaire' => $questionnaire));
                } elseif ($entityField == "instruction") {
                    $questionnaire->setMediaInstruction(null);
                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));
                }

                $em->persist($questionnaire);
                $em->flush();
                break;
            case "subquestion":
                $entity =  $em->getRepository('InnovaSelfBundle:Subquestion')->findOneById($entityId);
                if ($entityField == "amorce") {
                    $entity->setMediaAmorce(null);
                    $em->persist($entity);
                    $em->flush();

                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:subquestion.html.twig', array('questionnaire' => $questionnaire, 'subquestion' => $entity));
                } elseif ($entityField == "app-paire") {
                    if ($rightProposition = $em->getRepository('InnovaSelfBundle:Proposition')->findOneBy(array("subquestion" => $entity, "rightAnswer" => true))) {
                        $mediaToSearch = $rightProposition->getMedia();
                        $question = $entity->getQuestion();
                        $this->appManager->appDeletePropositions($mediaToSearch, $question);
                    }

                    $em->remove($entity);
                    $em->flush();
                    $em->refresh($questionnaire->getQuestions()[0]);

                    $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));
                }
                break;
            case "proposition":
                $proposition =  $em->getRepository('InnovaSelfBundle:Proposition')->findOneById($entityId);

                if ($entityField == "app-distractor") {
                    $mediaToSearch = $proposition->getMedia();
                    $question = $proposition->getSubquestion()->getQuestion();
                    $this->appManager->appDeletePropositions($mediaToSearch, $question);

                    $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));
                } elseif ($entityField == "distractor") {
                    $question = $proposition->getSubquestion()->getQuestion();
                    $media = $proposition->getMedia();
                    foreach ($question->getSubquestions() as $subquestion) {
                        foreach ($subquestion->getPropositions() as $needle) {
                            if ($needle->getMedia() == $media) {
                                $em->remove($needle);
                            }
                        }
                    }
                    $em->remove($media);
                    $em->flush();
                    $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));
                } else {
                    $em->remove($proposition);
                    $em->flush();

                    $template =  $this->templating->render('InnovaSelfBundle:Editor/partials:proposition.html.twig', array('questionnaire' => $questionnaire, 'proposition' => null));
                }
                break;
        }

        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        return new Response($template);
    }
}
