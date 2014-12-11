<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Media\Media;
use Innova\SelfBundle\Entity\Media\MediaLimit;

class MediaManager
{
    protected $entityManager;
    protected $questionnaireRevisorsManager;

    public function __construct($entityManager, $questionnaireRevisorsManager)
    {
        $this->entityManager = $entityManager;
        $this->questionnaireRevisorsManager = $questionnaireRevisorsManager;
    }

    public function createMedia(Questionnaire $questionnaire = null, $mediaTypeName, $name, $description, $url, $mediaLimit, $entityField)
    {
        $entityField2Purpose = array(
            "texte" => "objet de la question",
            "contexte" => "contexte",
            "amorce" => "question",
            "app-media" => "question",
            "app-answer" => "proposition",
            "app-distractor" => "proposition",
            "proposition" => "proposition",
            "reponse" => "reponse",
            "clue" => "clue",
            "syllable" => "syllable",
            "instruction" => "instruction",
            "functional-instruction" => "functional-instruction",
            "comment" => "comment",
            "feedback" => "feedback",
            "distractor" => "distractor",
            "blank-text" => "blank-text",
        );

        $em = $this->entityManager;
        $type = $em->getRepository('InnovaSelfBundle:Media\MediaType')->findOneByName($mediaTypeName);
        $purpose = $em->getRepository('InnovaSelfBundle:Media\MediaPurpose')->findOneByName($entityField2Purpose[$entityField]);

        $media = new Media();
        $media->setMediaType($type);
        $media->setMediaPurpose($purpose);
        $media->setName($name);
        $media->setDescription($description);
        $media->setUrl($url);

        $em->persist($media);
        $em->flush();

        if ($mediaTypeName == "audio" || $mediaTypeName == "video") {
            $this->updateMediaLimit($questionnaire, $media, $mediaLimit);
        }

        return $media;
    }

    public function updateMedia($mediaId, $url, $name, $description, Questionnaire $questionnaire)
    {
        $em = $this->entityManager;

        $media = $em->getRepository('InnovaSelfBundle:Media\Media')->find($mediaId);
        $media->setUrl($url);
        $media->setName($name);
        $media->setDescription($description);

        $em->persist($media);
        $em->flush();

        return $media;
    }

    /**
     * UpdateMediaLimit a mediaLimit entity or create one for a given media, and questionnaire
     */
    public function updateMediaLimit(Questionnaire $questionnaire, Media $media, $limit)
    {
        $em = $this->entityManager;

        if (!$mediaLimit = $em->getRepository('InnovaSelfBundle:Media\MediaLimit')->findOneBy(array('questionnaire' => $questionnaire, 'media' => $media))) {
            $mediaLimit = new MediaLimit();
            $mediaLimit->setQuestionnaire($questionnaire);
            $mediaLimit->setMedia($media);
        }
        $mediaLimit->setListeningLimit($limit);

        $em->persist($mediaLimit);
        $em->flush();

        return $mediaLimit;
    }
}
