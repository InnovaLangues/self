<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Media;
use Innova\SelfBundle\Entity\MediaLimit;

class MediaManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createMedia($test, $questionnaire, $mediaTypeName, $name, $description, $url, $mediaLimit)
    {
        $em = $this->entityManager;
        $type = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName($mediaTypeName);

        $media = new Media();
        $media->setMediaType($type);
        $media->setName($name);
        $media->setDescription($description);
        $media->setUrl($url);

        $em->persist($media);
        $em->flush();

        if ($mediaTypeName == "audio" || $mediaTypeName == "video") {
            $this->updateMediaLimit($test, $questionnaire, $media, $mediaLimit);
        }

        return $media;
    }

    /**
     * UpdateMediaLimit a mediaLimit entity or create one for a given media, and questionnaire
     */
    public function updateMediaLimit($test, $questionnaire, $media, $limit)
    {
        $em = $this->entityManager;

        if (!$mediaLimit = $em->getRepository('InnovaSelfBundle:MediaLimit')->findOneBy(array('test' => $test, 'questionnaire' => $questionnaire, 'media' => $media))) {
            $mediaLimit = new MediaLimit();
            $mediaLimit->setTest($test);
            $mediaLimit->setQuestionnaire($questionnaire);
            $mediaLimit->setMedia($media);
        }
        $mediaLimit->setListeningLimit($limit);

        $em->persist($mediaLimit);
        $em->flush();

        return $mediaLimit;
    }
}
