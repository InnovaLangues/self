<?php

namespace Innova\SelfBundle\Controller\Player;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Manager\MediaClickManager;

/**
 * Class MediaClickController
 *
 * @Route(
 *      "",
 *      name = "innova_mediaclick",
 *      service = "innova_mediaclick"
 * )
 * @ParamConverter("test", isOptional="true", class="InnovaSelfBundle:Test", options={"id" = "testId"})
 * @ParamConverter("session", isOptional="true", class="InnovaSelfBundle:Session", options={"id" = "sessionId"})
 * @ParamConverter("questionnaire", isOptional="true", class="InnovaSelfBundle:Questionnaire", options={"id" = "questionnaireId"})
 * @ParamConverter("media", isOptional="true", class="InnovaSelfBundle:Media\Media", options={"id" = "mediaId"})
 */
class MediaClickController
{
    protected $request;
    protected $mediaClickManager;

    public function __construct(MediaClickManager $mediaClickManager)
    {
        $this->mediaClickManager = $mediaClickManager;
    }

    public function setRequest(Request $request = null)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @Route("/get-remaining-listening/{mediaId}/{testId}/{sessionId}/{questionnaireId}", name="get-remaining-listening", options={"expose"=true})
     * @Method("GET")
     */
    public function getRemainingListeningAction($media, $test, $session, $questionnaire)
    {
        $remainingListening = $this->mediaClickManager->getRemainingListening($media, $questionnaire, $test, $session);

        return new JsonResponse(
            array(
                'remainingListening' => $remainingListening,
            )
        );
    }

    /**
     * @Route("/increment-media-clicks/{mediaId}/{testId}/{sessionId}/{questionnaireId}", name="increment-media-clicks", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function incrementMediaClicksAction($media, $test, $session, $questionnaire)
    {
        $this->mediaClickManager->createMediaClick($media, $questionnaire, $test, $session);
        $remainingListening = $this->mediaClickManager->getRemainingListening($media, $questionnaire, $test, $session);

        return new JsonResponse(
            array(
                'remainingListening' => $remainingListening,
            )
        );
    }

    /**
     * @Route("/is-media-playable/{mediaId}/{testId}/{sessionId}/{questionnaireId}", name="is-media-playable", options={"expose"=true})
     * @Method("GET")
     */
    public function isMediaPlayableAction($media, $test, $session, $questionnaire)
    {
        $isPlayable = $this->mediaClickManager->isMediaPlayable($media, $test, $questionnaire, $session);

        return new JsonResponse(
            array(
                'isPlayable' => $isPlayable,
            )
        );
    }
}
