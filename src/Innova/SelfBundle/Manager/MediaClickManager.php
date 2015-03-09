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

    public function getRemainingListening($media, $questionnaire, $test, $session)
    {
        $nbClick = $this->getMediaClickCount($media, $test, $questionnaire, $session);
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

    public function createMediaClick($media, $questionnaire, $test, $session)
    {
        if (!$this->securityContext->isGranted('ROLE_ADMIN')) {
            $mediaClick = new MediaClick();
            $mediaClick->setMedia($media);
            $mediaClick->setUser($this->user);
            $mediaClick->setTest($test);
            $mediaClick->setSession($session);
            $mediaClick->setQuestionnaire($questionnaire);

            $this->entityManager->persist($mediaClick);
            $this->entityManager->flush();
        }

        return $this;
    }

    public function isMediaPlayable($media, $test, $questionnaire, $session)
    {
        $nbClick = $this->getMediaClickCount($media, $test, $questionnaire, $session);
        $mediaLimit = $this->entityManager->getRepository('InnovaSelfBundle:Media\MediaLimit')->findOneBy(array('media' => $media, 'questionnaire' => $questionnaire));

        if (is_null($mediaLimit) || $mediaLimit->getListeningLimit() > $nbClick || $mediaLimit->getListeningLimit() === 0 || $this->securityContext->isGranted('ROLE_ADMIN')) {
            return true;
        } else {
            return false;
        }
    }

    public function getMediaClickCount($media, $test, $questionnaire, $session)
    {
        $mediaClicks = $this->entityManager->getRepository('InnovaSelfBundle:Media\MediaClick')
                        ->findBy(array(
                                        'media' => $media,
                                        'test' => $test,
                                        'questionnaire' => $questionnaire,
                                        'user' => $this->user,
                                        'session' => $session,
                                      )
                                );

        return count($mediaClicks);
    }
}
