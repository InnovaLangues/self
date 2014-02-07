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
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Question;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Proposition;
use Innova\SelfBundle\Entity\Media;


/**
 * Symfony command to add or not fixtures. EV.
 *
*/
class ItceFixtureCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('self:fixtures:itce')
            ->setDescription('ITCE')
        ;
    }

    /**
     * If I have any data in database, then I don't execute fixtures. EV.
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        // CREATION TEST
        $test = $this->createTest("Italien CE", "Italian");



        /*******************************************
                    QUESTIONNAIRE 1 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_1 = $this->createQuestionnaire("A1_CE_parking_gare", "A1", "CE", $test);
        $questionnaire_1->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere o false"));
        $questionnaire_1->setMediaContext($this->mediaText("", "Pubblicità in stazione"));
        $questionnaire_1->setMediaText($this->mediaText("Parcheggia l’auto e parti in treno!", "Lascia l’auto vicino alla stazione e parti con i treni Frecciarossa, Frecciargento e Frecciabianca.@@@ A Torino, Milano e Padova puoi avere una tariffa speciale in alcuni parcheggi e garage convenzionati, semplicemente presentando il tuo biglietto valido su treni Frecciarossa, Frecciargento e Frecciabianca."));
        // CREATION QUESTION
        $questionnaire_1_1 = $this->createQuestion("TVF", $questionnaire_1);
        // CREATION SUBQUESTION
        $questionnaire_1_1_1 = $this->createSubquestion("QRM", $questionnaire_1_1, "");
        // CREATION PROPOSITIONS
        $questionnaire_1_1_1_1 = $this->createProposition("L’offerta è valida solo in alcune città.", true, $questionnaire_1_1_1);
        $questionnaire_1_1_1_2 = $this->createProposition("Con il biglietto del treno il parcheggio per l’automobile è gratuito.", true, $questionnaire_1_1_1);
        $questionnaire_1_1_1_3 = $this->createProposition("Per avere tariffa speciale è necessario presentare il biglietto del treno.", true, $questionnaire_1_1_1);



        /*******************************************
                    QUESTIONNAIRE 3 : QRM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_3 = $this->createQuestionnaire("A1_CE_vie_tokyo", "A1", "CE", $test);
        $questionnaire_3->setMediaInstruction($this->mediaText("", "Due informazioni sono presenti nel testo. Quali?"));
        $questionnaire_3->setMediaContext($this->mediaText("", "E-mail ad un amico"));
        $questionnaire_3->setMediaText($this->mediaText("Notizie da Tokyo", "Ciao Matteo,@@@qui sono le 4.00 del mattino e sono stanchissimo! Sono arrivato a Tokyo, finalmente! Il viaggio è stato davvero lungo, ho cambiato tre aerei e ho attraversato due continenti, quasi non ci credo!@@@Sull’aereo ho mangiato il primo vero sushi della mia vita, non mi è piaciuto molto!@@@Ho conosciuto una ragazza americana che studia qui al Campus, mi ha parlato molto bene della città, domani mi porta a fare un giro, poi ti racconto.@@@Buona notte a presto,@@@Giulio"));
        // CREATION QUESTION
        $questionnaire_3_1 = $this->createQuestion("QRM", $questionnaire_3);
        // CREATION SUBQUESTION
        $questionnaire_3_1_1 = $this->createSubquestion("QRM", $questionnaire_3_1, "");
        // CREATION PROPOSITIONS
        $questionnaire_3_1_1_1 = $this->createProposition("Giulio scrive a Matteo dopo un lungo viaggio.", true, $questionnaire_3_1_1);
        $questionnaire_3_1_1_2 = $this->createProposition("Giulio racconta che l’aereo è arrivato in ritardo.", false, $questionnaire_3_1_1);
        $questionnaire_3_1_1_3 = $this->createProposition("Giulio visiterà la città accompagnato da una nuova amica.", true, $questionnaire_3_1_1);
        $questionnaire_3_1_1_4 = $this->createProposition("Giulio ha iniziato uno stage.", false, $questionnaire_3_1_1);

        /*******************************************
                    QUESTIONNAIRE 6 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_6 = $this->createQuestionnaire("A1_CE_cours_bibliotheque", "A1", "CE", $test);
        $questionnaire_6->setMediaInstruction($this->mediaText("", "Rispondi alle domande. Una sola risposta è corretta"));
        $questionnaire_6->setMediaContext($this->mediaText("", "Brochure informativa in biblioteca"));
        $questionnaire_6->setMediaText($this->mediaText("I corsi della Società per la biblioteca circolante
", "Società per la Biblioteca Circolante di Sesto Fiorentino"));
        // CREATION QUESTION
        $questionnaire_6_1 = $this->createQuestion("TQRU", $questionnaire_6);
        // CREATION SUBQUESTION
        $questionnaire_6_1_1 = $this->createSubquestion("QRU", $questionnaire_6_1, "1.I corsi dell’associazione sono");
        $questionnaire_6_1_2 = $this->createSubquestion("QRU", $questionnaire_6_1, "2. L’Associazione:");
        $questionnaire_6_1_3 = $this->createSubquestion("QRU", $questionnaire_6_1, "3. Per iscriversi all’Associazione:");
        // CREATION PROPOSITIONS
        $questionnaire_6_1_1_1 = $this->createProposition("rivolti agli anziani.", false, $questionnaire_6_1_1);
        $questionnaire_6_1_1_2 = $this->createProposition("aperti a tutti.", false, $questionnaire_6_1_1);
        $questionnaire_6_1_1_3 = $this->createProposition("solo per i soci.", true, $questionnaire_6_1_1);

        $questionnaire_6_1_2_1 = $this->createProposition("Offre solo corsi di lingua.", false, $questionnaire_6_1_2);
        $questionnaire_6_1_2_2 = $this->createProposition("Offre corsi di lingua e informatica.", false, $questionnaire_6_1_2);
        $questionnaire_6_1_2_3 = $this->createProposition("Offre corsi di vario tipo.", true, $questionnaire_6_1_2);

        $questionnaire_6_1_3_1 = $this->createProposition("Non si paga nulla", false, $questionnaire_6_1_3);
        $questionnaire_6_1_3_2 = $this->createProposition("Bisogna pagare una piccola somma", false, $questionnaire_6_1_3);
        $questionnaire_6_1_3_3 = $this->createProposition("Bisogna presentarsi il primo giorno dell’anno", true, $questionnaire_6_1_3);

        /*******************************************
                    QUESTIONNAIRE 7 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_7 = $this->createQuestionnaire("A1_CE_ticket_SMS", "A1", "CE", $test);
        $questionnaire_7->setMediaInstruction($this->mediaText("", "Rispondi alle domande. Una sola risposta è corretta"));
        $questionnaire_7->setMediaContext($this->mediaText("", "Brochure informativa sui servizi in autobus"));
        $questionnaire_7->setMediaText($this->mediaText("", "Invia un SMS e Sali a bordo"));
        // CREATION QUESTION
        $questionnaire_7_1 = $this->createQuestion("QRU", $questionnaire_7);
        // CREATION SUBQUESTION
        $questionnaire_7_1_1 = $this->createSubquestion("QRU", $questionnaire_7_1, "Il servizio permette di");

        // CREATION PROPOSITIONS
        $questionnaire_7_1_1_1 = $this->createProposition("avere informazioni sul traffico.", false, $questionnaire_7_1_1);
        $questionnaire_7_1_1_2 = $this->createProposition("comprare il biglietto con il cellulare.", true, $questionnaire_7_1_1);
        $questionnaire_7_1_1_3 = $this->createProposition("conoscere gli orari dell’autobus.", false, $questionnaire_7_1_1);



        /*******************************************
                    QUESTIONNAIRE 43 : APPTT
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_43 = $this->createQuestionnaire("B2_CE_superstitions_italie", "B2", "CE", $test);
        $questionnaire_43->setMediaInstruction($this->mediaText("", "Ricostruisci le frasi"));
        $questionnaire_43->setMediaContext($this->mediaText("", "Superstizioni in Italia"));
        $questionnaire_43->setMediaText($this->mediaText("Post su blog personale", "**Le forme di superstizione sono numerosissime in Italia, spesso legate alla vita quotidiana e in molti casi bizzarre. Ecco una lista delle piů comuni.@@@
1. Mangiare lenticchie a Capodanno porta fortuna per il nuovo anno@@@
2. Č presagio di sventura aprire lombrello in casa@@@
3.Posare il pane a rovescio sulla tavola, porta carestia.@@@
4. Il quadrifoglio porta fortuna e felicitŕ ma non lo si deve cogliere@@@
5. Porta sfortuna passare sotto una scala@@@
6. Rompere uno specchio preannuncia sette anni di guai@@@
7. Quando si vede una stella cadente, si puň esprimere un desiderio"));
        // CREATION QUESTION
        $questionnaire_43_1 = $this->createQuestion("APPTT", $questionnaire_43);
        // CREATION SUBQUESTION
        $questionnaire_43_1_1 = $this->createSubquestion("APPTT", $questionnaire_43_1, "1. Si teme che rompere uno specchio");
        $questionnaire_43_1_2 = $this->createSubquestion("APPTT", $questionnaire_43_1, "2. A capodanno si usa mangiare lenticchie affinché");
        $questionnaire_43_1_3 = $this->createSubquestion("APPTT", $questionnaire_43_1, "3. Si crede che vedere una stella cadente");
        $questionnaire_43_1_4 = $this->createSubquestion("APPTT", $questionnaire_43_1, "4. Secondo molti italiani, passare sotto una scala");
        $questionnaire_43_1_5 = $this->createSubquestion("APPTT", $questionnaire_43_1, "5. Aprire lombrello in casa");
        $questionnaire_43_1_6 = $this->createSubquestion("APPTT", $questionnaire_43_1, "6. Trovare un quadrifoglio č segno di felicitŕ e fortuna, purché");
        $questionnaire_43_1_7 = $this->createSubquestion("APPTT", $questionnaire_43_1, "7. Quando si č a tavola č importante controllare che");
        // CREATION PROPOSITIONS
        $questionnaire_43_1_1_1 = $this->createProposition("a. il nuovo anno sia ricco.", false, $questionnaire_43_1_1);
        $questionnaire_43_1_1_2 = $this->createProposition("a. il nuovo anno sia ricco.", false, $questionnaire_43_1_2);
        $questionnaire_43_1_1_3 = $this->createProposition("a. il nuovo anno sia ricco.", false, $questionnaire_43_1_3);
        $questionnaire_43_1_1_4 = $this->createProposition("a. il nuovo anno sia ricco.", false, $questionnaire_43_1_4);
        $questionnaire_43_1_1_5 = $this->createProposition("a. il nuovo anno sia ricco.", false, $questionnaire_43_1_5);
        $questionnaire_43_1_1_6 = $this->createProposition("a. il nuovo anno sia ricco.", true, $questionnaire_43_1_6);
        $questionnaire_43_1_1_7 = $this->createProposition("a. il nuovo anno sia ricco.", false, $questionnaire_43_1_7);

        $questionnaire_43_1_2_1 = $this->createProposition("b. il pane non sia al rovescio.", true, $questionnaire_43_1_1);
        $questionnaire_43_1_2_2 = $this->createProposition("b. il pane non sia al rovescio.", false, $questionnaire_43_1_2);
        $questionnaire_43_1_2_3 = $this->createProposition("b. il pane non sia al rovescio.", false, $questionnaire_43_1_3);
        $questionnaire_43_1_2_4 = $this->createProposition("b. il pane non sia al rovescio.", false, $questionnaire_43_1_4);
        $questionnaire_43_1_2_5 = $this->createProposition("b. il pane non sia al rovescio.", false, $questionnaire_43_1_5);
        $questionnaire_43_1_2_6 = $this->createProposition("b. il pane non sia al rovescio.", false, $questionnaire_43_1_6);
        $questionnaire_43_1_2_7 = $this->createProposition("b. il pane non sia al rovescio.", false, $questionnaire_43_1_7);

        $questionnaire_43_1_3_1 = $this->createProposition("c. porta sfortuna.", false, $questionnaire_43_1_1);
        $questionnaire_43_1_3_2 = $this->createProposition("c. porta sfortuna.", false, $questionnaire_43_1_2);
        $questionnaire_43_1_3_3 = $this->createProposition("c. porta sfortuna.", false, $questionnaire_43_1_3);
        $questionnaire_43_1_3_4 = $this->createProposition("c. porta sfortuna.", false, $questionnaire_43_1_4);
        $questionnaire_43_1_3_5 = $this->createProposition("c. porta sfortuna.", true, $questionnaire_43_1_5);
        $questionnaire_43_1_3_6 = $this->createProposition("c. porta sfortuna.", false, $questionnaire_43_1_6);
        $questionnaire_43_1_3_7 = $this->createProposition("c. porta sfortuna.", false, $questionnaire_43_1_7);

        $questionnaire_43_1_4_1 = $this->createProposition("d. lo si lasci al suo posto", false, $questionnaire_43_1_1);
        $questionnaire_43_1_4_2 = $this->createProposition("d. lo si lasci al suo posto", false, $questionnaire_43_1_2);
        $questionnaire_43_1_4_3 = $this->createProposition("d. lo si lasci al suo posto", false, $questionnaire_43_1_3);
        $questionnaire_43_1_4_4 = $this->createProposition("d. lo si lasci al suo posto", false, $questionnaire_43_1_4);
        $questionnaire_43_1_4_5 = $this->createProposition("d. lo si lasci al suo posto", false, $questionnaire_43_1_5);
        $questionnaire_43_1_4_6 = $this->createProposition("d. lo si lasci al suo posto", false, $questionnaire_43_1_6);
        $questionnaire_43_1_4_7 = $this->createProposition("d. lo si lasci al suo posto", true, $questionnaire_43_1_7);

        $questionnaire_43_1_5_1 = $this->createProposition("e. rappresenti unoccasione per formulare un progetto da realizzare", false, $questionnaire_43_1_1);
        $questionnaire_43_1_5_2 = $this->createProposition("e. rappresenti unoccasione per formulare un progetto da realizzare", false, $questionnaire_43_1_2);
        $questionnaire_43_1_5_3 = $this->createProposition("e. rappresenti unoccasione per formulare un progetto da realizzare", false, $questionnaire_43_1_3);
        $questionnaire_43_1_5_4 = $this->createProposition("e. rappresenti unoccasione per formulare un progetto da realizzare", false, $questionnaire_43_1_4);
        $questionnaire_43_1_5_5 = $this->createProposition("e. rappresenti unoccasione per formulare un progetto da realizzare", false, $questionnaire_43_1_5);
        $questionnaire_43_1_5_6 = $this->createProposition("e. rappresenti unoccasione per formulare un progetto da realizzare", false, $questionnaire_43_1_6);
        $questionnaire_43_1_5_7 = $this->createProposition("e. rappresenti unoccasione per formulare un progetto da realizzare", true, $questionnaire_43_1_7);


        /*******************************************
                    QUESTIONNAIRE 44 : TVFNM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_44 = $this->createQuestionnaire("B2_CE_vademecum", "B2", "CE", $test);
        $questionnaire_44->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere, false o non dette"));
        $questionnaire_44->setMediaContext($this->mediaText("", "Vademecum delle elezioni amministrative"));
        $questionnaire_44->setMediaText($this->mediaText("Brochure informativa delle elezioni amministrative", "**Come si vota nei comuni con popolazione superiore ai 15.000 abitanti**@@@La scheda per il rinnovo del Consiglio comunale č di colore azzurro. L'elettore ha a disposizione diverse modalitŕ per esprimere la propria preferenza.@@@1- Votare solo per un candidato sindaco, tracciando un segno sul nome, non scegliendo alcuna lista collegata. Il voto cosě espresso si intende attribuito solo al candidato sindaco.@@@2- Votare solo per una delle liste, tracciando un segno sul relativo simbolo. Il voto cosě espresso si intende attribuito anche al candidato sindaco collegato.@@@3- Votare per un candidato sindaco, tracciando un segno sul nome, e per una delle liste a esso collegate, tracciando un segno sul contrassegno della lista prescelta. Il voto cosě espresso si intende attribuito sia al candidato sindaco sia alla lista collegata."));
        // CREATION QUESTION
        $questionnaire_44_1 = $this->createQuestion("TVFNM", $questionnaire_44);
        // CREATION SUBQUESTION
        $questionnaire_44_1_1 = $this->createSubquestion("TVFNM", $questionnaire_44_1, "1. Č possibile votare per il sindaco e per le liste scegliendo solo il simbolo del partito di cui č a capo.");
        $questionnaire_44_1_2 = $this->createSubquestion("TVFNM", $questionnaire_44_1, "2. Č possibile votare per due partiti che fanno parte della stessa coalizione.");
        $questionnaire_44_1_3 = $this->createSubquestion("TVFNM", $questionnaire_44_1, "3. Č possibile votare per un solo candidato scrivendo il suo nome sulla scheda");
        // CREATION PROPOSITIONS
        $questionnaire_44_1_1_1 = $this->createProposition("VRAI", true, $questionnaire_44_1_1);
        $questionnaire_44_1_1_2 = $this->createProposition("FAUX", false, $questionnaire_44_1_1);
        $questionnaire_44_1_1_3 = $this->createProposition("ND", false, $questionnaire_44_1_1);

        $questionnaire_44_1_2_1 = $this->createProposition("VRAI", false, $questionnaire_44_1_2);
        $questionnaire_44_1_2_2 = $this->createProposition("FAUX", false, $questionnaire_44_1_2);
        $questionnaire_44_1_2_3 = $this->createProposition("ND", true, $questionnaire_44_1_2);

        $questionnaire_44_1_3_1 = $this->createProposition("VRAI", false, $questionnaire_44_1_3);
        $questionnaire_44_1_3_2 = $this->createProposition("FAUX", true, $questionnaire_44_1_3);
        $questionnaire_44_1_3_3 = $this->createProposition("ND", false, $questionnaire_44_1_3);

















        $em->flush();

        $output->writeln("Fixtures exécutées.");

    }

    /**
     *
     */
    protected function createTest($name, $language)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        $test = new Test();
        $test->setName($name);
        $language = $em->getRepository('InnovaSelfBundle:Language')->findOneByName($language);
        $test->setLanguage($language);
        $em->persist($test);

        return $test;
    }

    /**
     *
     */
    protected function createQuestionnaire($title, $level, $skill, $test)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        // Création du questionnaire
        $questionnaire = new Questionnaire();

        $questionnaire->addTest($test);

        $questionnaire->setTheme($title);

        $level = $em->getRepository('InnovaSelfBundle:Level')->findOneByName($level);
        $questionnaire->setLevel($level);

        // Traitement sur le skill
        $skill = $em->getRepository('InnovaSelfBundle:Skill')->findOneByName($skill);
        $questionnaire->setSkill($skill);


        $questionnaire->setAuthor();
        $questionnaire->setInstruction();
                        $questionnaire->setDuration();
                        $questionnaire->setDomain();
                        $questionnaire->setSupport();
                        $questionnaire->setFlow();
                        $questionnaire->setFocus();
                        $questionnaire->setSource();
                        $questionnaire->setListeningLimit(0); //ListeningLimit
                        $questionnaire->setDialogue(0);


        $em->persist($questionnaire);

        return $questionnaire;
    }

    /**
     *
     */
    protected function createQuestion($typology, $questionnaire)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        // Création du questionnaire
        $question = new Question();

        $typo = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($typology);
        $question->setTypology($typo);

        $question->setQuestionnaire($questionnaire);

        $em->persist($question);

        return $question;
    }


    /**
     *
     */
    protected function createSubquestion($typology, $question, $amorce)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        // Création du questionnaire
        $subquestion = new Subquestion();

        $typo = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($typology);
        $subquestion->setTypology($typo);

        $subquestion->setQuestion($question);

        if ($amorce != '') {
            $subquestion->setMediaAmorce($this->mediaText("", $amorce));
        }

        $em->persist($subquestion);

        return $subquestion;
    }

    /**
     *
     */
    protected function createProposition($text, $rightAnswer, $subquestion)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        $proposition = new Proposition();

        $proposition->setSubquestion($subquestion);
        $proposition->setMedia($this->mediaText("", $text));
        $proposition->setRightAnswer($rightAnswer);

        $em->persist($proposition);

        return $proposition;
    }

    /**
     *
     */
    protected function mediaText($title, $name)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        // TODO : l'appel à la fonction qui traite le markdown !!
        // Création dans "Media"
        $media = new Media();
        $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("texte"));

        $media->setName($title.$name);
        $media->setDescription(NULL);
        $media->setUrl(NULL);

        $em->persist($media);

        return $media;
    }

}
