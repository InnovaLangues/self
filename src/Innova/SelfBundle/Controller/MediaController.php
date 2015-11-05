<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Media\Media;
use Innova\SelfBundle\Entity\Questionnaire;

/**
 * Class MediaController.
 *
 * @Route(
 *      "/admin",
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
    protected $revisorManager;
    protected $templatingManager;
    protected $questionnaireManager;
    protected $securityContext;
    protected $rightManager;
    protected $subqRepo;
    protected $propRepo;

    public function __construct(
        $mediaManager,
        $propositionManager,
        $appManager,
        $commentManager,
        $entityManager,
        $templating,
        $revisorManager,
        $templatingManager,
        $questionnaireManager,
        $securityContext,
        $rightManager
    ) {
        $this->mediaManager = $mediaManager;
        $this->propositionManager = $propositionManager;
        $this->appManager = $appManager;
        $this->commentManager = $commentManager;
        $this->entityManager = $entityManager;
        $this->templating = $templating;
        $this->revisorManager = $revisorManager;
        $this->templatingManager = $templatingManager;
        $this->questionnaireManager = $questionnaireManager;
        $this->securityContext = $securityContext;
        $this->rightManager = $rightManager;
        $this->subqRepo = $this->entityManager->getRepository('InnovaSelfBundle:Subquestion');
        $this->propRepo = $this->entityManager->getRepository('InnovaSelfBundle:Proposition');
    }

    /**
     * @Route("/set-listening-limit/{questionnaireId}/{mediaId}/{limit}", name="set-listening-limit", options={"expose"=true})
     * @Method("PUT")
     */
    public function setListeningLimitAction(Questionnaire $questionnaire, Media $media, $limit)
    {
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $this->mediaManager->updateMediaLimit($questionnaire, $media, $limit);
            $this->revisorManager->addRevisor($questionnaire);

            return new Response(null, 200);
        }

        return;
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
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $case = $request->get('toBeReloaded');
            $this->mediaManager->updateMedia($media->getId(), $request->get('url'), $request->get('name'), $request->get('description'));

            if ($case == 'comments') {
                $this->commentManager->updateCommentDate($media);
            }

            $this->revisorManager->addRevisor($questionnaire);

            $view = $this->templatingManager->generateView($case, array('questionnaire' => $questionnaire));

            return new Response($view);
        }

        return;
    }

    /**
     * @Route("/questionnaires/create-media/{questionnaireId}", name="editor_questionnaire_create-media", options={"expose"=true})
     * @Method("PUT")
     */
    public function createMediaAction(Request $request, Questionnaire $questionnaire)
    {
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $em = $this->entityManager;

            $entityType = $request->get('entityType');
            $entityId = $request->get('entityId');
            $entityField = $request->get('entityField');
            $name = $request->get('name');
            $description = $request->get('description');
            $type = $request->get('type');
            $url = $request->get('url');

            $media = $this->mediaManager->createMedia($questionnaire, $type, $name, $description, $url, 0, $entityField);

            switch ($entityType) {
                case 'questionnaire':
                    if ($entityField !== 'comment') {
                        $this->questionnaireManager->editQuestionnaireField($questionnaire, $entityField, $media);
                    } else {
                        $this->commentManager->createComment($questionnaire, $media);
                    }
                    $parameters = array('questionnaire' => $questionnaire);

                    break;
                case 'subquestion':
                    $entity = $this->subqRepo->findOneById($entityId);
                    if ($entityField == 'amorce') {
                        $entity->setMediaAmorce($media);
                        $parameters = array('questionnaire' => $questionnaire, 'subquestion' => $entity);
                    } elseif ($entityField == 'app-media') {
                        $entity->setMedia($media);
                        $parameters = array('questionnaire' => $questionnaire);
                    }

                    $em->persist($entity);
                    break;
                case 'proposition':
                    if ($entityField == 'app-answer') {
                        $subquestion = $this->subqRepo->findOneById($entityId);
                        $proposition = $this->propositionManager->createProposition($subquestion, $media, true);
                        $this->appManager->createAppFakeAnswer($proposition);
                        $parameters = array('questionnaire' => $questionnaire);
                    } elseif ($entityField == 'app-distractor') {
                        $subquestions = $questionnaire->getQuestions()[0]->getSubquestions();
                        foreach ($subquestions as $subquestion) {
                            $this->propositionManager->createProposition($subquestion, $media, false);
                        }
                        $parameters = array('questionnaire' => $questionnaire);
                    } else {
                        $subquestion = $this->subqRepo->findOneById($entityId);
                        $this->propositionManager->createProposition($subquestion, $media, false);
                        $parameters = array('questionnaire' => $questionnaire, 'subquestion' => $subquestion);
                    }
                    break;
            }

            $em->flush();
            $this->revisorManager->addRevisor($questionnaire);
            $template = $this->templatingManager->generateView($entityField, $parameters);

            return new Response($template);
        }

        return;
    }

    /**
     * Supprime la relation qu'a un media avec un élément (ou supprime l'élément)... il faudrait supprimer le media dans certains cas.
     *
     * @Route("/questionnaires/unlink-media/{questionnaireId}", name="editor_questionnaire_unlink-media", options={"expose"=true})
     * @Method("DELETE")
     */
    public function unlinkMediaAction(Request $request, Questionnaire $questionnaire)
    {
        $currentUser = $this->securityContext->getToken()->getUser();

        if ($this->rightManager->canEditTask($currentUser, $questionnaire)) {
            $em = $this->entityManager;

            $entityType = $request->get('entityType');
            $entityId = $request->get('entityId');
            $entityField = $request->get('entityField');

            switch ($entityType) {
                case 'questionnaire':
                    $this->questionnaireManager->editQuestionnaireField($questionnaire, $entityField, null);
                    $parameters = array('questionnaire' => $questionnaire);
                    break;
                case 'subquestion':
                    $entity = $this->subqRepo->findOneById($entityId);
                    if ($entityField == 'amorce') {
                        $entity->setMediaAmorce(null);
                        $em->persist($entity);
                        $parameters = array('questionnaire' => $questionnaire, 'subquestion' => $entity);
                    } elseif ($entityField == 'app-paire') {
                        if ($rightProposition = $this->propRepo->findOneBy(array('subquestion' => $entity, 'rightAnswer' => true))) {
                            $mediaToSearch = $rightProposition->getMedia();
                            $question = $entity->getQuestion();
                            $this->appManager->appDeletePropositions($mediaToSearch, $question);
                        }
                        $em->remove($entity);
                        $em->refresh($questionnaire->getQuestions()[0]);
                        $parameters = array('questionnaire' => $questionnaire);
                    }
                    break;
                case 'proposition':
                    $proposition = $this->propRepo->findOneById($entityId);
                    $question = $questionnaire->getQuestions()[0];

                    if ($entityField == 'app-distractor') {
                        $this->appManager->appDeletePropositions($proposition->getMedia(), $question);
                        $parameters = array('questionnaire' => $questionnaire);
                    } elseif ($entityField == 'distractor') {
                        $this->appManager->deleteDistractor($question, $proposition);
                        $parameters = array('questionnaire' => $questionnaire);
                    } else {
                        $em->remove($proposition);
                        $parameters = array('questionnaire' => $questionnaire, 'proposition' => null);
                    }
                    break;
            }

            $em->flush();
            $template = $this->templatingManager->generateView($entityField, $parameters);
            $this->revisorManager->addRevisor($questionnaire);

            return new Response($template);
        }

        return;
    }
}
