<?php

namespace Innova\SelfBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Innova\SelfBundle\Entity\MediaType;
use Innova\SelfBundle\Entity\Duration;
use Innova\SelfBundle\Entity\Level;
use Innova\SelfBundle\Entity\Skill;
use Innova\SelfBundle\Entity\Typology;
use Innova\SelfBundle\Entity\OriginStudent;
use Innova\SelfBundle\Entity\Language;
use Innova\SelfBundle\Entity\LevelLansad;

class LoadFixturesData implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $mediaTypes = array("audio", "video", "texte", "image");
        foreach ($mediaTypes as $mediaType) {
            $type = new mediaType();
            $type->setName($mediaType);
            $manager->persist($type);
        }

        $questionnaireDurations = array("brève", "moyenne", "longue");
        foreach ($questionnaireDurations as $questionnaireDuration) {
            $duration = new Duration();
            $duration->setName($questionnaireDuration);
            $manager->persist($duration);
        }

        $questionnaireLevels = array("A1", "A2", "B1", "B2", "C1");
        foreach ($questionnaireLevels as $questionnaireLevel) {
            $level = new Level();
            $level->setName($questionnaireLevel);
            $manager->persist($level);
        }

        $questionnaireSkills = array("CO", "CE");
        foreach ($questionnaireSkills as $questionnaireSkill) {
            $skill = new Skill();
            $skill->setName($questionnaireSkill);
            $manager->persist($skill);
        }

        $typologies = array("TVF", "QRU", "VF", "QRM", "TQRU", "TQRM", "TVFPM", "VFPM", "APPAT", "APPAA", "APPAI");
        foreach ($typologies as $typology) {
            $typo = new Typology();
            $typo->setName($typology);
            $manager->persist($typo);
        }

        /*
        New table for version 1.2 or version 2 (2014)
        fixtures for originStudent table
        */
        $originStudents = array("LANSAD", "LLCE", "LEA", "Autres");
        foreach ($originStudents as $originStudent) {
            $student = new originStudent();
            $student->setName($originStudent);
            $manager->persist($student);
        }

        /*
        New table for version 1.2 or version 2 (2014)
        fixtures for language table
        */
        $lang_eng = new Language();
        $lang_eng->setName("eng");
        $lang_eng->setColor("E37E71");
        $manager->persist($lang_eng);
        $manager->flush();

        $lang_it = new Language();
        $lang_it->setName("it");
        $lang_it->setColor("717EE3");
        $manager->persist($lang_it);
        $manager->flush();

        /*
        New table for version 1.2 or version 2 (2014)
        fixtures for levelLansad table
        */
        /* Level for English language */
        $levelLansadEngs = array("A1", "A2", "B1.1", "B1.2", "B1.3", "B2.1", "B2.2", "C1", "C2");
        foreach ($levelLansadEngs as $levelLansadEng) {
            $level = new LevelLansad();
            $level->setLanguage($lang_eng);
            $level->setName($levelLansadEng);
            $manager->persist($level);
        }

        /* Level for Ialian language */
        $levelLansadIts = array("A1", "A2", "B1.1", "B1.2", "B1.3", "B2.1", "B2.2", "C1", "C2");
        foreach ($levelLansadIts as $levelLansadIt) {
            $level = new LevelLansad();
            $level->setLanguage($lang_it);
            $level->setName($levelLansadIt);
            $manager->persist($level);
        }

        $manager->flush();

    }
}
