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
        $test = $this->createTest("English CE", "English");


        /*******************************************

                    NIVEAU : B1

        ********************************************/

        /*******************************************
                    QUESTIONNAIRE 1 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_1 = $this->createQuestionnaire("B1_CE_AgathaChristie", "B1", "CE", $test);
        $questionnaire_1->setMediaInstruction($this->mediaText("", "Read the text and answer the following question."));
        $questionnaire_1->setMediaContext($this->mediaText("", ""));
        $questionnaire_1->setMediaText($this->mediaText("", "Dame Agatha Mary Clarissa Christie, DBE (born Miller; 15 September 1890 – 12 January 1976) was an English crime writer of novels, short stories, and plays. She also wrote six romances under the name Mary Westmacott, but she is best remembered for the 66 detective novels and 14 short story collections she wrote under her own name, most of which revolve around the investigations of such characters as Hercule Poirot, Miss Jane Marple and Tommy and Tuppence. She also wrote the world's longest-running play, The Mousetrap."));
        // CREATION QUESTION
        $questionnaire_1_1 = $this->createQuestion("QRU", $questionnaire_1);
        // CREATION SUBQUESTION
        $questionnaire_1_1_1 = $this->createSubquestion("QRU", $questionnaire_1_1, "Who is Mary Westmacott?");

        // CREATION PROPOSITIONS
        $questionnaire_1_1_1_1 = $this->createProposition("Agatha Christie", true, $questionnaire_1_1_1);
        $questionnaire_1_1_1_2 = $this->createProposition("A friend writer of Agatha Christie", false, $questionnaire_1_1_1);
        $questionnaire_1_1_1_3 = $this->createProposition("A character in one of Agatha Christie’s novels", false, $questionnaire_1_1_1);

        /*******************************************
                    QUESTIONNAIRE 2 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_2 = $this->createQuestionnaire("B1_CE_Parmesanchicken", "B1", "CE", $test);
        $questionnaire_2->setMediaInstruction($this->mediaText("", "Read the text and answer the questions."));
        $questionnaire_2->setMediaContext($this->mediaText("", ""));
        $questionnaire_2->setMediaText($this->mediaText("", "1. Preheat oven to 350 degrees F (175 degrees C). Lightly grease a 9x13 inch baking dish.@@@ 2. In a bowl, blend the olive oil and garlic. In a separate bowl, mix the bread crumbs, Parmesan cheese, basil, and pepper. Dip each chicken breast in the oil mixture, then in the bread crumb mixture. Arrange the coated chicken breasts in the prepared baking dish, and top with any remaining bread crumb mixture.@@@ 3. Bake 30 minutes in the preheated oven, or until chicken is no longer pink and juices run clear."));
        // CREATION QUESTION
        $questionnaire_2_1 = $this->createQuestion("TQRU", $questionnaire_2);
        // CREATION SUBQUESTION
        $questionnaire_2_1_1 = $this->createSubquestion("QRU", $questionnaire_2_1, "XXX");
        $questionnaire_2_1_2 = $this->createSubquestion("QRU", $questionnaire_2_1, "XXX");
        $questionnaire_2_1_3 = $this->createSubquestion("QRU", $questionnaire_2_1, "XXX");
        // CREATION PROPOSITIONS
        $questionnaire_2_1_1_1 = $this->createProposition("1.1. As you start the recipe", true, $questionnaire_2_1_1);
        $questionnaire_2_1_1_2 = $this->createProposition("1.2. When the chicken is no longer pink", false, $questionnaire_2_1_1);
        $questionnaire_2_1_1_3 = $this->createProposition("1.3. After putting the breadcrumb mixture", false, $questionnaire_2_1_1);

        $questionnaire_2_1_2_1 = $this->createProposition("2.1. Over the chicken breast at the end", true, $questionnaire_2_1_2);
        $questionnaire_2_1_2_2 = $this->createProposition("2.2. At the bottom of the baking dish", false, $questionnaire_2_1_2);
        $questionnaire_2_1_2_3 = $this->createProposition("2.3. In a bowl for another preparation", false, $questionnaire_2_1_2);

        $questionnaire_2_1_3_1 = $this->createProposition("3.1. The pink colour has totally disappeared", true, $questionnaire_2_1_3);
        $questionnaire_2_1_3_2 = $this->createProposition("3.2. The juice turns brown", false, $questionnaire_2_1_3);
        $questionnaire_2_1_3_3 = $this->createProposition("3.3. The meat is lightly pink", false, $questionnaire_2_1_3);

        /*******************************************
                    QUESTIONNAIRE 3 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_3 = $this->createQuestionnaire("B1_CE_Porsche", "B1", "CE", $test);
        $questionnaire_3->setMediaInstruction($this->mediaText("", "Read the text and answer the questions."));
        $questionnaire_3->setMediaContext($this->mediaText("", ""));
        $questionnaire_3->setMediaText($this->mediaText("", ""));
        // CREATION QUESTION
        $questionnaire_3_1 = $this->createQuestion("TQRU", $questionnaire_3);
        // CREATION SUBQUESTION
        $questionnaire_3_1_1 = $this->createSubquestion("QRU", $questionnaire_3_1, "XXX");
        $questionnaire_3_1_2 = $this->createSubquestion("QRU", $questionnaire_3_1, "XXX");
        $questionnaire_3_1_3 = $this->createSubquestion("QRU", $questionnaire_3_1, "XXX");
        // CREATION PROPOSITIONS
        $questionnaire_3_1_1_1 = $this->createProposition("1.1. A Porsche", true, $questionnaire_3_1_1);
        $questionnaire_3_1_1_2 = $this->createProposition("1.2. A Mitsubishi", false, $questionnaire_3_1_1);
        $questionnaire_3_1_1_3 = $this->createProposition("1.3. A Nissan", false, $questionnaire_3_1_1);

        $questionnaire_3_1_2_1 = $this->createProposition("2.1. Everybody waits years before buying a Porsche", true, $questionnaire_3_1_2);
        $questionnaire_3_1_2_2 = $this->createProposition("2.2. Everybody dreams of buying a Nissan", false, $questionnaire_3_1_2);
        $questionnaire_3_1_2_3 = $this->createProposition("2.3. Everybody has driven a Porsche once", false, $questionnaire_3_1_2);

        /*******************************************
                    QUESTIONNAIRE 4 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_4 = $this->createQuestionnaire("B1_CE_Renewableenergy", "B1", "CE", $test);
        $questionnaire_4->setMediaInstruction($this->mediaText("", "Read the text and answer the questions."));
        $questionnaire_4->setMediaContext($this->mediaText("", ""));
        $questionnaire_4->setMediaText($this->mediaText("",
        "Most people agree that carbon emissions from power stations are a significant cause of climate change. These days a fiercer argument is over what to do about it. Many governments are pumping money into renewable sources of electricity, such as wind turbines, solar farms, hydroelectric and geothermal plants. But countries with large amounts of renewable generation, such as Denmark and Germany, face the highest energy prices in the rich world. In Britain electricity from wind farms costs twice as much as that from traditional sources; solar power is even more dear."));
        // CREATION QUESTION
        $questionnaire_4_1 = $this->createQuestion("TQRU", $questionnaire_4);
        // CREATION SUBQUESTION
        $questionnaire_4_1_1 = $this->createSubquestion("QRU", $questionnaire_4_1, "XXX");
        $questionnaire_4_1_2 = $this->createSubquestion("QRU", $questionnaire_4_1, "XXX");
        $questionnaire_4_1_3 = $this->createSubquestion("QRU", $questionnaire_4_1, "XXX");
        // CREATION PROPOSITIONS
        $questionnaire_4_1_1_1 = $this->createProposition("1.1. They are very expensive in comparison to non-renewable sources", true, $questionnaire_4_1_1);
        $questionnaire_4_1_1_2 = $this->createProposition("1.2. Governments argue over which renewable source of energy is better", false, $questionnaire_4_1_1);
        $questionnaire_4_1_1_3 = $this->createProposition("1.3. No-one knows if they will really reduce climate change", false, $questionnaire_4_1_1);

        $questionnaire_4_1_2_1 = $this->createProposition("2.1. Solar energy is very expensive", true, $questionnaire_4_1_2);
        $questionnaire_4_1_2_2 = $this->createProposition("2.2. Solar energy is required in Britain", false, $questionnaire_4_1_2);
        $questionnaire_4_1_2_3 = $this->createProposition("2.3. People in Britain love solar energy", false, $questionnaire_4_1_2);

        /*******************************************
                    QUESTIONNAIRE 5 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_5 = $this->createQuestionnaire("B1_CE_Valentinesales", "B1", "CE", $test);
        $questionnaire_5->setMediaInstruction($this->mediaText("", "Read the text and answer the following question."));
        $questionnaire_5->setMediaContext($this->mediaText("", ""));
        $questionnaire_5->setMediaText($this->mediaText("", "Today couples tend to celebrate by exchanging gifts, from greeting cards to chocolates to weekend getaways.
According to the National Retail Federation’s 2008 Valentine’s Day Consumer Intentions and Actions Survey, conducted by Columbus-based BIGresearch, the average consumer plans to spend $122.98 on this day – an increase of about $3 over last year."));
        // CREATION QUESTION
        $questionnaire_5_1 = $this->createQuestion("QRU", $questionnaire_5);
        // CREATION SUBQUESTION
        $questionnaire_5_1_1 = $this->createSubquestion("QRU", $questionnaire_5_1, "According to the survey, how would the sales be this year?");

        // CREATION PROPOSITIONS
        $questionnaire_5_1_1_1 = $this->createProposition("Better than last year", true, $questionnaire_5_1_1);
        $questionnaire_5_1_1_2 = $this->createProposition("Worse than last year", false, $questionnaire_5_1_1);
        $questionnaire_5_1_1_3 = $this->createProposition("The same as last year", false, $questionnaire_5_1_1);

        /*******************************************
                    QUESTIONNAIRE 6 : QRM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_6 = $this->createQuestionnaire("B1_CE_Doves", "B1", "CE", $test);
        $questionnaire_6->setMediaInstruction($this->mediaText("", "Read the text and find the 2 correct answers."));
        $questionnaire_6->setMediaContext($this->mediaText("", ""));
        $questionnaire_6->setMediaText($this->mediaText("", "White doves are a traditional symbol of love and peace, so the idea of releasing doves at a wedding, christening or funeral may seem like an innocent expression of affection. But what about the animals involved?
The theory is that the doves should automatically return to their place of origin using their innate homing instinct but the ISPCA is seeing a different picture emerge. After a release of doves at a wedding in Athlone, 3 young birds remained around the hotel disorientated and confused. By the time ISPCA Inspector Karen Lyons captured the last of the birds they were severely underweight."));
        // CREATION QUESTION
        $questionnaire_6_1 = $this->createQuestion("QRM", $questionnaire_6);
        // CREATION SUBQUESTION
        $questionnaire_6_1_1 = $this->createSubquestion("QRM", $questionnaire_6_1, "");
        // CREATION PROPOSITIONS
        $questionnaire_6_1_1_1 = $this->createProposition("Doves are not always able to return to their home", true, $questionnaire_6_1_1);
        $questionnaire_6_1_1_2 = $this->createProposition("Doves didn’t know how to provide nourishment for themselves", true, $questionnaire_6_1_1);
        $questionnaire_6_1_1_3 = $this->createProposition("Some of the birds died", false, $questionnaire_6_1_1);

        /*******************************************
                    QUESTIONNAIRE 7 : TQRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_7 = $this->createQuestionnaire("B1_CE_Porsche", "B1", "CE", $test);
        $questionnaire_7->setMediaInstruction($this->mediaText("", "Read the text and answer the questions."));
        $questionnaire_7->setMediaContext($this->mediaText("", ""));
        $questionnaire_7->setMediaText($this->mediaText("", ""));
        // CREATION QUESTION
        $questionnaire_7_1 = $this->createQuestion("TQRU", $questionnaire_7);
        // CREATION SUBQUESTION
        $questionnaire_7_1_1 = $this->createSubquestion("QRU", $questionnaire_7_1, "XXX");
        $questionnaire_7_1_2 = $this->createSubquestion("QRU", $questionnaire_7_1, "XXX");
        $questionnaire_7_1_3 = $this->createSubquestion("QRU", $questionnaire_7_1, "XXX");
        // CREATION PROPOSITIONS
        $questionnaire_7_1_1_1 = $this->createProposition("1.1. A Porsche", true, $questionnaire_7_1_1);
        $questionnaire_7_1_1_2 = $this->createProposition("1.2. A Mitsubishi", false, $questionnaire_7_1_1);
        $questionnaire_7_1_1_3 = $this->createProposition("1.3. A Nissan", false, $questionnaire_7_1_1);

        $questionnaire_7_1_2_1 = $this->createProposition("2.1. Everybody waits years before buying a Porsche", true, $questionnaire_7_1_2);
        $questionnaire_7_1_2_2 = $this->createProposition("2.2. Everybody dreams of buying a Nissan", false, $questionnaire_7_1_2);
        $questionnaire_7_1_2_3 = $this->createProposition("2.3. Everybody has driven a Porsche once", false, $questionnaire_7_1_2);

        /*******************************************
                    QUESTIONNAIRE 8 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_8 = $this->createQuestionnaire("B1_CE_Scubadiving", "B1", "CE", $test);
        $questionnaire_8->setMediaInstruction($this->mediaText("", "According to the text, are the following statements true or false?"));
        $questionnaire_8->setMediaContext($this->mediaText("", ""));
        $questionnaire_8->setMediaText($this->mediaText("", "Scuba diving is a form of underwater diving in which a diver uses a self contained underwater breathing apparatus (scuba) to breathe underwater. Unlike other modes of diving, which rely either on breath-hold or on air pumped from the surface, scuba divers carry their own source of breathing gas, (usually compressed air), allowing them greater freedom of movement than with an air line or diver's umbilical and longer underwater endurance than breath-hold."));
        // CREATION QUESTION
        $questionnaire_8_1 = $this->createQuestion("TVF", $questionnaire_8);
        // CREATION SUBQUESTION
        $questionnaire_8_1_1 = $this->createSubquestion("QRM", $questionnaire_8_1, "");
        // CREATION PROPOSITIONS
        $questionnaire_8_1_1_1 = $this->createProposition("The air used by the scuba diver is pumped from the surface", false, $questionnaire_8_1_1);
        $questionnaire_8_1_1_2 = $this->createProposition("Divers can stay longer underwater", true, $questionnaire_8_1_1);
        $questionnaire_8_1_1_3 = $this->createProposition("Scuba divers don’t need to hold their breath", true, $questionnaire_8_1_1);

        /*******************************************
                    QUESTIONNAIRE 9 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_9 = $this->createQuestionnaire("A2_CE_Schoolbadboys", "A2", "CE", $test);
        $questionnaire_9->setMediaInstruction($this->mediaText("", "Read the text and answer the following question."));
        $questionnaire_9->setMediaContext($this->mediaText("", ""));
        $questionnaire_9->setMediaText($this->mediaText("",
        "The point is, though, that after six months on the course the kids all claim - and the school agrees - that their behaviour has improved beyond all recognition. \"I've only had one detention and I haven't felt like bunking off,\" says Mather. \"I thought it was about time I sorted myself out.\" There has also been a further knock-on benefit of improvements in their GCSE curricular work. So what is the secret?"));
        // CREATION QUESTION
        $questionnaire_9_1 = $this->createQuestion("QRU", $questionnaire_9);
        // CREATION SUBQUESTION
        $questionnaire_9_1_1 = $this->createSubquestion("QRU", $questionnaire_9_1, "According to the survey, how would the sales be this year?");

        // CREATION PROPOSITIONS
        $questionnaire_9_1_1_1 = $this->createProposition("Students' behaviour is better", true, $questionnaire_9_1_1);
        $questionnaire_9_1_1_2 = $this->createProposition("Students' behaviour is worse", false, $questionnaire_9_1_1);
        $questionnaire_9_1_1_3 = $this->createProposition("Students' behaviour has not changed", false, $questionnaire_9_1_1);


        /*******************************************
                    QUESTIONNAIRE 10 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_10 = $this->createQuestionnaire("B2_CE_Schoolskiveoff", "B2", "CE", $test);
        $questionnaire_10->setMediaInstruction($this->mediaText("", "Read the text and answer the following question."));
        $questionnaire_10->setMediaContext($this->mediaText("", ""));
        $questionnaire_10->setMediaText($this->mediaText("",
        "The kids enjoy the work - \"less boring, more useful\" - and the sanction of being slung off the course is a great deal more effective than being banned from maths, but what they really seem to appreciate is being treated as adults. \"If you get wound up and think you're going to lose your temper they let you take five minutes out,\" says Mather. \"A teacher would think you were trying to skive off if you asked for time out.\" \"They don't say 'Do this' or 'Do that',\" says Mather. \"They tell you what's expected and let you get on with it. If you need help they'll give it but they let you complete the work to your standard, not some curriculum standard. So you feel like putting more effort in.\""));
        // CREATION QUESTION
        $questionnaire_10_1 = $this->createQuestion("QRU", $questionnaire_10);
        // CREATION SUBQUESTION
        $questionnaire_10_1_1 = $this->createSubquestion("QRU", $questionnaire_10_1, "According to the survey, how would the sales be this year?");

        // CREATION PROPOSITIONS
        $questionnaire_10_1_1_1 = $this->createProposition("A teacher would think you were trying to miss class if you asked to be let out for some time", true, $questionnaire_10_1_1);
        $questionnaire_10_1_1_2 = $this->createProposition("A teacher would think you were losing your temper if you didn’t get some time out of class", false, $questionnaire_10_1_1);
        $questionnaire_10_1_1_3 = $this->createProposition("A teacher would think you needed to be treated like a child if you asked to leave class", false, $questionnaire_10_1_1);


        /*******************************************
                    QUESTIONNAIRE 11 : TVFNM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_11= $this->createQuestionnaire("B1_CE_Copsstory", "B1", "CE", $test);
        $questionnaire_11->setMediaInstruction($this->mediaText("", "According to the text, are the following statements true or false?"));
        $questionnaire_11->setMediaContext($this->mediaText("", ""));
        $questionnaire_11->setMediaText($this->mediaText("", "\"Called the cops?\" I asked.@@@
They nodded. @@@
\"Anything missing?\"@@@
\"His gold Rolex,\" the woman said. \"He loved it like his own child. And the other silver icepick. Both were part of a set he treasured.\"@@@
I walked out of the cabin into the reception and gestured to the couple to follow me. I sat down in a chair and the two of them slumped into a deep sofa. The smell of weed followed them. @@@
\"Why don't you tell me about it while we wait for the cops?\" I said to the woman. She looked more composed of the two. @@@
She took a deep breath and started.
"));
        // CREATION QUESTION
        $questionnaire_11_1 = $this->createQuestion("TVFNM", $questionnaire_11);
        // CREATION SUBQUESTION
        $questionnaire_11_1_1 = $this->createSubquestion("TVFNM", $questionnaire_11_1, "The woman looked calmer than the man");
        $questionnaire_11_1_2 = $this->createSubquestion("TVFNM", $questionnaire_11_1, "A few objects were missing according to the woman");
        $questionnaire_11_1_3 = $this->createSubquestion("TVFNM", $questionnaire_11_1, "The narrator of this story is a policeman");
        $questionnaire_11_1_4 = $this->createSubquestion("TVFNM", $questionnaire_11_1, "The man and woman had been drinking before they met the narrator");
        // CREATION PROPOSITIONS
        $questionnaire_11_1_1_1 = $this->createProposition("VRAI", true, $questionnaire_11_1_1);
        $questionnaire_11_1_1_2 = $this->createProposition("FAUX", false, $questionnaire_11_1_1);
        $questionnaire_11_1_1_3 = $this->createProposition("ND", false, $questionnaire_11_1_1);

        $questionnaire_11_1_2_1 = $this->createProposition("VRAI", false, $questionnaire_11_1_2);
        $questionnaire_11_1_2_2 = $this->createProposition("FAUX", true, $questionnaire_11_1_2);
        $questionnaire_11_1_2_3 = $this->createProposition("ND", false, $questionnaire_11_1_2);

        $questionnaire_11_1_3_1 = $this->createProposition("VRAI", false, $questionnaire_11_1_3);
        $questionnaire_11_1_3_2 = $this->createProposition("FAUX", true, $questionnaire_11_1_3);
        $questionnaire_11_1_3_3 = $this->createProposition("ND", false, $questionnaire_11_1_3);

        $questionnaire_11_1_4_1 = $this->createProposition("VRAI", false, $questionnaire_11_1_4);
        $questionnaire_11_1_4_2 = $this->createProposition("FAUX", false, $questionnaire_11_1_4);
        $questionnaire_11_1_4_3 = $this->createProposition("ND", true, $questionnaire_11_1_4);

        /*******************************************
                    QUESTIONNAIRE 12 : TVF
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_12 = $this->createQuestionnaire("B2_CE_Indiashotdead", "B2", "CE", $test);
        $questionnaire_12->setMediaInstruction($this->mediaText("", "According to the text, are the following statements true or false, or is the information not mentioned?"));
        $questionnaire_12->setMediaContext($this->mediaText("", ""));
        $questionnaire_12->setMediaText($this->mediaText("", "Narendra Dabholkar was on a regular morning stroll, in Pune, Maharashtra, when a pair of hitmen parked their motorbike and shot him dead. He had campaigned for 18 years against those who pretend to use, or offer protection from, the arts of black magic or other religious or mystical harassment. He wanted a law to prosecute such con artists and to protect their victims from extortion and bullying.
A local sect and assorted Hindu right-wingers opposed his law, which Maharashtra’s state government finally agreed to enact, in Mr Dabholkar’s memory, on August 21st. He had received death threats before. The chief minister, Prithviraj Chavan, compared the killing of the rationalist to the murder of India’s most revered figure, saying that \"just as Gandhi was killed by those who could not digest his thoughts…[Mr Dabholkar] too was eliminated\""));
        // CREATION QUESTION
        $questionnaire_12_1 = $this->createQuestion("TVF", $questionnaire_12);
        // CREATION SUBQUESTION
        $questionnaire_12_1_1 = $this->createSubquestion("QRM", $questionnaire_12_1, "");
        // CREATION PROPOSITIONS
        $questionnaire_12_1_1_1 = $this->createProposition("The Maharashtra state government has passed the law that Mr Dabholkar fought for", false, $questionnaire_12_1_1);
        $questionnaire_12_1_1_2 = $this->createProposition("One politician has condemned the murder", true, $questionnaire_12_1_1);
        $questionnaire_12_1_1_3 = $this->createProposition("Mr Dabholkar was killed while he was walking", true, $questionnaire_12_1_1);

        /*******************************************
                    QUESTIONNAIRE 13 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_13 = $this->createQuestionnaire("B2_CE_AtheismIndia", "B2", "CE", $test);
        $questionnaire_13->setMediaInstruction($this->mediaText("", "Read the text and answer the following question."));
        $questionnaire_13->setMediaContext($this->mediaText("", ""));
        $questionnaire_13->setMediaText($this->mediaText("",
        "Indian atheists generally have an easier time than those elsewhere in South Asia. Prominent figures including the first prime minister, Jawaharlal Nehru, and the current defence and home ministers, plus the chief minister of Karnataka state, are cheerily irreligious. Buddhists, Jains and many Hindus hold no particular belief in God. Humanist groups abound and the taboo against refusing to express religious belief is falling. A survey in May found 81% of Indians were religious, a fall from 87% in 2005.
Yet powerful groups remain to exploit superstition and religious fear. “Even now we have witch-hunting: people who are branded as witches and either killed or extorted for money”, says Sumitra Padmanabhan, the editor of the Freethinker, a humanist magazine in Kolkata. She lists a baffling range of charlatans in the state of West Bengal: sellers of gemstones with supposedly therapeutic powers, providers of talismans and amulets, purveyors of cosmetics with magical properties."));
        // CREATION QUESTION
        $questionnaire_13_1 = $this->createQuestion("QRU", $questionnaire_13);
        // CREATION SUBQUESTION
        $questionnaire_13_1_1 = $this->createSubquestion("QRU", $questionnaire_13_1, "According to the survey, how would the sales be this year?");

        // CREATION PROPOSITIONS
        $questionnaire_13_1_1_1 = $this->createProposition("A teacher would think you were trying to miss class if you asked to be let out for some time", true, $questionnaire_13_1_1);
        $questionnaire_13_1_1_2 = $this->createProposition("A teacher would think you were losing your temper if you didn’t get some time out of class", false, $questionnaire_13_1_1);
        $questionnaire_13_1_1_3 = $this->createProposition("A teacher would think you needed to be treated like a child if you asked to leave class", false, $questionnaire_13_1_1);

        /*******************************************
                    QUESTIONNAIRE 14 : QRM
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_14 = $this->createQuestionnaire("B2_CE_Valentineorigin", "B2", "CE", $test);
        $questionnaire_14->setMediaInstruction($this->mediaText("", "Read the text and find the 2 correct answers."));
        $questionnaire_14->setMediaContext($this->mediaText("", ""));
        $questionnaire_14->setMediaText($this->mediaText("", "This year, consumers are expected to spend more than $17 billion on this special day that traces its roots to ancient Rome.
Opinions abound about who the original Valentine was, with the most popular theory that he was a clergyman who was executed for secretly marrying couples in Rome even though the emperor at the time thought marriage weakened his soldiers. In AD 496, Pope Gelasius set aside Feb 14 to honor St. Valentine."));
        // CREATION QUESTION
        $questionnaire_14_1 = $this->createQuestion("QRM", $questionnaire_14);
        // CREATION SUBQUESTION
        $questionnaire_14_1_1 = $this->createSubquestion("QRM", $questionnaire_14_1, "");
        // CREATION PROPOSITIONS
        $questionnaire_14_1_1_1 = $this->createProposition("The day can be traced back to ancient Rome", true, $questionnaire_14_1_1);
        $questionnaire_14_1_1_2 = $this->createProposition("Valentine was a church minister who was killed", true, $questionnaire_14_1_1);
        $questionnaire_14_1_1_3 = $this->createProposition("The day is named to honor a Pope", false, $questionnaire_14);

        /*******************************************
                    QUESTIONNAIRE 15 : QRU
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_15 = $this->createQuestionnaire("B2_CE_Brfailingschools", "B2", "CE", $test);
        $questionnaire_15->setMediaInstruction($this->mediaText("", "Read the text and answer the following question."));
        $questionnaire_15->setMediaContext($this->mediaText("", ""));
        $questionnaire_15->setMediaText($this->mediaText("",
        "The new government wants to rely on methods other than overt selection to improve results in state schools. The education secretary, has rushed through two main sorts of supply-side reforms. The previous government had come up with “academies” to revive failing, mainly inner-city schools and given them certain freedoms. Academies do not have to stick zealously to the national curriculum, for example, and they are not constrained by the national pay deals for teachers that hobble their counterparts elsewhere in the state sector. They may not, however, select students: they are required to take the most local ones, even when an academy replaces that vanishingly rare thing, a failing church school."));
        // CREATION QUESTION
        $questionnaire_15_1 = $this->createQuestion("QRU", $questionnaire_15);
        // CREATION SUBQUESTION
        $questionnaire_15_1_1 = $this->createSubquestion("QRU", $questionnaire_15_1, "According to the survey, how would the sales be this year?");

        // CREATION PROPOSITIONS
        $questionnaire_15_1_1_1 = $this->createProposition("schools in city centers", true, $questionnaire_15_1_1);
        $questionnaire_15_1_1_2 = $this->createProposition("small village schools", false, $questionnaire_15_1_1);
        $questionnaire_15_1_1_3 = $this->createProposition("schools in the suburbs", false, $questionnaire_15_1_1);
        $questionnaire_15_1_1_4 = $this->createProposition("church schools", false, $questionnaire_15_1_1);

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
