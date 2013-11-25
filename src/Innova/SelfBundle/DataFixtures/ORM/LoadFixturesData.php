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

        $manager->flush();

    }
}