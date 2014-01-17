<?php

namespace Innova\SelfBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Innova\SelfBundle\Entity\MediaType;
use Innova\SelfBundle\Entity\Duration;
use Innova\SelfBundle\Entity\Level;
use Innova\SelfBundle\Entity\Skill;
use Innova\SelfBundle\Entity\Typology;
use Innova\SelfBundle\Entity\OriginStudent;
use Innova\SelfBundle\Entity\Language;
use Innova\SelfBundle\Entity\LevelLansad;

/**
 * Symfony command to add or not fixtures. EV.
 *
*/
class FixtureCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('self:fixtures:load')
            ->setDescription('Optimize Load Fixtures')
        ;
    }

    /**
     * If I have any data in database, then I don't execute fixtures. EV.
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        $skill =  $em->getRepository('InnovaSelfBundle:Skill')->findAll();

        $countSkill = count($skill);

        if ($countSkill == 0) {

            $output->writeln("Fixtures exécutées.");

            $mediaTypes = array("audio", "video", "texte", "image");
            foreach ($mediaTypes as $mediaType) {
                $type = new mediaType();
                $type->setName($mediaType);
                $em->persist($type);
            }

            $questionnaireDurations = array("brève", "moyenne", "longue");
            foreach ($questionnaireDurations as $questionnaireDuration) {
                $duration = new Duration();
                $duration->setName($questionnaireDuration);
                $em->persist($duration);
            }

            $questionnaireLevels = array("A1", "A2", "B1", "B2", "C1");
            foreach ($questionnaireLevels as $questionnaireLevel) {
                $level = new Level();
                $level->setName($questionnaireLevel);
                $em->persist($level);
            }

            $questionnaireSkills = array("CO", "CE");
            foreach ($questionnaireSkills as $questionnaireSkill) {
                $skill = new Skill();
                $skill->setName($questionnaireSkill);
                $em->persist($skill);
            }

            $typologies = array("TVF", "QRU", "VF", "QRM", "TQRU", "TQRM", "TVFPM", "VFPM", "APPAT", "APPAA", "APPAI");
            foreach ($typologies as $typology) {
                $typo = new Typology();
                $typo->setName($typology);
                $em->persist($typo);
            }

            /*
            New table for version 1.2 or version 2 (2014)
            fixtures for originStudent table
            */
            $originStudents = array("LANSAD", "LLCE", "LEA", "UJF", "Autres");
            foreach ($originStudents as $originStudent) {
                $student = new originStudent();
                $student->setName($originStudent);
                $em->persist($student);
            }

            /* New table for version 1.2 or version 2 (2014)
            fixtures for language table
            Important : we must have some keywords to add test.
            So, in TestController.php, we create the test with language "English" or "Italian". */
            $langEng = new Language();
            $langEng->setName("English");
            $langEng->setColor("blue");
            $em->persist($langEng);
            $em->flush();

            $langIt = new Language();
            $langIt->setName("Italian");
            $langIt->setColor("pink");
            $em->persist($langIt);
            $em->flush();

            /*
            New table for version 1.2 or version 2 (2014)
            fixtures for levelLansad table
            */
            /* Level for English language */
            $levelLansadEngs = array("A1", "A2", "B1.1", "B1.2", "B1.3", "B2.1", "B2.2", "C1", "C2");
            foreach ($levelLansadEngs as $levelLansadEng) {
                $level = new LevelLansad();
                $level->setLanguage($langEng);
                $level->setName($levelLansadEng);
                $em->persist($level);
            }

            /* Level for Ialian language */
            $levelLansadIts = array("A1", "A2", "B1.1", "B1.2", "B1.3", "B2.1", "B2.2", "C1", "C2");
            foreach ($levelLansadIts as $levelLansadIt) {
                $level = new LevelLansad();
                $level->setLanguage($langIt);
                $level->setName($levelLansadIt);
                $em->persist($level);
            }

            $em->flush();
        } else {
            $output->writeln("Fixtures non exécutées. Des données existent déjà.");
        }

    }
}
