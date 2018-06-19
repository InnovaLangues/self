<?php

namespace Innova\SelfBundle\Manager\Identity;

use Innova\SelfBundle\Entity\Typology;

class TypologyManager
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
            $typo = $this->findByName($el[0]);
            if (!$typo) {
                $r = new Typology();
                $r->setName($el[0]);
                $r->setDescription($el[1]);
                $em->persist($r);
            } elseif ($typo->getDescription() != $el[1]) {
                $typo->setDescription($el[1]);
                $em->persist($typo);
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

        return $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($name);
    }
}
