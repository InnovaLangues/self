<?php

namespace Innova\SelfBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Innova\SelfBundle\Entity\Level;
use Innova\SelfBundle\Entity\OriginStudent;
use Innova\SelfBundle\Entity\Language;
use Innova\SelfBundle\Entity\LevelLansad;
use Innova\SelfBundle\Entity\ClueType;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\SourceType;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\Channel;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\Genre;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\Variety;
use Innova\SelfBundle\Entity\PhasedTest\ComponentType;

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
        $em = $this->getContainer()->get('doctrine')->getManager();

        $typologyManager = $this->getContainer()->get("self.typology.manager");
        $typologyManager->create(array( array("TVF", "Vrai-Faux"), array("TQRU", "Question à Réponse Unique"),
                                        array("TQRM", "Question à Réponses Multiples"), array("TLCMLDM", "Liste de mots"),
                                        array("APP", "Appariemment"), array("TVFNM", "Vrai-Faux-Non Mentionné"),
                                        array("TLCMLMULT", "Listes de choix multiple"), array("TLQROC", "Question Réponse Ouverte Courte"),
        ));

        $skillManager = $this->getContainer()->get("self.skill.manager");
        $skillManager->create(array(    array("CO", array("APP", "TQRM", "TQRU", "TVF", "TVFNM")),
                                        array("CE", array("APP", "TQRM", "TQRU", "TVF", "TVFNM")),
                                        array("EEC", array("TLCMLMULT", "TLQROC", "TLCMLDM", "TQRU")),
        ));

        $levelManager = $this->getContainer()->get("self.level.manager");
        $levelManager->create(array("A1", "A2", "B1", "B2", "C1"));

        $originStudentManager = $this->getContainer()->get("self.originStudent.manager");
        $originStudentManager->create(array("LANSAD", "LLCE", "LEA", "UJF", "Formation continue", "Autres"));

        $languageManager = $this->getContainer()->get("self.language.manager");
        $languageManager->create(array("English", "Italian", "Chinese", "Spanish"));

        /* MEDIA */
        $mediaTypeManager = $this->getContainer()->get("self.mediaType.manager");
        $mediaTypeManager->create(array("audio", "video", "texte", "image"));

        $mediaPurposeManager = $this->getContainer()->get("self.mediaPurpose.manager");
        $mediaPurposeManager->create(array("blank-text", "contexte", "objet de la question", "question", "proposition", "reponse", "syllable", "clue", "instruction", "functional-instruction", "comment", "feedback", "distractor"));

        /* IDENTITY */
        $statusManager = $this->getContainer()->get("self.status.manager");
        $statusManager->create(array("Ecriture", "Révision", "Validation", "Modification post-pilotage"));

        $lengthManager = $this->getContainer()->get("self.audioLength.manager");
        $lengthManager->create(array("short", "medium", "long", "very_long"));

        $textlengthManager = $this->getContainer()->get("self.textLength.manager");
        $textlengthManager->create(array("very", "short", "medium", "long", "very_long"));

        $sourceManager = $this->getContainer()->get("self.source.manager");
        $sourceManager->create(array("source.certification", "source.textbook", "source.intern", "source.other"));

        $sourceOperationManager = $this->getContainer()->get("self.sourceOperation.manager");
        $sourceOperationManager->create(array("source_operation.original", "source_operation.original_modified", "source_operation.constructed", "source_operation.constructed_modified"));

        $authorRightManager = $this->getContainer()->get("self.authorRight.manager");
        $authorRightManager->create(array("author_right.authorized", "author_right.not_needed", "author_right.pending", "author_right.to_ask"));

        $domainManager = $this->getContainer()->get("self.domain.manager");
        $domainManager->create(array("domain.personal", "domain.public", "domain.profesional", "domain.educational"));

        $flowManager = $this->getContainer()->get("self.flow.manager");
        $flowManager->create(array("flow.slow", "flow.medium", "flow.fast"));

        $receptionManager = $this->getContainer()->get("self.reception.manager");
        $receptionManager->create(array("reception.listener", "reception.listener_interact"));
        $receptionManager->delete(array("reception.performer", "reception.listener_pluridirectional", "reception.listener_monodirectional"));

        $registerManager = $this->getContainer()->get("self.register.manager");
        $registerManager->create(array("register.formal_elevated", "register.formal_neutral", "register.informal", "register.mixte"));

        $focusManager = $this->getContainer()->get("self.focus.manager");
        $focusManager->create(array("focus.lexical", "focus.communicative", "focus.morphosyntaxic"));

        $cognitiveOpManager = $this->getContainer()->get("self.cognitiveOp.manager");
        $cognitiveOpManager->create(array("cognitive.global_comprehension", "cognitive.detailed_comprehension", "cognitive.infer_context", "cognitive.infer_intention", "cognitive.infer_state", "cognitive.infer_register", "cognitive.interaction"));

        $sourceTypeManager = $this->getContainer()->get("self.sourceType.manager");
        $sourceTypeManager->create(array("sourceType.audio", "sourceType.video", "sourceType.text", "sourceType.image"));

        $channelManager = $this->getContainer()->get("self.channel.manager");
        $channelManager->create(array("channel.phone", "channel.videoconf", "channel.speaker", "channel.radio", "channel.tv", "channel.web", "channel.tutorial", "channel.localRecord", "channel.GPS", "channel.other"));

        $genreManager = $this->getContainer()->get("self.genre.manager");
        $genreManager->create(array("genre.informative", "genre.argumentative", "genre.narrative", "genre.descriptive", "genre.literary", "genre.conversational", "genre.cmd_synchrone", "genre.cmd_asynchrone"));

        $varietyManager = $this->getContainer()->get("self.variety.manager");
        $varietyManager->create(array("variety.standard", "variety.non_standard"));

        $componentTypeManager = $this->getContainer()->get("self.componentType.manager");
        $componentTypeManager->create(array("minitest", "step1", "step2", "step3", "step4"));

        $langEng = $em->getRepository('InnovaSelfBundle:Language')->findOneByName("English");
        /* Level for English language */
        $levelLansadEngs = array("A1", "A2", "B1.1", "B1.2", "B2.1", "B2.2", "C1", "C2");
        foreach ($levelLansadEngs as $levelLansadEng) {
            if (!$em->getRepository('InnovaSelfBundle:LevelLansad')->findOneBy(array('name' => $levelLansadEng, 'language' => $langEng))) {
                $level = new LevelLansad();
                $level->setLanguage($langEng);
                $level->setName($levelLansadEng);
                $em->persist($level);
                $output->writeln("Add new LevelLansad (".$levelLansadEng.").");
            }
        }

        $langIt = $em->getRepository('InnovaSelfBundle:Language')->findOneByName("Italian");
        /* Level for Ialian language */
        $levelLansadIts = array("A1", "A2", "B1.1", "B1.2", "B2.1", "B2.2", "C1", "C2");
        foreach ($levelLansadIts as $levelLansadIt) {
            if (!$em->getRepository('InnovaSelfBundle:LevelLansad')->findOneBy(array('name' => $levelLansadIt, 'language' => $langIt))) {
                $level = new LevelLansad();
                $level->setLanguage($langIt);
                $level->setName($levelLansadIt);
                $em->persist($level);
                $output->writeln("Add new LevelLansad (".$levelLansadIt.").");
            }
        }

        $langCn = $em->getRepository('InnovaSelfBundle:Language')->findOneByName("Chinese");
        /* Level for Ialian language */
        $levelLansadCns = array("A1", "A1.1", "A1.2", "A2", "A2.1", "A2.2", "B1", "B1.1", "B1.2", "B2.1", "Débutant complet", "Faux débutant", "Intermédiaire", "Avancé");
        foreach ($levelLansadCns as $levelLansadCn) {
            if (!$em->getRepository('InnovaSelfBundle:LevelLansad')->findOneBy(array('name' => $levelLansadCn, 'language' => $langCn))) {
                $level = new LevelLansad();
                $level->setLanguage($langCn);
                $level->setName($levelLansadCn);
                $em->persist($level);
                $output->writeln("Add new LevelLansad (".$levelLansadCn.").");
            }
        }

        $langSp = $em->getRepository('InnovaSelfBundle:Language')->findOneByName("Spanish");
        /* Level for Chinese language */
        $levelLansadSps = array("A1", "A2", "B1.1", "B1.2", "B2.1", "B2.2", "C1", "C2");
        foreach ($levelLansadSps as $levelLansadSp) {
            if (!$em->getRepository('InnovaSelfBundle:LevelLansad')->findOneBy(array('name' => $levelLansadSp, 'language' => $langSp))) {
                $level = new LevelLansad();
                $level->setLanguage($langSp);
                $level->setName($levelLansadSp);
                $em->persist($level);
                $output->writeln("Add new LevelLansad (".$levelLansadSp.").");
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
            } elseif ($clueTyp->getColor() != $clueType[1]) {
                $clueTyp->setColor($clueType[1]);
                $em->persist($clueTyp);
                $output->writeln("Edit clueType (".$clueType[0].").");
            }
        }

        $em->flush();

        $now = time();
        $duration = $now - $start;

        $output->writeln("Fixtures exécutées en ".$duration." sec.");
    }
}
