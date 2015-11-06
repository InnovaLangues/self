<?php

namespace Innova\SelfBundle\Manager\Media;

use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Media\Media;
use Innova\SelfBundle\Entity\Media\MediaLimit;

class MediaManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createMedia(Questionnaire $questionnaire = null, $mediaTypeName, $name, $description, $url, $mediaLimit, $entityField)
    {
        $entityField2Purpose = array(
            'texte' => 'objet de la question',
            'contexte' => 'contexte',
            'amorce' => 'question',
            'app-media' => 'question',
            'app-answer' => 'proposition',
            'app-distractor' => 'proposition',
            'proposition' => 'proposition',
            'reponse' => 'reponse',
            'clue' => 'clue',
            'syllable' => 'syllable',
            'instruction' => 'instruction',
            'functional-instruction' => 'functional-instruction',
            'comment' => 'comment',
            'feedback' => 'feedback',
            'distractor' => 'distractor',
            'blank-text' => 'blank-text',
        );

        $type = $this->entityManager->getRepository('InnovaSelfBundle:Media\MediaType')->findOneByName($mediaTypeName);
        $purpose = $this->entityManager->getRepository('InnovaSelfBundle:Media\MediaPurpose')->findOneByName($entityField2Purpose[$entityField]);

        $media = $this->newMedia($name, $url, $description, $purpose, $type);

        if ($mediaTypeName == 'audio' || $mediaTypeName == 'video') {
            $this->updateMediaLimit($questionnaire, $media, $mediaLimit);
        }

        return $media;
    }

    public function updateMedia($mediaId, $url, $name, $description)
    {
        $media = $this->entityManager->getRepository('InnovaSelfBundle:Media\Media')->find($mediaId);
        $media->setUrl($url);
        $media->setName($name);
        $media->setDescription($description);

        $this->entityManager->persist($media);
        $this->entityManager->flush();

        return $media;
    }

    /**
     * UpdateMediaLimit a mediaLimit entity or create one for a given media, and questionnaire.
     */
    public function updateMediaLimit(Questionnaire $questionnaire, Media $media, $limit)
    {
        if (!$mediaLimit = $this->entityManager->getRepository('InnovaSelfBundle:Media\MediaLimit')->findOneBy(array('questionnaire' => $questionnaire, 'media' => $media))) {
            $mediaLimit = $this->newMediaLimit($questionnaire, $media);
        }
        $mediaLimit->setListeningLimit($limit);

        $this->entityManager->persist($mediaLimit);
        $this->entityManager->flush();

        return $mediaLimit;
    }

    public function duplicate(Media $media = null, Questionnaire $questionnaire)
    {
        if ($media) {
            $newMedia = $this->newMedia($media->getName(), $media->getUrl(), $media->getDescription(), $media->getMediaPurpose(), $media->getMediaType());

            $limits = $media->getMediaLimits();
            foreach ($limits as $limit) {
                $newLimit = $this->newMediaLimit($questionnaire, $newMedia);
                $newLimit->setListeningLimit($limit->getListeningLimit());
                $this->entityManager->persist($newLimit);
            }
            $this->entityManager->flush();

            return $newMedia;
        }
    }

    private function newMedia($name, $url, $description, $mediaPurpose, $mediaType)
    {
        $media = new Media();
        $media->setName($name);
        $media->setUrl($url);
        $media->setDescription($description);
        $media->setMediaPurpose($mediaPurpose);
        $media->setMediaType($mediaType);

        $this->entityManager->persist($media);
        $this->entityManager->flush();

        return $media;
    }

    private function newMediaLimit($questionnaire, $media)
    {
        $limit = new MediaLimit();
        $limit->setQuestionnaire($questionnaire);
        $limit->setMedia($media);

        return $limit;
    }
}
