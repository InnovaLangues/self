<?php

namespace Innova\SelfBundle\Manager\Identity;

use Innova\SelfBundle\Entity\Skill;

class SkillManager
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
            $skillName = $el[0];
            $typoNames = $el[1];
            if ($skill = $this->findByName($skillName)) {
                foreach ($typoNames as $typoName) {
                    $skillTypos = $skill->getTypologys();
                    if ($typo = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($typoName)) {
                        if (!$skillTypos->contains($typo)) {
                            $skill->addTypology($typo);
                            $em->persist($skill);
                        }
                    }
                }
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

        return $em->getRepository('InnovaSelfBundle:Skill')->findOneByName($name);
    }
}
