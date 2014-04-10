<?php

namespace Innova\SelfBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
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
            ->setDescription('SELF CE Italien B1 Pilote 2')
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
        $test = $this->createTest("Italien b1", "Italian");

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
        $questionnaire_3 = $this->createQuestionnaire("B1_CE_vacance_croisiere", "B1", "CE", $test, 0);
        $questionnaire_3->setOriginText("Une ou plusieurs réponses correctes");
        $questionnaire_3->setMediaInstruction($this->mediaText("", "Quali informazioni sono presenti nel testo?", ""));
        $questionnaire_3->setMediaContext($this->mediaText("", "Pubblicità in agenzia di viaggi", ""));
        $questionnaire_3->setMediaText($this->mediaText($startTitle . "Partire con ***Crociere nel Mondo***" . $endTitle, "Sempre più persone scelgono ogni anno di trascorrere le proprie vacanze con ***Crociere nel Mondo***; se deciderai di unirti a noi, capirai subito il perché.@@@Il comfort e l’eccezionale servizio della nostra nave saprà come sorprenderti: ti innamorerai delle meravigliose SPA, degli spettacoli, dell’intrattenimento a bordo, dei numerosi sport che potrai praticare e delle delizie della nostra cucina. Apprezzerai anche il modo  in cui sappiamo intrattenere gli ospiti di tutte le età, ad un prezzo che continuerà a farti sorridere. Prova l’esperienza di un viaggio con noi, non vorrai più tornare a casa.", ""));
        // CREATION QUESTION
        $questionnaire_3_1 = $this->createQuestion("QRM", $questionnaire_3);
        // CREATION SUBQUESTION
        $questionnaire_3_1_1 = $this->createSubquestion("QRM", $questionnaire_3_1, "");
        // CREATION PROPOSITIONS
        $this->createProposition("Con ***Crociere nel Mondo*** puoi continuare a fare gli sport che ti piacciono anche in vacanza", true, $questionnaire_3_1_1);
        $this->createProposition("Il punto di forza dell’azienda è la capacità di offrire servizi per tutte le esigenze", true, $questionnaire_3_1_1);
        $this->createProposition("Alcune offerte molto convenienti stanno per scadere", false, $questionnaire_3_1_1);

        /*******************************************
                    QUESTIONNAIRE 6 : QRM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_6 = $this->createQuestionnaire("B1_CE_annonce_immobilier", "B1", "CE", $test, 0);
        $questionnaire_6->setOriginText("Une ou plusieurs réponses correctes");
        $questionnaire_6->setMediaInstruction($this->mediaText("", "Quali informazioni sono presenti nel testo?", ""));
        $questionnaire_6->setMediaContext($this->mediaText("", "Annuncio immobiliare", ""));
        $questionnaire_6->setMediaText($this->mediaText($startTitle . "Affittasi appartamento al Marina Village" . $endTitle, "All'interno del Marina Village, vera oasi di pace sul trasparente mare Ionio, proponiamo in affitto splendido appartamento con 6 posti letto, climatizzato e finemente arredato composto da un ampio soggiorno con zona cottura, un bagno e un ampio balcone con una splendida vista sul mare. La cura dei dettagli ed il contesto donano alla casa un tocco di stile ed un'eleganza esclusiva. Il villaggio turistico offre intrattenimento serale per tutti. La spiaggia privata è raggiungibile solo attraverso un breve percorso a piedi o in bicicletta.", ""));
        // CREATION QUESTION
        $questionnaire_6_1 = $this->createQuestion("QRM", $questionnaire_6);
        // CREATION SUBQUESTION
        $questionnaire_6_1_1 = $this->createSubquestion("QRM", $questionnaire_6_1, "");
        // CREATION PROPOSITIONS
        $this->createProposition("Al villaggio turistico Marina Village propongono animazione serale", true, $questionnaire_6_1_1);
        $this->createProposition("L’appartamento dispone di 5 camere da letto", false, $questionnaire_6_1_1);
        $this->createProposition("Il terrazzo è arredato con ombrelloni e sdraio", false, $questionnaire_6_1_1);
        $this->createProposition("La spiaggia privata non è raggiungibile da veicoli a motore", true, $questionnaire_6_1_1);

        /*******************************************
                    QUESTIONNAIRE 8 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_8 = $this->createQuestionnaire("B1_CE_evenements_rome", "B1", "CE", $test, 0);
        $questionnaire_8->setOriginText("");
        $questionnaire_8->setMediaInstruction($this->mediaText("", "L'annuncio promuove:", ""));
        $questionnaire_8->setMediaContext($this->mediaText("", "Articolo su sito internet", ""));
        $questionnaire_8->setMediaText(
        $this->mediaText($startTitle .
            "Torna il festival più amato dell'estate romana" . $endTitle,
            "Arriva l’estate e ricomincia la stagione d’eventi proposta come ogni anno dall’associazione ***Fiesta***. Nelle calde estati romane, l’associazione promuove il Festival Internazionale di Musica e Cultura Latino Americana. Gli eventi si terranno da giugno a settembre e  il calendario è già disponible sul sito www.fiesta.it per prenotazioni. Come ogni anno gli spettacoli si terranno nello splendido Parco Rosati.@@@Adattato da: www.fiesta.it",
            ""));
        // CREATION QUESTION
        $questionnaire_8_1 = $this->createQuestion("QRU", $questionnaire_8);
        // CREATION SUBQUESTION
        $questionnaire_8_1_1 = $this->createSubquestion("QRU", $questionnaire_8_1, "");
        // CREATION PROPOSITIONS
        $this->createProposition("gli eventi estivi organizzati dall’associazione ***Fiesta*** nel Parco Rosati. Per partecipare è necessario prenotare i biglietti sul sito internet", true, $questionnaire_8_1_1);
        $this->createProposition("i corsi estivi di ballo latino-americano dell’associazione ***Fiesta***. Per partecipare è necessario iscriversi presso la sede dell’associazione situata nel Parco Rosati", false, $questionnaire_8_1_1);
        $this->createProposition("i corsi estivi di lingua e cultura latino-americana tenuti presso l’associazione ***Fiesta***, situata nello splendido Parco Rosati", false, $questionnaire_8_1_1);

        /*******************************************
                    QUESTIONNAIRE 9 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_9 = $this->createQuestionnaire("B1_CE_vacance_sicile", "B1", "CE", $test, 1);
        $questionnaire_9->setOriginText("");
        $questionnaire_9->setMediaInstruction($this->mediaText("", "", ""));
        $questionnaire_9->setMediaContext($this->mediaText("", "Pubblicità online", ""));
        $questionnaire_9->setMediaText($this->mediaText($startTitle . "Alla scoperta della Sicilia" . $endTitle,
        "Per quanti vogliono visitare la Sicilia e apprezzarne il patrimonio artistico, storico e naturalistico, www.hermes-sicily.com propone un programma di visite guidate settimanali. Si tratta di \"gruppi misti\" ai quali è possibile iscriversi scegliendo  le mete secondo il calendario stagionale previsto. I gruppi possono essere composti da massimo 10 partecipanti  e le iscrizioni possono essere singole o di gruppo. Oltre che in lingua italiana, le visite si tengono anche in inglese e tedesco.@@@Adattato da: www.sicily-holiday.com", ""));
        // CREATION QUESTION
        $questionnaire_9_1 = $this->createQuestion("TVF", $questionnaire_9);
        // CREATION SUBQUESTION
        $questionnaire_9_1_1 = $this->createSubquestionVF("VF", $questionnaire_9_1, "", "Le visite guidate si tengono una volta a settimana");
        $questionnaire_9_1_2 = $this->createSubquestionVF("VF", $questionnaire_9_1, "", "Il programma delle visite guidate cambia in base alla stagione");
        $questionnaire_9_1_3 = $this->createSubquestionVF("VF", $questionnaire_9_1, "", "I gruppi devono essere composti da almeno 10 partecipanti");

        // CREATION PROPOSITIONS
        $this->createPropositionVF("", "VRAI", true, $questionnaire_9_1_1);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_9_1_1);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_9_1_2);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_9_1_2);

        $this->createPropositionVF("", "VRAI", false, $questionnaire_9_1_3);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_9_1_3);

        /*******************************************
                    QUESTIONNAIRE 11 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B1_11 = $this->createQuestionnaire("B1_CE_chemin_compostelle", "B1", "CE", $test, 1);
        $questionnaire_B1_11->setOriginText("");
        $questionnaire_B1_11->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere o false", ""));
        $questionnaire_B1_11->setMediaContext($this->mediaText("", "Post su rivista di viaggi", ""));
        $questionnaire_B1_11->setMediaText($this->mediaText($startTitle . "Il cammino di Santiago" . $endTitle,
        "È difficile scrivere di un’esperienza personale così profonda, bisognerebbe scavare nell’anima, per trovare le radici delle motivazioni che spingono a intraprendere questo viaggio, che inizia ancor prima di partire dalla tua storia, dal tuo modo di essere e di vivere.@@@È facile invece elencare le persone incontrate, le storie ascoltate camminando, i pranzi e le cene in compagnia, i luoghi visitati, gli alberghi dove ho dormito. Ognuno meriterebbe di essere descritto e raccontato con dovizia di particolari, ma non basterebbe un libro.@@@Ometterò quindi aspetti puramente pratici, concentrandomi sulle sensazioni che crescevano in me, mentre vivevo uno dei capitoli più belli della mia vita.@@@Tratto da: www.nobordersmagazine.org", ""));
        // CREATION QUESTION
        $questionnaire_B1_11_1 = $this->createQuestion("TVF", $questionnaire_B1_11);
        // CREATION SUBQUESTION
        $questionnaire_B1_11_1_1 = $this->createSubquestionVF("VF", $questionnaire_B1_11_1, "", "Nel racconto di viaggio si descrivono alcuni  aspetti pratici dell’organizzazione");
        $questionnaire_B1_11_1_2 = $this->createSubquestionVF("VF", $questionnaire_B1_11_1, "", "L’autrice sostiene che sia complesso descrivere le forti emozioni provate durante il viaggio");
        $questionnaire_B1_11_1_3 = $this->createSubquestionVF("VF", $questionnaire_B1_11_1, "", "Per l’autrice i motivi che spronano a partire sono");

        // CREATION PROPOSITIONS
        $this->createPropositionVF("", "VRAI", false, $questionnaire_B1_11_1_1);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_B1_11_1_1);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_B1_11_1_2);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_B1_11_1_2);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_B1_11_1_3);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_B1_11_1_3);

        /*******************************************
                    QUESTIONNAIRE 13 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_13 = $this->createQuestionnaire("B1_CE_publicite_progres", "B1", "CE", $test, 0);
        $questionnaire_13->setOriginText("");
        $questionnaire_13->setMediaInstruction($this->mediaText("", "***Pubblicità Progresso***:", ""));
        $questionnaire_13->setMediaContext($this->mediaText("", "Articolo su sito internet", ""));
        $questionnaire_13->setMediaText($this->mediaText($startTitle . "Alfabetizzazione informatica" . $endTitle,
        "Recenti ricerche rilevano che gli Italiani, tra tutti i cittadini d’Europa, si collocano agli ultimi posti in quanto a utilizzo del computer.@@@Secondo il gruppo di lavoro di ***Pubblicità Progresso***, il problema della scarsa propensione dei nostri connazionali a utilizzare il computer esiste ma bisogna evitare di drammatizzarlo. L’informatica non deve essere considerata una nuova religione ma un formidabile strumento che amplia le potenzialità degli individui. Per questo, l’obiettivo delle pubblicità che verranno mandate in onda prossimamente, è quello di lanciare un messaggio, privo di effetti speciali e allarmismi, che metta in rilievo l’utilità del computer nella vita quotidiana.@@@Adattato da: www.pubblicitaprogresso.org", ""));

        // CREATION QUESTION
        $questionnaire_13_1 = $this->createQuestion("QRU", $questionnaire_13);
        // CREATION SUBQUESTION
        $questionnaire_13_1_1 = $this->createSubquestion("QRU", $questionnaire_13_1, "");
        // CREATION PROPOSITIONS
        $this->createProposition("dopo aver constatato lo scarso utilizzo del computer da parte degli italiani, si è impegnata nella creazione di una campagna pubblicitaria chiara e semplice che promuova l’utilizzo e l’utilità di questo strumento", true, $questionnaire_13_1_1);
        $this->createProposition("dopo aver constatato che nella società attuale l’informatica è diventata una sorta di religione, si è impegnata a lanciare una campagna pubblicitaria ad effetto che inviti ad un uso più moderato di questo strumento", false, $questionnaire_13_1_1);
        $this->createProposition("dopo aver constatato la drammatica situazione legata allo scarso utilizzo dei computer da parte dei cittadini italiani, si è impegnata nell’ideazione di una campagna promozionale di corsi di informatica", false, $questionnaire_13_1_1);

        /*******************************************
                    QUESTIONNAIRE 14 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_14 = $this->createQuestionnaire("B1_CE_avis_parc_naturel", "B1", "CE", $test, 1);
        $questionnaire_14->setOriginText("");
        $questionnaire_14->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere o false", ""));
        $questionnaire_14->setMediaContext($this->mediaText("", "Avviso pubblico in un parco naturale", ""));
        $questionnaire_14->setMediaText($this->mediaText($startTitle . "3 regole per rispettare il Parco" . $endTitle,
        "1. Quando avvisti degli animali, tieniti a distanza: rischi di spaventarli. Hanno paura anche dei cani che, per questo, è necessario tenere sempre sotto controllo.@@@2. Per salvaguardare il magico equilibrio del Parco, è vietato  il campeggio libero.@@@3. Quasi ovunque si possono raccogliere i funghi, ma serve un permesso, che viene rilasciato dai Comuni.@@@Queste semplici regole di buona educazione e buon senso vengono fatte rispettare dai guardaparco e dai forestali, anche applicando le sanzioni previste dalla L.P. 18/88.@@@Grazie per la collaborazione.@@@Adattato da: www.pnab.it", ""));
        // CREATION QUESTION
        $questionnaire_14_1 = $this->createQuestion("TVF", $questionnaire_14);
        // CREATION SUBQUESTION
        $questionnaire_14_1_1 = $this->createSubquestionVF("VF", $questionnaire_14_1, "", "Durante la visita al parco è obbligatorio tenere sempre sotto controllo i propri cani per evitare sanzioni da parte dei guardaparco e degli agenti forestali");
        $questionnaire_14_1_2 = $this->createSubquestionVF("VF", $questionnaire_14_1, "", "In tutte le aree del parco è concessa la raccolta dei funghi ai visitatori provvisti di permesso");
        $questionnaire_14_1_3 = $this->createSubquestionVF("VF", $questionnaire_14_1, "", "Per ragioni ambientali il campeggio nel parco non è permesso");
        // CREATION PROPOSITIONS
        $this->createPropositionVF("", "VRAI", true, $questionnaire_14_1_1);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_14_1_1);

        $this->createPropositionVF("", "VRAI", false, $questionnaire_14_1_2);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_14_1_2);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_14_1_3);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_14_1_3);


        /*******************************************
                    QUESTIONNAIRE 27 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_27 = $this->createQuestionnaire("B1_CE_diner_ciel", "B1", "CE", $test, 1);
        $questionnaire_27->setOriginText("");
        $questionnaire_27->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere o false", ""));
        $questionnaire_27->setMediaContext($this->mediaText("", "Post su blog", ""));
        $questionnaire_27->setMediaText($this->mediaText($startTitle . "Con ***Cene in Cielo*** si mangia sospesi nel vuoto" . $endTitle, "Talvolta a rendere speciale la cena non sono né gli ingredienti né l’abilità del cuoco, ma l’insolito panorama di cui potrete godere mentre cenate  sospesi a 50 metri d’altezza.
Se siete tra coloro che non temono l’avventura ma anzi più di qualsiasi cosa detestano la solita routine quotidiana e soprattutto non soffrite di vertigini, potreste cenare nel vuoto a circa 50 metri d’altezza, sullo sfondo di splendidi panorami.@@@
Ad offrire questo insolito servizio è ***Cene In Cielo***, società specializzata nell’organizzazione di cene, aperitivi e feste a bordo di una piattaforma che, insieme a chef, camerieri ed ospiti, viene sollevata ad altezze adrenaliniche. Sia chiaro, la cena è ad alto tasso di divertimento ma a rischio zero: gli ospiti cenano attaccati alle proprie sedie protetti dalle cinture di sicurezza e anche il personale, assicurato a delle corde, lavora in tutta tranquillità.
", ""));
        // CREATION QUESTION
        $questionnaire_27_1 = $this->createQuestion("TVF", $questionnaire_27);
        // CREATION SUBQUESTION
        $questionnaire_27_1_1 = $this->createSubquestionVF("VF", $questionnaire_27_1, "", "***Cene in cielo*** propone delle serate speciali in ristoranti dove cuochi di alto livello promuovono ingredienti di alta qualità");
        $questionnaire_27_1_2 = $this->createSubquestionVF("VF", $questionnaire_27_1, "", "Il servizio proposto è adatto anche alle persone che soffrono di vertigini");
        $questionnaire_27_1_3 = $this->createSubquestionVF("VF", $questionnaire_27_1, "", "Gli eventi proposti avvengono sempre nel massimo della sicurezza per il cliente e per i dipendenti dell’organizzazione");

        // CREATION PROPOSITIONS
        $this->createPropositionVF("", "VRAI", false, $questionnaire_27_1_1);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_27_1_1);

        $this->createPropositionVF("", "VRAI", false, $questionnaire_27_1_2);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_27_1_2);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_27_1_3);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_27_1_3);

        /*******************************************
                    QUESTIONNAIRE 21 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_21 = $this->createQuestionnaire("B1_CE_stage_etranger", "B1", "CE", $test, 1);
        $questionnaire_21->setOriginText("");
        $questionnaire_21->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere o false", ""));
        $questionnaire_21->setMediaContext($this->mediaText("", "Articolo su sito internet", ""));
        $questionnaire_21->setMediaText($this->mediaText($startTitle . "Stage all’estero" . $endTitle, "Un tirocinio all’estero prevede  un periodo di tempo da trascorrere in un’azienda o in un’istituzione, allo scopo di iniziare la propria formazione professionale. È un rapporto flessibile, regolato da leggi ministeriali, la cui durata varia per tipologia. Un tirocinio all'estero è un'occasione per chi vuole cominciare a muoversi in un contesto internazionale e aprirsi a nuove prospettive. Una volta terminato, l’esperienza sarà certificata da un attestato che acquisterà valore di credito formativo e che potrai annotare sul tuo curriculum.@@@Tratto da: www.progettogiovani.pd.it", ""));
        // CREATION QUESTION
        $questionnaire_21_1 = $this->createQuestion("TVF", $questionnaire_21);
        // CREATION SUBQUESTION
        $questionnaire_21_1_1 = $this->createSubquestionVF("VF", $questionnaire_21_1, "", "Il tirocinio all’estero è un’opportunità per cominciare la propria esperienza lavorativa in un contesto internazionale");
        $questionnaire_21_1_2 = $this->createSubquestionVF("VF", $questionnaire_21_1, "", "I tirocini all’estero hanno sempre la stessa durata, in ogni settore lavorativo");
        $questionnaire_21_1_3 = $this->createSubquestionVF("VF", $questionnaire_21_1, "", "Il tirocinio all’estero consente di accumulare crediti universitari");

        // CREATION PROPOSITIONS
        $this->createPropositionVF("", "VRAI", true, $questionnaire_21_1_1);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_21_1_1);

        $this->createPropositionVF("", "VRAI", false, $questionnaire_21_1_2);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_21_1_2);

        $this->createPropositionVF("", "VRAI", false, $questionnaire_21_1_3);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_21_1_3);

        /*******************************************
                    QUESTIONNAIRE 23 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_23 = $this->createQuestionnaire("B1_CE_unicef", "B1", "CE", $test, 1);
        $questionnaire_23->setOriginText("");
        $questionnaire_23->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere o false", ""));
        $questionnaire_23->setMediaContext($this->mediaText("", "Articolo su internet", ""));
        $questionnaire_23->setMediaText($this->mediaText($startTitle . "Diventa Volontario. Dai anche tu un prezioso contributo per salvare la vita di un bambino." . $endTitle,
"Le principali attività dei volontari sono orientate alla promozione dei diritti dell'infanzia in Italia e alla realizzazione a livello territoriale delle campagne UNICEF a sostegno dei programmi nei Paesi in via di sviluppo.@@@Contattando il Comitato UNICEF della tua città (ce ne sono 110, uno per ogni Provincia italiana) puoi impegnarti nei nostri \"eventi di piazza\" nazionali e in tutte le altre iniziative locali di raccolta fondi e di sensibilizzazione sui diritti dell'infanzia.@@@Se hai tra 14 e 30 anni, puoi entrare a far parte di ***Younicef***, il movimento di volontariato giovanile dell'UNICEF Italia, attivo in ogni parte del Paese.@@@Tratto da: www.unicef.it", ""));
        // CREATION QUESTION
        $questionnaire_23_1 = $this->createQuestion("TVF", $questionnaire_23);
        // CREATION SUBQUESTION
        $questionnaire_23_1_1 = $this->createSubquestionVF("VF", $questionnaire_23_1, "", "Il volontario Unicef svolge la sua azione unicamente nei paesi in via di sviluppo");
        $questionnaire_23_1_2 = $this->createSubquestionVF("VF", $questionnaire_23_1, "", "I volontari Unicef sono impiegati nella raccolta di denaro per finanziare  progetti");
        $questionnaire_23_1_3 = $this->createSubquestionVF("VF", $questionnaire_23_1, "", "****Younicef*** accoglie tra i suoi volontari persone di tutte le età");

        // CREATION PROPOSITIONS
        $this->createPropositionVF("", "VRAI", false, $questionnaire_23_1_1);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_23_1_1);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_23_1_2);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_23_1_2);

        $this->createPropositionVF("", "VRAI", false, $questionnaire_23_1_3);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_23_1_3);

        /*******************************************
         NOUVEAU       QUESTIONNAIRE 99 : QRM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_99 = $this->createQuestionnaire("B1_CE_consommation_ethique_bis", "B1", "CE", $test, 0);
        $questionnaire_99->setOriginText("Une ou plusieurs réponses correctes");
        $questionnaire_99->setMediaInstruction($this->mediaText("", "Quali informazioni sono presenti nel testo?", ""));
        $questionnaire_99->setMediaContext($this->mediaText("", "Articolo su rivista di attualità", ""));
        $questionnaire_99->setMediaText($this->mediaText($startTitle . "Il consumo etico oggi" . $endTitle,
        "Oggi, il consumo etico, cioè l’acquisto di prodotti il cui ricavato va ad aiutare le zone più disagiate del mondo, è in crescita. I prezzi, al contrario, scendono.@@@Fino a ieri, per comprare questi prodotti bisognava entrare in un negozio specializzato e spendere circa il 20 percento in più. Ora si trovano anche sugli scaffali dei supermercati.@@@Un esempio: il supermercato ***Coop*** ha creato la linea ***Solidarietà***, che prevede l’acquisto dei prodotti direttamente dal paese di origine. Comprare etico significa avere la certezza che i guadagni delle materie prime vadano alle comunità locali, che possono cosi migliorare le condizioni di vita e avere un’opportunità di crescita.@@@Tratto da: Glamour n° 123 - maggio 2002", ""));

        // CREATION QUESTION
        $questionnaire_99_1 = $this->createQuestion("QRM", $questionnaire_99);
        // CREATION SUBQUESTION
        $questionnaire_99_1_1 = $this->createSubquestion("QRM", $questionnaire_99_1, "");
        // CREATION PROPOSITIONS
        $this->createProposition("Il consumo etico mira a sostenere l’economia dei paesi in via di sviluppo", true, $questionnaire_99_1_1);
        $this->createProposition("I prodotti provenienti dal commercio etico hanno prezzi più elevati rispetto agli altri prodotti", false, $questionnaire_99_1_1);
        $this->createProposition("Per acquistare prodotti del commercio etico è necessario recarsi in negozi specializzati", false, $questionnaire_99_1_1);

        /*******************************************
                    QUESTIONNAIRE 24 : QRU à QRM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_24 = $this->createQuestionnaire("B1_CE_lecture", "B1", "CE", $test, 0);
        $questionnaire_24->setOriginText("Une ou plusieurs réponses correctes");
        $questionnaire_24->setMediaInstruction($this->mediaText("", "I grandi romanzi:", ""));
        $questionnaire_24->setMediaContext($this->mediaText("", "Articolo su sito internet", ""));
        $questionnaire_24->setMediaText($this->mediaText($startTitle . "L’importanza della lettura: partiamo dai classici." . $endTitle,
        "Leggere significa appropriarsi delle esperienze di migliaia di personaggi immaginari e farne tesoro; le esperienze acquisite saranno utili per affrontare le disavventure della vita. Le mille asperità che ogni adolescente si trova a sostenere sono le stesse che i protagonisti dei grandi romanzi di formazione si trovano a fronteggiare. L'amore perduto, l'odio, la vendetta, la rabbia e il senso d'impotenza possono indebolire un giovane ancora fragile, per questo avere interiorizzato decine, centinaia di esperienze simili, certo di personaggi immaginari, può essere utile e può fare la differenza.@@@Tratto da: www.agoravox.it", ""));

        // CREATION QUESTION
        $questionnaire_24_1 = $this->createQuestion("QRM", $questionnaire_24);
        // CREATION SUBQUESTION
        $questionnaire_24_1_1 = $this->createSubquestion("QRM", $questionnaire_24_1, "");
        // CREATION PROPOSITIONS
        $this->createProposition("aiutano i giovani a non sentirsi soli nelle disavventure della vita, poiché i problemi affrontati dai protagonisti della letteratura sono simili a quelli degli adolescenti del giorno d’oggi", true, $questionnaire_24_1_1);
        $this->createProposition("raccontano tutte le tappe della vita; per questo leggerli può aiutare i giovani ad affrontare i momenti più complessi della vita", true, $questionnaire_24_1_1);
        $this->createProposition("raccontando l’amore, l’odio, la rabbia ed altri sentimenti, indeboliscono l’animo degli adolescenti che purtroppo è già fragile", false, $questionnaire_24_1_1);

        /*******************************************
                    QUESTIONNAIRE 6 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_6 = $this->createQuestionnaire("B1_CE_partager_nourriture_en_ligne", "B1", "CE", $test, 0);
        $questionnaire_6->setOriginText("");
        $questionnaire_6->setMediaInstruction($this->mediaText("", "", ""));
        $questionnaire_6->setMediaContext($this->mediaText("", "Articolo su rivista di attualità", ""));
        $questionnaire_6->setMediaText($this->mediaText($startTitle . "Troppa pasta? Condividiamo in rete!" . $endTitle,
        "Primo comandamento: condividi il cibo che resta in tavola.@@@Una associazione italiana, ispirandosi ad un’esperienza tedesca di successo, ha creato il sito internet  www.allastessatavola.org che si occupa di ridistribuire gli alimenti inutilizzati dalle famiglie. Per partecipare all’iniziativa bisogna iscriversi al sito e, sulla pagina dedicata, indicare i prodotti che si vogliono donare (un pacco di riso, pomodori in scatola, quei biscotti che non si vogliono mangiare).@@@L’associazione si occupa di ritirare le merci proposte e di distribuirle a chi ne ha fatto richiesta. Il servizio è gratuito e agisce su scala locale. L’iniziativa è online da poche settimane e sono già 400 le persone iscritte.@@@Tratto da: Myself n° 18 - maggio 2012", ""));

        // CREATION QUESTION
        $questionnaire_6_1 = $this->createQuestion("TQRU", $questionnaire_6);
        // CREATION SUBQUESTION
        $questionnaire_6_1_1 = $this->createSubquestion("QRU", $questionnaire_6_1, "L'idea di \"allastessatavola.org\" è nata da:");
        $questionnaire_6_1_2 = $this->createSubquestion("QRU", $questionnaire_6_1, "L'associazione si occupa di:");
        $questionnaire_6_1_3 = $this->createSubquestion("QRU", $questionnaire_6_1, "L'iniziativa ha avuto:");
        // CREATION PROPOSITIONS
        $this->createProposition("un bisogno locale", false, $questionnaire_6_1_1);
        $this->createProposition("un'altra iniziativa simile", true, $questionnaire_6_1_1);
        $this->createProposition("un'associazione cattolica", false, $questionnaire_6_1_1);

        $this->createProposition("vendere merci a metà prezzo alle famiglie interessate", false, $questionnaire_6_1_2);
        $this->createProposition("recuperare le merci invendute dai supermercati locali", false, $questionnaire_6_1_2);
        $this->createProposition("raccogliere e consegnare gli alimenti a chi ne ha bisogno", true, $questionnaire_6_1_2);

        $this->createProposition("un successo immediato", false, $questionnaire_6_1_3);
        $this->createProposition("una scarsa adesione", true, $questionnaire_6_1_3);
        $this->createProposition("un debole impatto", false, $questionnaire_6_1_3);


        /*******************************************
                    QUESTIONNAIRE 30 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_30 = $this->createQuestionnaire("B1_CE_danser_pause_dejeuner", "B1", "CE", $test, 0);
        $questionnaire_30->setOriginText("");
        $questionnaire_30->setMediaInstruction($this->mediaText("", "Qual è la giusta riformulazione del testo?", ""));
        $questionnaire_30->setMediaContext($this->mediaText("", "Articolo su un quotidiano online", ""));
        $questionnaire_30->setMediaText($this->mediaText($startTitle . "Il Disco-Pranzo" . $endTitle,
        "Nasce a Stoccolma il fenomeno Disco-pranzo e ora arriva anche in Italia. L’idea è di  utilizzare il momento della pausa pranzo per staccare completamente la spina dai problemi lavorativi e far socializzare tra loro le persone a ritmo di musica. L’obbligo è di non pensare al lavoro. Lo slogan è “lascia la scrivania e vieni a divertirti con tante persone nuove”.@@@In città i luoghi per il Disco-pranzo sono tanti ma si prediligono le zone con alta presenza di uffici. Questo permette l’affluenza di partecipanti senza bisogno di grandi spostamenti.@@@Adattato da: www.affaritaliani.it", ""));

        // CREATION QUESTION
        $questionnaire_30_1 = $this->createQuestion("QRU", $questionnaire_30);
        // CREATION SUBQUESTION
        $questionnaire_30_1_1 = $this->createSubquestion("QRU", $questionnaire_30_1, "");
        // CREATION PROPOSITIONS
        $this->createProposition("Il Disco-Pranzo propone un modo diverso di trascorrere la pausa pranzo. Basta parlare di lavoro con i colleghi! Spazio alla musica e al divertimento! Scegli lo strumento musicale che preferisci e mettiti a suonare", false, $questionnaire_30_1_1);
        $this->createProposition("Il Disco-Pranzo ti permette di trascorrere la tua pausa pranzo in compagnia di persone nuove ascoltando ottima musica", true, $questionnaire_30_1_1);
        $this->createProposition("Grazie al Disco-Pranzo, tu e i tuoi colleghi potrete confrontare le vostre idee di lavoro in un ambiente gradevole animato da buona musica", false, $questionnaire_30_1_1);

        /*******************************************
                    QUESTIONNAIRE 31 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_31 = $this->createQuestionnaire("B1_CE_poste_dimmiquando", "B1", "CE", $test, 1);
        $questionnaire_31->setOriginText("");
        $questionnaire_31->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere o false", ""));
        $questionnaire_31->setMediaContext($this->mediaText("", "Pubblicità di Poste Italiane", ""));
        $questionnaire_31->setMediaText($this->mediaText($startTitle . "Diventa Volontario. Dai anche tu un prezioso contributo per salvare la vita di un bambino." . $endTitle,
"“Dimmi quando” è il servizio che ti permette di scegliere il giorno esatto della settimana in cui ricevere le tue raccomandate e assicurate.@@@Con “Chiamami” Poste Italiane ti riporta la corrispondenza da firmare che non hai ritirato perché eri assente. È sufficiente chiamare il numero indicato sull’avviso di giacenza nelle zone in cui il servizio è attivo. Attivare i servizi per il destinatario è semplice e puoi scegliere tu la modalità che preferisci; richiedili presso l’ufficio postale o al tuo portalettere fissando un appuntamento al numero 803.160 oppure direttamente on-line sul sito poste.it.@@@Tratto da: www.poste.it", ""));
        // CREATION QUESTION
        $questionnaire_31_1 = $this->createQuestion("TVF", $questionnaire_31);
        // CREATION SUBQUESTION
        $questionnaire_31_1_1 = $this->createSubquestionVF("VF", $questionnaire_31_1, "", "Il servizio “Chiamami” permette di stabilire il giorno della settimana in cui ricevere la posta");
        $questionnaire_31_1_2 = $this->createSubquestionVF("VF", $questionnaire_31_1, "", "Il servizio “Chiamami” permette di ricevere una seconda volta le lettere recapitate in nostra assenza");
        $questionnaire_31_1_3 = $this->createSubquestionVF("VF", $questionnaire_31_1, "", "Per attivare i servizi  si può solo prendere un appuntamento");

        // CREATION PROPOSITIONS
        $this->createPropositionVF("", "VRAI", true, $questionnaire_31_1_1);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_31_1_1);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_31_1_2);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_31_1_2);

        $this->createPropositionVF("", "VRAI", false, $questionnaire_31_1_3);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_31_1_3);


        /*******************************************
                    MISE EN BASE
        ********************************************/
        $em->flush();

        $output->writeln("Fixtures Italian CE B1 exécutées.");
        $output->writeln("");
        $output->writeln("IMPORTANT : copier les images dans media.");

    }

    /**
     *
     */
    protected function createTest($name, $language)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        if (!$test = $em->getRepository('InnovaSelfBundle:Test')->findOneByName($name)){
            $test = new Test();
        }

        $test->setName($name);
        $language = $em->getRepository('InnovaSelfBundle:Language')->findOneByName($language);
        $test->setLanguage($language);
        $em->persist($test);

        return $test;
    }

    /**
     *
     */
    protected function createQuestionnaire($title, $level, $skill, $test, $fixedOrder)
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
        $questionnaire->setFixedOrder($fixedOrder);

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

        // Création dans "Media"
        $media = new Media();

        if ($type != "") {
            $media->setName(StaticCommand::textSource($title));
            $media->setDescription(StaticCommand::textSource($title)); // Ajout ERV 03/03/2014 car c'est la description que l'on affiche dans la macro.texte
            $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("image"));
            $media->setUrl($name.".jpg");
        }
        else
        {
            $media->setName(StaticCommand::textSource($title.$name));
            $media->setDescription(StaticCommand::textSource($title.$name)); // Ajout ERV 03/03/2014 car c'est la description que l'on affiche dans la macro.texte
            $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("texte"));
            $media->setUrl(NULL);
        }

        $em->persist($media);

        return $media;
    }

}
