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
class Itceb2FixtureCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('self:fixtures:itceb2')
            ->setDescription('SELF CE Italien B2')
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
        $test = $this->createTest("CE Italien B2", "Italian");

        // To have CSS form title. #166
        $startTitle = "<span class=\"title-situation\">";
        $endTitle = "</span>";

        /*******************************************

                    NIVEAU : B2

        ********************************************/

        /*******************************************
                    QUESTIONNAIRE 1 : TVFNM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_1 = $this->createQuestionnaire("B2_CE_COMM_Come diventare famosi su internet", "B2", "CE", $test);
        $questionnaire_B2_1->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere, false o non dette.", ""));
        $questionnaire_B2_1->setMediaContext($this->mediaText("", "Post su blog", ""));
        $questionnaire_B2_1->setMediaText($this->mediaText($startTitle . "Come diventare famosi su internet" . $endTitle, "La celeberrima frase “Nel futuro, tutti avranno 15 minuti di celebrità”, pronunciata nel 1968 da Andy Warhol, diventa ogni giorno più profetica su internet. Ecco qualche consiglio su come diventare una web celebrity.@@@
• Occhio a chi incontri su internet ed evita di condividere troppe informazioni personali.@@@
• Gira un video su di te o sul tuo talento e pubblicalo su YouTube.@@@
• Il successo va e viene. Però, se lavori duro, offri contenuti freschi ed incanti i tuoi lettori, follower e spettatori, sarà più facile mantenerti a galla. Punta ad una fama che ti permetta di avere un articolo dedicato a te su Wikipedia e che ti consenta di poter dire che hai raggiunto una certa notorietà. In questo modo, il tuo successo si terrà in piedi, a meno che qualcuno non ti cancelli ma, ehi, siamo su internet!
", ""));
        // CREATION QUESTION
        $questionnaire_B2_1_1 = $this->createQuestion("TVFNM", $questionnaire_B2_1);
        // CREATION SUBQUESTION
        $questionnaire_B2_1_1_1 = $this->createSubquestion("VFNM", $questionnaire_B2_1_1, "1. La celebre frase di Andy Warhol è stata letta da milioni di utenti su internet.");
        $questionnaire_B2_1_1_2 = $this->createSubquestion("VFNM", $questionnaire_B2_1_1, "2. Secondo l’autore il successo su internet è un fenomeno duraturo.");
        $questionnaire_B2_1_1_3 = $this->createSubquestion("VFNM", $questionnaire_B2_1_1, "3. Il testo consiglia di pubblicare sempre articoli attuali per conservare il successo ottenuto");
        // CREATION PROPOSITIONS
        $questionnaire_B2_1_1_1_1 = $this->createProposition("VRAI", false, $questionnaire_B2_1_1_1);
        $questionnaire_B2_1_1_1_2 = $this->createProposition("FAUX", false, $questionnaire_B2_1_1_1);
        $questionnaire_B2_1_1_1_3 = $this->createProposition("ND", true, $questionnaire_B2_1_1_1);

        $questionnaire_B2_1_1_2_1 = $this->createProposition("VRAI", false, $questionnaire_B2_1_1_2);
        $questionnaire_B2_1_1_2_2 = $this->createProposition("FAUX", true, $questionnaire_B2_1_1_2);
        $questionnaire_B2_1_1_2_3 = $this->createProposition("ND", false, $questionnaire_B2_1_1_2);

        $questionnaire_B2_1_1_3_1 = $this->createProposition("VRAI", true, $questionnaire_B2_1_1_3);
        $questionnaire_B2_1_1_3_2 = $this->createProposition("FAUX", false, $questionnaire_B2_1_1_3);
        $questionnaire_B2_1_1_3_3 = $this->createProposition("ND", false, $questionnaire_B2_1_1_3);

        /*******************************************
                    QUESTIONNAIRE 4 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_4 = $this->createQuestionnaire("B2_CE_COMM_come affrontare gli esami", "B2", "CE", $test);
        $questionnaire_B2_4->setMediaInstruction($this->mediaText("", "Rispondi alle domande. Una sola risposta è corretta.", ""));
        $questionnaire_B2_4->setMediaContext($this->mediaText("", "Post su blog studentesco", ""));
        $questionnaire_B2_4->setMediaText($this->mediaText($startTitle . "Breve decalogo per gli studenti: prima di affrontare un esame" . $endTitle,
        "• Il \"nemico\" va conosciuto. Andate ad assistere agli esami prima di darli.@@@
• Siate gradevoli nell'aspetto. L'abito in questo caso fa il monaco.@@@
• Sappiate ascoltare. Aspettate a rispondere finché il docente non ha concluso la domanda.@@@
• Siate precisi, non arrampicatevi sugli specchi. Se non sapete la risposta non dite cose inesatte.@@@
• Se avete un vuoto mentale, ammettetelo. Chiedete poi al professore di riproporvi successivamente la domanda.", ""));
        // CREATION QUESTION
        $questionnaire_B2_4_1 = $this->createQuestion("TQRU", $questionnaire_B2_4);
        // CREATION SUBQUESTION
        $questionnaire_B2_4_1_1 = $this->createSubquestion("QRU", $questionnaire_B2_4_1, "**1. Il decalogo suggerisce di:**");
        $questionnaire_B2_4_1_2 = $this->createSubquestion("QRU", $questionnaire_B2_4_1, "**2. Se non si conosce la risposta, il decalogo suggerisce di:**");

        // CREATION PROPOSITIONS
        $questionnaire_B2_4_1_1_1 = $this->createProposition("1.1. studiare le domande più frequenti poste durante gli esami.", false, $questionnaire_B2_4_1_1);
        $questionnaire_B2_4_1_1_2 = $this->createProposition("1.2. osservare gli esami sostenuti da altri studenti.", true, $questionnaire_B2_4_1_1);
        $questionnaire_B2_4_1_1_3 = $this->createProposition("1.3. anticipare le risposte per fare una buona impressione", false, $questionnaire_B2_4_1_1);
        $questionnaire_B2_4_1_1_4 = $this->createProposition("1.4.  assistere agli esami dei colleghi per poter scegliere il giusto abbigliamento.", false, $questionnaire_B2_4_1_1);

        $questionnaire_B2_4_1_2_1 = $this->createProposition("2.1. dare comunque una risposta vaga ma il più possibile verosimile.", false, $questionnaire_B2_4_1_2);
        $questionnaire_B2_4_1_2_2 = $this->createProposition("2.2. ragionare sulle domande ed arrivare ad una soluzione logica.", false, $questionnaire_B2_4_1_2);
        $questionnaire_B2_4_1_2_3 = $this->createProposition("2.3. rinunciare a rispondere subito per evitare un’espressione vaga e incompleta.", true, $questionnaire_B2_4_1_2);
        $questionnaire_B2_4_1_2_4 = $this->createProposition("2.4. evitare di tacere cercando però di non dare risposte totalmente inesatte.", false, $questionnaire_B2_4_1_2);


        /*******************************************
                    QUESTIONNAIRE 6 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_6 = $this->createQuestionnaire("B2_CE_COMM_disdetta_contratto", "B1", "CE", $test);
        $questionnaire_B2_6->setMediaInstruction($this->mediaText("", "Seleziona il riassunto corretto", ""));
        $questionnaire_B2_6->setMediaContext($this->mediaText("", "Lettera di disdetta contratto di locazione", ""));
        $questionnaire_B2_6->setMediaText($this->mediaText($startTitle . "Disdetta straordinaria del contratto di locazione" . $endTitle,
        "Sig. Giacomo Verni@@@
via Rodolfo Lanciani, 3@@@
00100 Roma@@@

Raccomandata@@@

Roma, 12.10:2012@@@

Disdetta straordinaria del contratto di locazione@@@

Gentile sig. Pastani,
con la presente le comunico la mia intenzione di recedere dal contratto di locazione stipulato in data 09/10/2010 fuori dai termini stabiliti per il 30/10/2012. Dato che per motivi lavorativi devo traslocare non mi è possibile dare la disdetta nei termini fissati.@@@
Mi preoccuperò di cercare un inquilino subentrante adeguato e di inviarle i relativi documenti per la candidatura.@@@
La prego di informarmi al più presto sul termine di consegna dell’appartamento.@@@

Colgo l’occasione per ringraziarla del piacevole rapporto di locazione.@@@

Cordiali saluti@@@

Giacomo Verni@@@

____________________  ______________________
Luogo, data                           Firma del locatore
", ""));

        // CREATION QUESTION
        $questionnaire_B2_6_1 = $this->createQuestion("QRU", $questionnaire_B2_6);
        // CREATION SUBQUESTION
        $questionnaire_B2_6_1_1 = $this->createSubquestion("QRU", $questionnaire_B2_6_1, "");
        // CREATION PROPOSITIONS
        $questionnaire_B2_6_1_1_1 = $this->createProposition("1. Il Sig. Verni scrive al Sig. Pastani per chiedere la sospensione temporanea del contratto di affitto. Si impegna comunque a trovare un sostituto per i mesi in cui sarà assente.", false, $questionnaire_B2_6_1_1);
        $questionnaire_B2_6_1_1_2 = $this->createProposition("2. Il Sig Verni scrive al sig.Pastani per rescindere il contratto d’affitto con ampio anticipo, e si impegna con il proprietario a inviargli il nome del futuro inquilino.", false, $questionnaire_B2_6_1_1);
        $questionnaire_B2_6_1_1_3 = $this->createProposition("3. Il Sig Verni scrive al sig.Pastani per richiedere la sospensione anticipata del contratto. Chiede inoltre di essere informato sulla data esatta in cui dovrà lasciare l’appartamento.", true, $questionnaire_B2_6_1_1);

        /*******************************************
                    QUESTIONNAIRE 7 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_7 = $this->createQuestionnaire("B1_CE_diner_ciel", "B1", "CE", $test);
        $questionnaire_B2_7->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere o false.", ""));
        $questionnaire_B2_7->setMediaContext($this->mediaText("", "Avviso in Comune", ""));
        $questionnaire_B2_7->setMediaText($this->mediaText($startTitle . "Informazioni utili sulla tessera elettorale" . $endTitle, "Tessera elettorale per le elezioni politiche

L’ufficio elettorale comunale resta a  disposizione per quanto segue:@@@

• coloro che non avessero ricevuto la tessera elettorale a domicilio, possono ritirarla presso l’ufficio elettorale-;@@@
• coloro che avessero smarrito, deteriorato o subito il furto della tessera elettorale, possono ottenere un duplicato presentandosi all’ufficio elettorale.@@@
• Nel caso di smarrimento la domanda di duplicato deve essere corredata da denuncia presentata ai competenti uffici di pubblica sicurezza.@@@
", ""));
        // CREATION QUESTION
        $questionnaire_B2_7_1 = $this->createQuestion("TVF", $questionnaire_B2_7);

        // CREATION SUBQUESTION
        $questionnaire_B2_7_1_1 = $this->createSubquestionVF("VF", $questionnaire_B2_7_1, "", "1. Nel caso in cui la tessera non fosse arrivata per posta, bisogna recarsi all’ufficio elettorale");
        $questionnaire_B2_7_1_2 = $this->createSubquestionVF("VF", $questionnaire_B2_7_1, "", "2. Coloro, la cui tessera elettorale fosse rovinata, possono chiedere di riceverne una copia a casa.");
        $questionnaire_B2_7_1_3 = $this->createSubquestionVF("VF", $questionnaire_B2_7_1, "", "3. Coloro che avessero perso la tessera elettorale, devono avvertire la polizia della perdita");

        // CREATION PROPOSITIONS
        $questionnaire_B2_7_1_1_1 = $this->createPropositionVF("", "VRAI", true, $questionnaire_B2_7_1_1);
        $questionnaire_B2_7_1_1_1 = $this->createPropositionVF("", "FAUX", false, $questionnaire_B2_7_1_1);

        $questionnaire_B2_7_1_1_2 = $this->createPropositionVF("", "VRAI", false, $questionnaire_B2_7_1_2);
        $questionnaire_B2_7_1_1_2 = $this->createPropositionVF("", "FAUX", true, $questionnaire_B2_7_1_2);

        $questionnaire_B2_7_1_1_3 = $this->createPropositionVF("", "VRAI", true, $questionnaire_B2_7_1_3);
        $questionnaire_B2_7_1_1_3 = $this->createPropositionVF("", "FAUX", false, $questionnaire_B2_7_1_3);

        /*******************************************
                    QUESTIONNAIRE 9 : TVFNM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_9 = $this->createQuestionnaire("B2_CE_COMM_occhi su saturno", "B2", "CE", $test);
        $questionnaire_B2_9->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere, false o non dette.", ""));
        $questionnaire_B2_9->setMediaContext($this->mediaText("", "Articolo su rivista di eventi culturali", ""));
        $questionnaire_B2_9->setMediaText($this->mediaText($startTitle . "Occhi su Saturno" . $endTitle, "Sabato18 Maggio,una sera per mostrare Saturno all’Italia@@@
La sera del 18 Maggio cerca l'evento a te più vicino e scopri dal vivo Saturno, senza dubbio il più bel pianeta del Sistema Solare, generazioni di astronomi hanno posato gli occhi su di lui. Ora grazie alle sonde spaziali abbiamo una visione senza precedenti di Saturno, dei suoi anelli e dei suoi satelliti. Ma lo splendore di questo pianeta è folgorante anche se osservato con un piccolo telescopio.",
 ""));
        // CREATION QUESTION
        $questionnaire_B2_9_1 = $this->createQuestion("TVFNM", $questionnaire_B2_9);
        // CREATION SUBQUESTION
        $questionnaire_B2_9_1_1 = $this->createSubquestion("VFNM", $questionnaire_B2_9_1, "1. “Occhi su Saturno” è un’iniziativa organizzata da un gruppo di astronomi");
        $questionnaire_B2_9_1_2 = $this->createSubquestion("VFNM", $questionnaire_B2_9_1, "2. L’iniziativa non sarà solo locale, ma avrà luogo anche in diverse regioni italiane.");
        $questionnaire_B2_9_1_3 = $this->createSubquestion("VFNM", $questionnaire_B2_9_1, "3. Il pianeta sarà visibile ad occhio nudo.");
        // CREATION PROPOSITIONS
        $questionnaire_B2_9_1_1_1 = $this->createProposition("VRAI", false, $questionnaire_B2_9_1_1);
        $questionnaire_B2_9_1_1_2 = $this->createProposition("FAUX", false, $questionnaire_B2_9_1_1);
        $questionnaire_B2_9_1_1_3 = $this->createProposition("ND", true, $questionnaire_B2_9_1_1);

        $questionnaire_B2_9_1_2_1 = $this->createProposition("VRAI", true, $questionnaire_B2_9_1_2);
        $questionnaire_B2_9_1_2_2 = $this->createProposition("FAUX", false, $questionnaire_B2_9_1_2);
        $questionnaire_B2_9_1_2_3 = $this->createProposition("ND", false, $questionnaire_B2_9_1_2);

        $questionnaire_B2_9_1_3_1 = $this->createProposition("VRAI", false, $questionnaire_B2_9_1_3);
        $questionnaire_B2_9_1_3_2 = $this->createProposition("FAUX", true, $questionnaire_B2_9_1_3);
        $questionnaire_B2_9_1_3_3 = $this->createProposition("ND", false, $questionnaire_B2_9_1_3);

        /*******************************************
                    QUESTIONNAIRE 10 : TVFNM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_10 = $this->createQuestionnaire("B2_CE_COMM_candidatura", "B2", "CE", $test);
        $questionnaire_B2_10->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere, false o non dette.", ""));
        $questionnaire_B2_10->setMediaContext($this->mediaText("", "Lettera di motivazione", ""));
        $questionnaire_B2_10->setMediaText($this->mediaText($startTitle . "Candidatura spontanea" . $endTitle, "vorrei sottoporre alla Vostra cortese attenzione il mio interesse ad un’eventuale assunzione nella Vostra Azienda, leader nel settore della ristorazione. Come potete vedere dal Curriculum vitae che allego, dopo aver conseguito il diploma alberghiero ho svolto un tirocinio per approfondire le conoscenze nel servizio di sala e parlo abbastanza bene il tedesco e l’inglese. Sono disponibile fin da subito anche per un’assunzione a tempo determinato o con contratto di Formazione e Lavoro. Sono altresì disponibile a frequentare eventuali corsi di formazione ed a fare trasferte anche all’estero. Spero pertanto che vorrete considerare la mia candidatura.@@@"
        ,""));
        // CREATION QUESTION
        $questionnaire_B2_10_1 = $this->createQuestion("TVFNM", $questionnaire_B2_10);
        // CREATION SUBQUESTION
        $questionnaire_B2_10_1_1 = $this->createSubquestion("VFNM", $questionnaire_B2_10_1, "1. Nella lettera di candidatura, Luca scrive di avere conseguito un’esperienza formativa come cameriere di sala.");
        $questionnaire_B2_10_1_2 = $this->createSubquestion("VFNM", $questionnaire_B2_10_1, "2. Luca ha già operato nel settore del servizio di sala.");
        $questionnaire_B2_10_1_3 = $this->createSubquestion("VFNM", $questionnaire_B2_10_1, "3. Luca scrive di volere solo un impiego a lungo termine.");
        // CREATION PROPOSITIONS
        $questionnaire_B2_10_1_1_1 = $this->createProposition("VRAI", true, $questionnaire_B2_10_1_1);
        $questionnaire_B2_10_1_1_2 = $this->createProposition("FAUX", false, $questionnaire_B2_10_1_1);
        $questionnaire_B2_10_1_1_3 = $this->createProposition("ND", false, $questionnaire_B2_10_1_1);

        $questionnaire_B2_10_1_2_1 = $this->createProposition("VRAI", true, $questionnaire_B2_10_1_2);
        $questionnaire_B2_10_1_2_2 = $this->createProposition("FAUX", false, $questionnaire_B2_10_1_2);
        $questionnaire_B2_10_1_2_3 = $this->createProposition("ND", false, $questionnaire_B2_10_1_2);

        $questionnaire_B2_10_1_3_1 = $this->createProposition("VRAI", false, $questionnaire_B2_10_1_3);
        $questionnaire_B2_10_1_3_2 = $this->createProposition("FAUX", true, $questionnaire_B2_10_1_3);
        $questionnaire_B2_10_1_3_3 = $this->createProposition("ND", false, $questionnaire_B2_10_1_3);

        /*******************************************
                    QUESTIONNAIRE 11 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_11 = $this->createQuestionnaire("B2_CE_bryan_may", "B2", "CE", $test);
        $questionnaire_B2_11->setMediaInstruction($this->mediaText("", "Completa il testo usando le parole suggerite", ""));
        $questionnaire_B2_11->setMediaContext($this->mediaText("", "Articolo su rivista di musica", ""));
        $questionnaire_B2_11->setMediaText($this->mediaText($startTitle . "Brian May dei Queen avrebbe voluto suonare negli AC/DC" . $endTitle,
        "Il chitarrista dei Queen Brian May ha rivelato che 1.________________________ suonare negli AC/DC.@@@In un'intervista al quotidiano britannico The Independent May ha detto che se non fosse stato  per l'impegno con Freddy Mercury e compagni non gli 2.____________________ fare qualcosa con la band australiana, ma ha anche aggiunto che probabilmente non sarebbe stato adatto per il gruppo: \"Mi sarebbe piaciuto  lavorare con gli AC/DC [se non ci  3.__________________________ i Queen]. Ma sfortunatamente sono della forma e della taglia sbagliate\"",
        ""));
        // CREATION QUESTION
        $questionnaire_B2_11_1 = $this->createQuestion("TQRU", $questionnaire_B2_11);
        // CREATION SUBQUESTION
        $questionnaire_B2_11_1_1 = $this->createSubquestion("QRU", $questionnaire_B2_11_1, "");
        $questionnaire_B2_11_1_2 = $this->createSubquestion("QRU", $questionnaire_B2_11_1, "");
        $questionnaire_B2_11_1_3 = $this->createSubquestion("QRU", $questionnaire_B2_11_1, "");

        // CREATION PROPOSITIONS
        $questionnaire_B2_11_1_1_1 = $this->createProposition("1.1. avrebbe voluto", true, $questionnaire_B2_11_1_1);
        $questionnaire_B2_11_1_1_2 = $this->createProposition("1.2. avesse voluto", false, $questionnaire_B2_11_1_1);
        $questionnaire_B2_11_1_1_3 = $this->createProposition("1.3. volle", false, $questionnaire_B2_11_1_1);

        $questionnaire_B2_11_1_2_1 = $this->createProposition("2.1. sarebbe dispiaciuto", true, $questionnaire_B2_11_1_2);
        $questionnaire_B2_11_1_2_2 = $this->createProposition("2.2. fosse dispiaciuto", false, $questionnaire_B2_11_1_2);
        $questionnaire_B2_11_1_2_3 = $this->createProposition("2.3. dispiacesse", false, $questionnaire_B2_11_1_2);

        $questionnaire_B2_11_1_3_1 = $this->createProposition("3.1. furono", false, $questionnaire_B2_11_1_3);
        $questionnaire_B2_11_1_3_2 = $this->createProposition("3.2. sarebbero stati", false, $questionnaire_B2_11_1_3);
        $questionnaire_B2_11_1_3_3 = $this->createProposition("3.3. fossero stati ", true, $questionnaire_B2_11_1_3);

        /*******************************************
                    QUESTIONNAIRE 12 : TVFNM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_12 = $this->createQuestionnaire("B2_CE_yeux_sur_saturne", "B2", "CE", $test);
        $questionnaire_B2_12->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere, false o non dette", ""));
        $questionnaire_B2_12->setMediaContext($this->mediaText("", "Articolo su rivista di eventi culturali", ""));
        $questionnaire_B2_12->setMediaText($this->mediaText($startTitle . "Occhi su Saturno" . $endTitle, "Sabato 18 Maggio, una sera per mostrare Saturno all’Italia@@@
La sera del 18 Maggio cerca l'evento a te più vicino e scopri dal vivo Saturno, senza dubbio il più bel pianeta del Sistema Solare, generazioni di astronomi hanno posato gli occhi su di lui. Ora grazie alle sonde spaziali abbiamo una visione senza precedenti di Saturno, dei suoi anelli e dei suoi satelliti. Ma lo splendore di questo pianeta è folgorante anche se osservato con un piccolo telescopio.
", ""));
        // CREATION QUESTION
        $questionnaire_B2_12_1 = $this->createQuestion("TVFNM", $questionnaire_B2_12);
        // CREATION SUBQUESTION
        $questionnaire_B2_12_1_1 = $this->createSubquestion("VFNM", $questionnaire_B2_12_1, "1. “Occhi su Saturno” è un’iniziativa organizzata da un gruppo di astronomi.");
        $questionnaire_B2_12_1_2 = $this->createSubquestion("VFNM", $questionnaire_B2_12_1, "2. L’iniziativa non sarà solo locale, ma avrà luogo anche in diverse regioni italiane.");
        $questionnaire_B2_12_1_3 = $this->createSubquestion("VFNM", $questionnaire_B2_12_1, "3. Il pianeta sarà visibile ad occhio nudo.");
        // CREATION PROPOSITIONS
        $questionnaire_B2_12_1_1_1 = $this->createProposition("VRAI", false, $questionnaire_B2_12_1_1);
        $questionnaire_B2_12_1_1_2 = $this->createProposition("FAUX", false, $questionnaire_B2_12_1_1);
        $questionnaire_B2_12_1_1_3 = $this->createProposition("ND", true, $questionnaire_B2_12_1_1);

        $questionnaire_B2_12_1_2_1 = $this->createProposition("VRAI", true, $questionnaire_B2_12_1_2);
        $questionnaire_B2_12_1_2_2 = $this->createProposition("FAUX", false, $questionnaire_B2_12_1_2);
        $questionnaire_B2_12_1_2_3 = $this->createProposition("ND", false, $questionnaire_B2_12_1_2);

        $questionnaire_B2_12_1_3_1 = $this->createProposition("VRAI", false, $questionnaire_B2_12_1_3);
        $questionnaire_B2_12_1_3_2 = $this->createProposition("FAUX", true, $questionnaire_B2_12_1_3);
        $questionnaire_B2_12_1_3_3 = $this->createProposition("ND", false, $questionnaire_B2_12_1_3);

        /*******************************************
                    QUESTIONNAIRE 15 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_15 = $this->createQuestionnaire("B2_CE_gerondif", "B2", "CE", $test);
        $questionnaire_B2_15->setMediaInstruction($this->mediaText("", "Completa il testo con le parole suggerite. Attenzione: ci sono due intrusi", ""));
        $questionnaire_B2_15->setMediaContext($this->mediaText("", "Estratto da un romanzo", ""));
        $questionnaire_B2_15->setMediaText($this->mediaText($startTitle . "Un incidente" . $endTitle, "1. ______ Maria rientrava a casa ha visto una macchina avvicinarsi a grande velocità da Piazza S.Silvestro.@@@
2. _______ Maria aveva capito che la macchina non si sarebbe fermata per lasciarla passare, ha indietreggiato di qualche passo.@@@
3.________ Maria avesse lasciato lo spazio sufficiente, il conducente ha perso per un istante il controllo della macchina e ha urtato contro il suo piede.@@@
4. Il medico ha consigliato a Maria di usare le stampelle, spiegandole che ______ non le avesse utilizzate, avrebbe finito per peggiorare le condizioni della sua gamba.?",
""));
        // CREATION QUESTION
        $questionnaire_B2_15_1 = $this->createQuestion("TQRU", $questionnaire_B2_15);
        // CREATION SUBQUESTION
        $questionnaire_B2_15_1_1 = $this->createSubquestion("QRU", $questionnaire_B2_15_1, "1. ______ Maria rientrava a casa ha visto una macchina avvicinarsi a grande velocità da Piazza S.Silvestro.");
        $questionnaire_B2_15_1_2 = $this->createSubquestion("QRU", $questionnaire_B2_15_1, "2. _______ Maria aveva capito che la macchina non si sarebbe fermata per lasciarla passare, ha indietreggiato di qualche passo.");
        $questionnaire_B2_15_1_3 = $this->createSubquestion("QRU", $questionnaire_B2_15_1, "3.________ Maria avesse lasciato lo spazio sufficiente, il conducente ha perso per un istante il controllo della macchina e ha urtato contro il suo piede.");
        $questionnaire_B2_15_1_4 = $this->createSubquestion("QRU", $questionnaire_B2_15_1, "4. Il medico ha consigliato a Maria di usare le stampelle, spiegandole che ______ non le avesse utilizzate, avrebbe finito per peggiorare le condizioni della sua gamba.?");

        // CREATION PROPOSITIONS
        $questionnaire_B2_15_1_1_1 = $this->createProposition("dunque", false, $questionnaire_B2_15_1_1);
        $questionnaire_B2_15_1_1_2 = $this->createProposition("nonostante", true, $questionnaire_B2_15_1_1);
        $questionnaire_B2_15_1_1_3 = $this->createProposition("mentre", true, $questionnaire_B2_15_1_1);
        $questionnaire_B2_15_1_1_4 = $this->createProposition("inoltre", false, $questionnaire_B2_15_1_1);
        $questionnaire_B2_15_1_1_5 = $this->createProposition("se", true, $questionnaire_B2_15_1_1);
        $questionnaire_B2_15_1_1_6 = $this->createProposition("siccome", true, $questionnaire_B2_15_1_1);

        $questionnaire_B2_15_1_2_1 = $this->createProposition("dunque", false, $questionnaire_B2_15_1_2);
        $questionnaire_B2_15_1_2_2 = $this->createProposition("nonostante", true, $questionnaire_B2_15_1_2);
        $questionnaire_B2_15_1_2_3 = $this->createProposition("mentre", true, $questionnaire_B2_15_1_2);
        $questionnaire_B2_15_1_2_4 = $this->createProposition("inoltre", false, $questionnaire_B2_15_1_2);
        $questionnaire_B2_15_1_2_5 = $this->createProposition("se", true, $questionnaire_B2_15_1_2);
        $questionnaire_B2_15_1_2_6 = $this->createProposition("siccome", true, $questionnaire_B2_15_1_2);

        $questionnaire_B2_15_1_3_1 = $this->createProposition("dunque", false, $questionnaire_B2_15_1_3);
        $questionnaire_B2_15_1_3_2 = $this->createProposition("nonostante", true, $questionnaire_B2_15_1_3);
        $questionnaire_B2_15_1_3_3 = $this->createProposition("mentre", true, $questionnaire_B2_15_1_3);
        $questionnaire_B2_15_1_3_4 = $this->createProposition("inoltre", false, $questionnaire_B2_15_1_3);
        $questionnaire_B2_15_1_3_5 = $this->createProposition("se", true, $questionnaire_B2_15_1_3);
        $questionnaire_B2_15_1_3_6 = $this->createProposition("siccome", true, $questionnaire_B2_15_1_3);

        $questionnaire_B2_15_1_4_1 = $this->createProposition("dunque", false, $questionnaire_B2_15_1_4);
        $questionnaire_B2_15_1_4_2 = $this->createProposition("nonostante", true, $questionnaire_B2_15_1_4);
        $questionnaire_B2_15_1_4_3 = $this->createProposition("mentre", true, $questionnaire_B2_15_1_4);
        $questionnaire_B2_15_1_4_4 = $this->createProposition("inoltre", false, $questionnaire_B2_15_1_4);
        $questionnaire_B2_15_1_4_5 = $this->createProposition("se", true, $questionnaire_B2_15_1_4);
        $questionnaire_B2_15_1_4_6 = $this->createProposition("siccome", true, $questionnaire_B2_15_1_4);

        /*******************************************
                    QUESTIONNAIRE 17 : APPTT
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_17 = $this->createQuestionnaire("B2_CE_superstitions_italie", "B2", "CE", $test);
        $questionnaire_B2_17->setMediaInstruction($this->mediaText("", "Ricostruisci le frasi", ""));
        $questionnaire_B2_17->setMediaContext($this->mediaText("", "Post su blog personale", ""));
        $questionnaire_B2_17->setMediaText($this->mediaText($startTitle . "Superstizioni in Italia" . $endTitle, "Le forme di superstizione sono numerosissime in Italia, spesso legate alla vita quotidiana e in molti casi bizzarre. Ecco una lista delle più comuni.@@@
1. Mangiare lenticchie a Capodanno porta fortuna per il nuovo anno@@@
2. È presagio di sventura aprire l’ombrello in casa@@@
3.Posare il pane a rovescio sulla tavola, porta carestia.@@@
4. Il quadrifoglio porta fortuna e felicità ma non lo si deve cogliere@@@
5. Porta sfortuna passare sotto una scala@@@
6. Rompere uno specchio preannuncia sette anni di guai@@@
7. Quando si vede una stella cadente, si può esprimere un desiderio", ""));
        // CREATION QUESTION
        $questionnaire_B2_17_1 = $this->createQuestion("APPTT", $questionnaire_B2_17);
        // CREATION SUBQUESTION
        $questionnaire_B2_17_1_1 = $this->createSubquestion("APPTT", $questionnaire_B2_17_1, "1. Si teme che rompere uno specchio");
        $questionnaire_B2_17_1_2 = $this->createSubquestion("APPTT", $questionnaire_B2_17_1, "2. A capodanno si usa mangiare lenticchie affinché");
        $questionnaire_B2_17_1_3 = $this->createSubquestion("APPTT", $questionnaire_B2_17_1, "3. Si crede che vedere una stella cadente");
        $questionnaire_B2_17_1_4 = $this->createSubquestion("APPTT", $questionnaire_B2_17_1, "4. Secondo molti italiani, passare sotto una scala");
        $questionnaire_B2_17_1_5 = $this->createSubquestion("APPTT", $questionnaire_B2_17_1, "5. Aprire l’ombrello in casa");
        $questionnaire_B2_17_1_6 = $this->createSubquestion("APPTT", $questionnaire_B2_17_1, "6. Trovare un quadrifoglio è segno di felicità e fortuna, purché");
        $questionnaire_B2_17_1_7 = $this->createSubquestion("APPTT", $questionnaire_B2_17_1, "7. Quando si è a tavola è importante controllare che");
        // CREATION PROPOSITIONS
        $questionnaire_B2_17_1_1_1 = $this->createProposition("a. il nuovo anno sia ricco.", false, $questionnaire_B2_17_1_1);
        $questionnaire_B2_17_1_1_2 = $this->createProposition("a. il nuovo anno sia ricco.", false, $questionnaire_B2_17_1_2);
        $questionnaire_B2_17_1_1_3 = $this->createProposition("a. il nuovo anno sia ricco.", false, $questionnaire_B2_17_1_3);
        $questionnaire_B2_17_1_1_4 = $this->createProposition("a. il nuovo anno sia ricco.", false, $questionnaire_B2_17_1_4);
        $questionnaire_B2_17_1_1_5 = $this->createProposition("a. il nuovo anno sia ricco.", false, $questionnaire_B2_17_1_5);
        $questionnaire_B2_17_1_1_6 = $this->createProposition("a. il nuovo anno sia ricco.", true, $questionnaire_B2_17_1_6);
        $questionnaire_B2_17_1_1_7 = $this->createProposition("a. il nuovo anno sia ricco.", false, $questionnaire_B2_17_1_7);

        $questionnaire_B2_17_1_2_1 = $this->createProposition("b. il pane non sia al rovescio.", true, $questionnaire_B2_17_1_1);
        $questionnaire_B2_17_1_2_2 = $this->createProposition("b. il pane non sia al rovescio.", false, $questionnaire_B2_17_1_2);
        $questionnaire_B2_17_1_2_3 = $this->createProposition("b. il pane non sia al rovescio.", false, $questionnaire_B2_17_1_3);
        $questionnaire_B2_17_1_2_4 = $this->createProposition("b. il pane non sia al rovescio.", false, $questionnaire_B2_17_1_4);
        $questionnaire_B2_17_1_2_5 = $this->createProposition("b. il pane non sia al rovescio.", false, $questionnaire_B2_17_1_5);
        $questionnaire_B2_17_1_2_6 = $this->createProposition("b. il pane non sia al rovescio.", false, $questionnaire_B2_17_1_6);
        $questionnaire_B2_17_1_2_7 = $this->createProposition("b. il pane non sia al rovescio.", false, $questionnaire_B2_17_1_7);

        $questionnaire_B2_17_1_3_1 = $this->createProposition("c. porta sfortuna.", false, $questionnaire_B2_17_1_1);
        $questionnaire_B2_17_1_3_2 = $this->createProposition("c. porta sfortuna.", false, $questionnaire_B2_17_1_2);
        $questionnaire_B2_17_1_3_3 = $this->createProposition("c. porta sfortuna.", false, $questionnaire_B2_17_1_3);
        $questionnaire_B2_17_1_3_4 = $this->createProposition("c. porta sfortuna.", false, $questionnaire_B2_17_1_4);
        $questionnaire_B2_17_1_3_5 = $this->createProposition("c. porta sfortuna.", true, $questionnaire_B2_17_1_5);
        $questionnaire_B2_17_1_3_6 = $this->createProposition("c. porta sfortuna.", false, $questionnaire_B2_17_1_6);
        $questionnaire_B2_17_1_3_7 = $this->createProposition("c. porta sfortuna.", false, $questionnaire_B2_17_1_7);

        $questionnaire_B2_17_1_4_1 = $this->createProposition("d. lo si lasci al suo posto", false, $questionnaire_B2_17_1_1);
        $questionnaire_B2_17_1_4_2 = $this->createProposition("d. lo si lasci al suo posto", false, $questionnaire_B2_17_1_2);
        $questionnaire_B2_17_1_4_3 = $this->createProposition("d. lo si lasci al suo posto", false, $questionnaire_B2_17_1_3);
        $questionnaire_B2_17_1_4_4 = $this->createProposition("d. lo si lasci al suo posto", false, $questionnaire_B2_17_1_4);
        $questionnaire_B2_17_1_4_5 = $this->createProposition("d. lo si lasci al suo posto", false, $questionnaire_B2_17_1_5);
        $questionnaire_B2_17_1_4_6 = $this->createProposition("d. lo si lasci al suo posto", false, $questionnaire_B2_17_1_6);
        $questionnaire_B2_17_1_4_7 = $this->createProposition("d. lo si lasci al suo posto", true, $questionnaire_B2_17_1_7);

        $questionnaire_B2_17_1_5_1 = $this->createProposition("e. rappresenti un’occasione per formulare un progetto da realizzare", false, $questionnaire_B2_17_1_1);
        $questionnaire_B2_17_1_5_2 = $this->createProposition("e. rappresenti un’occasione per formulare un progetto da realizzare", false, $questionnaire_B2_17_1_2);
        $questionnaire_B2_17_1_5_3 = $this->createProposition("e. rappresenti un’occasione per formulare un progetto da realizzare", false, $questionnaire_B2_17_1_3);
        $questionnaire_B2_17_1_5_4 = $this->createProposition("e. rappresenti un’occasione per formulare un progetto da realizzare", false, $questionnaire_B2_17_1_4);
        $questionnaire_B2_17_1_5_5 = $this->createProposition("e. rappresenti un’occasione per formulare un progetto da realizzare", false, $questionnaire_B2_17_1_5);
        $questionnaire_B2_17_1_5_6 = $this->createProposition("e. rappresenti un’occasione per formulare un progetto da realizzare", false, $questionnaire_B2_17_1_6);
        $questionnaire_B2_17_1_5_7 = $this->createProposition("e. rappresenti un’occasione per formulare un progetto da realizzare", true, $questionnaire_B2_17_1_7);


        /*******************************************
                    QUESTIONNAIRE 25 : TVFNM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_25 = $this->createQuestionnaire("B2_CE_vademecum", "B2", "CE", $test);
        $questionnaire_B2_25->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere, false o non dette", ""));
        $questionnaire_B2_25->setMediaContext($this->mediaText("", "Brochure informativa delle elezioni amministrative", ""));
        $questionnaire_B2_25->setMediaText($this->mediaText($startTitle . "Vademecum delle elezioni amministrative" . $endTitle, "**Come si vota nei comuni con popolazione superiore ai 15.000 abitanti**@@@La scheda per il rinnovo del Consiglio comunale č di colore azzurro. L'elettore ha a disposizione diverse modalitŕ per esprimere la propria preferenza.@@@1- Votare solo per un candidato sindaco, tracciando un segno sul nome, non scegliendo alcuna lista collegata. Il voto cosě espresso si intende attribuito solo al candidato sindaco.@@@2- Votare solo per una delle liste, tracciando un segno sul relativo simbolo. Il voto cosě espresso si intende attribuito anche al candidato sindaco collegato.@@@3- Votare per un candidato sindaco, tracciando un segno sul nome, e per una delle liste a esso collegate, tracciando un segno sul contrassegno della lista prescelta. Il voto cosě espresso si intende attribuito sia al candidato sindaco sia alla lista collegata.",
        ""));
        // CREATION QUESTION
        $questionnaire_B2_25_1 = $this->createQuestion("TVFNM", $questionnaire_B2_25);
        // CREATION SUBQUESTION
        $questionnaire_B2_25_1_1 = $this->createSubquestion("VFNM", $questionnaire_B2_25_1, "1. Č possibile votare per il sindaco e per le liste scegliendo solo il simbolo del partito di cui č a capo.");
        $questionnaire_B2_25_1_2 = $this->createSubquestion("VFNM", $questionnaire_B2_25_1, "2. Č possibile votare per due partiti che fanno parte della stessa coalizione.");
        $questionnaire_B2_25_1_3 = $this->createSubquestion("VFNM", $questionnaire_B2_25_1, "3. Č possibile votare per un solo candidato scrivendo il suo nome sulla scheda");
        // CREATION PROPOSITIONS
        $questionnaire_B2_25_1_1_1 = $this->createProposition("VRAI", true, $questionnaire_B2_25_1_1);
        $questionnaire_B2_25_1_1_2 = $this->createProposition("FAUX", false, $questionnaire_B2_25_1_1);
        $questionnaire_B2_25_1_1_3 = $this->createProposition("ND", false, $questionnaire_B2_25_1_1);

        $questionnaire_B2_25_1_2_1 = $this->createProposition("VRAI", false, $questionnaire_B2_25_1_2);
        $questionnaire_B2_25_1_2_2 = $this->createProposition("FAUX", false, $questionnaire_B2_25_1_2);
        $questionnaire_B2_25_1_2_3 = $this->createProposition("ND", true, $questionnaire_B2_25_1_2);

        $questionnaire_B2_25_1_3_1 = $this->createProposition("VRAI", false, $questionnaire_B2_25_1_3);
        $questionnaire_B2_25_1_3_2 = $this->createProposition("FAUX", true, $questionnaire_B2_25_1_3);
        $questionnaire_B2_25_1_3_3 = $this->createProposition("ND", false, $questionnaire_B2_25_1_3);

        /*******************************************
                    QUESTIONNAIRE 26 : APPTT
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_26 = $this->createQuestionnaire("B2_CE_voisin_greta", "B2", "CE", $test);
        $questionnaire_B2_26->setMediaInstruction($this->mediaText("", "Abbina ad ogni parola la definizione corretta. Ci sono due intrusi", ""));
        $questionnaire_B2_26->setMediaContext($this->mediaText("", "Post su un blog personale", ""));
        $questionnaire_B2_26->setMediaText($this->mediaText($startTitle . "Riflessione in treno" . $endTitle, "In treno mi piace chiudere gli occhi e ascoltare la gente che urla faccende private, intimi segreti a tutta la carrozza. Non per quello che dicono ma per come lo dicono. Per una rubrica come questa le ferrovie sono una grande fonte di ispirazione. Solo che dovremmo cambiare il Titolo: invece che tre minuti una parola, tre ore e migliaia di parole, nel viaggio solo da Milano a Roma. Molte sono superflue ma alcune sono sintomatiche. Il mio vicino nel corso interminabile di una telefonata, più o meno a distanza Parma - Firenze, continuava a ripetere agitato: ma si figuri, ma si figuri, ma si figuri! Non so cosa si figurasse il misterioso interlocutore: io mi figuravo un figuro che temeva una figuraccia", ""));
        // CREATION QUESTION
        $questionnaire_B2_26_1 = $this->createQuestion("APPTT", $questionnaire_B2_26);
        // CREATION SUBQUESTION
        $questionnaire_B2_26_1_1 = $this->createSubquestion("APPTT", $questionnaire_B2_26_1, "Figurasi");
        $questionnaire_B2_26_1_2 = $this->createSubquestion("APPTT", $questionnaire_B2_26_1, "Figuro");
        $questionnaire_B2_26_1_3 = $this->createSubquestion("APPTT", $questionnaire_B2_26_1, "Figuraccia");
        // CREATION PROPOSITIONS
        $questionnaire_B2_26_1_1_1 = $this->createProposition("Personaggio famoso", false, $questionnaire_B2_26_1_1);
        $questionnaire_B2_26_1_1_2 = $this->createProposition("Personaggio famoso", false, $questionnaire_B2_26_1_2);
        $questionnaire_B2_26_1_1_3 = $this->createProposition("Personaggio famoso", false, $questionnaire_B2_26_1_3);

        $questionnaire_B2_26_1_2_1 = $this->createProposition("Buona impressione", false, $questionnaire_B2_26_1_1);
        $questionnaire_B2_26_1_2_2 = $this->createProposition("Buona impressione", false, $questionnaire_B2_26_1_2);
        $questionnaire_B2_26_1_2_3 = $this->createProposition("Buona impressione", false, $questionnaire_B2_26_1_3);

        $questionnaire_B2_26_1_3_1 = $this->createProposition("Individuo losco", false, $questionnaire_B2_26_1_1);
        $questionnaire_B2_26_1_3_2 = $this->createProposition("Individuo losco", true, $questionnaire_B2_26_1_2);
        $questionnaire_B2_26_1_3_3 = $this->createProposition("Individuo losco", false, $questionnaire_B2_26_1_3);

        $questionnaire_B2_26_1_4_1 = $this->createProposition("Azione inopportuna", false, $questionnaire_B2_26_1_1);
        $questionnaire_B2_26_1_4_2 = $this->createProposition("Azione inopportuna", false, $questionnaire_B2_26_1_2);
        $questionnaire_B2_26_1_4_3 = $this->createProposition("Azione inopportuna", true, $questionnaire_B2_26_1_3);

        $questionnaire_B2_26_1_5_1 = $this->createProposition("Rappresentare", false, $questionnaire_B2_26_1_1);
        $questionnaire_B2_26_1_5_2 = $this->createProposition("Rappresentare", false, $questionnaire_B2_26_1_2);
        $questionnaire_B2_26_1_5_3 = $this->createProposition("Rappresentare", false, $questionnaire_B2_26_1_3);

        $questionnaire_B2_26_1_6_1 = $this->createProposition("Immaginare", true, $questionnaire_B2_26_1_1);
        $questionnaire_B2_26_1_6_2 = $this->createProposition("Immaginare", false, $questionnaire_B2_26_1_2);
        $questionnaire_B2_26_1_6_3 = $this->createProposition("Immaginare", false, $questionnaire_B2_26_1_3);

        /*******************************************
                    QUESTIONNAIRE 27 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_27 = $this->createQuestionnaire("B2_CE_enfin_les_pierres_volent", "B2", "CE", $test);
        $questionnaire_B2_27->setMediaInstruction($this->mediaText("", "Rispondi alle domande. Una sola risposta è corretta.", ""));
        $questionnaire_B2_27->setMediaContext($this->mediaText("", "Post su blog di viaggi", ""));
        $questionnaire_B2_27->setMediaText($this->mediaText($startTitle . "I sassi finalmente volano" . $endTitle,
        "I sassi di Matera sono un’attrazione turistica da sempre molto forte. Ma avete mai provato a guardarli da una nuova prospettiva? L’evento “I Sassi finalmente volano”, dal 18 marzo al 1°aprile, propone voli in mongolfiera per ammirare il paesaggio antropologico di quella che è stata definita la città più antica del mondo. 30 mongolfiere che si librano in volo al soffio del vento e fanno vedere e vivere dall’alto l’inusuale paesaggio rupestre della Città dei Sassi, patrimonio dell’umanità Unesco. Inoltre, dal 18 al 24 marzo, è previsto un evento di Light Mobility a favore di una consapevole ed ecosostenibile mobilità turistica.", ""));
        // CREATION QUESTION
        $questionnaire_B2_27_1 = $this->createQuestion("TQRU", $questionnaire_B2_27);
        // CREATION SUBQUESTION
        $questionnaire_B2_27_1_1 = $this->createSubquestion("QRU", $questionnaire_B2_27_1, "**1. L’articolo parla di un evento a Matera in cui:**");
        $questionnaire_B2_27_1_2 = $this->createSubquestion("QRU", $questionnaire_B2_27_1, "**2. L’evento:**");
        $questionnaire_B2_27_1_3 = $this->createSubquestion("QRU", $questionnaire_B2_27_1, "**3. Dal 18 al 24 marzo viene inoltre proposta:**");

        // CREATION PROPOSITIONS
        $questionnaire_B2_27_1_1_1 = $this->createProposition("1.1. dall’alto delle mongolfiere vengono lanciati dei sassi contro dei bersagli.", false, $questionnaire_B2_27_1_1);
        $questionnaire_B2_27_1_1_2 = $this->createProposition("1.2. dei giri in mongolfiera partono da Matera per visitare la regione della Basilicata.", false, $questionnaire_B2_27_1_1);
        $questionnaire_B2_27_1_1_3 = $this->createProposition("1.3. dei giri in mongolfiera vengono organizzati per godere della veduta della città.", true, $questionnaire_B2_27_1_1);
        $questionnaire_B2_27_1_1_4 = $this->createProposition("1.4. dei giri in mongolfiera vengono organizzati per promuovere il trasporto ecologico.", false, $questionnaire_B2_27_1_1);

        $questionnaire_B2_27_1_2_1 = $this->createProposition("2.1. attrae da diversi anni  molti turisti.", false, $questionnaire_B2_27_1_2);
        $questionnaire_B2_27_1_2_2 = $this->createProposition("2.2. è una novità turistica", true, $questionnaire_B2_27_1_2);
        $questionnaire_B2_27_1_2_3 = $this->createProposition("2.3. è alla sua ultima edizione", false, $questionnaire_B2_27_1_2);
        $questionnaire_B2_27_1_2_3 = $this->createProposition("2.4. fa parte della tradizione della città.", false, $questionnaire_B2_27_1_2);

        $questionnaire_B2_27_1_3_1 = $this->createProposition("3.1. una visita guidata turistica di Matera, detta anche città dei Sassi.", false, $questionnaire_B2_27_1_3);
        $questionnaire_B2_27_1_3_2 = $this->createProposition("3.2. un evento che promuove la raccolta differenziata nella città di Matera.", false, $questionnaire_B2_27_1_3);
        $questionnaire_B2_27_1_3_3 = $this->createProposition("3.3. un evento che promuove  un risparmio delle risorse energetiche.", false, $questionnaire_B2_27_1_3);
        $questionnaire_B2_27_1_3_3 = $this->createProposition("3.4. un evento che promuove  una gestione ecologica dei visitatori.", true, $questionnaire_B2_27_1_3);


        /*******************************************
                    MISE EN BASE
        ********************************************/
        $em->flush();

        $output->writeln("Fixtures Italian CE B2 exécutées.");


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
     * #167
     */
    protected function createSubquestion($typology, $question, $media)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        // Création du questionnaire
        $subquestion = new Subquestion();

        $typo = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($typology);
        $subquestion->setTypology($typo);

        $subquestion->setQuestion($question);

        if ($media != '') {
            $subquestion->setMedia($this->mediaText("", $media, ""));
        }

        $em->persist($subquestion);

        return $subquestion;
    }

    /**
     *
     */
    protected function createSubquestionVF($typology, $question, $amorce, $media)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        // Création du questionnaire
        $subquestion = new Subquestion();

        $typo = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($typology);
        $subquestion->setTypology($typo);

        $subquestion->setQuestion($question);

        if ($amorce != '') {
            $subquestion->setMediaAmorce($this->mediaText("", $amorce, ""));
        }
        if ($media != '') {
            $subquestion->setMedia($this->mediaText("", $media, ""));
        }

        $em->persist($subquestion);

        return $subquestion;
    }

    /**
     *
     */
    protected function createProposition($text, $rightAnswer, Subquestion $subquestion)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        $proposition = new Proposition();

        $proposition->setSubquestion($subquestion);
        $proposition->setMedia($this->mediaText("", $text, ""));
        $proposition->setRightAnswer($rightAnswer);

        $em->persist($proposition);

        return $proposition;
    }


    /**
     *createPropositionVF()
     */
    protected function createPropositionVF($text, $textAnswer, $rightAnswer, Subquestion $subquestion)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        $proposition = new Proposition();

        $proposition->setSubquestion($subquestion);
        $proposition->setMedia($this->mediaText("", $textAnswer, ""));
        $proposition->setRightAnswer($rightAnswer);

        $em->persist($proposition);

        return $proposition;
    }

    /**
     *
     */
    protected function mediaText($title, $name, $type)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        // TODO : l'appel à la fonction qui traite le markdown !!
        // Création dans "Media"
        $media = new Media();

        if ($type != "") {
            $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("image"));
            $media->setUrl($name.".jpg");
        }
        else
        {
            $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("texte"));
            $media->setUrl(NULL);
        }

        $media->setName($this->textSource($title.$name));
        $media->setDescription($this->textSource($title.$name)); // Ajout ERV 03/03/2014 car c'est la description que l'on affiche dans la macro.texte

        $em->persist($media);

        return $media;
    }

    /**
     * textSource function
     *
     */
    private function textSource($textSource)
    {

        // Règles :
        // *** pour un texte italique
        // $$$ pour un texte souligné
        // @@@ pour aller à la ligne
        //
        //
        // For more explications : http://www.php.net/manual/fr/reference.pcre.pattern.modifiers.php
        // echo "<br /><br />Texte AVANT = " . $textSource;
        //$rule = '($$$).*?($$$)';
        //$final = '<i>.*?</i>';

        $textDisplay = preg_replace('/\*{3}(.*?)\*{3}/s', '<i>$1</i>', $textSource);
        // echo "<br /><br />Texte APRES = " . $textDisplay;

        // echo "<br /><br />Texte AVANT = " . $textSource;
        $textDisplay = preg_replace('/\${3}(.*?)\${3}/s', '<u>$1</u>', $textDisplay);
        //$textDisplay = preg_replace('/***(.*?)***/s', '<i>$1</i>', $textSource); // Texte italique

        $textDisplay = str_replace('@@@', '<br>', $textDisplay); // Saut de ligne

        // echo "<br /><br />Texte APRES = " . $textDisplay;

        return $textDisplay;
    }

}
