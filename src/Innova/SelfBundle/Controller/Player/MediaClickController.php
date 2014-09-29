<?php

namespace Innova\SelfBundle\Controller\Player;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Innova\SelfBundle\Manager\MediaClickManager;

/**
 * Class MediaClickController
 *
 * @Route(
 *      "",
 *      name = "innova_mediaclick",
 *      service = "innova_mediaclick"
 * )
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
     * @Route("/get-remaining-listening", name="get-remaining-listening", options={"expose"=true})
     * @Method("GET")
     */
    public function getRemainingListeningAction()
    {
        $mediaId = $this->request->get('mediaId');
        $questionnaireId = $this->request->get('questionnaireId');
        $testId = $this->request->get('testId');

        $remainingListening = $this->mediaClickManager->getRemainingListening($mediaId, $questionnaireId, $testId);

        return new JsonResponse(
            array(
                'remainingListening' => $remainingListening,
            )
        );
    }

    /**
     * @Route("/increment-media-clicks", name="increment-media-clicks", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function incrementMediaClicksAction()
    {
        $mediaId = $this->request->get('mediaId');
        $questionnaireId = $this->request->get('questionnaireId');
        $testId = $this->request->get('testId');

        $this->mediaClickManager->createMediaClick($mediaId, $questionnaireId, $testId);

        $remainingListening = $this->mediaClickManager->getRemainingListening($mediaId, $questionnaireId, $testId);

        return new JsonResponse(
            array(
                'remainingListening' => $remainingListening,
            )
        );
    }

    /**
     * @Route("/is-media-playable", name="is-media-playable", options={"expose"=true})
     * @Method("GET")
     */
    public function isMediaPlayableAction()
    {
        $mediaId = $this->request->get('mediaId');
        $questionnaireId = $this->request->get('questionnaireId');
        $testId = $this->request->get('testId');

        $isPlayable = $this->mediaClickManager->isMediaPlayable($mediaId, $testId, $questionnaireId);

        return new JsonResponse(
            array(
                'isPlayable' => $isPlayable,
            )
        );
    }
}
