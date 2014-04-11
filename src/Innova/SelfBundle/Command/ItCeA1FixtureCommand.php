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
class Itcea1FixtureCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('self:fixtures:itcea1')
            ->setDescription('SELF CE Italien A1 Pilote 2')
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
        $test = $this->createTest("Italien a1 A1", "Italian");

        // To have CSS form title. #166
        $startTitle = "<span class=\"title-situation\">";
        $endTitle = "</span>";

        /*******************************************

                    NIVEAU : A1

        ********************************************/

        /*******************************************
                    QUESTIONNAIRE 1 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_1 = $this->createQuestionnaire("A1_CE_parking_gare", "A1", "CE", $test, 1);
        $questionnaire_1->setOriginText("");
        $questionnaire_1->setMediaInstruction($this->mediaText("", "", ""));
        $questionnaire_1->setMediaContext($this->mediaText("", "Pubblicità in stazione", ""));
        $questionnaire_1->setMediaText(
        $this->mediaText($startTitle . "Parcheggia l’auto e parti in treno!" . $endTitle,
        "Lascia l’auto vicino alla stazione e parti con i treni Frecciarossa, Frecciargento e Frecciabianca.@@@A Torino, Milano e Padova puoi avere una tariffa speciale in alcuni parcheggi e garage convenzionati, semplicemente presentando il tuo biglietto valido su treni Frecciarossa, Frecciargento e Frecciabianca.@@@Tratto da: www.trenitalia.com", "")
        );
        // CREATION QUESTION
        $questionnaire_1_1 = $this->createQuestion("TVF", $questionnaire_1);
        // CREATION SUBQUESTION
        $questionnaire_1_1_1 = $this->createSubquestionVF("VF", $questionnaire_1_1, "", "L’offerta è valida solo in alcune città");
        $questionnaire_1_1_2 = $this->createSubquestionVF("VF", $questionnaire_1_1, "", "Con il biglietto del treno il parcheggio per l’automobile è gratuito");
        $questionnaire_1_1_3 = $this->createSubquestionVF("VF", $questionnaire_1_1, "", "Per avere la tariffa speciale è necessario presentare il biglietto del treno");
        // CREATION PROPOSITIONS
        $this->createPropositionVF("", "VRAI", true, $questionnaire_1_1_1);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_1_1_1);

        $this->createPropositionVF("", "VRAI", false, $questionnaire_1_1_2);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_1_1_2);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_1_1_3);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_1_1_3);

        /*******************************************
           A TERMINER         QUESTIONNAIRE : QRM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_2 = $this->createQuestionnaire("A1_CE_carsharing", "A1", "CE", $test, 0);
        $questionnaire_2->setOriginText("Une ou plusieurs réponses correctes");
        $questionnaire_2->setMediaInstruction($this->mediaText("", "Quali informazioni sono presenti nel testo?", ""));
        $questionnaire_2->setMediaContext($this->mediaText("", "Pubblicità su sito internet", ""));
        $questionnaire_2->setMediaText($this->mediaText($startTitle . "Car sharing, la promozione estiva" . $endTitle, "A1_CE_carsharing", "image"));
        // CREATION QUESTION
        $questionnaire_2_1 = $this->createQuestion("QRM", $questionnaire_2);
        // CREATION SUBQUESTION
        $questionnaire_2_1_1 = $this->createSubquestion("QRM", $questionnaire_2_1, "");
        // CREATION PROPOSITIONS
        $this->createProposition("Per usare", true, $questionnaire_2_1_1);
        $this->createProposition("Carsharing", false, $questionnaire_2_1_1);
        $this->createProposition("devi iscriverti sul sito web", true, $questionnaire_2_1_1);

        /*******************************************
                    QUESTIONNAIRE 3 : QRM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_3 = $this->createQuestionnaire("A1_CE_vie_tokyo", "A1", "CE", $test, 0);
        $questionnaire_3->setOriginText("Une ou plusieurs réponses correctes");
        $questionnaire_3->setMediaInstruction($this->mediaText("", "Giulio:", ""));
        $questionnaire_3->setMediaContext($this->mediaText("", "E-mail ad un amico", ""));
        $questionnaire_3->setMediaText($this->mediaText($startTitle . "Notizie da Tokyo" . $endTitle, "Ciao Matteo,@@@qui sono le 4.00 del mattino e sono stanchissimo :-(! Sono arrivato a Tokyo, finalmente! Il viaggio è stato davvero lungo, ho cambiato tre aerei e ho attraversato due continenti, quasi non ci credo!@@@Sull’aereo ho mangiato il primo vero sushi della mia vita, non mi è piaciuto molto!@@@Ho conosciuto una ragazza americana che studia qui al Campus, mi ha parlato molto bene della città, domani mi porta a fare un giro, poi ti racconto. :-)@@@Buona notte e a presto,@@@Giulio", ""));
        // CREATION QUESTION
        $questionnaire_3_1 = $this->createQuestion("QRM", $questionnaire_3);
        // CREATION SUBQUESTION
        $questionnaire_3_1_1 = $this->createSubquestion("QRM", $questionnaire_3_1, "");
        // CREATION PROPOSITIONS
        $this->createProposition("scrive a Matteo dopo un lungo viaggio", true, $questionnaire_3_1_1);
        $this->createProposition("racconta che l’aereo è arrivato in ritardo.", false, $questionnaire_3_1_1);
        $this->createProposition("visiterà la città accompagnato da una nuova amica", true, $questionnaire_3_1_1);
        $this->createProposition("ha iniziato uno stage.", false, $questionnaire_3_1_1);

        /*******************************************
                    QUESTIONNAIRE 4 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_4 = $this->createQuestionnaire("A1_CE_services_bibliotheque", "A1", "CE", $test, 1);
        $questionnaire_4->setOriginText("");
        $questionnaire_4->setMediaInstruction($this->mediaText("", "", ""));
        $questionnaire_4->setMediaContext($this->mediaText("", "Avviso in biblioteca", ""));
        $questionnaire_4->setMediaText($this->mediaText($startTitle . $endTitle, "A1_CE_services_bibliotheque", "image"));
        // CREATION QUESTION
        $questionnaire_4_1 = $this->createQuestion("TVF", $questionnaire_4);
        // CREATION SUBQUESTION
        $questionnaire_4_1_1 = $this->createSubquestionVF("VF", $questionnaire_4_1, "", "La biblioteca chiude per la pausa pranzo");
        $questionnaire_4_1_2 = $this->createSubquestionVF("VF", $questionnaire_4_1, "", "La biblioteca è aperta tutte le mattine");
        $questionnaire_4_1_3 = $this->createSubquestionVF("VF", $questionnaire_4_1, "", "In biblioteca è possibile navigare su internet senza pagare.");
        $questionnaire_4_1_4 = $this->createSubquestionVF("VF", $questionnaire_4_1, "", "Non è permesso restare in biblioteca a studiare");
        // CREATION PROPOSITIONS
        $this->createPropositionVF("", "VRAI", true, $questionnaire_4_1_1);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_4_1_1);

        $this->createPropositionVF("", "VRAI", false, $questionnaire_4_1_2);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_4_1_2);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_4_1_3);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_4_1_3);

        $this->createPropositionVF("", "VRAI", false, $questionnaire_4_1_4);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_4_1_4);


        /*******************************************
                    QUESTIONNAIRE 5 : n'existe pas
        ********************************************/

        /*******************************************
                    QUESTIONNAIRE 6 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_6 = $this->createQuestionnaire("A1_CE_cours_bibliotheque", "A1", "CE", $test, 0);
        $questionnaire_6->setOriginText("");
        $questionnaire_6->setMediaInstruction($this->mediaText("", "", ""));
        $questionnaire_6->setMediaContext($this->mediaText("", "Informazione in biblioteca", ""));
        $questionnaire_6->setMediaText($this->mediaText($startTitle . "" . $endTitle, "A1_CE_cours_bibliotheque", "image"));
        // CREATION QUESTION
        $questionnaire_6_1 = $this->createQuestion("TQRU", $questionnaire_6);
        // CREATION SUBQUESTION
        $questionnaire_6_1_1 = $this->createSubquestion("QRU", $questionnaire_6_1, "I corsi dell’associazione sono:");
        $questionnaire_6_1_2 = $this->createSubquestion("QRU", $questionnaire_6_1, "L’Associazione offre:");
        $questionnaire_6_1_3 = $this->createSubquestion("QRU", $questionnaire_6_1, "Per iscriversi all’Associazione:");
        // CREATION PROPOSITIONS
        $this->createProposition("rivolti a persone anziane", false, $questionnaire_6_1_1);
        $this->createProposition("aperti a tutti", false, $questionnaire_6_1_1);
        $this->createProposition("solo per i soci", true, $questionnaire_6_1_1);

        $this->createProposition("solo corsi di lingua", false, $questionnaire_6_1_2);
        $this->createProposition("corsi di lingua e informatica", false, $questionnaire_6_1_2);
        $this->createProposition("corsi di vario tipo", true, $questionnaire_6_1_2);

        $this->createProposition("non si paga nulla", false, $questionnaire_6_1_3);
        $this->createProposition("bisogna pagare una piccola somma", true, $questionnaire_6_1_3);
        $this->createProposition("bisogna presentarsi il primo giorno dell'anno", false, $questionnaire_6_1_3);

        /*******************************************
                    QUESTIONNAIRE 7 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_7 = $this->createQuestionnaire("A1_CE_ticket_SMS", "A1", "CE", $test, 0);
        $questionnaire_7->setOriginText("");
        $questionnaire_7->setMediaInstruction($this->mediaText("", "", ""));
        $questionnaire_7->setMediaContext($this->mediaText("", "Brochure informativa sui servizi in autobus", ""));
        $questionnaire_7->setMediaText($this->mediaText("", "A1_CE_ticket_SMS", "image"));
        // CREATION QUESTION
        $questionnaire_7_1 = $this->createQuestion("QRU", $questionnaire_7);
        // CREATION SUBQUESTION
        $questionnaire_7_1_1 = $this->createSubquestion("QRU", $questionnaire_7_1, "Il servizio permette di:");

        // CREATION PROPOSITIONS
        $this->createProposition("avere informazioni sul traffico", false, $questionnaire_7_1_1);
        $this->createProposition("comprare il biglietto con il cellulare", true, $questionnaire_7_1_1);
        $this->createProposition("conoscere gli orari dell’autobus", false, $questionnaire_7_1_1);

        /*******************************************
                    QUESTIONNAIRE 8 : n'existe pas
        ********************************************/

        /*******************************************
                    QUESTIONNAIRE 9 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_9 = $this->createQuestionnaire("A1_CE_train_enfants", "A1", "CE", $test, 0);
        $questionnaire_9->setOriginText("Une ou plusieurs réponses correctes");
        $questionnaire_9->setMediaInstruction($this->mediaText("", "Quali informazioni sono presenti nel testo?", ""));
        $questionnaire_9->setMediaContext($this->mediaText("", "Pubblicità informativa in stazione", ""));
        $questionnaire_9->setMediaText($this->mediaText(
        $startTitle . "Su Italo grandi vantaggi per i piccoli!" . $endTitle,
        "Su Italo i bambini fino a 4 anni viaggiano gratuitamente e devono essere accompagnati da un adulto. Quelli dai 5 ai 14 anni possono viaggiare da soli ma i genitori devono richiedere il Servizio Hostess. Per i ragazzi dai 15 anni ai 18 anni sono previsti ottimi sconti sulle offerte Base ed Economy.@@@Adattato da: www.italotreno.it", ""));
        // CREATION QUESTION
        $questionnaire_9_1 = $this->createQuestion("QRM", $questionnaire_9);
        // CREATION SUBQUESTION
        $questionnaire_9_1_1 = $this->createSubquestion("QRM", $questionnaire_9_1, "Il servizio permette di");

        // CREATION PROPOSITIONS
        $this->createProposition("I bambini che hanno meno di quattro anni non devono pagare il  biglietto", true, $questionnaire_9_1_1);
        $this->createProposition("Il Servizio Hostess è incluso nel prezzo del biglietto", false, $questionnaire_9_1_1);
        $this->createProposition("Comprare il biglietto su internet permette di avere ottimi sconti", false, $questionnaire_9_1_1);

        /*******************************************
                    QUESTIONNAIRE 10 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_10 = $this->createQuestionnaire("A1_CE_SMS_pizza", "A1", "CE", $test, 0);
        $questionnaire_10->setOriginText("");
        $questionnaire_10->setMediaInstruction($this->mediaText("", "", ""));
        $questionnaire_10->setMediaContext($this->mediaText("", "SMS alla mamma", ""));
        $questionnaire_10->setMediaText($this->mediaText("", "Mamma, stasera non ci sono, vado a mangiare la pizza con Paolo. Tranquilla non faccio tardi, lo so che domani c’è scuola.@@@A dopo, Francy", ""));
        // CREATION QUESTION
        $questionnaire_10_1 = $this->createQuestion("TQRU", $questionnaire_10);
        // CREATION SUBQUESTION
        $questionnaire_10_1_1 = $this->createSubquestion("QRU", $questionnaire_10_1, "Francesca esce con Paolo per:");
        $questionnaire_10_1_2 = $this->createSubquestion("QRU", $questionnaire_10_1, "Domani Francesca:");
        // CREATION PROPOSITIONS
        $this->createProposition("cena", true, $questionnaire_10_1_1);
        $this->createProposition("pranzo", false, $questionnaire_10_1_1);
        $this->createProposition("merenda", false, $questionnaire_10_1_1);

        $this->createProposition("è in vacanza", false, $questionnaire_10_1_2);
        $this->createProposition("deve andare a lezione", true, $questionnaire_10_1_2);
        $this->createProposition("esce con Paolo", false, $questionnaire_10_1_2);

        /*******************************************
                    QUESTIONNAIRE 11 : QRM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_11 = $this->createQuestionnaire("A1_CE_mail_vacances", "A1", "CE", $test, 0);
        $questionnaire_11->setOriginText("Une ou plusieurs réponses correctes");
        $questionnaire_11->setMediaInstruction($this->mediaText("", "Giulio:", ""));
        $questionnaire_11->setMediaContext($this->mediaText("", "E-mail al papà", ""));
        $questionnaire_11->setMediaText($this->mediaText($startTitle . "Salutino" . $endTitle, "Ciao papà,@@@le vacanze procedono benissimo! :-) La mattina dormo ;-) poi faccio colazione al bar con cornetto e cappuccio :-D e poi vado in spiaggia :-DD Dopo pranzo sto un po' in camera a leggere e a guardare la posta sul PC, poi la sera verso le sette vado a correre e dopo cena esco con dei ragazzi di Padova che ho conosciuto qui. Spero tutto bene lì a casa!! Fammi sapere!@@@Un abbraccio e a presto, Giulio.", ""));
        // CREATION QUESTION
        $questionnaire_11_1 = $this->createQuestion("QRM", $questionnaire_11);
        // CREATION SUBQUESTION
        $questionnaire_11_1_1 = $this->createSubquestion("QRM", $questionnaire_11_1, "");
        // CREATION PROPOSITIONS
        $this->createProposition("è in vacanza al mare", true, $questionnaire_11_1_1);
        $this->createProposition("la mattina prende il cappuccino", true, $questionnaire_11_1_1);
        $this->createProposition("di pomeriggio controlla le sue mail", true, $questionnaire_11_1_1);
        $this->createProposition("non si è fatto nuovi amici in vacanza", false, $questionnaire_11_1_1);

        /*******************************************
                    QUESTIONNAIRE 12 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_12 = $this->createQuestionnaire("A1_CE_cours_prives_science", "A1", "CE", $test, 1);
        $questionnaire_12->setOriginText("");
        $questionnaire_12->setMediaInstruction($this->mediaText("", "", ""));
        $questionnaire_12->setMediaContext($this->mediaText("", "Annuncio all’università", ""));
        $questionnaire_12->setMediaText($this->mediaText($startTitle . "Lezioni private" . $endTitle, "Hai problemi con la matematica? Non capisci la fisica? Non dormi prima dell’esame di chimica? Stai tranquillo!! C’è chi può aiutarti!! Sono disponibile per lezioni private e preparazione agli esami. Chiamami al 345 6756433, oppure scrivi al mio indirizzo mail: fabrizio.sos-esami@hotmail.it.", ""));
        // CREATION QUESTION
        $questionnaire_12_1 = $this->createQuestion("TVF", $questionnaire_12);
        // CREATION SUBQUESTION
        $questionnaire_12_1_1 = $this->createSubquestionVF("VF", $questionnaire_12_1, "", "L’annuncio è rivolto agli studenti che hanno difficoltà con le materie letterarie");
        $questionnaire_12_1_2 = $this->createSubquestionVF("VF", $questionnaire_12_1, "", "L’annuncio pubblicizza i servizi di una scuola");
        $questionnaire_12_1_3 = $this->createSubquestionVF("VF", $questionnaire_12_1, "", "Fabrizio propone lezioni individuali");
        // CREATION PROPOSITIONS
        $this->createPropositionVF("", "VRAI", false, $questionnaire_12_1_1);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_12_1_1);

        $this->createPropositionVF("", "VRAI", false, $questionnaire_12_1_2);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_12_1_2);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_12_1_3);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_12_1_3);

        /*******************************************
                    QUESTIONNAIRE 13 : QRM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_13 = $this->createQuestionnaire("A1_CE_livres_universite", "A1", "CE", $test, 0);
        $questionnaire_13->setOriginText("Une ou plusieurs réponses correctes");
        $questionnaire_13->setMediaInstruction($this->mediaText("", "Quali informazioni sono presenti nel testo?", ""));
        $questionnaire_13->setMediaContext($this->mediaText("", "Annuncio all’università", ""));
        $questionnaire_13->setMediaText($this->mediaText($startTitle . "Vendo libri usati" . $endTitle, "Vendo libri usati per gli studenti del I anno di Letteratura italiana. I libri sono come nuovi, prezzo da stabilire. Offro in regalo le fotocopie distribuite durante il corso.@@@Per informazioni chiamare il 329 6753123.", ""));
        // CREATION QUESTION
        $questionnaire_13_1 = $this->createQuestion("QRM", $questionnaire_13);
        // CREATION SUBQUESTION
        $questionnaire_13_1_1 = $this->createSubquestion("QRM", $questionnaire_13_1, "");
        // CREATION PROPOSITIONS
        $this->createProposition("L’annuncio è rivolto a studenti che cercano libri", true, $questionnaire_13_1_1);
        $this->createProposition("I libri sono venduti a metà prezzo", false, $questionnaire_13_1_1);
        $this->createProposition("Chi compra i libri non deve pagare le fotocopie del corso", true, $questionnaire_13_1_1);

        /*******************************************
                    QUESTIONNAIRE 14 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_14 = $this->createQuestionnaire("A1_CE_soldes_ete", "A1", "CE", $test, 0);
        $questionnaire_14->setOriginText("");
        $questionnaire_14->setMediaInstruction($this->mediaText("", "", ""));
        $questionnaire_14->setMediaContext($this->mediaText("", "Pubblicità in un negozio di abbigliamento", ""));
        $questionnaire_14->setMediaText($this->mediaText($startTitle . "Sconti di stagione" . $endTitle, "Dal 1° luglio al 30 agosto grandi sconti su tutti i capi d’abbigliamento. Pantaloni e giacche al 40%, gonne e vestiti fino al 60% e tutti i costumi da bagno al 50%. Per i clienti che hanno la carta fedeltà, in regalo una borsa da spiaggia. Venite a trovarci, dal lunedì al sabato dalle 9 alle 19. Siamo aperti anche la prima domenica del mese.", ""));
        // CREATION QUESTION
        $questionnaire_14_1 = $this->createQuestion("TQRU", $questionnaire_14);
        // CREATION SUBQUESTION
        $questionnaire_14_1_1 = $this->createSubquestion("QRU", $questionnaire_14_1, "Il messaggio pubblicizza gli sconti:");
        $questionnaire_14_1_2 = $this->createSubquestion("QRU", $questionnaire_14_1, "I clienti con la carta fedeltà hanno diritto a:");
        $questionnaire_14_1_3 = $this->createSubquestion("QRU", $questionnaire_14_1, "Il negozio è aperto la domenica:");
        // CREATION PROPOSITIONS
        $this->createProposition("estivi", true, $questionnaire_14_1_1);
        $this->createProposition("invernali", false, $questionnaire_14_1_1);
        $this->createProposition("primaverili", false, $questionnaire_14_1_1);

        $this->createProposition("uno sconto ulteriore", false, $questionnaire_14_1_2);
        $this->createProposition("un oggetto in regalo", true, $questionnaire_14_1_2);
        $this->createProposition("punti extra per le prossime spese", false, $questionnaire_14_1_2);

        $this->createProposition("una volta al mese", true, $questionnaire_14_1_3);
        $this->createProposition("due volte al mese", false, $questionnaire_14_1_3);
        $this->createProposition("sempre", false, $questionnaire_14_1_3);

        /*******************************************
                    QUESTIONNAIRE 15 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_15 = $this->createQuestionnaire("A1_CE_competitions_campus", "A1", "CE", $test, 1);
        $questionnaire_15->setOriginText("");
        $questionnaire_15->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere o false", ""));
        $questionnaire_15->setMediaContext($this->mediaText("", "E-mail ad un amico", ""));
        $questionnaire_15->setMediaText($this->mediaText($startTitle . "Gare di atletica" . $endTitle, "Ciao Luca,@@@eccomi per gli aggiornamenti dal campus...@@@Oggi, come previsto, sono iniziate le gare di atletica. Io ho fatto i 100 metri e sono arrivato terzo :-) quindi domani posso correre di nuovo :-).@@@Laura invece domani fa la maratona, è andata a letto molto presto stasera.@@@Domani ti racconto come va...@@@Ciao ciao, buona notte, sono stanchissimo (-.-) zzz@@@Riccardo", ""));
        // CREATION QUESTION
        $questionnaire_15_1 = $this->createQuestion("TVF", $questionnaire_15);
        // CREATION SUBQUESTION
        $questionnaire_15_1_1 = $this->createSubquestionVF("VF", $questionnaire_15_1, "", "Al campus sono cominciate le competizioni sportive");
        $questionnaire_15_1_2 = $this->createSubquestionVF("VF", $questionnaire_15_1, "", "Riccardo ha finito le sue gare");
        $questionnaire_15_1_3 = $this->createSubquestionVF("VF", $questionnaire_15_1, "", "Laura non corre domani");
        // CREATION PROPOSITIONS
        $this->createPropositionVF("", "VRAI", true, $questionnaire_15_1_1);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_15_1_1);

        $this->createPropositionVF("", "VRAI", false, $questionnaire_15_1_2);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_15_1_2);

        $this->createPropositionVF("", "VRAI", false, $questionnaire_15_1_3);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_15_1_3);


        /*******************************************
                    QUESTIONNAIRE 17 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_17 = $this->createQuestionnaire("A1_CE_indications_route", "A1", "CE", $test, 1);
        $questionnaire_17->setOriginText("");
        $questionnaire_17->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere o false", ""));
        $questionnaire_17->setMediaContext($this->mediaText("", "Biglietto per una amica", ""));
        $questionnaire_17->setMediaText($this->mediaText("", "Ciao Sara,@@@io esco, ci vediamo direttamente a casa di Giorgio, ci vogliono due minuti a piedi. La festa inizia alle 10.00, non arrivare tardi come sempre! ;-) È facilissimo: attraversa la strada e continua dritto fino a piazza Verdi, poi quando arrivi al supermercato all’angolo prendi la seconda a sinistra, non puoi sbagliare, perché trovi il Bar Sport.@@@Dopo gira subito a destra e trovi la sua casa accanto al panificio. Suona al campanello Rossi.@@@A stasera, :-)@@@Lucia", ""));
        // CREATION QUESTION
        $questionnaire_17_1 = $this->createQuestion("TVF", $questionnaire_17);
        // CREATION SUBQUESTION
        $questionnaire_17_1_1 = $this->createSubquestionVF("VF", $questionnaire_17_1, "", "La casa di Giorgio è lontana da quella di Lucia e Sara");
        $questionnaire_17_1_2 = $this->createSubquestionVF("VF", $questionnaire_17_1, "", "Per andare alla festa Sara deve prendere il tram");
        $questionnaire_17_1_3 = $this->createSubquestionVF("VF", $questionnaire_17_1, "", "Il Bar Sport si trova dopo piazza Verdi");
        $questionnaire_17_1_4 = $this->createSubquestionVF("VF", $questionnaire_17_1, "", "La casa di Giorgio si trova al lato del panificio");
        // CREATION PROPOSITIONS
        $this->createPropositionVF("", "VRAI", false, $questionnaire_17_1_1);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_17_1_1);

        $this->createPropositionVF("", "VRAI", false, $questionnaire_17_1_2);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_17_1_2);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_17_1_3);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_17_1_3);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_17_1_4);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_17_1_4);

        /*******************************************
                    QUESTIONNAIRE 19 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_19 = $this->createQuestionnaire("A1_CE_agenda_anita", "A1", "CE", $test, 1);
        $questionnaire_19->setOriginText("");
        $questionnaire_19->setMediaInstruction($this->mediaText("", "", ""));
        $questionnaire_19->setMediaContext($this->mediaText("", "L’agenda di Anita", ""));
        $questionnaire_19->setMediaText($this->mediaText($startTitle . "" . $endTitle, "A1_CE_agenda_anita", "image"));

        // CREATION QUESTION
        $questionnaire_19_1 = $this->createQuestion("TVF", $questionnaire_19);
        // CREATION SUBQUESTION
        $questionnaire_19_1_1 = $this->createSubquestionVF("VF", $questionnaire_19_1, "", "Anita esce spesso con Luca");
        $questionnaire_19_1_2 = $this->createSubquestionVF("VF", $questionnaire_19_1, "", "Anita non va mai a correre");
        $questionnaire_19_1_3 = $this->createSubquestionVF("VF", $questionnaire_19_1, "", "Le lezioni di Anita sono quasi sempre la mattina");
        $questionnaire_19_1_4 = $this->createSubquestionVF("VF", $questionnaire_19_1, "", "Anita lavora solo la sera");

        // CREATION PROPOSITIONS
        $this->createPropositionVF("", "VRAI", false, $questionnaire_19_1_1);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_19_1_1);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_19_1_2);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_19_1_2);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_19_1_3);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_19_1_3);

        $this->createPropositionVF("", "VRAI", false, $questionnaire_19_1_4);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_19_1_4);
        /*******************************************
                    MISE EN BASE
        ********************************************/
        $em->flush();

        $output->writeln("Fixtures Italian CE A1 exécutées.");
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
