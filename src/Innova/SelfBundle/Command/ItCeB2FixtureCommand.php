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
class ItCeB2FixtureCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('self:fixtures:itceb2')
            ->setDescription('SELF CE Italien B2 Pilote 2')
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
        $test = $this->createTest("Italien b2", "Italian");

        // To have CSS form title. #166
        $startTitle = "<span class=\"title-situation\">";
        $endTitle = "</span>";

        /*******************************************

                    NIVEAU : B2

        ********************************************/

        /*******************************************
                    QUESTIONNAIRE 9 : TVFNM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_9 = $this->createQuestionnaire("B2_CE_yeux_sur_saturne", "B2", "CE", $test, 1);
        $questionnaire_B2_9->setOriginText("");
        $questionnaire_B2_9->setMediaInstruction($this->mediaText("", "", ""));
        $questionnaire_B2_9->setMediaContext($this->mediaText("", "Articolo su sito internet", ""));
        $questionnaire_B2_9->setMediaText($this->mediaText($startTitle . "Occhi su Saturno" . $endTitle, "Sabato 18 maggio, una sera per mostrare Saturno all’Italia.
La sera del 18 maggio cerca l'evento a te più vicino e scopri dal vivo Saturno, senza dubbio il più bel pianeta del Sistema Solare, generazioni di astronomi hanno posato gli occhi su di lui. Ora grazie alle sonde spaziali abbiamo una visione senza precedenti di Saturno, dei suoi anelli e dei suoi satelliti. Ma lo splendore di questo pianeta è folgorante anche se osservato con un piccolo telescopio.@@@Tratto da: www.occhisusaturno.it",
""));
        // CREATION QUESTION
        $questionnaire_B2_9_1 = $this->createQuestion("TVFNM", $questionnaire_B2_9);
        // CREATION SUBQUESTION
        $questionnaire_B2_9_1_1 = $this->createSubquestion("VFNM", $questionnaire_B2_9_1, "“Occhi su Saturno” è un’iniziativa organizzata da un gruppo di astronomi");
        $questionnaire_B2_9_1_2 = $this->createSubquestion("VFNM", $questionnaire_B2_9_1, "L’iniziativa non sarà solo locale, ma avrà luogo anche in diverse regioni italiane");
        $questionnaire_B2_9_1_3 = $this->createSubquestion("VFNM", $questionnaire_B2_9_1, "Il pianeta sarà visibile ad occhio nudo");
        // CREATION PROPOSITIONS
        $this->createProposition("VRAI", false, $questionnaire_B2_9_1_1);
        $this->createProposition("FAUX", false, $questionnaire_B2_9_1_1);
        $this->createProposition("ND", true, $questionnaire_B2_9_1_1);

        $this->createProposition("VRAI", true, $questionnaire_B2_9_1_2);
        $this->createProposition("FAUX", false, $questionnaire_B2_9_1_2);
        $this->createProposition("ND", false, $questionnaire_B2_9_1_2);

        $this->createProposition("VRAI", false, $questionnaire_B2_9_1_3);
        $this->createProposition("FAUX", true, $questionnaire_B2_9_1_3);
        $this->createProposition("ND", false, $questionnaire_B2_9_1_3);

        /*******************************************
                    QUESTIONNAIRE 1 : TVFNM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_1 = $this->createQuestionnaire("B2_CE_devenir_celebres_sur_internet", "B2", "CE", $test, 1);
        $questionnaire_B2_1->setOriginText("");
        $questionnaire_B2_1->setMediaInstruction($this->mediaText("", "", ""));
        $questionnaire_B2_1->setMediaContext($this->mediaText("", "Post su blog", ""));
        $questionnaire_B2_1->setMediaText($this->mediaText($startTitle . "Come diventare famosi su internet" . $endTitle, "La celeberrima frase “Nel futuro, tutti avranno 15 minuti di celebrità”, pronunciata nel 1968 da Andy Warhol, diventa ogni giorno più profetica su internet. Ecco qualche consiglio su come diventare una ***web celebrity***.@@@• Occhio a chi incontri su internet ed evita di condividere troppe informazioni personali.@@@• Gira un video su di te o sul tuo talento e pubblicalo su YouTube.@@@• Il successo va e viene. Però, se lavori duro, offri contenuti freschi ed incanti i tuoi lettori, ***follower*** e spettatori, sarà più facile mantenerti a galla. Punta ad una fama che ti permetta di avere un articolo dedicato a te su Wikipedia e che ti consenta di poter dire che hai raggiunto una certa notorietà. In questo modo, il tuo successo si terrà in piedi, a meno che qualcuno non ti cancelli ma, ehi, siamo su internet!@@@Adattato da: it.wikihow.com",
        ""));
        // CREATION QUESTION
        $questionnaire_B2_1_1 = $this->createQuestion("TVF", $questionnaire_B2_1);
        // CREATION SUBQUESTION
        $questionnaire_B2_1_1_1 = $this->createSubquestion("VF", $questionnaire_B2_1_1, "La celebre frase di Andy Warhol si rivela illusoria per gli utenti di internet");
        $questionnaire_B2_1_1_2 = $this->createSubquestion("VF", $questionnaire_B2_1_1, "Secondo l’autore il successo su internet è un fenomeno duraturo");
        $questionnaire_B2_1_1_3 = $this->createSubquestion("VF", $questionnaire_B2_1_1, "Si consiglia di pubblicare sempre nuovi articoli per rimanere visibili");
        $questionnaire_B2_1_1_4 = $this->createSubquestion("VF", $questionnaire_B2_1_1, "Si consiglia di diffidare da chi si incontra in rete");
        // CREATION PROPOSITIONS
        $this->createProposition("VRAI", false, $questionnaire_B2_1_1_1);
        $this->createProposition("FAUX", true, $questionnaire_B2_1_1_1);

        $this->createProposition("VRAI", false, $questionnaire_B2_1_1_2);
        $this->createProposition("FAUX", true, $questionnaire_B2_1_1_2);

        $this->createProposition("VRAI", true, $questionnaire_B2_1_1_3);
        $this->createProposition("FAUX", false, $questionnaire_B2_1_1_3);

        $this->createProposition("VRAI", true, $questionnaire_B2_1_1_4);
        $this->createProposition("FAUX", false, $questionnaire_B2_1_1_4);

        /*******************************************
                    QUESTIONNAIRE 6 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_98 = $this->createQuestionnaire("B2_CE_menu_viande_2_personnes", "B2", "CE", $test, 0);
        $questionnaire_98->setOriginText("Une ou plusieurs réponses correctes");
        $questionnaire_98->setMediaInstruction($this->mediaText("", "", ""));
        $questionnaire_98->setMediaContext($this->mediaText("", "Promozione su sito internet", ""));
        $questionnaire_98->setMediaText($this->mediaText($startTitle . "Menù di carne per due" . $endTitle,
        "###MENU' DI CARNE PER DUE con ricco antipasto rustico + secondo a scelta + contorno + caffè a 23 Euro! Vivi una serata emozionante nella giungla!### @@@Concediti una serata avventurosa nella giungla senza scappare dalla metropoli con la promozione PoinX per una:@@@Cena per Due a 23 Euro invece di 47 Euro presso il Ristorante Tam Tam.@@@Per scendere nella giungla, la scelta è obbligata: si prende lo scivolo (o le scale per i meno temerari)! Sì perché per accedere al locale dovete proprio tornare bambini e fare una bella e lunga scivolata dove alla fine dello scivolo ad attendervi troverete un enorme KING KONG che vi darà il benvenuto insieme a tanti altri animali sparsi per tutta “la giungla” come Leoni, Avvoltoi, Rapaci e Coccodrilli, tutti lì pronti ad aspettarti!
Affrettati, perché i coupon sono limitati!@@@Tratto da: www.poinx.it", ""));

        // CREATION QUESTION
        $questionnaire_98_1 = $this->createQuestion("TQRM", $questionnaire_98);
        // CREATION SUBQUESTION
        $questionnaire_98_1_1 = $this->createSubquestion("QRM", $questionnaire_98_1, "La promozione PoinX:");
        $questionnaire_98_1_2 = $this->createSubquestion("QRM", $questionnaire_98_1, "L'annuncio pubblicizza una cena in un ristorante:");
        $questionnaire_98_1_3 = $this->createSubquestion("QRM", $questionnaire_98_1, "L'accesso al ristorante:");
        // CREATION PROPOSITIONS
        $this->createProposition("è valida per poco tempo", true, $questionnaire_98_1_1);
        $this->createProposition("interessa solo le coppie", false, $questionnaire_98_1_1);
        $this->createProposition("prevede un menù per bambini", false, $questionnaire_98_1_1);
        $this->createProposition("non prevede un menù vegetariano", true, $questionnaire_98_1_1);

        $this->createProposition("in campagna", false, $questionnaire_98_1_2);
        $this->createProposition("in città", true, $questionnaire_98_1_2);
        $this->createProposition("di un parco divertimenti", false, $questionnaire_98_1_2);
        $this->createProposition("con tema \"la giungla\"", true, $questionnaire_98_1_2);

        $this->createProposition("prevede il passaggio in una giungla", false, $questionnaire_98_1_3);
        $this->createProposition("avviene unicamente attraverso uno scivolo", false, $questionnaire_98_1_3);
        $this->createProposition("simula l'entrata in una giungla", true, $questionnaire_98_1_3);
        $this->createProposition("avviene anche attraverso delle scale", true, $questionnaire_98_1_3);

        /*******************************************
                    QUESTIONNAIRE 6 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_6 = $this->createQuestionnaire("B2_CE_pizza_nel_cuore", "B2", "CE", $test, 0);
        $questionnaire_6->setOriginText("");
        $questionnaire_6->setMediaInstruction($this->mediaText("", "", ""));
        $questionnaire_6->setMediaContext($this->mediaText("", "Pubblicità su sito internet", ""));
        $questionnaire_6->setMediaText($this->mediaText($startTitle . "Qui pizza nel cuore" . $endTitle,
        "I Partner del progetto sono aziende leader nel settore, in collaborazione con tecnologi, nutrizionisti e ricercatori universitari, per offrire all’operatore professionale e al consumatore finale risposte serie e strumenti concreti per valorizzare le caratteristiche qualitative e le proprietà nutrizionali di un alimento principe della nostra alimentazione: la pizza. Aderire al progetto “Qui Pizza nel cuore” offre notevoli vantaggi competitivi, significa sposare una filosofia di qualità che abbraccia tutta la filiera della pizza, che rispetta il modello alimentare della dieta mediterranea e pone in primo piano la sensibilità del consumatore per la sana, corretta e gustosa alimentazione. Ogni “Qui Pizza nel cuore” verrà servito, assistito e guidato per massimizzare i benefici, cogliendo tutte le opportunità di crescita verso la propria clientela.@@@Adattato da: www.pizzanelcuore.net", ""));

        // CREATION QUESTION
        $questionnaire_6_1 = $this->createQuestion("TQRU", $questionnaire_6);
        // CREATION SUBQUESTION
        $questionnaire_6_1_1 = $this->createSubquestion("QRU", $questionnaire_6_1, "L'annuncio pubblicitario intende promuovere:");
        $questionnaire_6_1_2 = $this->createSubquestion("QRU", $questionnaire_6_1, "L'annuncio pubblicizza:");
        // CREATION PROPOSITIONS
        $this->createProposition("la nuova marca di pizza “Qui Pizza nel cuore”", false, $questionnaire_6_1_1);
        $this->createProposition("una nuova pizza dietetica “Qui Pizza nel cuore”", false, $questionnaire_6_1_1);
        $this->createProposition("la pizza secondo l’antica ricetta", false, $questionnaire_6_1_1);
        $this->createProposition("il nuovo marchio di produzione “Qui Pizza nel cuore”", true, $questionnaire_6_1_1);

        $this->createProposition("una dieta alimentare per perdere peso conservando il gusto", false, $questionnaire_6_1_2);
        $this->createProposition("un modello per il consumo alimentare equilibrato", true, $questionnaire_6_1_2);
        $this->createProposition("una nuova gustosa ricetta della pizza", false, $questionnaire_6_1_2);
        $this->createProposition("una nuova ricetta mediterranea della pizza", false, $questionnaire_6_1_2);

        /*******************************************
                    QUESTIONNAIRE 38 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_38 = $this->createQuestionnaire("B2_CE_aborder_examen", "B2", "CE", $test, 0);
        $questionnaire_38->setOriginText("");
        $questionnaire_38->setMediaInstruction($this->mediaText("", "", ""));
        $questionnaire_38->setMediaContext($this->mediaText("", "Post su blog studentesco", ""));
        $questionnaire_38->setMediaText($this->mediaText($startTitle . "Breve decalogo per affrontare un esame" . $endTitle,
        "• Il \"nemico\" va conosciuto. Andate ad assistere agli esami prima di darli.@@@• Siate gradevoli nell'aspetto. L'abito in questo caso fa il monaco.@@@• Sappiate ascoltare. Aspettate a rispondere finché il docente non ha concluso la domanda.@@@• Siate precisi, non arrampicatevi sugli specchi. Se non sapete la risposta non dite cose inesatte.@@@• Se avete un vuoto mentale, ammettetelo. Chiedete poi al professore di riproporvi successivamente la domanda.@@@Adattato da: www.opsonline.it",
        ""));

        // CREATION QUESTION
        $questionnaire_38_1 = $this->createQuestion("TQRU", $questionnaire_38);
        // CREATION SUBQUESTION
        $questionnaire_38_1_1 = $this->createSubquestion("QRU", $questionnaire_38_1, "Il decalogo suggerisce di:");
        $questionnaire_38_1_2 = $this->createSubquestion("QRU", $questionnaire_38_1, "Se non si conosce la risposta, il decalogo suggerisce di:");
        // CREATION PROPOSITIONS
        $this->createProposition("studiare le domande più frequenti poste durante gli esami", false, $questionnaire_38_1_1);
        $this->createProposition("osservare gli esami sostenuti da altri studenti", true, $questionnaire_38_1_1);
        $this->createProposition("anticipare le risposte per fare una buona impressione", false, $questionnaire_38_1_1);
        $this->createProposition("assistere agli esami dei colleghi per poter scegliere il giusto abbigliamento", false, $questionnaire_38_1_1);

        $this->createProposition("dare comunque una risposta il più possibile verosimile", false, $questionnaire_38_1_2);
        $this->createProposition("ragionare sulle domande ed arrivare ad una soluzione logica", false, $questionnaire_38_1_2);
        $this->createProposition("rinunciare a rispondere subito per evitare un’espressione vaga e incompleta", true, $questionnaire_38_1_2);
        $this->createProposition("evitare di tacere cercando però di non dare risposte totalmente inesatte", false, $questionnaire_38_1_2);

        /*******************************************
                    QUESTIONNAIRE 39 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_39 = $this->createQuestionnaire("B2_CE_devenir_pilote", "B2", "CE", $test, 0);
        $questionnaire_39->setOriginText("");
        $questionnaire_39->setMediaInstruction($this->mediaText("", "", ""));
        $questionnaire_39->setMediaContext($this->mediaText("", "Messaggio di benvenuto su sito internet", ""));
        $questionnaire_39->setMediaText($this->mediaText($startTitle . "Benvenuto in ***Diventa Pilota***" . $endTitle,
        "Benvenuto in ***Diventa Pilota***, il portale per tutto ciò che vuoi sapere sul diventare pilota d’aereo, e su come atterrare sul lavoro perfetto per te.@@@Questo sito è impostato come un vecchio manuale di rotte, speriamo che tu riesca a far tuo questo manuale così da trovare la tua rotta verso questa bellissima professione. Non vedi l'ora d'iniziare, di immergerti nei libri, di leggere cartine, di metterti un paio di cuffie addosso e parlare alla radio del tuo aereo?@@@Se hai qualsiasi domanda o dubbio puoi scriverci un email a info@diventapilota.it, oppure guarda i nostri contatti.@@@Buona lettura e... Speriamo presto di poterti augurare “buon volo”.@@@Adattato da: www.diventapilota.it",
        ""));

        // CREATION QUESTION
        $questionnaire_39_1 = $this->createQuestion("TQRU", $questionnaire_39);
        // CREATION SUBQUESTION
        $questionnaire_39_1_1 = $this->createSubquestion("QRU", $questionnaire_39_1, "Il sito dà istruzioni:");
        $questionnaire_39_1_2 = $this->createSubquestion("QRU", $questionnaire_39_1, "Nel secondo paragrafo:");
        // CREATION PROPOSITIONS
        $this->createProposition("tecniche su come effettuare un buon atterraggio", false, $questionnaire_39_1_1);
        $this->createProposition("generali a chi svolge il lavoro di pilota", false, $questionnaire_39_1_1);
        $this->createProposition("tecniche a coloro che studiano per essere piloti", false, $questionnaire_39_1_1);
        $this->createProposition("generali a coloro che vogliono prepararsi al lavoro di pilota", true, $questionnaire_39_1_1);

        $this->createProposition("si suggerisce di consultare un vecchio manuale di percorsi aerei", false, $questionnaire_39_1_2);
        $this->createProposition("si augura a chi legge di intraprendere la giusta strada per diventare pilota", true, $questionnaire_39_1_2);
        $this->createProposition("si pubblicizza un manuale che descrive la professione di pilota", false, $questionnaire_39_1_2);
        $this->createProposition("si consiglia di consultare una guida per la professione di pilota", false, $questionnaire_39_1_2);

        /*******************************************
                    RESILIATION CONTRAT
        ********************************************/
        /*******************************************
                    QUESTIONNAIRE 6 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_6 = $this->createQuestionnaire("B2_CE_resiliation_contrat", "B2", "CE", $test, 0);
        $questionnaire_B2_6->setOriginText("");
        $questionnaire_B2_6->setMediaInstruction($this->mediaText("", "Il Sig. Verni scrive al Sig. Pastani per:", ""));
        $questionnaire_B2_6->setMediaContext($this->mediaText("", "Lettera di disdetta contratto di locazione", ""));
        $questionnaire_B2_6->setMediaText($this->mediaText($startTitle . "" . $endTitle, "B2_CE_resiliation_contrat", "image"));

        // CREATION QUESTION
        $questionnaire_B2_6_1 = $this->createQuestion("QRU", $questionnaire_B2_6);
        // CREATION SUBQUESTION
        $questionnaire_B2_6_1_1 = $this->createSubquestion("QRU", $questionnaire_B2_6_1, "");
        // CREATION PROPOSITIONS
        $this->createProposition("chiedere la sospensione temporanea del contratto di affitto. Si impegna comunque a trovare un sostituto per i mesi in cui sarà assente", false, $questionnaire_B2_6_1_1);
        $this->createProposition("rescindere il contratto d’affitto con ampio anticipo, e si impegna con il proprietario a inviargli il nome del futuro inquilino", false, $questionnaire_B2_6_1_1);
        $this->createProposition("richiedere la sospensione anticipata del contratto. Chiede inoltre di essere informato sulla data esatta in cui dovrà lasciare l’appartamento", true, $questionnaire_B2_6_1_1);

       /*******************************************
                    QUESTIONNAIRE 7 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_7 = $this->createQuestionnaire("B2_CE_carte_electorale", "B2", "CE", $test, 1);
        $questionnaire_B2_7->setOriginText("");
        $questionnaire_B2_7->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere o false.", ""));
        $questionnaire_B2_7->setMediaContext($this->mediaText("", "Avviso in Comune", ""));
        $questionnaire_B2_7->setMediaText($this->mediaText($startTitle . "Tessera elettorale per le elezioni politiche" . $endTitle, "L’ufficio elettorale comunale resta a  disposizione per quanto segue:@@@• coloro che non avessero ricevuto la tessera elettorale a domicilio, possono ritirarla presso l’ufficio elettorale;@@@• coloro che avessero smarrito, deteriorato o subito il furto della tessera elettorale, possono ottenere un duplicato presentandosi all’ufficio elettorale;@@@• nel caso di smarrimento la domanda di duplicato deve essere corredata da denuncia presentata ai competenti uffici di pubblica sicurezza.",
        ""));
        // CREATION QUESTION
        $questionnaire_B2_7_1 = $this->createQuestion("TVF", $questionnaire_B2_7);

        // CREATION SUBQUESTION
        $questionnaire_B2_7_1_1 = $this->createSubquestionVF("VF", $questionnaire_B2_7_1, "", "Se la tessera non è arrivata per posta, bisogna recarsi all’ufficio elettorale");
        $questionnaire_B2_7_1_2 = $this->createSubquestionVF("VF", $questionnaire_B2_7_1, "", "In caso di tessera elettorale rovinata e inutilizzabile, è possibile ricevere una copia dell’originale a casa");
        $questionnaire_B2_7_1_3 = $this->createSubquestionVF("VF", $questionnaire_B2_7_1, "", "Coloro che avessero perso la tessera elettorale, devono esporre denuncia alla polizia");

        // CREATION PROPOSITIONS
        $this->createPropositionVF("", "VRAI", true, $questionnaire_B2_7_1_1);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_B2_7_1_1);

        $this->createPropositionVF("", "VRAI", false, $questionnaire_B2_7_1_2);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_B2_7_1_2);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_B2_7_1_3);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_B2_7_1_3);

        /*******************************************
                    QUESTIONNAIRE 10 : TVFNM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_10 = $this->createQuestionnaire("B2_CE_metiers_bien_payes", "B2", "CE", $test, 1);
        $questionnaire_B2_10->setOriginText("");
        $questionnaire_B2_10->setMediaInstruction($this->mediaText("", "", ""));
        $questionnaire_B2_10->setMediaContext($this->mediaText("", "Articolo su sito internet", ""));
        $questionnaire_B2_10->setMediaText($this->mediaText($startTitle . "I lavori ben pagati che nessuno ha voglia di fare" . $endTitle, "Sei alla ricerca di un lavoro? Ci sono molti settori che offrono molte opportunità e lavori pagati molto bene, ma dove si fa fatica a trovare personale. Scopri quali sono i lavori con più richieste.@@@Tempo di crisi. Ed è difficile trovare lavoro. Ma è veramente così?@@@Ci sono alcuni settori che offrono molte opportunità di lavoro, anche ben pagate, ma ai giovani non interessano. E così le aziende fanno fatica a trovare personale. Ed allora perché non provare a confrontarsi con queste opportunità invece di lamentarsi che in Italia non c'è lavoro?@@@Tratto da: www.studenti.it
" ,""));
        // CREATION QUESTION
        $questionnaire_B2_10_1 = $this->createQuestion("TVFNM", $questionnaire_B2_10);
        // CREATION SUBQUESTION
        $questionnaire_B2_10_1_1 = $this->createSubquestion("VFNM", $questionnaire_B2_10_1, "L’articolo propone lavori ben retribuiti ma fisicamente duri");
        $questionnaire_B2_10_1_2 = $this->createSubquestion("VFNM", $questionnaire_B2_10_1, "L’articolo denuncia mancanza di forza lavoro disponibile in alcuni settori");
        $questionnaire_B2_10_1_3 = $this->createSubquestion("VFNM", $questionnaire_B2_10_1, "I giovani si lamentano delle condizioni di lavoro in Italia");
        // CREATION PROPOSITIONS
        $this->createProposition("VRAI", false, $questionnaire_B2_10_1_1);
        $this->createProposition("FAUX", false, $questionnaire_B2_10_1_1);
        $this->createProposition("ND", true, $questionnaire_B2_10_1_1);

        $this->createProposition("VRAI", true, $questionnaire_B2_10_1_2);
        $this->createProposition("FAUX", false, $questionnaire_B2_10_1_2);
        $this->createProposition("ND", false, $questionnaire_B2_10_1_2);

        $this->createProposition("VRAI", false, $questionnaire_B2_10_1_3);
        $this->createProposition("FAUX", false, $questionnaire_B2_10_1_3);
        $this->createProposition("ND", true, $questionnaire_B2_10_1_3);

        /*******************************************
                    QUESTIONNAIRE 10 : TVFNM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_B2_10 = $this->createQuestionnaire("B2_CE_candidature", "B2", "CE", $test, 1);
        $questionnaire_B2_10->setOriginText("");
        $questionnaire_B2_10->setMediaInstruction($this->mediaText("", "Indica se le affermazioni sono vere, false o non dette.", ""));
        $questionnaire_B2_10->setMediaContext($this->mediaText("", "Candidatura spontanea", ""));
        $questionnaire_B2_10->setMediaText($this->mediaText($startTitle . "" . $endTitle, "Egregio Direttore,@@@vorrei sottoporre alla Sua cortese attenzione la mia candidatura. Sono interessato ad un’eventuale assunzione nella vostra Azienda, leader nel settore della ristorazione. Come potete vedere dal Curriculum vitae che allego, dopo aver conseguito il diploma alberghiero ho svolto un tirocinio per approfondire le conoscenze nel servizio di sala e parlo abbastanza bene il tedesco e l’inglese. Sono disponibile fin da subito anche per un’assunzione a tempo determinato o con contratto di Formazione e Lavoro. Sono altresì disponibile a frequentare eventuali corsi di formazione e a fare trasferte, anche all’estero. Spero pertanto che vogliate considerare la mia candidatura.@@@In attesa di poter avere un colloquio di persona, ringrazio per l’attenzione dedicatami.@@@
Distinti saluti.@@@Luca Gentile", ""));
        // CREATION QUESTION
        $questionnaire_B2_10_1 = $this->createQuestion("TVF", $questionnaire_B2_10);
        // CREATION SUBQUESTION
        $questionnaire_B2_10_1_1 = $this->createSubquestion("VF", $questionnaire_B2_10_1, "Nella lettera di candidatura, Luca scrive di avere conseguito un’esperienza formativa come cameriere di sala");
        $questionnaire_B2_10_1_2 = $this->createSubquestion("VF", $questionnaire_B2_10_1, "Luca ha già operato nel settore della ristorazione");
        $questionnaire_B2_10_1_3 = $this->createSubquestion("VF", $questionnaire_B2_10_1, "Luca scrive di volere solo un impiego a lungo termine");
        // CREATION PROPOSITIONS
        $this->createProposition("VRAI", true, $questionnaire_B2_10_1_1);
        $this->createProposition("FAUX", false, $questionnaire_B2_10_1_1);

        $this->createProposition("VRAI", true, $questionnaire_B2_10_1_2);
        $this->createProposition("FAUX", false, $questionnaire_B2_10_1_2);

        $this->createProposition("VRAI", false, $questionnaire_B2_10_1_3);
        $this->createProposition("FAUX", true, $questionnaire_B2_10_1_3);

        /*******************************************
                    MISE EN BASE
        ********************************************/
        $em->flush();

        $output->writeln("Fixtures Italian CE B2 exécutées.");
        $output->writeln("");
        $output->writeln("IMPORTANT : copier les images dans media.");

    }

    /**
     *
     */
    protected function createTest($name, $language)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        if (!$test = $em->getRepository('InnovaSelfBundle:Test')->findOneByName($name)) {
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
        } else {
            $media->setName(StaticCommand::textSource($title.$name));
            $media->setDescription(StaticCommand::textSource($title.$name)); // Ajout ERV 03/03/2014 car c'est la description que l'on affiche dans la macro.texte
            $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("texte"));
            $media->setUrl(NULL);
        }

        $em->persist($media);

        return $media;
    }

}
