<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Media\MediaClick;

class MediaClickManager
{
    protected $entityManager;
    protected $securityContext;
    protected $user;

    public function __construct($entityManager, $securityContext)
    {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
        $this->user = $this->securityContext->getToken()->getUser();
    }

    public function getRemainingListening($mediaId, $questionnaireId, $testId)
    {
        $media = $this->entityManager->getRepository('InnovaSelfBundle:Media\Media')->find($mediaId);
        $questionnaire = $this->entityManager->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        $test = $this->entityManager->getRepository('InnovaSelfBundle:Test')->find($testId);

        $nbClick = $this->getMediaClickCount($media, $test, $questionnaire);
        $mediaLimit = $this->entityManager->getRepository('InnovaSelfBundle:Media\MediaLimit')->findOneBy(array(
                                                                                    'media' => $media,
                                                                                    'questionnaire' => $questionnaire,
                                                                                ));

        if (is_null($mediaLimit) || $mediaLimit->getListeningLimit() == 0) {
            $remainingListening = "X";
        } else {
            $remainingListening = $mediaLimit->getListeningLimit() - $nbClick;
        }

        return $remainingListening;
    }

    public function createMediaClick($mediaId, $questionnaireId, $testId)
    {
        $media = $this->entityManager->getRepository('InnovaSelfBundle:Media\Media')->find($mediaId);
        $test = $this->entityManager->getRepository('InnovaSelfBundle:Test')->find($testId);
        $questionnaire = $this->entityManager->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);

        if (!$this->securityContext->isGranted('ROLE_ADMIN')) {
            $mediaClick = new MediaClick();
            $mediaClick->setMedia($media);
            $mediaClick->setUser($this->user);
            $mediaClick->setTest($test);
            $mediaClick->setQuestionnaire($questionnaire);

            $this->entityManager->persist($mediaClick);
            $this->entityManager->flush();
        }

        return $this;
    }

    public function isMediaPlayable($mediaId, $testId, $questionnaireId)
    {
        $media = $this->entityManager->getRepository('InnovaSelfBundle:Media\Media')->find($mediaId);
        $test = $this->entityManager->getRepository('InnovaSelfBundle:Test')->find($testId);
        $questionnaire = $this->entityManager->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);

        $nbClick = $this->getMediaClickCount($media, $test, $questionnaire);
        $mediaLimit = $this->entityManager->getRepository('InnovaSelfBundle:Media\MediaLimit')->findOneBy(array('media' => $media, 'questionnaire' => $questionnaire));

        if (is_null($mediaLimit) || $mediaLimit->getListeningLimit() > $nbClick || $mediaLimit->getListeningLimit() === 0 || $this->securityContext->isGranted('ROLE_ADMIN')) {
            return true;
        } else {
            return false;
        }
    }

    public function getMediaClickCount($media, $test, $questionnaire)
    {
        $mediaClicks = $this->entityManager->getRepository('InnovaSelfBundle:Media\MediaClick')
                        ->findBy(array(
                                        'media' => $media,
                                        'test' => $test,
                                        'questionnaire' => $questionnaire,
                                        'user' => $this->user,
                                      )
                                );

        return count($mediaClicks);
    }
}
