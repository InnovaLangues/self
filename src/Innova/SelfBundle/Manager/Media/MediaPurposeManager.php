<?php

namespace Innova\SelfBundle\Manager\Media;

use Innova\SelfBundle\Entity\QuestionnaireIdentity\MediaPurpose;

class MediaPurposeManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create($array)
    {
        $em = $this->entityManager;

        foreach ($array as $el) {
            if (!$this->findByName($el)) {
                $r = new MediaPurpose();
                $r->setName($el);
                $em->persist($r);
            }
        }

        $em->flush();

        return true;
    }

    public function delete($array)
    {
        $em = $this->entityManager;

        foreach ($array as $el) {
            if ($r = $this->findByName($el)) {
                $em->remove($r);
            }
        }

        $em->flush();

        return true;
    }

    private function findByName($name)
    {
        $em = $this->entityManager;

        return $em->getRepository('InnovaSelfBundle:Media\MediaPurpose')->findOneByName($name);
    }
}
