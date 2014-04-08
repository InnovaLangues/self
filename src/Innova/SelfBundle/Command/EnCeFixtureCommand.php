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
class EnceFixtureCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('self:fixtures:ence')
            ->setDescription('English CE test')
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
        $test = $this->createTest("Anglais", "English");

        // To have CSS form title. #166
        $startTitle = "<span class=\"title-situation\">";
        $endTitle = "</span>";

        /*******************************************

                    NIVEAU : B1

        ********************************************/

        /*******************************************
                    QUESTIONNAIRE 1 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_1 = $this->createQuestionnaire("B1_CE_AgathaChristie", "B1", "CE", $test);
        $questionnaire_1->setMediaInstruction($this->mediaText("", "Read the text and answer the following question.", ""));
        $questionnaire_1->setMediaText(
            $this->mediaText("",
            "Dame Agatha Mary Clarissa Christie, DBE (born Miller; 15 September 1890 – 12 January 1976) was an English crime writer of novels, short stories, and plays. She also wrote six romances under the name Mary Westmacott, but she is best remembered for the 66 detective novels and 14 short story collections she wrote under her own name, most of which revolve around the investigations of such characters as Hercule Poirot, Miss Jane Marple and Tommy and Tuppence. She also wrote the world's longest-running play, The Mousetrap.",
            "")
            );
        // CREATION QUESTION
        $questionnaire_1_1 = $this->createQuestion("QRU", $questionnaire_1);
        // CREATION SUBQUESTION
        $questionnaire_1_1_1 = $this->createSubquestion("QRU", $questionnaire_1_1, "Who is Mary Westmacott?");

        // CREATION PROPOSITIONS
        $this->createProposition("Agatha Christie", true, $questionnaire_1_1_1);
        $this->createProposition("A friend writer of Agatha Christie", false, $questionnaire_1_1_1);
        $this->createProposition("A character in one of Agatha Christie’s novels", false, $questionnaire_1_1_1);

        /*******************************************
                    QUESTIONNAIRE 2 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_2 = $this->createQuestionnaire("B1_CE_Parmesanchicken", "B1", "CE", $test);
        $questionnaire_2->setMediaInstruction($this->mediaText("", "Read the text and answer the questions.", ""));
        $questionnaire_2->setMediaText(
            $this->mediaText("",
            "1. Preheat oven to 350 degrees F (175 degrees C). Lightly grease a 9x13 inch baking dish.@@@ 2. In a bowl, blend the olive oil and garlic. In a separate bowl, mix the bread crumbs, Parmesan cheese, basil, and pepper. Dip each chicken breast in the oil mixture, then in the bread crumb mixture. Arrange the coated chicken breasts in the prepared baking dish, and top with any remaining bread crumb mixture.@@@ 3. Bake 30 minutes in the preheated oven, or until chicken is no longer pink and juices run clear.",
            ""));
        // CREATION QUESTION
        $questionnaire_2_1 = $this->createQuestion("TQRU", $questionnaire_2);
        // CREATION SUBQUESTION
        $questionnaire_2_1_1 = $this->createSubquestion("QRU", $questionnaire_2_1, "When do we have to heat the oven?");
        $questionnaire_2_1_2 = $this->createSubquestion("QRU", $questionnaire_2_1, "Where should we put the bread crumbs that are not used?");
        $questionnaire_2_1_3 = $this->createSubquestion("QRU", $questionnaire_2_1, "What is the visual indicator that means the dish is ready?");
        // CREATION PROPOSITIONS
        $this->createProposition("As you start the recipe", true, $questionnaire_2_1_1);
        $this->createProposition("When the chicken is no longer pink", false, $questionnaire_2_1_1);
        $this->createProposition("After putting the breadcrumb mixture", false, $questionnaire_2_1_1);

        $this->createProposition("Over the chicken breast at the end", true, $questionnaire_2_1_2);
        $this->createProposition("At the bottom of the baking dish", false, $questionnaire_2_1_2);
        $this->createProposition("In a bowl for another preparation", false, $questionnaire_2_1_2);

        $this->createProposition("The pink colour has totally disappeared", true, $questionnaire_2_1_3);
        $this->createProposition("The juice turns brown", false, $questionnaire_2_1_3);
        $this->createProposition("The meat is lightly pink", false, $questionnaire_2_1_3);

        /*******************************************
                    QUESTIONNAIRE 3 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_3 = $this->createQuestionnaire("B1_CE_Porsche", "B1", "CE", $test);
        $questionnaire_3->setMediaInstruction($this->mediaText("", "Read the text and answer the questions.", ""));
        $questionnaire_3->setMediaText($this->mediaText("B1_CE_Porsche", "B1_CE_Porsche", "image"));
        // CREATION QUESTION
        $questionnaire_3_1 = $this->createQuestion("TQRU", $questionnaire_3);
        // CREATION SUBQUESTION
        $questionnaire_3_1_1 = $this->createSubquestion("QRU", $questionnaire_3_1, "The advertisement is encouraging you to buy …");
        $questionnaire_3_1_2 = $this->createSubquestion("QRU", $questionnaire_3_1, "What do they say about people?");
        // CREATION PROPOSITIONS
        $this->createProposition("A Porsche", true, $questionnaire_3_1_1);
        $this->createProposition("A Mitsubishi", false, $questionnaire_3_1_1);
        $this->createProposition("A Nissan", false, $questionnaire_3_1_1);

        $this->createProposition("Everybody waits years before buying a Porsche", true, $questionnaire_3_1_2);
        $this->createProposition("Everybody dreams of buying a Nissan", false, $questionnaire_3_1_2);
        $this->createProposition("Everybody has driven a Porsche once", false, $questionnaire_3_1_2);

        /*******************************************
                    QUESTIONNAIRE 4 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_4 = $this->createQuestionnaire("B1_CE_Renewableenergy", "B1", "CE", $test);
        $questionnaire_4->setMediaInstruction($this->mediaText("", "Read the text and answer the questions.", ""));
        $questionnaire_4->setMediaText(
        $this->mediaText("",
        "Most people agree that carbon emissions from power stations are a significant cause of climate change. These days a fiercer argument is over what to do about it. Many governments are pumping money into renewable sources of electricity, such as wind turbines, solar farms, hydroelectric and geothermal plants. But countries with large amounts of renewable generation, such as Denmark and Germany, face the highest energy prices in the rich world. In Britain electricity from wind farms costs twice as much as that from traditional sources; solar power is even more dear.",
        ""));
        // CREATION QUESTION
        $questionnaire_4_1 = $this->createQuestion("TQRU", $questionnaire_4);
        // CREATION SUBQUESTION
        $questionnaire_4_1_1 = $this->createSubquestion("QRU", $questionnaire_4_1, "What, according to this extract, is the major problem with renewable sources of energy?");
        $questionnaire_4_1_2 = $this->createSubquestion("QRU", $questionnaire_4_1, "What is the meaning of “solar power is even more dear”?");
        // CREATION PROPOSITIONS
        $this->createProposition("They are very expensive in comparison to non-renewable sources", true, $questionnaire_4_1_1);
        $this->createProposition("Governments argue over which renewable source of energy is better", false, $questionnaire_4_1_1);
        $this->createProposition("No-one knows if they will really reduce climate change", false, $questionnaire_4_1_1);

        $this->createProposition("Solar energy is very expensive", true, $questionnaire_4_1_2);
        $this->createProposition("Solar energy is required in Britain", false, $questionnaire_4_1_2);
        $this->createProposition("People in Britain love solar energy", false, $questionnaire_4_1_2);

        /*******************************************
                    QUESTIONNAIRE 5 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_5 = $this->createQuestionnaire("B1_CE_Valentinesales", "B1", "CE", $test);
        $questionnaire_5->setMediaInstruction($this->mediaText("", "Read the text and answer the following question.", ""));
        $questionnaire_5->setMediaText($this->mediaText("", "Today couples tend to celebrate by exchanging gifts, from greeting cards to chocolates to weekend getaways.
According to the National Retail Federation’s 2008 Valentine’s Day Consumer Intentions and Actions Survey, conducted by Columbus-based BIGresearch, the average consumer plans to spend $122.98 on this day – an increase of about $3 over last year.", ""));
        // CREATION QUESTION
        $questionnaire_5_1 = $this->createQuestion("QRU", $questionnaire_5);
        // CREATION SUBQUESTION
        $questionnaire_5_1_1 = $this->createSubquestion("QRU", $questionnaire_5_1, "According to the survey, how would the sales be this year?");

        // CREATION PROPOSITIONS
        $this->createProposition("Better than last year", true, $questionnaire_5_1_1);
        $this->createProposition("Worse than last year", false, $questionnaire_5_1_1);
        $this->createProposition("The same as last year", false, $questionnaire_5_1_1);

        /*******************************************
                    QUESTIONNAIRE 6 : QRM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_6 = $this->createQuestionnaire("B1_CE_Doves", "B1", "CE", $test);
        $questionnaire_6->setMediaInstruction($this->mediaText("", "Read the text and find the 2 correct answers.", ""));
        $questionnaire_6->setMediaText($this->mediaText("", "White doves are a traditional symbol of love and peace, so the idea of releasing doves at a wedding, christening or funeral may seem like an innocent expression of affection. But what about the animals involved?
The theory is that the doves should automatically return to their place of origin using their innate homing instinct but the ISPCA is seeing a different picture emerge. After a release of doves at a wedding in Athlone, 3 young birds remained around the hotel disorientated and confused. By the time ISPCA Inspector Karen Lyons captured the last of the birds they were severely underweight.", ""));
        // CREATION QUESTION
        $questionnaire_6_1 = $this->createQuestion("QRM", $questionnaire_6);
        // CREATION SUBQUESTION
        $questionnaire_6_1_1 = $this->createSubquestion("QRM", $questionnaire_6_1, "What did the ISPCA observe?");
        // CREATION PROPOSITIONS
        $this->createProposition("Doves are not always able to return to their home", true, $questionnaire_6_1_1);
        $this->createProposition("Doves didn’t know how to provide nourishment for themselves", true, $questionnaire_6_1_1);
        $this->createProposition("Some of the birds died", false, $questionnaire_6_1_1);

        /*******************************************
                    QUESTIONNAIRE 7 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_8 = $this->createQuestionnaire("B1_CE_Scubadiving", "B1", "CE", $test);
        $questionnaire_8->setMediaInstruction($this->mediaText("", "According to the text, are the following statements true or false ?", ""));
        $questionnaire_8->setMediaText($this->mediaText("", "Scuba diving is a form of underwater diving in which a diver uses a self contained underwater breathing apparatus (scuba) to breathe underwater. Unlike other modes of diving, which rely either on breath-hold or on air pumped from the surface, scuba divers carry their own source of breathing gas, (usually compressed air), allowing them greater freedom of movement than with an air line or diver's umbilical and longer underwater endurance than breath-hold.", ""));
        // CREATION QUESTION
        $questionnaire_8_1 = $this->createQuestion("TVF", $questionnaire_8);
        // CREATION SUBQUESTION
        $questionnaire_8_1_1 = $this->createSubquestionVF("VF", $questionnaire_8_1, "", "The air used by the scuba diver is pumped from the surface");
        $questionnaire_8_1_2 = $this->createSubquestionVF("VF", $questionnaire_8_1, "", "Divers can stay longer underwater");
        $questionnaire_8_1_3 = $this->createSubquestionVF("VF", $questionnaire_8_1, "", "Scuba divers don’t need to hold their breath");
        // CREATION PROPOSITIONS
        $this->createPropositionVF("", "VRAI", false, $questionnaire_8_1_1);
        $this->createPropositionVF("", "FAUX", true, $questionnaire_8_1_1);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_8_1_2);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_8_1_2);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_8_1_3);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_8_1_3);

        /*******************************************
                    QUESTIONNAIRE 8 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_9 = $this->createQuestionnaire("A2_CE_Schoolbadboys", "A2", "CE", $test);
        $questionnaire_9->setMediaInstruction($this->mediaText("", "Read the text and answer the following question.", ""));
        $questionnaire_9->setMediaText($this->mediaText("",
        "The point is, though, that after six months on the course the kids all claim - and the school agrees - that their behaviour has improved beyond all recognition. \"I've only had one detention and I haven't felt like bunking off,\" says Mather. \"I thought it was about time I sorted myself out.\" There has also been a further knock-on benefit of improvements in their GCSE curricular work. So what is the secret ?", ""));
        // CREATION QUESTION
        $questionnaire_9_1 = $this->createQuestion("QRU", $questionnaire_9);
        // CREATION SUBQUESTION
        $questionnaire_9_1_1 = $this->createSubquestion("QRU", $questionnaire_9_1, "What according to this extract is the principal consequence of this course?");

        // CREATION PROPOSITIONS
        $this->createProposition("Students' behaviour is better", true, $questionnaire_9_1_1);
        $this->createProposition("Students' behaviour is worse", false, $questionnaire_9_1_1);
        $this->createProposition("Students' behaviour has not changed", false, $questionnaire_9_1_1);


        /*******************************************
                    QUESTIONNAIRE 9 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_10 = $this->createQuestionnaire("B2_CE_Schoolskiveoff", "B2", "CE", $test);
        $questionnaire_10->setMediaInstruction($this->mediaText("", "Read the text and answer the following question.", ""));
        $questionnaire_10->setMediaText($this->mediaText("",
        "The kids enjoy the work - \"less boring, more useful\" - and the sanction of being slung off the course is a great deal more effective than being banned from maths, but what they really seem to appreciate is being treated as adults. \"If you get wound up and think you're going to lose your temper they let you take five minutes out,\" says Mather. \"A teacher would think you were trying to skive off if you asked for time out.\" \"They don't say 'Do this' or 'Do that',\" says Mather. \"They tell you what's expected and let you get on with it. If you need help they'll give it but they let you complete the work to your standard, not some curriculum standard. So you feel like putting more effort in.\"", ""));
        // CREATION QUESTION
        $questionnaire_10_1 = $this->createQuestion("QRU", $questionnaire_10);
        // CREATION SUBQUESTION
        $questionnaire_10_1_1 = $this->createSubquestion("QRU", $questionnaire_10_1, "What do you think Mather means when he says, \"A teacher would think you were trying to skive off if you asked for time out\"?");

        // CREATION PROPOSITIONS
        $this->createProposition("A teacher would think you were trying to miss class if you asked to be let out for some time", true, $questionnaire_10_1_1);
        $this->createProposition("A teacher would think you were losing your temper if you didn’t get some time out of class", false, $questionnaire_10_1_1);
        $this->createProposition("A teacher would think you needed to be treated like a child if you asked to leave class", false, $questionnaire_10_1_1);


        /*******************************************
                    QUESTIONNAIRE 10 : TVFNM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_11= $this->createQuestionnaire("B1_CE_Copsstory", "B1", "CE", $test);
        $questionnaire_11->setMediaInstruction($this->mediaText("", "According to the text, are the following statements true or false, or is the information not mentioned ?", ""));
        $questionnaire_11->setMediaText($this->mediaText("", "\"Called the cops?\" I asked.@@@
They nodded. @@@
\"Anything missing?\"@@@
\"His gold Rolex,\" the woman said. \"He loved it like his own child. And the other silver icepick. Both were part of a set he treasured.\"@@@
I walked out of the cabin into the reception and gestured to the couple to follow me. I sat down in a chair and the two of them slumped into a deep sofa. The smell of weed followed them. @@@
\"Why don't you tell me about it while we wait for the cops?\" I said to the woman. She looked more composed of the two. @@@
She took a deep breath and started.
", ""));
        // CREATION QUESTION
        $questionnaire_11_1 = $this->createQuestion("TVFNM", $questionnaire_11);
        // CREATION SUBQUESTION
        $questionnaire_11_1_1 = $this->createSubquestion("VFNM", $questionnaire_11_1, "The woman looked calmer than the man");
        $questionnaire_11_1_2 = $this->createSubquestion("VFNM", $questionnaire_11_1, "A few objects were missing according to the woman");
        $questionnaire_11_1_3 = $this->createSubquestion("VFNM", $questionnaire_11_1, "The narrator of this story is a policeman");
        $questionnaire_11_1_4 = $this->createSubquestion("VFNM", $questionnaire_11_1, "The man and woman had been drinking before they met the narrator");
        // CREATION PROPOSITIONS
        $this->createProposition("VRAI", true, $questionnaire_11_1_1);
        $this->createProposition("FAUX", false, $questionnaire_11_1_1);
        $this->createProposition("ND", false, $questionnaire_11_1_1);

        $this->createProposition("VRAI", true, $questionnaire_11_1_2);
        $this->createProposition("FAUX", false, $questionnaire_11_1_2);
        $this->createProposition("ND", false, $questionnaire_11_1_2);

        $this->createProposition("VRAI", false, $questionnaire_11_1_3);
        $this->createProposition("FAUX", true, $questionnaire_11_1_3);
        $this->createProposition("ND", false, $questionnaire_11_1_3);

        $this->createProposition("VRAI", false, $questionnaire_11_1_4);
        $this->createProposition("FAUX", false, $questionnaire_11_1_4);
        $this->createProposition("ND", true, $questionnaire_11_1_4);

        /*******************************************
                    QUESTIONNAIRE 11 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_12 = $this->createQuestionnaire("B2_CE_Indiashotdead", "B2", "CE", $test);
        $questionnaire_12->setMediaInstruction($this->mediaText("", "According to the text, are the following statements true or false ?", ""));
        $questionnaire_12->setMediaText($this->mediaText("", "Narendra Dabholkar was on a regular morning stroll, in Pune, Maharashtra, when a pair of hitmen parked their motorbike and shot him dead. He had campaigned for 18 years against those who pretend to use, or offer protection from, the arts of black magic or other religious or mystical harassment. He wanted a law to prosecute such con artists and to protect their victims from extortion and bullying.
A local sect and assorted Hindu right-wingers opposed his law, which Maharashtra’s state government finally agreed to enact, in Mr Dabholkar’s memory, on August 21st. He had received death threats before. The chief minister, Prithviraj Chavan, compared the killing of the rationalist to the murder of India’s most revered figure, saying that \"just as Gandhi was killed by those who could not digest his thoughts…[Mr Dabholkar] too was eliminated\"", ""));
        // CREATION QUESTION
        $questionnaire_12_1 = $this->createQuestion("TVF", $questionnaire_12);
        // CREATION SUBQUESTION
        $questionnaire_12_1_1 = $this->createSubquestionVF("VF", $questionnaire_12_1, "", "The Maharashtra state government has passed the law that Mr Dabholkar fought for");
        $questionnaire_12_1_2 = $this->createSubquestionVF("VF", $questionnaire_12_1, "", "One politician has condemned the murder");
        $questionnaire_12_1_3 = $this->createSubquestionVF("VF", $questionnaire_12_1, "", "Mr Dabholkar was killed while he was walking");
        // CREATION PROPOSITIONS
        $this->createPropositionVF("", "VRAI", true, $questionnaire_12_1_1);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_12_1_1);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_12_1_2);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_12_1_2);

        $this->createPropositionVF("", "VRAI", true, $questionnaire_12_1_3);
        $this->createPropositionVF("", "FAUX", false, $questionnaire_12_1_3);

        /*******************************************
                    QUESTIONNAIRE 12 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_13 = $this->createQuestionnaire("B2_CE_AtheismIndia", "B2", "CE", $test);
        $questionnaire_13->setMediaInstruction($this->mediaText("", "Read the text and answer the following question.", ""));
        $questionnaire_13->setMediaText($this->mediaText("",
        "Indian atheists generally have an easier time than those elsewhere in South Asia. Prominent figures including the first prime minister, Jawaharlal Nehru, and the current defence and home ministers, plus the chief minister of Karnataka state, are cheerily irreligious. Buddhists, Jains and many Hindus hold no particular belief in God. Humanist groups abound and the taboo against refusing to express religious belief is falling. A survey in May found 81% of Indians were religious, a fall from 87% in 2005.
Yet powerful groups remain to exploit superstition and religious fear. “Even now we have witch-hunting: people who are branded as witches and either killed or extorted for money”, says Sumitra Padmanabhan, the editor of the Freethinker, a humanist magazine in Kolkata. She lists a baffling range of charlatans in the state of West Bengal: sellers of gemstones with supposedly therapeutic powers, providers of talismans and amulets, purveyors of cosmetics with magical properties.", ""));
        // CREATION QUESTION
        $questionnaire_13_1 = $this->createQuestion("QRU", $questionnaire_13);
        // CREATION SUBQUESTION
        $questionnaire_13_1_1 = $this->createSubquestion("QRU", $questionnaire_13_1, "How can this extract be best summarized?");

        // CREATION PROPOSITIONS
        $this->createProposition("The number of religious people in India is decreasing, yet they continue to be swayed by irrational beliefs",
        true, $questionnaire_13_1_1);
        $this->createProposition("Powerful politicians in India are not religious, so all Indian atheists are treated reasonably well",
        false, $questionnaire_13_1_1);
        $this->createProposition("A lot of imposters in India try to bribe innocent people by using precious stones with healing powers and other such tricks",
        false, $questionnaire_13_1_1);

        /*******************************************
                    QUESTIONNAIRE 13 : QRM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_14 = $this->createQuestionnaire("B2_CE_Valentineorigin", "B2", "CE", $test);
        $questionnaire_14->setMediaInstruction($this->mediaText("", "Read the text and find the 2 correct answers.", ""));
        $questionnaire_14->setMediaText($this->mediaText("", "This year, consumers are expected to spend more than $17 billion on this special day that traces its roots to ancient Rome.
Opinions abound about who the original Valentine was, with the most popular theory that he was a clergyman who was executed for secretly marrying couples in Rome even though the emperor at the time thought marriage weakened his soldiers. In AD 496, Pope Gelasius set aside Feb 14 to honor St. Valentine.", ""));
        // CREATION QUESTION
        $questionnaire_14_1 = $this->createQuestion("QRM", $questionnaire_14);
        // CREATION SUBQUESTION
        $questionnaire_14_1_1 = $this->createSubquestion("QRM", $questionnaire_14_1, "Which historical facts about Valentine’s Day do readers get from this extract?");
        // CREATION PROPOSITIONS
        $this->createProposition("The day can be traced back to ancient Rome", true, $questionnaire_14_1_1);
        $this->createProposition("Valentine was a church minister who was killed", true, $questionnaire_14_1_1);
        $this->createProposition("The day is named to honor a Pope", false, $questionnaire_14_1_1);

        /*******************************************
                    QUESTIONNAIRE 14 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_15 = $this->createQuestionnaire("B2_CE_Brfailingschools", "B2", "CE", $test);
        $questionnaire_15->setMediaInstruction($this->mediaText("", "Read the text and complete the statement.", ""));
        $questionnaire_15->setMediaText($this->mediaText("",
        "The new government wants to rely on methods other than overt selection to improve results in state schools. The education secretary, has rushed through two main sorts of supply-side reforms. The previous government had come up with “academies” to revive failing, mainly inner-city schools and given them certain freedoms. Academies do not have to stick zealously to the national curriculum, for example, and they are not constrained by the national pay deals for teachers that hobble their counterparts elsewhere in the state sector. They may not, however, select students: they are required to take the most local ones, even when an academy replaces that vanishingly rare thing, a failing church school.", ""));
        // CREATION QUESTION
        $questionnaire_15_1 = $this->createQuestion("QRU", $questionnaire_15);
        // CREATION SUBQUESTION
        $questionnaire_15_1_1 = $this->createSubquestion("QRU", $questionnaire_15_1, "Most \"bad\" schools are...");

        // CREATION PROPOSITIONS
        $this->createProposition("schools in city centers", true, $questionnaire_15_1_1);
        $this->createProposition("small village schools", false, $questionnaire_15_1_1);
        $this->createProposition("schools in the suburbs", false, $questionnaire_15_1_1);
        $this->createProposition("church schools", false, $questionnaire_15_1_1);

        $em->flush();

        $output->writeln("Fixtures English CE exécutées.");
        $output->writeln("");
        $output->writeln("IMPORTANT : copier l'image B1_CE_Porsche.png dans media.");
        $output->writeln("");

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
        $questionnaire->setListeningLimit(0);
        $questionnaire->setDialogue(0);
        $questionnaire->setFixedOrder(0);

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
            $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("image"));
            $media->setUrl("B1_CE_Porsche.png");
        }
        else
        {
            $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("texte"));
            $media->setUrl(NULL);
        }

        $media->setName(StaticCommand::textSource($title.$name));
        $media->setDescription(StaticCommand::textSource($title.$name)); // Ajout ERV 03/03/2014 car c'est la description que l'on affiche dans la macro.texte

        $em->persist($media);

        return $media;
    }

}
