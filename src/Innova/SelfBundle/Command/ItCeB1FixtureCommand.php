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
class Itceb1FixtureCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('self:fixtures:itceb1')
            ->setDescription('SELF CE Italien B1')
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
        $test = $this->createTest("CE Italien B1", "Italian");

        // To have CSS form title. #166
        $startTitle = "<span class=\"title-situation\">";
        $endTitle = "</span>";

        /*******************************************

                    NIVEAU : B1

        ********************************************/

        /*******************************************
                    QUESTIONNAIRE 3 : QRM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_3 = $this->createQuestionnaire("B1_CE_vacance_croisiere", "B1", "CE", $test);
        $questionnaire_3->setMediaInstruction($this->mediaText("", "Due informazioni sono presenti nel testo. Quali?", ""));
        $questionnaire_3->setMediaContext($this->mediaText("", "Pubblicità in agenzia di viaggi", ""));
        $questionnaire_3->setMediaText($this->mediaText($startTitle . "Partire con ***Crociere nel Mondo***" . $endTitle, "Sempre più persone scelgono ogni anno di trascorrere le proprie vacanze con Crociere nel Mondo; se deciderai di unirti a noi, capirai subito il perché. @@@
Il comfort e l’eccezionale servizio della nostra nave saprà come sorprenderti: ti innamorerai delle meravigliose SPA, degli spettacoli, dell’intrattenimento a bordo, dei numerosi sport che potrai praticare e delle delizie della nostra cucina. Apprezzerai anche il modo  in cui sappiamo intrattenere gli ospiti di tutte le età, ad un prezzo che continuerà a farti sorridere. Prova l’esperienza di un viaggio con noi, non vorrai più tornare a casa.
Sempre più persone scelgono ogni anno di trascorrere le proprie vacanze con Crociere nel Mondo; se deciderai di unirti a noi, capirai subito il perché. @@@
Il comfort e l’eccezionale servizio della nostra nave saprà come sorprenderti: ti innamorerai delle meravigliose SPA, degli spettacoli, dell’intrattenimento a bordo, dei numerosi sport che potrai praticare e delle delizie della nostra cucina. Apprezzerai anche il modo  in cui sappiamo intrattenere gli ospiti di tutte le età, ad un prezzo che continuerà a farti sorridere. Prova l’esperienza di un viaggio con noi, non vorrai più tornare a casa.", ""));
        // CREATION QUESTION
        $questionnaire_3_1 = $this->createQuestion("QRM", $questionnaire_3);
        // CREATION SUBQUESTION
        $questionnaire_3_1_1 = $this->createSubquestion("QRM", $questionnaire_3_1, "");
        // CREATION PROPOSITIONS
        $questionnaire_3_1_1_1 = $this->createProposition("Con Crociere nel Mondo puoi continuare a fare gli sport che ti  piacciono anche in vacanza.", true, $questionnaire_3_1_1);
        $questionnaire_3_1_1_2 = $this->createProposition("Il punto di forza dell’azienda è la capacità di offrire servizi per  tutte le esigenze.", true, $questionnaire_3_1_1);
        $questionnaire_3_1_1_3 = $this->createProposition("L’offerta è accessibile ad un pubblico ristretto", false, $questionnaire_3_1_1);


        /*******************************************
                    QUESTIONNAIRE 4 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_4 = $this->createQuestionnaire("B1_CE_voyager_en_securite", "B1", "CE", $test);
        $questionnaire_4->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere o false", ""));
        $questionnaire_4->setMediaContext($this->mediaText("", "Avviso sul sito del Ministero degli Esteri", ""));
        $questionnaire_4->setMediaText($this->mediaText($startTitle . "Viaggiare sicuri" . $endTitle, "Sono stati di recente segnalati casi di false società che, attraverso la rete, propongono servizi di prenotazione alberghiera, in particolare per le regioni del sud del Portogallo. Per evitare di pagare un servizio e  avere poi brutte sorprese, si raccomanda quindi, di rivolgersi esclusivamente ad agenzie e a tour operator affidabili.@@@
Si consiglia inoltre di registrare i dati relativi al viaggio che si intende effettuare sul sito Dove siamo nel mondo e di sottoscrivere una assicurazione che copra anche le spese sanitarie, e l’eventuale trasferimento aereo al paese d’origine in caso di malattie gravi.
Sono stati di recente segnalati casi di false società che, attraverso la rete, propongono servizi di prenotazione alberghiera, in particolare per le regioni del sud del Portogallo. Per evitare di pagare un servizio e  avere poi brutte sorprese, si raccomanda quindi, di rivolgersi esclusivamente ad agenzie e a tour operator affidabili.@@@
Si consiglia inoltre di registrare i dati relativi al viaggio che si intende effettuare sul sito Dove siamo nel mondo e di sottoscrivere una assicurazione che copra anche le spese sanitarie, e l’eventuale trasferimento aereo al paese d’origine in caso di malattie gravi.
", ""));
        // CREATION QUESTION
        $questionnaire_4_1 = $this->createQuestion("TVF", $questionnaire_4);
        // CREATION SUBQUESTION
        //$questionnaire_4_1_1 = $this->createSubquestion("QRM", $questionnaire_4_1, "");
        // CREATION PROPOSITIONS
        //$questionnaire_4_1_1_1 = $this->createProposition("Il messaggio intende mettere in guardia i turisti da siti internet poco sicuri.", true, $questionnaire_4_1_1);
        //$questionnaire_4_1_1_2 = $this->createProposition("Nel messaggio si consiglia di contattare le società di prenotazione alberghiera una volta arrivati sul posto.", false, $questionnaire_4_1_1);
        //$questionnaire_4_1_1_3 = $this->createProposition("Prima di partire è obbligatorio acquistare un'assicurazione per le spese mediche.", false, $questionnaire_4_1_1);

        // CREATION SUBQUESTION
        $questionnaire_4_1_1 = $this->createSubquestionVF("VF", $questionnaire_4_1, "", "Il messaggio intende mettere in guardia i turisti da siti internet poco sicuri.");
        $questionnaire_4_1_2 = $this->createSubquestionVF("VF", $questionnaire_4_1, "", "Nel messaggio si consiglia di contattare le società di prenotazione alberghiera una volta arrivati sul posto.");
        $questionnaire_4_1_3 = $this->createSubquestionVF("VF", $questionnaire_4_1, "", "Prima di partire è obbligatorio acquistare un'assicurazione per le spese mediche.");

        // CREATION PROPOSITIONS
        $questionnaire_4_1_1_1 = $this->createPropositionVF("", "VRAI", true, $questionnaire_4_1_1);
        $questionnaire_4_1_1_1 = $this->createPropositionVF("", "FAUX", false, $questionnaire_4_1_1);

        $questionnaire_4_1_1_2 = $this->createPropositionVF("", "VRAI", false, $questionnaire_4_1_2);
        $questionnaire_4_1_1_2 = $this->createPropositionVF("", "FAUX", true, $questionnaire_4_1_2);

        $questionnaire_4_1_1_3 = $this->createPropositionVF("", "VRAI", false, $questionnaire_4_1_3);
        $questionnaire_4_1_1_3 = $this->createPropositionVF("", "FAUX", true, $questionnaire_4_1_3);



        /*******************************************
                    QUESTIONNAIRE 6 : QRM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_6 = $this->createQuestionnaire("B1_CE_annonce_immobilier", "B1", "CE", $test);
        $questionnaire_6->setMediaInstruction($this->mediaText("", "Due informazioni sono presenti nel testo. Quali?", ""));
        $questionnaire_6->setMediaContext($this->mediaText("", "Annuncio immobiliare", ""));
        $questionnaire_6->setMediaText($this->mediaText($startTitle . "Affittasi appartamento al Marina Village" . $endTitle, "All'interno del Marina Village, vera oasi di pace sul trasparente mare Ionio, proponiamo in affitto splendido appartamento con 6 posti letto, climatizzato e finemente arredato composto da un ampio soggiorno con zona cottura, un bagno e un ampio balcone con una splendida vista sul mare. La cura dei dettagli ed il contesto donano alla casa un tocco di stile ed un'eleganza esclusiva. Il villaggio turistico offre intrattenimento serale per tutti. La spiaggia privata è raggiungibile solo attraverso un breve percorso a piedi o in bicicletta.", ""));
        // CREATION QUESTION
        $questionnaire_6_1 = $this->createQuestion("QRM", $questionnaire_6);
        // CREATION SUBQUESTION
        $questionnaire_6_1_1 = $this->createSubquestion("QRM", $questionnaire_6_1, "");
        // CREATION PROPOSITIONS
        $questionnaire_6_1_1_1 = $this->createProposition("Al villaggio turistico Marina Village propongono animazione serale.", true, $questionnaire_6_1_1);
        $questionnaire_6_1_1_2 = $this->createProposition("L’appartamento dispone di 5 camere da letto.", false, $questionnaire_6_1_1);
        $questionnaire_6_1_1_3 = $this->createProposition("Il terrazzo è arredato con ombrelloni e sdraio.", false, $questionnaire_6_1_1);
        $questionnaire_6_1_1_4 = $this->createProposition("La spiaggia privata non è raggiungibile da veicoli a motore", true, $questionnaire_6_1_1);

        /*******************************************
                    QUESTIONNAIRE 7 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_7 = $this->createQuestionnaire("B1_CE_cours_pizzaiolo", "B1", "CE", $test);
        $questionnaire_7->setMediaInstruction($this->mediaText("", "Completa il testo usando le parole suggerite", ""));
        $questionnaire_7->setMediaContext($this->mediaText("", "Annuncio lavorativo", ""));
        $questionnaire_7->setMediaText($this->mediaText($startTitle . "Corso per pizzaiolo! Diventa pizzaiolo e impara un mestiere!
" . $endTitle, "Sono aperte le iscrizioni al prossimo corso per 1.________________ pizzaiolo. Durata 13 giorni di pratica e teoria direttamente in pizzeria dal primo all’ultimo giorno di corso. Alla fine verrà rilasciato il nostro 2._________________ da pizzaiolo e l’iscrizione al nostro albo pizzaioli.
Il corso è a numero 3._________________. Riservato a 3 persone per volta. I nostri corsi sono riservati a poche persone per volta per darti la garanzia che sarai seguito bene!
I nostri orari sono flessibili, adatti anche a chi studia o lavora.
Per maggiori informazioni visita anche il nostro sito www.pizzaitalianaacademy.com", ""));
        // CREATION QUESTION
        $questionnaire_7_1 = $this->createQuestion("TQRU", $questionnaire_7);
        // CREATION SUBQUESTION
        $questionnaire_7_1_1 = $this->createSubquestion("QRU", $questionnaire_7_1, "");
        $questionnaire_7_1_2 = $this->createSubquestion("QRU", $questionnaire_7_1, "");
        $questionnaire_7_1_3 = $this->createSubquestion("QRU", $questionnaire_7_1, "");
        $questionnaire_7_1_4 = $this->createSubquestion("QRU", $questionnaire_7_1, "");
        // CREATION PROPOSITIONS
        $questionnaire_7_1_1_1 = $this->createProposition("1.1. Lavorare", false, $questionnaire_7_1_1);
        $questionnaire_7_1_1_2 = $this->createProposition("1.2. Apprendere", false, $questionnaire_7_1_1);
        $questionnaire_7_1_1_3 = $this->createProposition("1.3. Diventare", true, $questionnaire_7_1_1);

        $questionnaire_7_1_2_1 = $this->createProposition("2.1. Diploma", true, $questionnaire_7_1_2);
        $questionnaire_7_1_2_2 = $this->createProposition("2.2. Documento", false, $questionnaire_7_1_2);
        $questionnaire_7_1_2_3 = $this->createProposition("2.3. Libretto", false, $questionnaire_7_1_2);

        $questionnaire_7_1_3_1 = $this->createProposition("3.1. Chiuso", true, $questionnaire_7_1_3);
        $questionnaire_7_1_3_2 = $this->createProposition("3.2. Stretto", false, $questionnaire_7_1_3);
        $questionnaire_7_1_3_3 = $this->createProposition("3.3 Corto", false, $questionnaire_7_1_3);

        $questionnaire_7_1_4_1 = $this->createProposition("4.1. Assicurazione", false, $questionnaire_7_1_4);
        $questionnaire_7_1_4_2 = $this->createProposition("4.2. Garanzia", true, $questionnaire_7_1_4);
        $questionnaire_7_1_4_3 = $this->createProposition("4.3. Celebrità", false, $questionnaire_7_1_4);

        /*******************************************
                    QUESTIONNAIRE 8 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_8 = $this->createQuestionnaire("B1_CE_evenements_rome", "B1", "CE", $test);
        $questionnaire_8->setMediaInstruction($this->mediaText("", "Seleziona il riassunto corretto", ""));
        $questionnaire_8->setMediaContext($this->mediaText("", "Brochure informativa a teatro", ""));
        $questionnaire_8->setMediaText(
        $this->mediaText($startTitle .
            "Rappresentazioni ed eventi teatrali a Roma" . $endTitle,
            "Arriva l’estate e ricomincia la stagione d’eventi proposta come ogni anno dall’associazione Fiesta. Nelle calde estati romane, l’associazione promuove il Festival Internazionale di Musica e Cultura Latino Americana. Gli eventi si terranno da giugno a settembre e  il calendario è già disponibile sul sito $$$$$$ per prenotazioni. Come ogni anno gli spettacoli si terranno nello splendido Parco Rosati.",
            ""));
        // CREATION QUESTION
        $questionnaire_8_1 = $this->createQuestion("TQRU", $questionnaire_8);
        // CREATION SUBQUESTION
        $questionnaire_8_1_1 = $this->createSubquestion("QRU", $questionnaire_8_1, "");
        // CREATION PROPOSITIONS
        $questionnaire_8_1_1_1 = $this->createProposition("L’annuncio promuove gli eventi estivi organizzati dall’associazione ***Fiesta*** nel Parco Rosati. Per partecipare è necessario prenotare i biglietti sul sito internet.", true, $questionnaire_8_1_1);
        $questionnaire_8_1_1_2 = $this->createProposition("L’annuncio promuove i corsi estivi di ballo latino-americano dell’associazione ***Fiesta***. Per partecipare è necessario iscriversi presso la sede dell’associazione situata nel Parco Rosati.", false, $questionnaire_8_1_1);
        $questionnaire_8_1_1_3 = $this->createProposition("L’annuncio promuove i corsi estivi di lingua e cultura latino-americana tenuti presso l’associazione ***Fiesta***, situata nello splendido Parco Rosati.", false, $questionnaire_8_1_1);

        /*******************************************
                    QUESTIONNAIRE 9 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_9 = $this->createQuestionnaire("B1_CE_vacance_sicile", "B1", "CE", $test);
        $questionnaire_9->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere o false", ""));
        $questionnaire_9->setMediaContext($this->mediaText("", "Pubblicità in un’agenzia di viaggi", ""));
        $questionnaire_9->setMediaText($this->mediaText($startTitle . "Alla scoperta della Sicilia" . $endTitle,
        "Per quanti vogliono visitare la Sicilia e apprezzarne il patrimonio artistico, storico e naturalistico, Hermes-Sicily.com propone un programma di visite guidate settimanali. Si tratta di \"gruppi misti\" ai quali è possibile iscriversi scegliendo  le mete secondo il calendario stagionale previsto. I gruppi possono essere composti da massimo 10 partecipanti  e le iscrizioni possono essere singole o di gruppo. Oltre che in lingua italiana le visite, si tengono anche in inglese e tedesco.", ""));
        // CREATION QUESTION
        $questionnaire_9_1 = $this->createQuestion("TVF", $questionnaire_9);
        // CREATION SUBQUESTION
        //$questionnaire_9_1_1 = $this->createSubquestion("QRM", $questionnaire_9_1, "");
        // CREATION PROPOSITIONS
        //$questionnaire_9_1_1_1 = $this->createProposition("Le visite guidate si tengono una volta a settimana.", true, $questionnaire_9_1_1);
        //$questionnaire_9_1_1_2 = $this->createProposition("Le visite guidate cambiano in base alla stagione.", true, $questionnaire_9_1_1);
        //$questionnaire_9_1_1_3 = $this->createProposition("I gruppi devono essere composti da almeno 10 partecipanti.", false, $questionnaire_9_1_1);


        // CREATION SUBQUESTION
        $questionnaire_9_1_1 = $this->createSubquestionVF("VF", $questionnaire_9_1, "", "Le visite guidate si tengono una volta a settimana.");
        $questionnaire_9_1_2 = $this->createSubquestionVF("VF", $questionnaire_9_1, "", "Le visite guidate cambiano in base alla stagione.");
        $questionnaire_9_1_3 = $this->createSubquestionVF("VF", $questionnaire_9_1, "", "I gruppi devono essere composti da almeno 10 partecipanti.");

        // CREATION PROPOSITIONS
        $questionnaire_9_1_1_1 = $this->createPropositionVF("", "VRAI", true, $questionnaire_9_1_1);
        $questionnaire_9_1_1_1 = $this->createPropositionVF("", "FAUX", false, $questionnaire_9_1_1);

        $questionnaire_9_1_1_2 = $this->createPropositionVF("", "VRAI", true, $questionnaire_9_1_2);
        $questionnaire_9_1_1_2 = $this->createPropositionVF("", "FAUX", false, $questionnaire_9_1_2);

        $questionnaire_9_1_1_3 = $this->createPropositionVF("", "VRAI", false, $questionnaire_9_1_3);
        $questionnaire_9_1_1_3 = $this->createPropositionVF("", "FAUX", true, $questionnaire_9_1_3);

        /*******************************************
                    QUESTIONNAIRE 11 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B1_11 = $this->createQuestionnaire("B1_CE_chemin_compostelle", "B1", "CE", $test);
        $questionnaire_B1_11->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere o false", ""));
        $questionnaire_B1_11->setMediaContext($this->mediaText("", "Post su blog di viaggi", ""));
        $questionnaire_B1_11->setMediaText($this->mediaText($startTitle . "Il cammino di Santiago" . $endTitle,
        "È difficile scrivere di un’esperienza personale così profonda, bisognerebbe scavare nell’anima, per trovare le radici delle motivazioni che spingono a intraprendere questo viaggio, che inizia ancor prima di partire dalla tua storia, dal tuo modo di essere e di vivere. @@@
È facile invece elencare le persone incontrate, le storie ascoltate camminando, i pranzi e le cene in compagnia, i luoghi visitati, gli alberghi dove ho dormito. Ognuno meriterebbe di essere descritto e raccontato con dovizia di particolari, ma non basterebbe un libro. @@@
Ometterò quindi aspetti puramente pratici, concentrandomi sulle sensazioni che crescevano in me, mentre vivevo uno dei capitoli più belli della mia vita.", ""));
        // CREATION QUESTION
        $questionnaire_B1_11_1 = $this->createQuestion("TVF", $questionnaire_B1_11);
        // CREATION SUBQUESTION
        //$questionnaire_11_1_1 = $this->createSubquestion("QRM", $questionnaire_11_1, "");
        // CREATION PROPOSITIONS
        //$questionnaire_11_1_1_1 = $this->createProposition("Il racconto di viaggio descrive principalmente gli aspetti pratici dell’organizzazione.", false, $questionnaire_11_1_1);
        //$questionnaire_11_1_1_2 = $this->createProposition("L’autrice sostiene che sia complesso descrivere le forti emozioni provate durante il viaggio.   ", true, $questionnaire_11_1_1);
        //$questionnaire_11_1_1_3 = $this->createProposition("Per l’autrice i motivi che spronano a partire sono profondi, inconsci e forti.", true, $questionnaire_11_1_1);

        // CREATION SUBQUESTION
        $questionnaire_B1_11_1_1 = $this->createSubquestionVF("VF", $questionnaire_B1_11_1, "", "Il racconto di viaggio descrive principalmente gli aspetti pratici dell’organizzazione.");
        $questionnaire_B1_11_1_2 = $this->createSubquestionVF("VF", $questionnaire_B1_11_1, "", "L’autrice sostiene che sia complesso descrivere le forti emozioni provate durante il viaggio.");
        $questionnaire_B1_11_1_3 = $this->createSubquestionVF("VF", $questionnaire_B1_11_1, "", "Per l’autrice i motivi che spronano a partire sono profondi, inconsci e forti.");

        // CREATION PROPOSITIONS
        $questionnaire_B1_11_1_1_1 = $this->createPropositionVF("", "VRAI", false, $questionnaire_B1_11_1_1);
        $questionnaire_B1_11_1_1_1 = $this->createPropositionVF("", "FAUX", true, $questionnaire_B1_11_1_1);

        $questionnaire_B1_11_1_1_2 = $this->createPropositionVF("", "VRAI", true, $questionnaire_B1_11_1_2);
        $questionnaire_B1_11_1_1_2 = $this->createPropositionVF("", "FAUX", false, $questionnaire_B1_11_1_2);

        $questionnaire_B1_11_1_1_3 = $this->createPropositionVF("", "VRAI", true, $questionnaire_B1_11_1_3);
        $questionnaire_B1_11_1_1_3 = $this->createPropositionVF("", "FAUX", false, $questionnaire_B1_11_1_3);

        /*******************************************
                    QUESTIONNAIRE 13 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_13 = $this->createQuestionnaire("B1_CE_publicite_progres", "B1", "CE", $test);
        $questionnaire_13->setMediaInstruction($this->mediaText("", "Seleziona il riassunto corretto", ""));
        $questionnaire_13->setMediaContext($this->mediaText("", "Articolo su quotidiano", ""));
        $questionnaire_13->setMediaText($this->mediaText($startTitle . "Alfabetizzazione informatica" . $endTitle,
        "Recenti ricerche dimostrano che gli italiani, tra tutti i cittadini d’Europa, si collocano agli ultimi posti in quanto a utilizzo del computer.
Il gruppo di lavoro di ***Pubblicità Progresso*** ha rilevato che il problema della scarsa propensione dei nostri connazionali a utilizzare il computer esiste ma bisogna evitare di drammatizzarlo. L’informatica non deve essere considerata una nuova religione ma un formidabile strumento che amplia le potenzialità degli individui. Per questo, l’obiettivo delle pubblicità che verranno mandate in onda prossimamente, è quello di lanciare un messaggio, privo di effetti speciali e allarmismi, che metta in rilievo l’utilità del computer nella vita quotidiana.", ""));

        // CREATION QUESTION
        $questionnaire_13_1 = $this->createQuestion("TQRU", $questionnaire_13);
        // CREATION SUBQUESTION
        $questionnaire_13_1_1 = $this->createSubquestion("QRU", $questionnaire_13_1, "");
        // CREATION PROPOSITIONS
        $questionnaire_13_1_1_1 = $this->createProposition("***Pubblicità Progresso***, dopo aver constatato lo scarso utilizzo del computer da parte degli italiani, si è impegnata nella creazione di una campagna pubblicitaria chiara e semplice che promuova l’utilizzo e l’utilità di questo strumento.", true, $questionnaire_13_1_1);
        $questionnaire_13_1_1_2 = $this->createProposition("***Pubblicità Progresso***, dopo aver constatato che, nella società attuale l’informatica è diventata una sorta di religione, si è impegnata a lanciare una campagna pubblicitaria ad effetto che inviti ad un uso più moderato di questo strumento.", false, $questionnaire_13_1_1);
        $questionnaire_13_1_1_3 = $this->createProposition("***Pubblicità Progresso***, dopo aver constatato la drammatica situazione legata allo scarso utilizzo dei computer da parte dei cittadini italiani, si è impegnata nell’ideazione di una campagna promozionale di corsi di informatica.", false, $questionnaire_13_1_1);

        /*******************************************
                    QUESTIONNAIRE 14 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_14 = $this->createQuestionnaire("B1_CE_avis_parc_naturel", "B1", "CE", $test);
        $questionnaire_14->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere o false", ""));
        $questionnaire_14->setMediaContext($this->mediaText("", "Avviso pubblico in un parco naturale", ""));
        $questionnaire_14->setMediaText($this->mediaText($startTitle . "Parco Naturale Amedeo Brenta: 3 regole per rispettare il parco" . $endTitle,
        "1. Quando avvisti degli animali, tieniti a distanza: rischi di spaventarli. Hanno paura anche dei cani che, per questo, è necessario tenere sempre sotto controllo.@@@

2. Per salvaguardare il magico equilibrio del Parco, è vietato  il campeggio libero.@@@

3. Quasi ovunque si possono raccogliere i funghi, ma serve un permesso, che viene rilasciato dai Comuni.@@@
Queste semplici regole di buona educazione e buon senso vengono fatte rispettare dai guardaparco e dai forestali, anche applicando le sanzioni previste dalla L.P. 18/88.
Grazie per la collaborazione.", ""));
        // CREATION QUESTION
        $questionnaire_14_1 = $this->createQuestion("TVF", $questionnaire_14);
        // CREATION SUBQUESTION
        //$questionnaire_14_1_1 = $this->createSubquestion("QRM", $questionnaire_14_1, "");
        // CREATION PROPOSITIONS
        //$questionnaire_14_1_1_1 = $this->createProposition("Durante la visita al parco è obbligatorio tenere sempre sotto controllo i propri cani per evitare sanzioni da parte dei guardaparco e degli agenti forestali.", true, $questionnaire_11_1_1);
        //$questionnaire_14_1_1_2 = $this->createProposition("In tutte le aree del parco è concessa la raccolta dei funghi ai visitatori provvisti di permesso.", false, $questionnaire_11_1_1);
        //$questionnaire_14_1_1_3 = $this->createProposition("Per ragioni ambientali il campeggio nel parco non è permesso", true, $questionnaire_11_1_1);

        // CREATION SUBQUESTION
        $questionnaire_14_1_1 = $this->createSubquestionVF("VF", $questionnaire_14_1, "", "Durante la visita al parco è obbligatorio tenere sempre sotto controllo i propri cani per evitare sanzioni da parte dei guardaparco e degli agenti forestali.");
        $questionnaire_14_1_2 = $this->createSubquestionVF("VF", $questionnaire_14_1, "", "In tutte le aree del parco è concessa la raccolta dei funghi ai visitatori provvisti di permesso.");
        $questionnaire_14_1_3 = $this->createSubquestionVF("VF", $questionnaire_14_1, "", "Per ragioni ambientali il campeggio nel parco non è permesso");

        // CREATION PROPOSITIONS
        $questionnaire_14_1_1_1 = $this->createPropositionVF("", "VRAI", true, $questionnaire_14_1_1);
        $questionnaire_14_1_1_1 = $this->createPropositionVF("", "FAUX", false, $questionnaire_14_1_1);

        $questionnaire_14_1_1_2 = $this->createPropositionVF("", "VRAI", false, $questionnaire_14_1_2);
        $questionnaire_14_1_1_2 = $this->createPropositionVF("", "FAUX", true, $questionnaire_14_1_2);

        $questionnaire_14_1_1_3 = $this->createPropositionVF("", "VRAI", true, $questionnaire_14_1_3);
        $questionnaire_14_1_1_3 = $this->createPropositionVF("", "FAUX", false, $questionnaire_14_1_3);

        /*******************************************
                    QUESTIONNAIRE 15 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_15 = $this->createQuestionnaire("B1_CE_famille", "B1", "CE", $test);
        $questionnaire_15->setMediaInstruction($this->mediaText("", "Completa il testo usando le parole suggerite", ""));
        $questionnaire_15->setMediaContext($this->mediaText("", "Articolo su una rivista di attualità", ""));
        $questionnaire_15->setMediaText($this->mediaText($startTitle . "Le nuove famiglie" . $endTitle, "La società italiana 1.__________________ e quindi il modello familiare si evolve. 2.________________ la famiglia è una istituzione sociale fondamentale che, negli ultimi anni, ha subito profondi cambiamenti e 3.________________________ molto dal modello tradizione. Secondo i sociologi oggi 4._____ esistono diversi tipi: quella estesa, quella multipla, quella senza struttura coniugale e quella solitaria.
Johanna Viggosdottir – ***Fare famiglia in Italia***", ""));
        // CREATION QUESTION
        $questionnaire_15_1 = $this->createQuestion("TQRU", $questionnaire_15);
        // CREATION SUBQUESTION
        $questionnaire_15_1_1 = $this->createSubquestion("QRU", $questionnaire_15_1, "");
        $questionnaire_15_1_2 = $this->createSubquestion("QRU", $questionnaire_15_1, "");
        $questionnaire_15_1_3 = $this->createSubquestion("QRU", $questionnaire_15_1, "");
        $questionnaire_15_1_4 = $this->createSubquestion("QRU", $questionnaire_15_1, "");
        // CREATION PROPOSITIONS
        $questionnaire_15_1_1_1 = $this->createProposition("1.1. si sviluppa", true, $questionnaire_15_1_1);
        $questionnaire_15_1_1_2 = $this->createProposition("1.2. è sviluppata", false, $questionnaire_15_1_1);
        $questionnaire_15_1_1_3 = $this->createProposition("1.3. ha sviluppato", false, $questionnaire_15_1_1);

        $questionnaire_15_1_2_1 = $this->createProposition("2.1. Da sempre", true, $questionnaire_15_1_2);
        $questionnaire_15_1_2_2 = $this->createProposition("2.2. Quindi", false, $questionnaire_15_1_2);
        $questionnaire_15_1_2_3 = $this->createProposition("2.3. Comunque", false, $questionnaire_15_1_2);

        $questionnaire_15_1_3_1 = $this->createProposition("3.1. si è allontanata", true, $questionnaire_15_1_3);
        $questionnaire_15_1_3_2 = $this->createProposition("3.2. ha allontanato", false, $questionnaire_15_1_3);
        $questionnaire_15_1_3_3 = $this->createProposition("3.3. è allontanato", false, $questionnaire_15_1_3);

        $questionnaire_15_1_4_1 = $this->createProposition("4.1. ne", true, $questionnaire_15_1_4);
        $questionnaire_15_1_4_2 = $this->createProposition("4.2. ci", false, $questionnaire_15_1_4);
        $questionnaire_15_1_4_3 = $this->createProposition("4.3. vi", false, $questionnaire_15_1_4);

        /*******************************************
                    QUESTIONNAIRE 16 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_16 = $this->createQuestionnaire("B1_CE_erasmus", "B1", "CE", $test);
        $questionnaire_16->setMediaInstruction($this->mediaText("", "Completa il testo usando le parole suggerite", ""));
        $questionnaire_16->setMediaContext($this->mediaText("", "Post su un blog studentesco", ""));
        $questionnaire_16->setMediaText($this->mediaText($startTitle . "L’esperienza Erasmus" . $endTitle,
        "Cari amici, @@@al rientro dall’Erasmus, ho avuto la voglia e il bisogno di creare un ***blog*** per condividere questa bellissima esperienza. Perché partire per l’Erasmus? Quelli che 1.___________________ direbbero piuttosto \"Perché non farlo?\" Credo che una delle ragioni 2._______ il desiderio di uscire dalla propria nazione, divertirsi e conoscere giovani provenienti da tutta Europa; senza dimenticarsi  degli esami da sostenere! Penso che una esperienza di questo tipo 3._____________ non solo la possibilità di migliorare o imparare una lingua straniera, ma anche, e soprattutto, 4.________________ di acquisire una maggiore apertura mentale.", ""));
        // CREATION QUESTION
        $questionnaire_16_1 = $this->createQuestion("TQRU", $questionnaire_16);
        // CREATION SUBQUESTION
        $questionnaire_16_1_1 = $this->createSubquestion("QRU", $questionnaire_16_1, "");
        $questionnaire_16_1_2 = $this->createSubquestion("QRU", $questionnaire_16_1, "");
        $questionnaire_16_1_3 = $this->createSubquestion("QRU", $questionnaire_16_1, "");
        $questionnaire_16_1_4 = $this->createSubquestion("QRU", $questionnaire_16_1, "");
        // CREATION PROPOSITIONS
        $questionnaire_16_1_1_1 = $this->createProposition("1.1. lo faranno", false, $questionnaire_16_1_1);
        $questionnaire_16_1_1_2 = $this->createProposition("1.2. l'hanno fatto", true, $questionnaire_16_1_1);
        $questionnaire_16_1_1_3 = $this->createProposition("1.3. lo facevano", false, $questionnaire_16_1_1);

        $questionnaire_16_1_2_1 = $this->createProposition("2.1. sia", true, $questionnaire_16_1_2);
        $questionnaire_16_1_2_2 = $this->createProposition("2.2. è", false, $questionnaire_16_1_2);
        $questionnaire_16_1_2_3 = $this->createProposition("2.3. sarà", false, $questionnaire_16_1_2);

        $questionnaire_16_1_3_1 = $this->createProposition("3.1. offra", true, $questionnaire_16_1_3);
        $questionnaire_16_1_3_2 = $this->createProposition("3.2. offre", false, $questionnaire_16_1_3);
        $questionnaire_16_1_3_3 = $this->createProposition("3.3. abbia offerto", false, $questionnaire_16_1_3);

        $questionnaire_16_1_4_1 = $this->createProposition("4.1. permetta", true, $questionnaire_16_1_4);
        $questionnaire_16_1_4_2 = $this->createProposition("4.2. permette", false, $questionnaire_16_1_4);
        $questionnaire_16_1_4_3 = $this->createProposition("4.3. ha permesso", false, $questionnaire_16_1_4);


        /*******************************************
                    QUESTIONNAIRE 17 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_27 = $this->createQuestionnaire("B1_CE_recette_cuisine", "B1", "CE", $test);
        $questionnaire_27->setMediaInstruction($this->mediaText("", "Completa il testo usando le parole suggerite", ""));
        $questionnaire_27->setMediaContext($this->mediaText("", "Ricetta su una rivista di cucina", ""));
        $questionnaire_27->setMediaText($this->mediaText($startTitle . "Lasagne ai carciofi" . $endTitle,
        "***Ingredienti***:
500 gr di Lasagne
500 gr carciofi
50 gr di burro
500 gr di latte intero
150 gr di farina
100 gr di parmigiano
250 gr di mozzarella
10 cl di vino bianco

***Procedimento***:
Prima di tutto è necessario preparare la besciamella. Mettere in una pentola il burro e quando **1.**_________________ aggiungere la farina e mescolare. Quando **2.**_______________________ un composto omogeneo aggiungete lentamente il latte, che **3.**____________________________ precedentemente.
Aggiungete un pizzico di sale e spegnete il fuoco.
Pulite e tagliate finemente i carciofi e metteteli a cuocere in una padella con un filo d’olio e un po’ di vino bianco. Quando il vino 4.________________________ mettete i carciofi su un piatto e accendete  il forno a 180°.
Imburrate una teglia da forno e disponete la pasta, i carciofi, la besciamella e il formaggio, formando degli strati. Quando il forno sarà caldo e 5.________________________ la teglia, infornatela per 45 minuti.
", ""
));
        // CREATION QUESTION
        $questionnaire_27_1 = $this->createQuestion("TQRU", $questionnaire_27);
        // CREATION SUBQUESTION
        $questionnaire_27_1_1 = $this->createSubquestion("QRU", $questionnaire_27_1, "");
        $questionnaire_27_1_2 = $this->createSubquestion("QRU", $questionnaire_27_1, "");
        $questionnaire_27_1_3 = $this->createSubquestion("QRU", $questionnaire_27_1, "");
        $questionnaire_27_1_4 = $this->createSubquestion("QRU", $questionnaire_27_1, "");
        $questionnaire_27_1_5 = $this->createSubquestion("QRU", $questionnaire_27_1, "");

        // CREATION PROPOSITIONS
        $questionnaire_27_1_1_1 = $this->createProposition("1.1. sarà sciolto", true, $questionnaire_27_1_1);
        $questionnaire_27_1_1_2 = $this->createProposition("1.2. sarebbe sciolto", false, $questionnaire_27_1_1);
        $questionnaire_27_1_1_3 = $this->createProposition("1.3. scioglierà", false, $questionnaire_27_1_1);

        $questionnaire_27_1_2_1 = $this->createProposition("2.1. avrete ottenuto", true, $questionnaire_27_1_2);
        $questionnaire_27_1_2_2 = $this->createProposition("2.2. avrebbe ottenuto", false, $questionnaire_27_1_2);
        $questionnaire_27_1_2_3 = $this->createProposition("2.3. otterrà", false, $questionnaire_27_1_2);

        $questionnaire_27_1_3_1 = $this->createProposition("3.1. 1. avrete scaldato ", true, $questionnaire_27_1_3);
        $questionnaire_27_1_3_2 = $this->createProposition("3.2. avrebbe scaldato", false, $questionnaire_27_1_3);
        $questionnaire_27_1_3_3 = $this->createProposition("3.3. avreste scaldato", false, $questionnaire_27_1_3);

        $questionnaire_27_1_4_1 = $this->createProposition("4.1. sarà evaporato ", true, $questionnaire_27_1_4);
        $questionnaire_27_1_4_2 = $this->createProposition("4.2. sarebbe evaporato", false, $questionnaire_27_1_4);
        $questionnaire_27_1_4_3 = $this->createProposition("4.3. evaporerà", false, $questionnaire_27_1_4);

        $questionnaire_27_1_5_1 = $this->createProposition("5.1. avrete riempito", true, $questionnaire_27_1_5);
        $questionnaire_27_1_5_2 = $this->createProposition("5.2. avrebbe riempito", false, $questionnaire_27_1_5);
        $questionnaire_27_1_5_3 = $this->createProposition("5.3. avreste riempito", false, $questionnaire_27_1_5);


        /*******************************************
                    QUESTIONNAIRE 18 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_18 = $this->createQuestionnaire("B1_CE_critique_restaurant", "B1", "CE", $test);
        $questionnaire_18->setMediaInstruction($this->mediaText("", "Completa il testo usando le parole suggerite", ""));
        $questionnaire_18->setMediaContext($this->mediaText("", "Recensione di un ristorante su un sito internet", ""));
        $questionnaire_18->setMediaText($this->mediaText("", "Ieri sera ho cenato con la mia ragazza al Ristorante La Lanterna. Il locale è arredato in modo veramente chic, 1.________________ il servizio non è dei migliori.  2.__________________ me lo avessero consigliato non sono rimasto molto soddisfatto: la presentazione dei piatti era poco curata e 3.______________ abbiamo dovuto aspettare mezz’ora prima di mangiare. 4._________________ avevamo mangiato presto a pranzo e nel frattempo siamo morti di fame. 5.___________________, poi abbiamo preso anche il dolce che, devo dire, era davvero ottimo.", ""));
        // CREATION QUESTION
        $questionnaire_18_1 = $this->createQuestion("TQRU", $questionnaire_18);
        // CREATION SUBQUESTION
        $questionnaire_18_1_1 = $this->createSubquestion("QRU", $questionnaire_18_1, "");
        $questionnaire_18_1_2 = $this->createSubquestion("QRU", $questionnaire_18_1, "");
        $questionnaire_18_1_3 = $this->createSubquestion("QRU", $questionnaire_18_1, "");
        $questionnaire_18_1_4 = $this->createSubquestion("QRU", $questionnaire_18_1, "");
        $questionnaire_18_1_5 = $this->createSubquestion("QRU", $questionnaire_18_1, "");

        // CREATION PROPOSITIONS
        $questionnaire_18_1_1_1 = $this->createProposition("1.1. infatti", false, $questionnaire_18_1_1);
        $questionnaire_18_1_1_2 = $this->createProposition("1.2. inoltre", false, $questionnaire_18_1_1);
        $questionnaire_18_1_1_3 = $this->createProposition("1.3. anche se", true, $questionnaire_18_1_1);

        $questionnaire_18_1_2_1 = $this->createProposition("2.1. nonostante", true, $questionnaire_18_1_2);
        $questionnaire_18_1_2_2 = $this->createProposition("2.2. comunque", false, $questionnaire_18_1_2);
        $questionnaire_18_1_2_3 = $this->createProposition("2.3. però", false, $questionnaire_18_1_2);

        $questionnaire_18_1_3_1 = $this->createProposition("3.1. inoltre", true, $questionnaire_18_1_3);
        $questionnaire_18_1_3_2 = $this->createProposition("3.2. dunque", false, $questionnaire_18_1_3);
        $questionnaire_18_1_3_3 = $this->createProposition("3.3. quindi", false, $questionnaire_18_1_3);

        $questionnaire_18_1_4_1 = $this->createProposition("4.1. purtroppo", true, $questionnaire_18_1_4);
        $questionnaire_18_1_4_2 = $this->createProposition("4.2. ma", false, $questionnaire_18_1_4);
        $questionnaire_18_1_4_3 = $this->createProposition("4.3. eppure", false, $questionnaire_18_1_4);

        $questionnaire_18_1_5_1 = $this->createProposition("5.1. infatti", true, $questionnaire_18_1_5);
        $questionnaire_18_1_5_2 = $this->createProposition("5.2. oppure", false, $questionnaire_18_1_5);
        $questionnaire_18_1_5_3 = $this->createProposition("5.3. sebbene", false, $questionnaire_18_1_5);

        /*******************************************
                    QUESTIONNAIRE 21 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_21 = $this->createQuestionnaire("B1_CE_stage_etranger", "B1", "CE", $test);
        $questionnaire_21->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere o false", ""));
        $questionnaire_21->setMediaContext($this->mediaText("", "Articolo su sito internet", ""));
        $questionnaire_21->setMediaText($this->mediaText($startTitle . "Stage all’estero" . $endTitle, "Un tirocinio all’estero prevede  un periodo di tempo da trascorrere in un’azienda o in un'istituzione, allo scopo di iniziare la propria formazione professionale. È un rapporto flessibile, regolato da leggi ministeriali, la cui durata varia per tipologia. Un tirocinio all'estero è un'occasione per chi vuole cominciare a muoversi in un contesto internazionale e aprirsi a nuove prospettive. Una volta terminato, l’esperienza sarà certificata da un attestato che acquisterà valore di credito formativo e che potrai annotare sul tuo curriculum.", ""));
        // CREATION QUESTION
        $questionnaire_21_1 = $this->createQuestion("TVF", $questionnaire_21);
        // CREATION SUBQUESTION
        //$questionnaire_21_1_1 = $this->createSubquestion("QRM", $questionnaire_21_1, "");
        // CREATION PROPOSITIONS
        //$questionnaire_21_1_1_1 = $this->createProposition("Il tirocinio all’estero è un’opportunità per cominciare la propria esperienza lavorativa in un contesto internazionale", true, $questionnaire_21_1_1);
        //$questionnaire_21_1_1_2 = $this->createProposition("I tirocini all’estero hanno sempre la stessa durata, in ogni settore lavorativo ", false, $questionnaire_21_1_1);
        //$questionnaire_21_1_1_3 = $this->createProposition("Il tirocinio all’estero consente di accumulare crediti universitari per il piano di studio", false, $questionnaire_21_1_1);

        // CREATION SUBQUESTION
        $questionnaire_21_1_1 = $this->createSubquestionVF("VF", $questionnaire_21_1, "", "Il tirocinio all’estero è un’opportunità per cominciare la propria esperienza lavorativa in un contesto internazionale");
        $questionnaire_21_1_2 = $this->createSubquestionVF("VF", $questionnaire_21_1, "", "I tirocini all’estero hanno sempre la stessa durata, in ogni settore lavorativo");
        $questionnaire_21_1_3 = $this->createSubquestionVF("VF", $questionnaire_21_1, "", "Il tirocinio all’estero consente di accumulare crediti universitari per il piano di studio");

        // CREATION PROPOSITIONS
        $questionnaire_21_1_1_1 = $this->createPropositionVF("", "VRAI", true, $questionnaire_21_1_1);
        $questionnaire_21_1_1_1 = $this->createPropositionVF("", "FAUX", false, $questionnaire_21_1_1);

        $questionnaire_21_1_1_2 = $this->createPropositionVF("", "VRAI", false, $questionnaire_21_1_2);
        $questionnaire_21_1_1_2 = $this->createPropositionVF("", "FAUX", true, $questionnaire_21_1_2);

        $questionnaire_21_1_1_3 = $this->createPropositionVF("", "VRAI", false, $questionnaire_21_1_3);
        $questionnaire_21_1_1_3 = $this->createPropositionVF("", "FAUX", true, $questionnaire_21_1_3);



        /*******************************************
                    QUESTIONNAIRE 22 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_22 = $this->createQuestionnaire("B1_CE_sauvegarde_forets", "B1", "CE", $test);
        $questionnaire_22->setMediaInstruction($this->mediaText("", "Completa il testo usando le parole suggerite", ""));
        $questionnaire_22->setMediaContext($this->mediaText("", "Articolo su sito internet", ""));
        $questionnaire_22->setMediaText($this->mediaText($startTitle . "Come possiamo salvare le foreste pluviali?" . $endTitle, "Le foreste amazzoniche stanno scomparendo molto velocemente a causa della grande produzione di olio di palma. La buona notizia però è che sempre più persone sono sensibilizzate alla salvaguardia delle foreste. La brutta notizia invece sta nel fatto che difendere le foreste non è poi così facile. Bisognerebbe avere l'aiuto e la cooperazione di molti per poter difendere le foreste e la vita animale affinché i nostri figli possano goderne un giorno.", ""));
        // CREATION QUESTION
        $questionnaire_22_1 = $this->createQuestion("TQRU", $questionnaire_22);
        // CREATION SUBQUESTION
        $questionnaire_22_1_1 = $this->createSubquestion("QRU", $questionnaire_22_1, "");
        $questionnaire_22_1_2 = $this->createSubquestion("QRU", $questionnaire_22_1, "");
        $questionnaire_22_1_3 = $this->createSubquestion("QRU", $questionnaire_22_1, "");
        // CREATION PROPOSITIONS
        $questionnaire_22_1_1_1 = $this->createProposition("1.1. Però", true, $questionnaire_22_1_1);
        $questionnaire_22_1_1_2 = $this->createProposition("1.2. nonostante", false, $questionnaire_22_1_1);
        $questionnaire_22_1_1_3 = $this->createProposition("1.3. quindi", false, $questionnaire_22_1_1);

        $questionnaire_22_1_2_1 = $this->createProposition("2.1. invece", true, $questionnaire_22_1_2);
        $questionnaire_22_1_2_2 = $this->createProposition("2.2. nemmeno ", false, $questionnaire_22_1_2);
        $questionnaire_22_1_2_3 = $this->createProposition("2.3. anche", false, $questionnaire_22_1_2);

        $questionnaire_22_1_3_1 = $this->createProposition("3.1. affiché", true, $questionnaire_22_1_3);
        $questionnaire_22_1_3_2 = $this->createProposition("3.2. dunque", false, $questionnaire_22_1_3);
        $questionnaire_22_1_3_3 = $this->createProposition("3.3. perciò", false, $questionnaire_22_1_3);

        /*******************************************
                    QUESTIONNAIRE 23 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_23 = $this->createQuestionnaire("B1_CE_unicef", "B1", "CE", $test);
        $questionnaire_23->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere o false", ""));
        $questionnaire_23->setMediaContext($this->mediaText("", "Articolo su internet", ""));
        $questionnaire_23->setMediaText($this->mediaText($startTitle . "Diventa Volontario. Dai anche tu un prezioso contributo per salvare la vita di un bambino." . $endTitle,
"Le principali attività dei volontari sono orientate alla promozione dei diritti dell'infanzia in Italia e alla realizzazione a livello territoriale delle campagne UNICEF a sostegno dei programmi nei Paesi in via di sviluppo.@@@
Contattando il Comitato UNICEF della tua città (ce ne sono 110, uno per ogni Provincia italiana) puoi impegnarti nei nostri \"eventi di piazza\" nazionali e in tutte le altre iniziative locali di raccolta fondi e di sensibilizzazione sui diritti dell'infanzia.@@@
Se hai tra 14 e 30 anni, puoi entrare a far parte di ***Younicef***, il movimento di volontariato giovanile dell'UNICEF Italia, attivo in ogni parte del Paese.
", ""));
        // CREATION QUESTION
        $questionnaire_23_1 = $this->createQuestion("TVF", $questionnaire_23);
        // CREATION SUBQUESTION
        //$questionnaire_23_1_1 = $this->createSubquestion("QRM", $questionnaire_23_1, "");
        // CREATION PROPOSITIONS
        //$questionnaire_23_1_1_1 = $this->createProposition("Il volontario Unicef svolge la sua azione unicamente nei paesi in via di sviluppo", false, $questionnaire_23_1_1);
        //$questionnaire_23_1_1_2 = $this->createProposition("I volontari Unicef sono impiegati nella raccolta di denaro per finanziare i progetti", true, $questionnaire_23_1_1);
        //$questionnaire_23_1_1_3 = $this->createProposition("***Younicef*** accoglie tra i suoi volontari persone di tutte le età", false, $questionnaire_23_1_1);

        // CREATION SUBQUESTION
        $questionnaire_23_1_1 = $this->createSubquestionVF("VF", $questionnaire_23_1, "", "Il volontario Unicef svolge la sua azione unicamente nei paesi in via di sviluppo");
        $questionnaire_23_1_2 = $this->createSubquestionVF("VF", $questionnaire_23_1, "", "I volontari Unicef sono impiegati nella raccolta di denaro per finanziare i progetti");
        $questionnaire_23_1_3 = $this->createSubquestionVF("VF", $questionnaire_23_1, "", "***Younicef*** accoglie tra i suoi volontari persone di tutte le età");

        // CREATION PROPOSITIONS
        $questionnaire_23_1_1_1 = $this->createPropositionVF("", "VRAI", false, $questionnaire_23_1_1);
        $questionnaire_23_1_1_1 = $this->createPropositionVF("", "FAUX", true, $questionnaire_23_1_1);

        $questionnaire_23_1_1_2 = $this->createPropositionVF("", "VRAI", true, $questionnaire_23_1_2);
        $questionnaire_23_1_1_2 = $this->createPropositionVF("", "FAUX", false, $questionnaire_23_1_2);

        $questionnaire_23_1_1_3 = $this->createPropositionVF("", "VRAI", false, $questionnaire_23_1_3);
        $questionnaire_23_1_1_3 = $this->createPropositionVF("", "FAUX", true, $questionnaire_23_1_3);

        /*******************************************
                    QUESTIONNAIRE 24 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_24 = $this->createQuestionnaire("B1_CE_lecture", "B1", "CE", $test);
        $questionnaire_24->setMediaInstruction($this->mediaText("", "Seleziona il riassunto corretto", ""));
        $questionnaire_24->setMediaContext($this->mediaText("", "Articolo su internet", ""));
        $questionnaire_24->setMediaText($this->mediaText($startTitle . "L’importanza della lettura : partiamo dai classici." . $endTitle,
        "Leggere significa appropriarsi delle esperienze di migliaia di personaggi immaginari e farne tesoro; le esperienze acquisite saranno utili per affrontare le disavventure della vita. Le mille asperità che ogni adolescente si trova a sostenere sono le stesse che i protagonisti dei grandi romanzi di formazione si trovano a fronteggiare L'amore perduto, l'odio, la vendetta, la rabbia e il senso d'impotenza possono indebolire un giovane ancora fragile, per questo avere interiorizzato decine, centinaia di esperienze simili, certo di personaggi immaginari, può essere utile e può fare la differenza.", ""));

        // CREATION QUESTION
        $questionnaire_24_1 = $this->createQuestion("TQRU", $questionnaire_24);
        // CREATION SUBQUESTION
        $questionnaire_24_1_1 = $this->createSubquestion("QRU", $questionnaire_24_1, "");
        // CREATION PROPOSITIONS
        $questionnaire_24_1_1_1 = $this->createProposition("Leggere i grandi romanzi aiuta i giovani a non sentirsi soli nelle disavventure della vita, poiché i problemi affrontati dai protagonisti della letteratura sono simili a quelli degli adolescenti del giorno d’oggi.", true, $questionnaire_24_1_1);
        $questionnaire_24_1_1_2 = $this->createProposition("I romanzi di formazione raccontano tutte le tappe della vita, per questo, leggerli può aiutare i personaggi immaginari a affrontare i momento più complessi della vita.", false, $questionnaire_24_1_1);
        $questionnaire_24_1_1_3 = $this->createProposition("I romanzi di formazione raccontando l’amore, l’odio, la rabbia ed altri sentimenti, indeboliscono l’animo degli adolescenti che purtroppo è già fragile.", false, $questionnaire_24_1_1);

        /*******************************************
                    QUESTIONNAIRE 25 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_25 = $this->createQuestionnaire("B1_CE_mail_travail", "B1", "CE", $test);
        $questionnaire_25->setMediaInstruction($this->mediaText("", "Completa il testo usando le parole suggerite", ""));
        $questionnaire_25->setMediaContext($this->mediaText("", "Mail di lavoro", ""));
        $questionnaire_25->setMediaText($this->mediaText("", "Gentile Direttore,
Le scrivo in merito alla riunione che si è svolta questa mattina con i colleghi dell’ufficio di Boston. Il manager del gruppo è molto ottimista sul progetto, 1.________ a mio parere non ha valutato tutte le conseguenze. Non abbiamo avuto tempo per discutere i dettagli ma, 2.___________, la sua strategia è chiara. Vorrebbe spingerci a promuovere il prodotto adesso sul mercato americano. Dobbiamo  3.______________ tenere presente che questa decisione comporta dei rischi : se 4. ____________ la sua proposta è interessante date le possibilità di guadagno elevate, 5. ________ mi sembra che a livello di costi sia finanziariamente inaccettabile.@@@
Tutti i dettagli della riunione sono presenti in allegato.@@@
Buona giornata@@@
Dott.ssa Angela Pitti
", ""));
        // CREATION QUESTION
        $questionnaire_25_1 = $this->createQuestion("TQRU", $questionnaire_25);
        // CREATION SUBQUESTION
        $questionnaire_25_1_1 = $this->createSubquestion("QRU", $questionnaire_25_1, "");
        $questionnaire_25_1_2 = $this->createSubquestion("QRU", $questionnaire_25_1, "");
        $questionnaire_25_1_3 = $this->createSubquestion("QRU", $questionnaire_25_1, "");
        $questionnaire_25_1_4 = $this->createSubquestion("QRU", $questionnaire_25_1, "");
        $questionnaire_25_1_5 = $this->createSubquestion("QRU", $questionnaire_25_1, "");
        // CREATION PROPOSITIONS
        $questionnaire_25_1_1_1 = $this->createProposition("1.1. però", true, $questionnaire_25_1_1);
        $questionnaire_25_1_1_2 = $this->createProposition("1.2. infatti", false, $questionnaire_25_1_1);
        $questionnaire_25_1_1_3 = $this->createProposition("1.3. inoltre", false, $questionnaire_25_1_1);

        $questionnaire_25_1_2_1 = $this->createProposition("2.1. ma", true, $questionnaire_25_1_2);
        $questionnaire_25_1_2_2 = $this->createProposition("2.2. di conseguenza", false, $questionnaire_25_1_2);
        $questionnaire_25_1_2_3 = $this->createProposition("2.3. in particolare", false, $questionnaire_25_1_2);

        $questionnaire_25_1_3_1 = $this->createProposition("3.1. tuttavia", true, $questionnaire_25_1_3);
        $questionnaire_25_1_3_2 = $this->createProposition("3.2. sebbene", false, $questionnaire_25_1_3);
        $questionnaire_25_1_3_3 = $this->createProposition("3.3. come", false, $questionnaire_25_1_3);

        $questionnaire_25_1_4_1 = $this->createProposition("4.1. da un lato", true, $questionnaire_25_1_4);
        $questionnaire_25_1_4_2 = $this->createProposition("4.2. anzi", false, $questionnaire_25_1_4);
        $questionnaire_25_1_4_3 = $this->createProposition("4.3. qualora", false, $questionnaire_25_1_4);

        $questionnaire_25_1_5_1 = $this->createProposition("5.1. dall'altro", true, $questionnaire_25_1_5);
        $questionnaire_25_1_5_2 = $this->createProposition("5.2. perché", false, $questionnaire_25_1_5);
        $questionnaire_25_1_3_3 = $this->createProposition("5.3. quindi", false, $questionnaire_25_1_5);

        /*******************************************
                    QUESTIONNAIRE 26 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_26 = $this->createQuestionnaire("B1_CE_lettre_reclamation", "B1", "CE", $test);
        $questionnaire_26->setMediaInstruction($this->mediaText("", "Completa il testo usando le parole suggerite", ""));
        $questionnaire_26->setMediaContext($this->mediaText("", "Mail di reclamo", ""));
        $questionnaire_26->setMediaText($this->mediaText("",
        "Gentile Responsabile del Servizio Clienti,@@@Le scrivo 1. ______________  all’offerta vacanze  \"Sole, mare e relax a Cefalonia\" della durata di una settimana che ho acquistato sul vostro sito internet.
Non sono per niente soddisfatto del vostro servizio. Sul sito internet l’hotel era descritto come un’oasi di pace, ma 2. ____________ era situato vicino ad una discoteca.
3. _______________, nel pacchetto si parlava di un ristorante di pesce molto famoso, che a dire il V era di bassa qualità.
Trovo scandaloso che un’azienda come la vostra non solo venda dei servizi che poi non offre, ma che prenda in giro i suoi clienti.4. _______________ sconsiglierò la vostra agenzia a tutte le persone che conosco.@@@
Cordiali saluti,@@@Gianni Rossi
", ""));
        // CREATION QUESTION
        $questionnaire_26_1 = $this->createQuestion("TQRU", $questionnaire_26);
        // CREATION SUBQUESTION
        $questionnaire_26_1_1 = $this->createSubquestion("QRU", $questionnaire_26_1, "");
        $questionnaire_26_1_2 = $this->createSubquestion("QRU", $questionnaire_26_1, "");
        $questionnaire_26_1_3 = $this->createSubquestion("QRU", $questionnaire_26_1, "");
        $questionnaire_26_1_4 = $this->createSubquestion("QRU", $questionnaire_26_1, "");

        // CREATION PROPOSITIONS
        $questionnaire_26_1_1_1 = $this->createProposition("1.1. in merito", true, $questionnaire_26_1_1);
        $questionnaire_26_1_1_2 = $this->createProposition("1.2. a proposito", false, $questionnaire_26_1_1);
        $questionnaire_26_1_1_3 = $this->createProposition("1.3. circa", false, $questionnaire_26_1_1);

        $questionnaire_26_1_2_1 = $this->createProposition("2.1. in realtà", true, $questionnaire_26_1_2);
        $questionnaire_26_1_2_2 = $this->createProposition("2.2. dunque", false, $questionnaire_26_1_2);
        $questionnaire_26_1_2_3 = $this->createProposition("2.3. comunque", false, $questionnaire_26_1_2);

        $questionnaire_26_1_3_1 = $this->createProposition("3.1. inoltre", true, $questionnaire_26_1_3);
        $questionnaire_26_1_3_2 = $this->createProposition("3.2. al contrario", false, $questionnaire_26_1_3);
        $questionnaire_26_1_3_3 = $this->createProposition("3.3. poiché", false, $questionnaire_26_1_3);

        $questionnaire_26_1_4_1 = $this->createProposition("4.1. per questo", true, $questionnaire_26_1_4);
        $questionnaire_26_1_4_2 = $this->createProposition("4.2. in realtà", false, $questionnaire_26_1_4);
        $questionnaire_26_1_4_3 = $this->createProposition("4.3. in alternativa", false, $questionnaire_26_1_4);


        /*******************************************
                    QUESTIONNAIRE 27 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_27 = $this->createQuestionnaire("B1_CE_diner_ciel", "B1", "CE", $test);
        $questionnaire_27->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere o false", ""));
        $questionnaire_27->setMediaContext($this->mediaText("", "Articolo da blog", ""));
        $questionnaire_27->setMediaText($this->mediaText($startTitle . "***Cene in Cielo***" . $endTitle, "Talvolta a rendere speciale la cena non sono né gli ingredienti né l’abilità del cuoco, ma l’insolito panorama di cui potrete godere mentre cenate  sospesi a 50 metri d’altezza.
Se siete tra coloro che non temono l’avventura ma anzi più di qualsiasi cosa detestano la solita routine quotidiana e soprattutto non soffrite di vertigini, potreste cenare nel vuoto a circa 50 metri d’altezza, sullo sfondo di splendidi panorami.@@@
Ad offrire questo insolito servizio è ***Cene In Cielo***, società specializzata nell’organizzazione di cene, aperitivi e feste a bordo di una piattaforma che, insieme a chef, camerieri ed ospiti, viene sollevata ad altezze adrenaliniche. Sia chiaro, la cena è ad alto tasso di divertimento ma a rischio zero: gli ospiti cenano attaccati alle proprie sedie protetti dalle cinture di sicurezza e anche il personale, assicurato a delle corde, lavora in tutta tranquillità.
", ""));
        // CREATION QUESTION
        $questionnaire_27_1 = $this->createQuestion("TVF", $questionnaire_27);
        // CREATION SUBQUESTION
        //$questionnaire_17_1_1 = $this->createSubquestion("QRM", $questionnaire_17_1, "");
        // CREATION PROPOSITIONS
        //$questionnaire_17_1_1_1 = $this->createProposition("***Cene in cielo*** propone delle serate speciali in ristoranti dove cuochi di alto livello promuovono ingredienti di alta qualità", false, $questionnaire_17_1_1);
        //$questionnaire_17_1_1_2 = $this->createProposition("Il servizio proposto è adatto anche alle persone che soffrono di vertigini", false, $questionnaire_17_1_1);
        //$questionnaire_17_1_1_3 = $this->createProposition("Gli eventi proposti avvengono sempre nel massimo della sicurezza per il cliente e per i dipendenti dell’organizzazione", true, $questionnaire_17_1_1);

        // CREATION SUBQUESTION
        $questionnaire_27_1_1 = $this->createSubquestionVF("VF", $questionnaire_27_1, "", "***Cene in cielo*** propone delle serate speciali in ristoranti dove cuochi di alto livello promuovono ingredienti di alta qualità");
        $questionnaire_27_1_2 = $this->createSubquestionVF("VF", $questionnaire_27_1, "", "Il servizio proposto è adatto anche alle persone che soffrono di vertigini");
        $questionnaire_27_1_3 = $this->createSubquestionVF("VF", $questionnaire_27_1, "", "Gli eventi proposti avvengono sempre nel massimo della sicurezza per il cliente e per i dipendenti dell’organizzazione");

        // CREATION PROPOSITIONS
        $questionnaire_27_1_1_1 = $this->createPropositionVF("", "VRAI", false, $questionnaire_27_1_1);
        $questionnaire_27_1_1_1 = $this->createPropositionVF("", "FAUX", true, $questionnaire_27_1_1);

        $questionnaire_27_1_1_2 = $this->createPropositionVF("", "VRAI", false, $questionnaire_27_1_2);
        $questionnaire_27_1_1_2 = $this->createPropositionVF("", "FAUX", true, $questionnaire_27_1_2);

        $questionnaire_27_1_1_3 = $this->createPropositionVF("", "VRAI", true, $questionnaire_27_1_3);
        $questionnaire_27_1_1_3 = $this->createPropositionVF("", "FAUX", false, $questionnaire_27_1_3);



        /*******************************************
                    QUESTIONNAIRE 28 : QRM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_28 = $this->createQuestionnaire("B1_CE_reglement_gym", "B1", "CE", $test);
        $questionnaire_28->setMediaInstruction($this->mediaText("", "Tre informazioni sono presenti nel testo. Quali?", ""));
        $questionnaire_28->setMediaContext($this->mediaText("", "Regolamento", ""));
        $questionnaire_28->setMediaText($this->mediaText($startTitle . "Regolamento palestra Body Club" . $endTitle, "Nella frequentazione della palestra Body club è vietato:@@@
- lasciare durante o alla fine dell’allenamento, bottiglie varie e  rifiuti nei locali della palestra;@@@
- accedere ai locali della palestra con scarpe indossate all’esterno;@@@
- fumare all’interno dei locali della palestra, negli spogliatoi e nei servizi igienici;@@@
- introdurre e consumare bevande alcoliche all’interno della palestra, negli spogliatoi e nei servizi igienici;@@@
- far uso di sostanze ritenute dopanti ai sensi delle norme riconosciute in Italia e introdurle in palestra;@@@
- lasciare uscire i bambini dallo spazio a loro dedicato e circolare nella palestra;@@@
- disturbare ed intralciare nell’allenamento gli altri utenti con il proprio comportamento;@@@
- introdurre ogni tipo di animale nei locali della palestra, negli spogliatoi e nei servizi igienici;@@@
- l’ingresso in palestra senza aver obliterato la tessera personale.@@@
", ""));
        // CREATION QUESTION
        $questionnaire_28_1 = $this->createQuestion("QRM", $questionnaire_28);
        // CREATION SUBQUESTION
        $questionnaire_28_1_1 = $this->createSubquestion("QRM", $questionnaire_28_1, "");
        // CREATION PROPOSITIONS
        $questionnaire_28_1_1_1 = $this->createProposition("All’interno della palestra non è permesso mangiare", false, $questionnaire_28_1_1);
        $questionnaire_28_1_1_2 = $this->createProposition("L’ingresso agli animali è vietato nei locali della palestra", true, $questionnaire_28_1_1);
        $questionnaire_28_1_1_3 = $this->createProposition("Per accedere ai locali della palestra è obbligatorio  timbrare la tessera", true, $questionnaire_28_1_1);
        $questionnaire_28_1_1_4 = $this->createProposition("L’accesso ai locali della palestra è consentito solo con scarpe con suola di gomma", false, $questionnaire_28_1_1);
        $questionnaire_28_1_1_5 = $this->createProposition("I bambini possono utilizzare la palestra ma solo negli spazi previsti", true, $questionnaire_28_1_1);


        /*******************************************
                    MISE EN BASE
        ********************************************/
        $em->flush();

        $output->writeln("Fixtures Italian CE B1 exécutées.");


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
