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
use Innova\SelfBundle\Entity\Status;
use Innova\SelfBundle\Entity\MediaPurpose;
use Innova\SelfBundle\Entity\ClueType;
use Innova\SelfBundle\Entity\EditorLogAction;
use Innova\SelfBundle\Entity\EditorLogObject;


class FixtureCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('self:fixtures:load')
            ->setDescription('Load needed datas')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
            $start = time();
            $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

            $mediaTypes = array("audio", "video", "texte", "image");
            foreach ($mediaTypes as $mediaType) {
                if (!$em->getRepository('InnovaSelfBundle:MediaType')->findOneByName($mediaType)) {
                    $type = new mediaType();
                    $type->setName($mediaType);
                    $em->persist($type);
                    $output->writeln("Add new mediaType (".$mediaType.").");
                }
            }

            $questionnaireDurations = array("brève", "moyenne", "longue");
            foreach ($questionnaireDurations as $questionnaireDuration) {
                if (!$em->getRepository('InnovaSelfBundle:Duration')->findOneByName($questionnaireDuration)) {
                    $duration = new Duration();
                    $duration->setName($questionnaireDuration);
                    $em->persist($duration);
                    $output->writeln("Add new Duration (".$questionnaireDuration.").");
                }
            }

            $questionnaireLevels = array("A1", "A2", "B1", "B2", "C1");
            foreach ($questionnaireLevels as $questionnaireLevel) {
                if (!$em->getRepository('InnovaSelfBundle:Level')->findOneByName($questionnaireLevel)) {
                    $level = new Level();
                    $level->setName($questionnaireLevel);
                    $em->persist($level);
                    $output->writeln("Add new Level (".$questionnaireLevel.").");
                }
            }

            $questionnaireSkills = array("CO", "CE", "EEC");
            foreach ($questionnaireSkills as $questionnaireSkill) {
                if (!$em->getRepository('InnovaSelfBundle:Skill')->findOneByName($questionnaireSkill)) {
                    $skill = new Skill();
                    $skill->setName($questionnaireSkill);
                    $em->persist($skill);
                    $output->writeln("Add new Skill (".$questionnaireSkill.").");
                }
            }

            $typologies = array(
                array("TVF", "Tableau de Vrai-Faux"), array("QRU", "Question à Réponse Unique"), array("VF", "Vrai-Faux"),
                array("QRM", "Question à Réponse Multiple"), array("TQRU", "Tableau de QRU"), array("TQRM", "Tableau de QRM"),
                array("APPAT","Appariemment Audio-Texte"), array("APPIT","Appariemment Image-Texte"), array("APPAA", "Appariemment Audio-Audio"), array("APPAI", "Appariemment Audio-Image"),
                array("APPTT", "Appariemment Texte-Texte"), array("TVFNM", "Tableau de Vrai-Faux-Non Mentionné"),
                array("VFNM", "Vrai-Faux-Non Mentionné"), array("TLCMLDM", "Liste de mots"),
                array("TLQROCNOCLU", "Aucune indice"), array("TLQROCLEN","Longueur"), array("TLQROCFIRST","Premier caractère"), array("TLQROCFIRSTLEN","1er caractère et longueur"), array("TLQROCSYL","Syllabe"),
                array("TLCMLMULT", "Listes de choix multiple"), array("TLQROCDERIV", "Dérivation"), array("TLQROCTRANS", "Transformation")
            );
            foreach ($typologies as $typology) {
                if (!$typo = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($typology[0])) {
                    $typo = new Typology();
                    $typo->setName($typology[0]);
                    $typo->setDescription($typology[1]);
                    $em->persist($typo);
                    $output->writeln("Add new Typology (".$typology[0]." : ".$typology[1].").");
                } else {
                    if ($typo->getDescription() != $typology[1]) {
                        $typo->setDescription($typology[1]);
                        $em->persist($typo);
                        $output->writeln("Edit ".$typology[0]." description (".$typology[1].").");
                    }
                }
            }

            $typoName = '';
            $typologiesToDelete = array("TLCMQRU", "TLCMTQRU", "TLQROCDCTU", "TLQROCDCTM");
            foreach ($typologiesToDelete as $typology) {
                if ($typo = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($typology)) {
                    $em->remove($typo);
                    /* Database queries should use parameter binding fix #397 */
                    $typoName = $typo->getName();
                    $text = "Delete Typology (". $typoName .").";
                    printf($text);
                }
            }
            /*
                New table for version 1.2 or version 2 (2014)
                fixtures for originStudent table
            */
            $originStudents = array("LANSAD", "LLCE", "LEA", "UJF", "Autres");
            foreach ($originStudents as $originStudent) {
                if (!$em->getRepository('InnovaSelfBundle:OriginStudent')->findOneByName($originStudent)) {
                    $student = new originStudent();
                    $student->setName($originStudent);
                    $em->persist($student);
                    $output->writeln("Add new OriginStudent (".$originStudent.").");
                }
            }

            /*  New table for version 1.2 or version 2 (2014)
                fixtures for language table
                Important : we must have some keywords to add test.
                So, in TestController.php, we create the test with language "English" or "Italian".
            */
            if (!$em->getRepository('InnovaSelfBundle:Language')->findOneByName("English")) {
                $langEng = new Language();
                $langEng->setName("English");
                $langEng->setColor("blue");
                $em->persist($langEng);
                $em->flush();
                $output->writeln("Add new Language (English).");
            }

            if (!$em->getRepository('InnovaSelfBundle:Language')->findOneByName("Italian")) {
                $langIt = new Language();
                $langIt->setName("Italian");
                $langIt->setColor("pink");
                $em->persist($langIt);
                $em->flush();
                $output->writeln("Add new Language (Italian).");
            }

            if (!$em->getRepository('InnovaSelfBundle:Language')->findOneByName("Chinese")) {
                $langCn = new Language();
                $langCn->setName("Chinese");
                $langCn->setColor("pink");
                $em->persist($langCn);
                $em->flush();
                $output->writeln("Add new Language (Chinese).");
            }

            /*
                New table for version 1.2 or version 2 (2014)
                fixtures for levelLansad table
            */
            $langEng = $em->getRepository('InnovaSelfBundle:Language')->findOneByName("English");
            /* Level for English language */
            $levelLansadEngs = array("A1", "A2", "B1.1", "B1.2", "B1.3", "B2.1", "B2.2", "C1", "C2");
            foreach ($levelLansadEngs as $levelLansadEng) {
                if (!$em->getRepository('InnovaSelfBundle:LevelLansad')->findOneByName($levelLansadEng)) {
                    $level = new LevelLansad();
                    $level->setLanguage($langEng);
                    $level->setName($levelLansadEng);
                    $em->persist($level);
                    $output->writeln("Add new LevelLansad (".$levelLansadEng.").");
                }
            }

            $langIt = $em->getRepository('InnovaSelfBundle:Language')->findOneByName("Italian");
            /* Level for Ialian language */
            $levelLansadIts = array("A1", "A2", "B1.1", "B1.2", "B1.3", "B2.1", "B2.2", "C1", "C2");
            foreach ($levelLansadIts as $levelLansadIt) {
                if (!$em->getRepository('InnovaSelfBundle:LevelLansad')->findOneByName($levelLansadIt)) {
                    $level = new LevelLansad();
                    $level->setLanguage($langIt);
                    $level->setName($levelLansadIt);
                    $em->persist($level);
                    $output->writeln("Add new LevelLansad (".$levelLansadIt.").");
                }
            }



            /* Gestion du statut des tâches */
            $status = array("Ecriture", "Révision", "Validation", "Modification post-pilotage");
            foreach ($status as $s) {
                if (!$em->getRepository('InnovaSelfBundle:Status')->findOneByName($s)) {
                    $stat = new Status();
                    $stat->setName($s);
                    $em->persist($stat);
                    $output->writeln("Add new Status (".$s.").");
                }
            }

            /* Gestion du mediaPurpose... à quoi sert le media (consigne, contexte, proposition, etc.) */
            $purposes = array("blank-text", "contexte", "objet de la question", "question", "proposition", "reponse", "syllable", "clue", "instruction", "functional-instruction", "comment", "feedback", "distractor");
            foreach ($purposes as $purpose) {
                if (!$em->getRepository('InnovaSelfBundle:MediaPurpose')->findOneByName($purpose)) {
                    $p = new MediaPurpose();
                    $p->setName($purpose);
                    $em->persist($p);
                    $output->writeln("Add new MediaPurpose (".$purpose.").");
                }
            }

            /* Gestion du mediaPurpose... à quoi sert le media (consigne, contexte, proposition, etc.) */
            $clueTypes = array(array("fonctionnel", "clue-fonctionnel"), array("didactique", "clue-didactique"));
            foreach ($clueTypes as $clueType) {
                if (!$clueTyp = $em->getRepository('InnovaSelfBundle:ClueType')->findOneByName($clueType[0])) {
                    $c = new clueType();
                    $c->setName($clueType[0]);
                    $c->setColor($clueType[1]);
                    $em->persist($c);
                    $output->writeln("Add new clueType (".$clueType[0].").");
                } elseif($clueTyp->getColor() != $clueType[1]) {
                    $clueTyp->setColor($clueType[1]);
                    $em->persist($clueTyp);
                    $output->writeln("Edit clueType (".$clueType[0].").");
                }
            }

            /* Gestion des logs éditeur */
            $editorLogActions = array("editor_create", "editor_edit", "editor_delete");
            foreach ($editorLogActions as $editorAction) {
                if (!$em->getRepository('InnovaSelfBundle:EditorLogAction')->findOneByName($editorAction)) {
                    $e = new EditorLogAction();
                    $e->setName($editorAction);
                    $em->persist($e);
                    $output->writeln("Add new editorLogAction (".$editorAction.")");
                }
            }

            $editorLogObjects = array(
                "contexte", "texte", "objet de la question", "question", "proposition",
                "reponse", "syllable", "clue", "instruction", "functional-instruction",
                "comment", "feedback", "distractor", "app-paire", "app-media", "app-answer",
                "app-distractor", "listening-limit", "clue-type", "task", "words-list", "blanks", "blank-text",
                "theme", "fixed-order", "skill", "level", "typology", "status", "text-type"
            );
            foreach ($editorLogObjects as $editorLogObject) {
                if (!$em->getRepository('InnovaSelfBundle:EditorLogObject')->findOneByName($editorLogObject)) {
                    $e = new EditorLogObject();
                    $e->setName($editorLogObject);
                    $em->persist($e);
                    $output->writeln("Add new editorLogObject (".$editorLogObject.")");
                }
            }

            $em->flush();

            $now = time();
            $duration = $now - $start;

            $output->writeln("Fixtures exécutées en ".$duration." sec.");
    }
}
