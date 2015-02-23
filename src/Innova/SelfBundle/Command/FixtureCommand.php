<?php

namespace Innova\SelfBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Innova\SelfBundle\Entity\Level;
use Innova\SelfBundle\Entity\Skill;
use Innova\SelfBundle\Entity\Typology;
use Innova\SelfBundle\Entity\OriginStudent;
use Innova\SelfBundle\Entity\Language;
use Innova\SelfBundle\Entity\LevelLansad;
use Innova\SelfBundle\Entity\ClueType;
use Innova\SelfBundle\Entity\Media\MediaPurpose;
use Innova\SelfBundle\Entity\Media\MediaType;
use Innova\SelfBundle\Entity\EditorLog\EditorLogAction;
use Innova\SelfBundle\Entity\EditorLog\EditorLogObject;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\Status;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\Length;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\Source;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\SourceOperation;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\AuthorRight;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\Domain;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\Flow;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\Reception;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\Register;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\Focus;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\CognitiveOperation;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\SourceType;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\Channel;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\Genre;
use Innova\SelfBundle\Entity\QuestionnaireIdentity\Variety;

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

            /* TYPOLOGY */
            $typologies = array(
                array("TVF", "Vrai-Faux"), array("TQRU", "Question à Réponse Unique"),
                array("TQRM", "Question à Réponses Multiples"), array("TLCMLDM", "Liste de mots"),
                array("APP", "Appariemment"), array("TVFNM", "Vrai-Faux-Non Mentionné"),
                array("TLCMLMULT", "Listes de choix multiple"), array("TLQROC", "Question Réponse Ouverte Courte"),
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
        $em->flush();

            /* SKILLS */
            $questionnaireSkills = array("CO", "CE", "EEC");
        foreach ($questionnaireSkills as $questionnaireSkill) {
            if (!$em->getRepository('InnovaSelfBundle:Skill')->findOneByName($questionnaireSkill)) {
                $skill = new Skill();
                $skill->setName($questionnaireSkill);
                $em->persist($skill);
                $output->writeln("Add new Skill (".$questionnaireSkill.").");
            }
        }
        $em->flush();

            /* SKILL / TYPO */
            $skills2typos = array(
                array("CO", array("APP", "TQRM", "TQRU", "TVF", "TVFNM")),
                array("CE", array("APP", "TQRM", "TQRU", "TVF", "TVFNM")),
                array("EEC", array("TLCMLMULT", "TLQROC", "TLCMLDM", "TQRU")),
            );
        foreach ($skills2typos as $skills2typo) {
            $skillName = $skills2typo[0];
            $typoNames = $skills2typo[1];
            if ($skill = $em->getRepository('InnovaSelfBundle:Skill')->findOneByName($skillName)) {
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

        $mediaTypes = array("audio", "video", "texte", "image");
        foreach ($mediaTypes as $mediaType) {
            if (!$em->getRepository('InnovaSelfBundle:Media\MediaType')->findOneByName($mediaType)) {
                $type = new mediaType();
                $type->setName($mediaType);
                $em->persist($type);
                $output->writeln("Add new mediaType (".$mediaType.").");
            }
        }

        $questionnaireLengths = array("short", "medium", "long");
        foreach ($questionnaireLengths as $questionnaireLength) {
            if (!$em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Length')->findOneByName($questionnaireLength)) {
                $Length = new Length();
                $Length->setName($questionnaireLength);
                $em->persist($Length);
                $output->writeln("Add new Length (".$questionnaireLength.").");
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

        $typologiesToDelete = array("TLCMQRU", "TLCMTQRU", "TLQROCDCTU", "TLQROCDCTM");
        foreach ($typologiesToDelete as $typology) {
            if ($typo = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($typology)) {
                if ($questions = $em->getRepository('InnovaSelfBundle:Question')->findByTypology($typo)) {
                    foreach ($questions as $question) {
                        $question->setTypology(null);
                        $em->persist($question);
                        foreach ($question->getSubquestions() as $subquestion) {
                            $subquestion->setTypology(null);
                            $em->persist($subquestion);
                        }
                    }
                }
                $em->remove($typo);
                $typoName = $typo->getName();
                $output->writeln(" Typo ".$typoName." removed");
            }
        }

        $typologiesToReplace = array(
                array("TLQROCFIRSTLEN", "TLQROC"), array("TLQROCNOCLU", "TLQROC"),
                array("TLQROCLEN", "TLQROC"), array("TLQROCFIRST", "TLQROC"),
                array("TLQROCSYL", "TLQROC"), array("TLQROCTRANS", "TLQROC"),
                array("TLQROCDERIV", "TLQROC"), array("APPAT", "APP"),
                array("APPIT", "APP"), array("APPAA", "APP"), array("APPAI", "APP"),
                array("APPTT", "APP"), array("QRU", "TQRU"), array("QRM", "TQRM"),
                array("VF", "TVF"), array("VFNM", "TVFNM"),
            );
        foreach ($typologiesToReplace as $typology) {
            if ($typo = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($typology[0])) {
                $newTypo = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($typology[1]);

                if ($questions = $em->getRepository('InnovaSelfBundle:Question')->findByTypology($typo)) {
                    foreach ($questions as $question) {
                        $question->setTypology($newTypo);
                        $em->persist($question);
                    }
                }

                if ($subquestions = $em->getRepository('InnovaSelfBundle:Subquestion')->findByTypology($typo)) {
                    foreach ($subquestions as $subquestion) {
                        $subquestion->setTypology($newTypo);
                        $em->persist($subquestion);
                    }
                }

                $em->remove($typo);
                $output->writeln(" Typo ".$typology[0]." replaced by ".$typology[1]);
            }
        }

            /*
                New table for version 1.2 or version 2 (2014)
                fixtures for originStudent table
            */
            $originStudents = array("LANSAD", "LLCE", "LEA", "UJF", "Formation continue", "Autres");
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

        if (!$em->getRepository('InnovaSelfBundle:Language')->findOneByName("Spanish")) {
            $langSp = new Language();
            $langSp->setName("Spanish");
            $langSp->setColor("pink");
            $em->persist($langSp);
            $em->flush();
            $output->writeln("Add new Language (Spanish).");
        }

            /*
                New table for version 1.2 or version 2 (2014)
                fixtures for levelLansad table
            */
            $langEng = $em->getRepository('InnovaSelfBundle:Language')->findOneByName("English");
            /* Level for English language */
            $levelLansadEngs = array("A1", "A2", "B1.1", "B1.2", "B1.3", "B2.1", "B2.2", "C1", "C2");
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
            $levelLansadIts = array("A1", "A2", "B1.1", "B1.2", "B1.3", "B2.1", "B2.2", "C1", "C2");
        foreach ($levelLansadIts as $levelLansadIt) {
            if (!$em->getRepository('InnovaSelfBundle:LevelLansad')->findOneBy(array('name' => $levelLansadIt, 'language' => $langIt))) {
                $level = new LevelLansad();
                $level->setLanguage($langIt);
                $level->setName($levelLansadIt);
                $em->persist($level);
                $output->writeln("Add new LevelLansad (".$levelLansadIt.").");
            }
        }

        $langSp = $em->getRepository('InnovaSelfBundle:Language')->findOneByName("Spanish");
            /* Level for Ialian language */
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

            /* Gestion du statut des tâches */
            $status = array("Ecriture", "Révision", "Validation", "Modification post-pilotage");
        foreach ($status as $s) {
            if (!$em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Status')->findOneByName($s)) {
                $stat = new Status();
                $stat->setName($s);
                $em->persist($stat);
                $output->writeln("Add new Status (".$s.").");
            }
        }

            /* Gestion du mediaPurpose... à quoi sert le media (consigne, contexte, proposition, etc.) */
            $purposes = array("blank-text", "contexte", "objet de la question", "question", "proposition", "reponse", "syllable", "clue", "instruction", "functional-instruction", "comment", "feedback", "distractor");
        foreach ($purposes as $purpose) {
            if (!$em->getRepository('InnovaSelfBundle:Media\MediaPurpose')->findOneByName($purpose)) {
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
            } elseif ($clueTyp->getColor() != $clueType[1]) {
                $clueTyp->setColor($clueType[1]);
                $em->persist($clueTyp);
                $output->writeln("Edit clueType (".$clueType[0].").");
            }
        }

            /* Gestion des logs éditeur */
            $editorLogActions = array("editor_create", "editor_edit", "editor_delete");
        foreach ($editorLogActions as $editorAction) {
            if (!$em->getRepository('InnovaSelfBundle:EditorLog\EditorLogAction')->findOneByName($editorAction)) {
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
                "theme", "fixed-order", "skill", "level", "typology", "status", "text-type", "identity",
            );
        foreach ($editorLogObjects as $editorLogObject) {
            if (!$em->getRepository('InnovaSelfBundle:EditorLog\EditorLogObject')->findOneByName($editorLogObject)) {
                $e = new EditorLogObject();
                $e->setName($editorLogObject);
                $em->persist($e);
                $output->writeln("Add new editorLogObject (".$editorLogObject.")");
            }
        }

        $sources = array("source.certification", "source.textbook", "source.intern", "source.other");
        foreach ($sources as $source) {
            if (!$em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Source')->findOneByName($source)) {
                $s = new Source();
                $s->setName($source);
                $em->persist($s);
                $output->writeln("Add new Source (".$source.")");
            }
        }

        $sourceOperations = array("source_operation.original", "source_operation.original_modified", "source_operation.constructed", "source_operation.constructed_modified");
        foreach ($sourceOperations as $sourceOperation) {
            if (!$em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\SourceOperation')->findOneByName($sourceOperation)) {
                $s = new SourceOperation();
                $s->setName($sourceOperation);
                $em->persist($s);
                $output->writeln("Add new Source Operation (".$sourceOperation.")");
            }
        }

        $authorRightStates = array("author_right.authorized", "author_right.not_needed", "author_right.pending", "author_right.to_ask");
        foreach ($authorRightStates as $authorRightState) {
            if (!$em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\AuthorRight')->findOneByName($authorRightState)) {
                $a = new AuthorRight();
                $a->setName($authorRightState);
                $em->persist($a);
                $output->writeln("Add new Author Right State (".$authorRightState.")");
            }
        }

        $domains = array("domain.personal", "domain.public", "domain.profesional", "domain.educational");
        foreach ($domains as $domain) {
            if (!$em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Domain')->findOneByName($domain)) {
                $d = new Domain();
                $d->setName($domain);
                $em->persist($d);
                $output->writeln("Add new Domain (".$domain.")");
            }
        }

        $flows = array("flow.slow", "flow.medium", "flow.fast");
        foreach ($flows as $flow) {
            if (!$em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Flow')->findOneByName($flow)) {
                $f = new Flow();
                $f->setName($flow);
                $em->persist($f);
                $output->writeln("Add new Flow (".$flow.")");
            }
        }

        $receptions = array("reception.listener_monodirectional", "reception.listener_pluridirectional", "reception.performer");
        foreach ($receptions as $reception) {
            if (!$em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Reception')->findOneByName($reception)) {
                $r = new Reception();
                $r->setName($reception);
                $em->persist($r);
                $output->writeln("Add new Reception (".$reception.")");
            }
        }

        $registers = array("register.formal_elevated", "register.formal_neutral", "register.informal");
        foreach ($registers as $register) {
            if (!$em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Register')->findOneByName($register)) {
                $r = new Register();
                $r->setName($register);
                $em->persist($r);
                $output->writeln("Add new Register (".$register.")");
            }
        }

        $focuses = array("focus.lexical", "focus.communicative", "focus.morphosyntaxic");
        foreach ($focuses as $focus) {
            if (!$em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Focus')->findOneByName($focus)) {
                $f = new Focus();
                $f->setName($focus);
                $em->persist($f);
                $output->writeln("Add new focus (".$focus.")");
            }
        }

        $cognitiveOps = array("cognitive.global_comprehension", "cognitive.detailed_comprehension",
                                                "cognitive.infer_context", "cognitive.infer_intention", "cognitive.infer_state",
                                                "cognitive.infer_register", "cognitive.interaction", );
        foreach ($cognitiveOps as $cognitiveOp) {
            if (!$em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\CognitiveOperation')->findOneByName($cognitiveOp)) {
                $c = new CognitiveOperation();
                $c->setName($cognitiveOp);
                $em->persist($c);
                $output->writeln("Add new CognitiveOperation (".$cognitiveOp.")");
            }
        }

        $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->findByAuthor(null);
        foreach ($questionnaires as $questionnaire) {
            if ($em->getRepository('InnovaSelfBundle:EditorLog\EditorLog')->findBy(array('questionnaire' => $questionnaire))) {
                $questionnaire->setAuthor($questionnaire->getEditorLogs()[0]->getUser());
                $em->persist($questionnaire);
            }
        }
        $em->flush();

        $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->findAll();
        foreach ($questionnaires as $questionnaire) {
            if (count($questionnaire->getRevisors()) == 0 && count($editorLogs = $questionnaire->getEditorLogs()) > 0) {
                $revisors = array();
                foreach ($editorLogs as $editorLog) {
                    if (!in_array($editorLog->getUser(), $revisors)) {
                        $revisors[] = $editorLog->getUser();
                        $questionnaire->addRevisor($editorLog->getUser());
                    }
                }
                $em->persist($questionnaire);
            }
        }

        $sourceTypes = array("sourceType.audio", "sourceType.video", "sourceType.text", "sourceType.image");
        foreach ($sourceTypes as $sourceType) {
            if (!$em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\SourceType')->findOneByName($sourceType)) {
                $s = new sourceType();
                $s->setName($sourceType);
                $em->persist($s);
                $output->writeln("Add new SourceType (".$sourceType.")");
            }
        }

        $channels = array("channel.phone", "channel.videoconf", "channel.speaker", "channel.radio",
                                         "channel.tv", "channel.web", "channel.tutorial", "channel.localRecord", "channel.GPS", "channel.other", );
        foreach ($channels as $channel) {
            if (!$em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Channel')->findOneByName($channel)) {
                $c = new Channel();
                $c->setName($channel);
                $em->persist($c);
                $output->writeln("Add new Channel (".$channel.")");
            }
        }

        $genres = array("genre.informative", "genre.argumentative", "genre.narrative", "genre.descriptive", "genre.literary",
                                    "genre.conversational", "genre.cmd_synchrone", "genre.cmd_asynchrone", );
        foreach ($genres as $genre) {
            if (!$em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Genre')->findOneByName($genre)) {
                $g = new Genre();
                $g->setName($genre);
                $em->persist($g);
                $output->writeln("Add new Genre (".$genre.")");
            }
        }

        $varieties = array("variety.standard", "variety.non_standard");
        foreach ($varieties as $variety) {
            if (!$em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Variety')->findOneByName($variety)) {
                $v = new Variety();
                $v->setName($variety);
                $em->persist($v);
                $output->writeln("Add new Variety (".$variety.")");
            }
        }

        $em->flush();

        $now = time();
        $duration = $now - $start;

        $output->writeln("Fixtures exécutées en ".$duration." sec.");
    }
}
