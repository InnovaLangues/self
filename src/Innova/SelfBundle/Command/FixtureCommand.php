<?php

namespace Innova\SelfBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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

        $typologyManager = $this->getContainer()->get("self.typology.manager");
        $typologyManager->create(array(
            array("TVF", "Vrai-Faux"), array("TQRU", "Question à Réponse Unique"),
            array("TQRM", "Question à Réponses Multiples"), array("TLCMLDM", "Liste de mots"),
            array("APP", "Appariemment"), array("TVFNM", "Vrai-Faux-Non Mentionné"),
            array("TLCMLMULT", "Listes de choix multiple"), array("TLQROC", "Question Réponse Ouverte Courte"),
        ));

        $skillManager = $this->getContainer()->get("self.skill.manager");
        $skillManager->create(array(
            array("CO", array("APP", "TQRM", "TQRU", "TVF", "TVFNM")),
            array("CE", array("APP", "TQRM", "TQRU", "TVF", "TVFNM")),
            array("EEC", array("TLCMLMULT", "TLQROC", "TLCMLDM", "TQRU")),
        ));

        $levelManager = $this->getContainer()->get("self.level.manager");
        $levelManager->create(array("A1", "A1+", "A2", "A2+", "B1", "B1+", "B2", "B2+", "C1", "C1+"));

        $originStudentManager = $this->getContainer()->get("self.originStudent.manager");
        $originStudentManager->create(array("LANSAD", "LLCE", "LEA", "UJF", "Formation continue", "Autres"));

        $languageManager = $this->getContainer()->get("self.language.manager");
        $languageManager->create(array("English", "Italian", "Chinese", "Spanish"));

        $levelLansadManager = $this->getContainer()->get("self.levelLansad.manager");
        $levelLansadManager->create(array(
            array("English", array("A1", "A2", "B1.1", "B1.2", "B2.1", "B2.2", "C1", "C2")),
            array("Italian", array("A1", "A2", "B1.1", "B1.2", "B2.1", "B2.2", "C1", "C2")),
            array("Chinese", array("A1", "A1.1", "A1.2", "A2", "A2.1", "A2.2", "B1", "B1.1", "B1.2", "B2.1", "Débutant complet", "Faux débutant", "Intermédiaire", "Avancé")),
            array("Spanish", array("A1", "A2", "B1.1", "B1.2", "B2.1", "B2.2", "C1", "C2")),
        ));

        $componentTypeManager = $this->getContainer()->get("self.componentType.manager");
        $componentTypeManager->create(array("minitest", "step1", "step2", "step3", "step4"));

        $clueTypeManager = $this->getContainer()->get("self.clueType.manager");
        $clueTypeManager->create(array(
            array("fonctionnel", "clue-fonctionnel"),
            array("didactique", "clue-didactique"), )
        );

        /* MEDIA */
        $mediaTypeManager = $this->getContainer()->get("self.mediaType.manager");
        $mediaTypeManager->create(array("audio", "video", "texte", "image"));

        $mediaPurposeManager = $this->getContainer()->get("self.mediaPurpose.manager");
        $mediaPurposeManager->create(array("blank-text", "contexte", "objet de la question", "question", "proposition", "reponse", "syllable", "clue", "instruction", "functional-instruction", "comment", "feedback", "distractor"));

        /* IDENTITY */
        $statusManager = $this->getContainer()->get("self.status.manager");
        $statusManager->create(array("Ecriture", "Révision", "Validation", "Modification post-pilotage"));

        $lengthManager = $this->getContainer()->get("self.audioLength.manager");
        $lengthManager->create(array("length.short", "length.medium", "length.long", "length.very_long"));
        $lengthManager->delete(array("short", "medium", "long"));

        $textlengthManager = $this->getContainer()->get("self.textLength.manager");
        $textlengthManager->create(array("text_length.very_short", "text_length.short", "text_length.medium", "text_length.long", "text_length.very_long"));

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
        $focusManager->create(array("focus.lexical", "focus.communicative", "focus.morphosyntaxic", "focus.textualCohesion"));

        $cognitiveOpManager = $this->getContainer()->get("self.cognitiveOp.manager");
        $cognitiveOpManager->create(array(
            "cognitive.global_comprehension", "cognitive.detailed_comprehension", "cognitive.infer_context", "cognitive.infer_intention",
            "cognitive.infer_state", "cognitive.infer_register", "cognitive.infer_information", "cognitive.interaction",
            "cognitive.completeMessage", "cognitive.reformulateMessage", "cognitive.interact", "cognitive.readBack", "cognitive.other",
        ));

        $sourceTypeManager = $this->getContainer()->get("self.sourceType.manager");
        $sourceTypeManager->create(array("sourceType.audio", "sourceType.video", "sourceType.text", "sourceType.image"));

        $channelManager = $this->getContainer()->get("self.channel.manager");
        $channelManager->delete(array("channel.radio", "channel.tv", "channel.web", "channel.localRecord"));
        $channelManager->create(array(
            "channel.phone", "channel.visual", "channel.chat_sms_oral", "channel.chat_sms_written", "channel.tools", "channel.videoconf",
            "channel.speaker", "channel.tutorial", "channel.GPS", "channel.other", "channel.postit", "channel.brochure", "channel.ticket", "channel.notice",
        ));

        $socialLocationManager = $this->getContainer()->get("self.socialLocation.manager");
        $socialLocationManager->create(array(
            "socialLocation.radio", "socialLocation.tv", "socialLocation.web", "socialLocation.institution", "socialLocation.press",
            "socialLocation.edition", "socialLocation.other",
        ));

        $genreManager = $this->getContainer()->get("self.genre.manager");
        $genreManager->create(array("genre.informative", "genre.argumentative", "genre.narrative", "genre.explicatif", "genre.descriptive",
            "genre.injonctif", "genre.expressif", "genre.poetique", ));
        $genreManager->delete(array("genre.literary", "genre.conversational", "genre.cmd_synchrone", "genre.cmd_asynchrone"));

        $varietyManager = $this->getContainer()->get("self.variety.manager");
        $varietyManager->delete(array("variety.standard", "variety.non_standard"));
        $varietyManager->create(array(
            "variety.italian.standard", "variety.italian.nonstandard_diatopie", "variety.italian.nonstandard_diastratie", "variety.italian.nonstandard_diaphasie",
            "variety.english.us_standard", "variety.english.uk_standard", "variety.english.other_standard", "variety.english.regional", "variety.english.secondLang",
            "variety.chinese.standard", "variety.chinese.taiwan", "variety.chinese.otherVariant", "variety.chinese.secondLang",
        ));

        $productionTypeManager = $this->getContainer()->get("self.productionType.manager");
        $productionTypeManager->create(array(
            "productionType.monologal.self", "productionType.monologal.hetero",
            "productionType.dialogal.bi", "productionType.dialogal.poly",
        ));

        $rightGroupManager = $this->getContainer()->get("self.rightgroup.manager");
        $rightGroupManager->createGroups(array("rightgroup_tasks", "rightgroup_tests", "rightgroup_sessions", "rightgroup_groups", "rightgroup_users"));

        $rightManager = $this->getContainer()->get("self.right.manager");
        $rightManager->createRights(array(
            // task
            array("right_createtask", "rightgroup_tasks"),
            array("right_deletetask", "rightgroup_tasks"),
            array("right_edittask", "rightgroup_tasks"),
            array("right_listtask", "rightgroup_tasks"),
            // test (ok view)
            array("right_createtest", "rightgroup_tests"),
            array("right_deletetest", "rightgroup_tests"),
            array("right_edittest", "rightgroup_tests"),
            array("right_listtest", "rightgroup_tests"),
            array("right_duplicatetest", "rightgroup_tests"),
            array("right_managesessiontest", "rightgroup_tests"),
            array("right_managetaskstest", "rightgroup_tests"),
            // user (ok view)
            array("right_listuser", "rightgroup_users"),
            array("right_createuser", "rightgroup_users"),
            array("right_deleteuser", "rightgroup_users"),
            array("right_edituser", "rightgroup_users"),
            array("right_deletetraceuser", "rightgroup_users"),
            array("right_editpassworduser", "rightgroup_users"),
            array("right_editrightsuser", "rightgroup_users"),
            // group (ok view)
            array("right_listgroup", "rightgroup_groups"),
            array("right_editgroup", "rightgroup_groups"),
            array("right_creategroup", "rightgroup_groups"),
            array("right_deletegroup", "rightgroup_groups"),
            array("right_csvimportgroup", "rightgroup_groups"),
             // session (ok view)
            array("right_deletesession", "rightgroup_sessions"),
            array("right_listsession", "rightgroup_sessions"),
            array("right_editsession", "rightgroup_sessions"),
            array("right_createsession", "rightgroup_sessions"),
            array("right_exportresultssession", "rightgroup_sessions"),
            array("right_individualresultssession", "rightgroup_sessions"),
        ));

        $now = time();
        $duration = $now - $start;

        $output->writeln("Fixtures exécutées en ".$duration." sec.");
    }
}
