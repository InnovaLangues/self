<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Media\MediaClick;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Session;
use Innova\SelfBundle\Entity\Media\Media;
use Innova\SelfBundle\Entity\PhasedTest\Component;

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

    public function getRemainingListening(Media $media, Questionnaire $questionnaire, Test $test, Session $session, Component $component = null)
    {
        $nbClick = $this->getMediaClickCount($media, $test, $questionnaire, $session, $component);
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

    public function createMediaClick(Media $media, Questionnaire $questionnaire, Test $test, Session $session, Component $component = null)
    {
        if (!$this->securityContext->isGranted('ROLE_ADMIN')) {
            $mediaClick = new MediaClick();
            $mediaClick->setMedia($media);
            $mediaClick->setUser($this->user);
            $mediaClick->setTest($test);
            $mediaClick->setSession($session);
            $mediaClick->setComponent($component);
            $mediaClick->setQuestionnaire($questionnaire);

            $this->entityManager->persist($mediaClick);
            $this->entityManager->flush();
        }

        return $this;
    }

    public function isMediaPlayable(Media $media, Test $test, Questionnaire $questionnaire, Session $session, Component $component = null)
    {
        $nbClick = $this->getMediaClickCount($media, $test, $questionnaire, $session, $component);
        $mediaLimit = $this->entityManager->getRepository('InnovaSelfBundle:Media\MediaLimit')->findOneBy(array('media' => $media, 'questionnaire' => $questionnaire));

        if (is_null($mediaLimit) || $mediaLimit->getListeningLimit() > $nbClick || $mediaLimit->getListeningLimit() === 0 || $this->securityContext->isGranted('ROLE_ADMIN')) {
            return true;
        } else {
            return false;
        }
    }

    public function getMediaClickCount(Media $media, Test $test, Questionnaire $questionnaire, Session $session, Component $component = null)
    {
        $mediaClicks = $this->entityManager->getRepository('InnovaSelfBundle:Media\MediaClick')
                        ->findBy(array(
                                        'media' => $media,
                                        'test' => $test,
                                        'questionnaire' => $questionnaire,
                                        'user' => $this->user,
                                        'session' => $session,
                                        'component' => $component,
                                      )
                                );

        return count($mediaClicks);
    }
}
