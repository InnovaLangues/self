<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Innova\SelfBundle\Manager\Media\MediaClickManager;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Session;
use Innova\SelfBundle\Entity\Media\Media;
use Innova\SelfBundle\Entity\PhasedTest\Component;

/**
 * Class MediaClickController
 *
 * @Route(
 *      name = "innova_mediaclick",
 *      service = "innova_mediaclick"
 * )
 * @ParamConverter("test", isOptional="true", class="InnovaSelfBundle:Test", options={"id" = "testId"})
 * @ParamConverter("session", isOptional="true", class="InnovaSelfBundle:Session", options={"id" = "sessionId"})
 * @ParamConverter("questionnaire", isOptional="true", class="InnovaSelfBundle:Questionnaire", options={"id" = "questionnaireId"})
 * @ParamConverter("media", isOptional="true", class="InnovaSelfBundle:Media\Media", options={"id" = "mediaId"})
 * @ParamConverter("component", isOptional="true", class="InnovaSelfBundle:PhasedTest\Component", options={"id" = "componentId"})
 */
class MediaClickController
{
    protected $mediaClickManager;

    public function __construct(MediaClickManager $mediaClickManager)
    {
        $this->mediaClickManager = $mediaClickManager;
    }

    /**
     * @Route(
     *  "/get-remaining-listening/{mediaId}/{testId}/{sessionId}/{questionnaireId}/{componentId}",
     *  name="get-remaining-listening", options={"expose"=true})
     * @Method("GET")
     * @Cache(smaxage="0", maxage="0")
     *
     */
    public function getRemainingListeningAction(Media $media, Test $test, Session $session, Questionnaire $questionnaire, Component $component = null)
    {
        $remainingListening = $this->mediaClickManager->getRemainingListening($media, $questionnaire, $test, $session, $component);

        return new JsonResponse(
            array(
                'remainingListening' => $remainingListening,
            )
        );
    }

    /**
     * @Route(
     *  "/increment-media-clicks/{mediaId}/{testId}/{sessionId}/{questionnaireId}/{componentId}",
     *  name="increment-media-clicks", options={"expose"=true})
     * @Method({"GET", "POST"})
     * @Cache(smaxage="0", maxage="0")
     *
     */
    public function incrementMediaClicksAction(Media $media, Test $test, Session $session, Questionnaire $questionnaire, Component $component = null)
    {
        $this->mediaClickManager->createMediaClick($media, $questionnaire, $test, $session, $component);
        $remainingListening = $this->mediaClickManager->getRemainingListening($media, $questionnaire, $test, $session, $component);

        return new JsonResponse(
            array(
                'remainingListening' => $remainingListening,
            )
        );
    }

    /**
     * @Route(
     *  "/is-media-playable/{mediaId}/{testId}/{sessionId}/{questionnaireId}/{componentId}",
     *  name="is-media-playable", options={"expose"=true})
     * @Method("GET")
     * @Cache(smaxage="0", maxage="0")
     *
     */
    public function isMediaPlayableAction(Media $media, Test $test, Session $session, Questionnaire $questionnaire, Component $component = null)
    {
        $isPlayable = $this->mediaClickManager->isMediaPlayable($media, $test, $questionnaire, $session, $component);

        return new JsonResponse(
            array(
                'isPlayable' => $isPlayable,
            )
        );
    }
}
