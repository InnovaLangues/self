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

    public function createMedia($test, $questionnaire, $mediaTypeName, $name, $description, $url, $mediaLimit, $entityField)
    {

        $entityField2Purpose = array(
            "texte" => "objet de la question",
            "contexte" => "contexte",
            "amorce" => "question",
            "media" => "question",
            "app-answer" => "proposition",
            "app-distractor" => "proposition",
            "proposition" => "proposition",
            "reponse" => "reponse", 
            "clue" => "clue",
            "syllable" => "syllable",
            "instruction" => "instruction"

        );

        $em = $this->entityManager;
        $type = $em->getRepository('InnovaSelfBundle:MediaType')->findOneByName($mediaTypeName);
        $purpose = $em->getRepository('InnovaSelfBundle:MediaPurpose')->findOneByName($entityField2Purpose[$entityField]);

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

    /**
     * UpdateMediaLimit a mediaLimit entity or create one for a given media, and questionnaire
     */
    public function updateMediaLimit($questionnaire, $media, $limit)
    {
        $em = $this->entityManager;

        if (!$mediaLimit = $em->getRepository('InnovaSelfBundle:MediaLimit')->findOneBy(array('questionnaire' => $questionnaire, 'media' => $media))) {
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
