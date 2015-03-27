<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\LevelLansad;

class LevelLansadManager
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
            $language = $em->getRepository('InnovaSelfBundle:Language')->findOneByName($el[0]);
            $names = $el[1];

            foreach ($names as $name) {
                if (!$this->findByNameAndLanguage($name, $language)) {
                    $level = new LevelLansad();
                    $level->setLanguage($language);
                    $level->setName($name);
                    $em->persist($level);
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
            $language = $el[0];
            $name = $el[1];
            if ($r = $this->findByNameAndLanguage($name, $language)) {
                $em->remove($r);
            }
        }

        $em->flush();

        return true;
    }

    private function findByNameAndLanguage($name, $language)
    {
        $em = $this->entityManager;

        return $em->getRepository('InnovaSelfBundle:LevelLansad')->findOneBy(array("name" => $name, "language" => $language));
    }
}
