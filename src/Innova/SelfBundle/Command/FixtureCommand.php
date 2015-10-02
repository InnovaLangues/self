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
        $originStudentManager->create(array("MEEF Savoie", "MEEF Valence", "ICM", "LANSAD Valence", "IFSI Valence", "LLCE Valence", "LEA", "IUT2", "Formation continue", "Lycée Vaucanson", "Université de Nice", "Université Lyon 1", "Autres"));
        $originStudentManager->update(array("LANSAD" => "LANSAD Grenoble", "LLCE" => "LLCE Grenoble", "UJF" => "MEEF Grenoble"));

        $languageManager = $this->getContainer()->get("self.language.manager");
        $languageManager->create(array("English", "Italian", "Chinese", "Spanish", "Japanese"));

        $levelLansadManager = $this->getContainer()->get("self.levelLansad.manager");
        $levelLansadManager->create(array(
            array("English", array("A1", "A2", "B1.1", "B1.2", "B2.1", "B2.2", "C1", "C2")),
            array("Italian", array("A1", "A2", "B1.1", "B1.2", "B2.1", "B2.2", "C1", "C2")),
            array("Chinese", array("A1", "A1.1", "A1.2", "A2", "A2.1", "A2.2", "B1", "B1.1", "B1.2", "B2.1", "Débutant complet", "Faux débutant", "Intermédiaire", "Avancé")),
            array("Spanish", array("A1", "A2", "B1.1", "B1.2", "B2.1", "B2.2", "C1", "C2")),
        ));

        $componentTypeManager = $this->getContainer()->get("self.componentType.manager");
        $componentTypeManager->create(array("minitest", "step1", "step2", "step3"));
        $componentTypeManager->delete(array("step4"));

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
        $rightGroupManager->createGroups(array("rightgroup.tasks", "rightgroup.tests", "rightgroup.sessions", "rightgroup.groups", "rightgroup.users", "rightgroup.exports"));

        $rightManager = $this->getContainer()->get("self.right.manager");
        $rightManager->createRights(array(
            // task
            array("right.createtask", "rightgroup.tasks", null, "RightUserTask"),
            array("right.deletetask", "rightgroup.tasks", "canDelete", "RightUserTask"),
            array("right.edittask", "rightgroup.tasks", "canEdit", "RightUserTask"),
            array("right.listtask", "rightgroup.tasks", null, "RightUserTask"),

            // test
            array("right.createtest", "rightgroup.tests", null, "RightUserTest"),
            array("right.deletetest", "rightgroup.tests", "canDelete", "RightUserTest"),
            array("right.edittest", "rightgroup.tests", "canEdit", "RightUserTest"),
            array("right.listtest", "rightgroup.tests", null, "RightUserTest"),
            array("right.duplicatetest", "rightgroup.tests", "canDuplicate", "RightUserTest"),
            array("right.managesessiontest", "rightgroup.tests", "canManageSession", "RightUserTest"),
            array("right.managetaskstest", "rightgroup.tests", "canManageTask", "RightUserTest"),
            array("right.addtasktest", "rightgroup.tests", "canAddTask", "RightUserTest"),
            array("right.reordertasktest", "rightgroup.tests", "canReorderTasks", "RightUserTest"),
            array("right.deletetasktest", "rightgroup.tests", "canDeleteTask", "RightUserTest"),
            array("right.edittasktest", "rightgroup.tests", "canEditTask", "RightUserTest"),
            array("right.editrightstest", "rightgroup.tests", null, "RightUserTest"),

            // user
            array("right.listuser", "rightgroup.users", null, "RightUserSomeone"),
            array("right.createuser", "rightgroup.users", null, "RightUserSomeone"),
            array("right.deleteuser", "rightgroup.users", "canDelete", "RightUserSomeone"),
            array("right.edituser", "rightgroup.users", "canEdit", "RightUserSomeone"),
            array("right.deletetraceuser", "rightgroup.users", "canDeleteTrace", "RightUserSomeone"),
            array("right.editpassworduser", "rightgroup.users", "canEditPassword", "RightUserSomeone"),
            array("right.editrightsuser", "rightgroup.users", 'canEditRights', "RightUserSomeone"),

            // group
            array("right.listgroup", "rightgroup.groups", null, "RightUserGroup"),
            array("right.editgroup", "rightgroup.groups", "canEdit", "RightUserGroup"),
            array("right.creategroup", "rightgroup.groups", null, "RightUserGroup"),
            array("right.deletegroup", "rightgroup.groups", "canDelete", "RightUserGroup"),
            array("right.csvimportgroup", "rightgroup.groups", "canImportCsv", "RightUserGroup"),
            array("right.editrightsgroup", "rightgroup.groups", null, "RightUserGroup"),

            // session
            array("right.deletesession", "rightgroup.sessions", "canDelete", "RightUserSession"),
            array("right.listsession", "rightgroup.sessions", null, "RightUserSession"),
            array("right.editsession", "rightgroup.sessions", "canEdit", "RightUserSession"),
            array("right.createsession", "rightgroup.sessions", null, "RightUserSession"),
            array("right.individualresultssession", "rightgroup.sessions", "canExportIndividual", "RightUserSession"),
            array("right.exportresultssession", "rightgroup.sessions", "canExportCollective", "RightUserSession"),
            array("right.editrightssession", "rightgroup.sessions", null, "RightUserSession"),

            array("right.exportPDF", "rightgroup.exports", null, null),
            array("right.exportCSV", "rightgroup.exports", null, null),
        ));

        $generalParamsManager = $this->getContainer()->get("self.generalparams.manager");
        $generalParamsManager->initialize();

        $now = time();
        $duration = $now - $start;

        $output->writeln("Fixtures exécutées en ".$duration." sec.");
    }
}
