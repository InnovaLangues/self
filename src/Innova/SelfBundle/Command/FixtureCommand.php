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
            ->setDescription('Load needed datas');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $start = time();

        $skillManager = $this->getContainer()->get('self.skill.manager');
        $skillManager->create(array(
            array('CO', array('APP', 'TQRM', 'TQRU', 'TVF', 'TVFNM')),
            array('CE', array('APP', 'TQRM', 'TQRU', 'TVF', 'TVFNM')),
            array('EEC', array('TLCMLMULT', 'TLQROC', 'TLCMLDM', 'TQRU')),
        ));

        $componentTypeManager = $this->getContainer()->get('self.componentType.manager');
        $componentTypeManager->create(array('minitest', 'step1', 'step2', 'step3'));

        $clueTypeManager = $this->getContainer()->get('self.clueType.manager');
        $clueTypeManager->create(array(
                array('fonctionnel', 'clue-fonctionnel'),
                array('didactique', 'clue-didactique'),
            )
        );

        /* MEDIA */
        $mediaTypeManager = $this->getContainer()->get('self.mediaType.manager');
        $mediaTypeManager->create(array('audio', 'video', 'texte', 'image'));

        $mediaPurposeManager = $this->getContainer()->get('self.mediaPurpose.manager');
        $mediaPurposeManager->create(array(
            'blank-text',
            'contexte',
            'objet de la question',
            'question',
            'proposition',
            'reponse',
            'syllable',
            'clue',
            'instruction',
            'functional-instruction',
            'comment',
            'feedback',
            'distractor'
        ));

        /* IDENTITY */
        $statusManager = $this->getContainer()->get('self.status.manager');
        $statusManager->create(array('Ecriture', 'Révision', 'Validation', 'Modification post-pilotage'));

        $textlengthManager = $this->getContainer()->get('self.textLength.manager');
        $textlengthManager->create(array(
            'text_length.very_short',
            'text_length.short',
            'text_length.medium',
            'text_length.long',
            'text_length.very_long'
        ));

        $flowManager = $this->getContainer()->get('self.flow.manager');
        $flowManager->create(array('flow.slow', 'flow.medium', 'flow.fast'));

        $registerManager = $this->getContainer()->get('self.register.manager');
        $registerManager->create(array(
            'register.formal_elevated',
            'register.formal_neutral',
            'register.informal',
            'register.mixte'
        ));

        $focusManager = $this->getContainer()->get('self.focus.manager');
        $focusManager->create(array(
            'focus.lexical',
            'focus.communicative',
            'focus.morphosyntaxic',
            'focus.textualCohesion'
        ));

        $cognitiveOpManager = $this->getContainer()->get('self.cognitiveOp.manager');
        $cognitiveOpManager->create(array(
            'cognitive.global_comprehension',
            'cognitive.detailed_comprehension',
            'cognitive.infer_context',
            'cognitive.infer_intention',
            'cognitive.infer_state',
            'cognitive.infer_register',
            'cognitive.infer_information',
            'cognitive.interaction',
            'cognitive.completeMessage',
            'cognitive.reformulateMessage',
            'cognitive.interact',
            'cognitive.readBack',
            'cognitive.other',
        ));

        $sourceTypeManager = $this->getContainer()->get('self.sourceType.manager');
        $sourceTypeManager->create(array(
            'sourceType.audio',
            'sourceType.video',
            'sourceType.text',
            'sourceType.image'
        ));

        $genreManager = $this->getContainer()->get('self.genre.manager');
        $genreManager->create(array(
            'genre.informative',
            'genre.argumentative',
            'genre.narrative',
            'genre.explicatif',
            'genre.injonctif',
            'genre.poetique',
        ));
        $genreManager->delete(array(
            'genre.literary',
            'genre.conversational',
            'genre.cmd_synchrone',
            'genre.cmd_asynchrone'
        ));

        $rightGroupManager = $this->getContainer()->get('self.rightgroup.manager');
        $rightGroupManager->createGroups(array(
            'rightgroup.tasks',
            'rightgroup.tests',
            'rightgroup.sessions',
            'rightgroup.groups',
            'rightgroup.users',
            'rightgroup.exports',
            'rightgroup.generalParameters'
        ));

        $rightManager = $this->getContainer()->get('self.right.manager');
        $rightManager->createRights(array(
            // task
            array('right.createtask', 'rightgroup.tasks', null, 'RightUserTask'),
            array('right.deletetask', 'rightgroup.tasks', 'canDelete', 'RightUserTask'),
            array('right.edittask', 'rightgroup.tasks', 'canEdit', 'RightUserTask'),
            array('right.listtask', 'rightgroup.tasks', null, 'RightUserTask'),

            // test
            array('right.createtest', 'rightgroup.tests', null, 'RightUserTest'),
            array('right.deletetest', 'rightgroup.tests', 'canDelete', 'RightUserTest'),
            array('right.edittest', 'rightgroup.tests', 'canEdit', 'RightUserTest'),
            array('right.listtest', 'rightgroup.tests', null, 'RightUserTest'),
            array('right.duplicatetest', 'rightgroup.tests', 'canDuplicate', 'RightUserTest'),
            array('right.managesessiontest', 'rightgroup.tests', 'canManageSession', 'RightUserTest'),
            array('right.managetaskstest', 'rightgroup.tests', 'canManageTask', 'RightUserTest'),
            array('right.addtasktest', 'rightgroup.tests', 'canAddTask', 'RightUserTest'),
            array('right.reordertasktest', 'rightgroup.tests', 'canReorderTasks', 'RightUserTest'),
            array('right.deletetasktest', 'rightgroup.tests', 'canDeleteTask', 'RightUserTest'),
            array('right.edittasktest', 'rightgroup.tests', 'canEditTask', 'RightUserTest'),
            array('right.editrightstest', 'rightgroup.tests', null, 'RightUserTest'),
            array('right.editorreadonlytest', 'rightgroup.tests', 'canEditorReadOnlyTasks', 'RightUserTest'),

            // user
            array('right.listuser', 'rightgroup.users', null, 'RightUserSomeone'),
            array('right.createuser', 'rightgroup.users', null, 'RightUserSomeone'),
            array('right.deleteuser', 'rightgroup.users', 'canDelete', 'RightUserSomeone'),
            array('right.edituser', 'rightgroup.users', 'canEdit', 'RightUserSomeone'),
            array('right.deletetraceuser', 'rightgroup.users', 'canDeleteTrace', 'RightUserSomeone'),
            array('right.editpassworduser', 'rightgroup.users', 'canEditPassword', 'RightUserSomeone'),
            array('right.editrightsuser', 'rightgroup.users', 'canEditRights', 'RightUserSomeone'),

            // session
            array('right.deletesession', 'rightgroup.sessions', 'canDelete', 'RightUserSession'),
            array('right.listsession', 'rightgroup.sessions', null, 'RightUserSession'),
            array('right.editsession', 'rightgroup.sessions', 'canEdit', 'RightUserSession'),
            array('right.createsession', 'rightgroup.sessions', null, 'RightUserSession'),
            array('right.individualresultssession', 'rightgroup.sessions', 'canExportIndividual', 'RightUserSession'),
            array('right.exportresultssession', 'rightgroup.sessions', 'canExportCollective', 'RightUserSession'),
            array('right.editrightssession', 'rightgroup.sessions', null, 'RightUserSession'),
            array('right.deletetracesession', 'rightgroup.sessions', 'canDeleteTrace', 'RightUserSession'),

            // export
            array('right.exportPDF', 'rightgroup.exports', null, null),
            array('right.exportCSV', 'rightgroup.exports', null, null),

            // paramètres généraux
            array('right.generalParameters', 'rightgroup.generalParameters', null, null),
            array('right.message', 'rightgroup.generalParameters', null, null),
            array('right.institution', 'rightgroup.generalParameters', null, null),
        ));

        $generalParamsManager = $this->getContainer()->get('self.generalparams.manager');
        $generalParamsManager->initialize();

        $now = time();
        $duration = $now - $start;

        $output->writeln('Fixtures exécutées en ' . $duration . ' sec.');
    }
}
