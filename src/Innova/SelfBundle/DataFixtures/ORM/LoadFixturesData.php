<?php

namespace Innova\SelfBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Question;

class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $test = new Test();
        $test->setNom('Test 1 - A2 italien');
        $manager->persist($test);

        $questionnaire1 = new Questionnaire();
        $questionnaire2 = new Questionnaire();
        $questionnaire3 = new Questionnaire();
        $questionnaire4 = new Questionnaire();
        $questionnaire5 = new Questionnaire();
        $questionnaire6 = new Questionnaire();
        $questionnaire7 = new Questionnaire();
        $questionnaire8 = new Questionnaire();
        $questionnaire9 = new Questionnaire();
        $questionnaire10 = new Questionnaire();
        $questionnaire11 = new Questionnaire();
        $questionnaire12 = new Questionnaire();
        $questionnaire14 = new Questionnaire();
        $questionnaire15 = new Questionnaire();
        $questionnaire16 = new Questionnaire();
        $questionnaire17 = new Questionnaire();
        $questionnaire18 = new Questionnaire();
        $questionnaire19 = new Questionnaire();
        $questionnaire20 = new Questionnaire();
        $questionnaire21 = new Questionnaire();
        $questionnaire22 = new Questionnaire();
        $questionnaire23 = new Questionnaire();
        $questionnaire24 = new Questionnaire();
        $questionnaire25 = new Questionnaire();
        $questionnaire26 = new Questionnaire();
        $questionnaire27 = new Questionnaire();
        $questionnaire28 = new Questionnaire();
        $questionnaire29 = new Questionnaire();
        $questionnaire30 = new Questionnaire();
        $questionnaire31 = new Questionnaire();
        $questionnaire32 = new Questionnaire();
        $questionnaire33 = new Questionnaire();
        $questionnaire34 = new Questionnaire();
        $questionnaire35 = new Questionnaire();
        $questionnaire36 = new Questionnaire();
        $questionnaire37 = new Questionnaire();
        $questionnaire38 = new Questionnaire();
        $questionnaire39 = new Questionnaire();


    // ITEM 1
        $questionnaire1->addTest($test);
        $questionnaire1->setLevel("A2");
        $questionnaire1->setConsigne('');
        $questionnaire1->setTheme('à la boulangerie');
        $questionnaire1->setTypology('QRU');
        $questionnaire1->setSource('Conçu en interne');
        $questionnaire1->setSupportType("enregistrement local (MLC)");
        $questionnaire1->setFocus('');
        $questionnaire1->setCognitiveOperation('');
        $questionnaire1->setFunction('');
        $questionnaire1->setReceptionType('');
        $questionnaire1->setDomain('');
        $questionnaire1->setGenre('');
        $questionnaire1->setSourceType('construit');
        $questionnaire1->setLanguageLevel('');
        $questionnaire1->setDurationGroup('');
        $questionnaire1->setFlow('');
        $questionnaire1->setWordCount('');
        $questionnaire1->setAuthor('');
        $questionnaire1->setAudioConsigne('');
        $questionnaire1->setAudioContexte('');
        $questionnaire1->setAudioItem('');
        $manager->persist($questionnaire1);

        $question1 = new Question();
        $question1->setQuestionnaire($questionnaire1);
        $manager->persist($question1);

     // ITEM 2
        $questionnaire2->addTest($test);
        $questionnaire2->setLevel("A2");
        $questionnaire2->setConsigne('');
        $questionnaire2->setTheme('achat d’un CD');
        $questionnaire2->setTypology('QRU');
        $questionnaire2->setSource('Conçu en interne');
        $questionnaire2->setSupportType("enregistrement local (MLC)");
        $questionnaire2->setFocus('');
        $questionnaire2->setCognitiveOperation('');
        $questionnaire2->setFunction('');
        $questionnaire2->setReceptionType('');
        $questionnaire2->setDomain('');
        $questionnaire2->setGenre('');
        $questionnaire2->setSourceType('');
        $questionnaire2->setLanguageLevel('');
        $questionnaire2->setDurationGroup('');
        $questionnaire2->setFlow('');
        $questionnaire2->setWordCount('');
        $questionnaire2->setAuthor('');
        $questionnaire2->setAudioConsigne('');
        $questionnaire2->setAudioContexte('');
        $questionnaire2->setAudioItem('');
        $manager->persist($questionnaire2);

        $question2 = new Question();
        $question2->setQuestionnaire($questionnaire2);
        $manager->persist($question2);

    // ITEM 3
        $questionnaire3->addTest($test);
        $questionnaire3->setLevel("A2");
        $questionnaire3->setConsigne('');
        $questionnaire3->setTheme('bureau');
        $questionnaire3->setTypology('QRU');
        $questionnaire3->setSource('Conçu en interne');
        $questionnaire3->setSupportType("enregistrement local (MLC)");
        $questionnaire3->setFocus('');
        $questionnaire3->setCognitiveOperation('');
        $questionnaire3->setFunction('');
        $questionnaire3->setReceptionType('');
        $questionnaire3->setDomain('');
        $questionnaire3->setGenre('');
        $questionnaire3->setSourceType('');
        $questionnaire3->setLanguageLevel('');
        $questionnaire3->setDurationGroup('');
        $questionnaire3->setFlow('');
        $questionnaire3->setWordCount('');
        $questionnaire3->setAuthor('');
        $questionnaire3->setAudioConsigne('');
        $questionnaire3->setAudioContexte('');
        $questionnaire3->setAudioItem('');
        $manager->persist($questionnaire3);

        $question3 = new Question();
        $question3->setQuestionnaire($questionnaire3);
        $manager->persist($question3);

    // ITEM 4
        $questionnaire4->addTest($test);
        $questionnaire4->setLevel("A2");
        $questionnaire4->setConsigne('');
        $questionnaire4->setTheme('dialogue maman-fils');
        $questionnaire4->setTypology('QRU');
        $questionnaire4->setSource('Conçu en interne');
        $questionnaire4->setSupportType("enregistrement local (MLC)");
        $questionnaire4->setFocus('');
        $questionnaire4->setCognitiveOperation('');
        $questionnaire4->setFunction('');
        $questionnaire4->setReceptionType('');
        $questionnaire4->setDomain('');
        $questionnaire4->setGenre('');
        $questionnaire4->setSourceType('');
        $questionnaire4->setLanguageLevel('');
        $questionnaire4->setDurationGroup('');
        $questionnaire4->setFlow('');
        $questionnaire4->setWordCount('');
        $questionnaire4->setAuthor('');
        $questionnaire4->setAudioConsigne('');
        $questionnaire4->setAudioContexte('');
        $questionnaire4->setAudioItem('');
        $manager->persist($questionnaire4);

        $question4 = new Question();
        $question4->setQuestionnaire($questionnaire4);
        $manager->persist($question4);

    // ITEM 5    
        $questionnaire5->addTest($test);
        $questionnaire5->setLevel("A2");
        $questionnaire5->setConsigne('');
        $questionnaire5->setTheme('dialogue week-end');
        $questionnaire5->setTypology('QRU');
        $questionnaire5->setSource('Conçu en interne');
        $questionnaire5->setSupportType("enregistrement local (MLC)");
        $questionnaire5->setFocus('');
        $questionnaire5->setCognitiveOperation('');
        $questionnaire5->setFunction('');
        $questionnaire5->setReceptionType('');
        $questionnaire5->setDomain('');
        $questionnaire5->setGenre('');
        $questionnaire5->setSourceType('');
        $questionnaire5->setLanguageLevel('');
        $questionnaire5->setDurationGroup('');
        $questionnaire5->setFlow('');
        $questionnaire5->setWordCount('');
        $questionnaire5->setAuthor('');
        $questionnaire5->setAudioConsigne('');
        $questionnaire5->setAudioContexte('');
        $questionnaire5->setAudioItem('');
        $manager->persist($questionnaire5);

        $question5 = new Question();
        $question5->setQuestionnaire($questionnaire5);
        $manager->persist($question5);

    // ITEM 6
        $questionnaire6->addTest($test);
        $questionnaire6->setLevel("A2");
        $questionnaire6->setConsigne('');
        $questionnaire6->setTheme('la valise');
        $questionnaire6->setTypology('QRU');
        $questionnaire6->setSource('Conçu en interne');
        $questionnaire6->setSupportType("enregistrement local (MLC)");
        $questionnaire6->setFocus('');
        $questionnaire6->setCognitiveOperation('');
        $questionnaire6->setFunction('');
        $questionnaire6->setReceptionType('');
        $questionnaire6->setDomain('');
        $questionnaire6->setGenre('');
        $questionnaire6->setSourceType('');
        $questionnaire6->setLanguageLevel('');
        $questionnaire6->setDurationGroup('');
        $questionnaire6->setFlow('');
        $questionnaire6->setWordCount('');
        $questionnaire6->setAuthor('');
        $questionnaire6->setAudioConsigne('');
        $questionnaire6->setAudioContexte('');
        $questionnaire6->setAudioItem('');
        $manager->persist($questionnaire6);

        $question6 = new Question();
        $question6->setQuestionnaire($questionnaire6);
        $manager->persist($question6);

    // ITEM 7   
        $questionnaire7->addTest($test);
        $questionnaire7->setLevel("A2");
        $questionnaire7->setConsigne('');
        $questionnaire7->setTheme('moment de relax');
        $questionnaire7->setTypology('QRU');
        $questionnaire7->setSource('Conçu en interne');
        $questionnaire7->setSupportType("enregistrement local (MLC)");
        $questionnaire7->setFocus('');
        $questionnaire7->setCognitiveOperation('');
        $questionnaire7->setFunction('');
        $questionnaire7->setReceptionType('');
        $questionnaire7->setDomain('');
        $questionnaire7->setGenre('');
        $questionnaire7->setSourceType('');
        $questionnaire7->setLanguageLevel('');
        $questionnaire7->setDurationGroup('');
        $questionnaire7->setFlow('');
        $questionnaire7->setWordCount('');
        $questionnaire7->setAuthor('');
        $questionnaire7->setAudioConsigne('');
        $questionnaire7->setAudioContexte('');
        $questionnaire7->setAudioItem('');
        $manager->persist($questionnaire7);

        $question7 = new Question();
        $question7->setQuestionnaire($questionnaire7);
        $manager->persist($question7);


    // ITEM 8   
        $questionnaire8->addTest($test);
        $questionnaire8->setLevel("A2");
        $questionnaire8->setConsigne('');
        $questionnaire8->setTheme('réserver des billets au théâtre');
        $questionnaire8->setTypology('QRU');
        $questionnaire8->setSource('Conçu en interne');
        $questionnaire8->setSupportType("enregistrement local (MLC)");
        $questionnaire8->setFocus('');
        $questionnaire8->setCognitiveOperation('');
        $questionnaire8->setFunction('');
        $questionnaire8->setReceptionType('');
        $questionnaire8->setDomain('');
        $questionnaire8->setGenre('');
        $questionnaire8->setSourceType('');
        $questionnaire8->setLanguageLevel('');
        $questionnaire8->setDurationGroup('');
        $questionnaire8->setFlow('');
        $questionnaire8->setWordCount('');
        $questionnaire8->setAuthor('');
        $questionnaire8->setAudioConsigne('');
        $questionnaire8->setAudioContexte('');
        $questionnaire8->setAudioItem('');
        $manager->persist($questionnaire8);

        $question8 = new Question();
        $question8->setQuestionnaire($questionnaire8);
        $manager->persist($question8);

    // ITEM 9   
        $questionnaire9->addTest($test);
        $questionnaire9->setLevel("A2");
        $questionnaire9->setConsigne('');
        $questionnaire9->setTheme('dialogue entre amies');
        $questionnaire9->setTypology('TVF');
        $questionnaire9->setSource('Conçu en interne');
        $questionnaire9->setSupportType("enregistrement local (MLC)");
        $questionnaire9->setFocus('');
        $questionnaire9->setCognitiveOperation('');
        $questionnaire9->setFunction('');
        $questionnaire9->setReceptionType('');
        $questionnaire9->setDomain('');
        $questionnaire9->setGenre('');
        $questionnaire9->setSourceType('');
        $questionnaire9->setLanguageLevel('');
        $questionnaire9->setDurationGroup('');
        $questionnaire9->setFlow('');
        $questionnaire9->setWordCount('');
        $questionnaire9->setAuthor('');
        $questionnaire9->setAudioConsigne('');
        $questionnaire9->setAudioContexte('');
        $questionnaire9->setAudioItem('');
        $manager->persist($questionnaire9);

        $question9_1 = new Question();
        $question9_1->setQuestionnaire($questionnaire9);
        $manager->persist($question9_1);

        $question9_2 = new Question();
        $question9_2->setQuestionnaire($questionnaire9);
        $manager->persist($question9_2);

        $question9_3 = new Question();
        $question9_3->setQuestionnaire($questionnaire9);
        $manager->persist($question9_3);


    // ITEM 10   
        $questionnaire10->addTest($test);
        $questionnaire10->setLevel("A2");
        $questionnaire10->setConsigne('');
        $questionnaire10->setTheme('expression d’une inquiétude');
        $questionnaire10->setTypology('TVF');
        $questionnaire10->setSource('certification/test validé (CELI) / modifié');
        $questionnaire10->setSupportType("enregistrement local (MLC)");
        $questionnaire10->setFocus('');
        $questionnaire10->setCognitiveOperation('');
        $questionnaire10->setFunction('');
        $questionnaire10->setReceptionType('');
        $questionnaire10->setDomain('');
        $questionnaire10->setGenre('');
        $questionnaire10->setSourceType('');
        $questionnaire10->setLanguageLevel('');
        $questionnaire10->setDurationGroup('');
        $questionnaire10->setFlow('');
        $questionnaire10->setWordCount('');
        $questionnaire10->setAuthor('');
        $questionnaire10->setAudioConsigne('');
        $questionnaire10->setAudioContexte('');
        $questionnaire10->setAudioItem('');
        $manager->persist($questionnaire10);

        $question10_1 = new Question();
        $question10_1->setQuestionnaire($questionnaire10);
        $manager->persist($question10_1);

        $question10_2 = new Question();
        $question10_2->setQuestionnaire($questionnaire10);
        $manager->persist($question10_2);

        $question10_3 = new Question();
        $question10_3->setQuestionnaire($questionnaire10);
        $manager->persist($question10_3);

        $question10_4 = new Question();
        $question10_4->setQuestionnaire($questionnaire10);
        $manager->persist($question10_4);

    // ITEM 11   
        $questionnaire11->addTest($test);
        $questionnaire11->setLevel("A2");
        $questionnaire11->setConsigne('');
        $questionnaire11->setTheme('motiver son choix 01/10');
        $questionnaire11->setTypology('VF');
        $questionnaire11->setSource('certification/test validé (CELI) / modifié');
        $questionnaire11->setSupportType("enregistrement local (MLC)");
        $questionnaire11->setFocus('');
        $questionnaire11->setCognitiveOperation('');
        $questionnaire11->setFunction('');
        $questionnaire11->setReceptionType('');
        $questionnaire11->setDomain('');
        $questionnaire11->setGenre('');
        $questionnaire11->setSourceType('');
        $questionnaire11->setLanguageLevel('');
        $questionnaire11->setDurationGroup('');
        $questionnaire11->setFlow('');
        $questionnaire11->setWordCount('');
        $questionnaire11->setAuthor('');
        $questionnaire11->setAudioConsigne('');
        $questionnaire11->setAudioContexte('');
        $questionnaire11->setAudioItem('');
        $manager->persist($questionnaire11);

        $question11 = new Question();
        $question11->setQuestionnaire($questionnaire11);
        $manager->persist($question11);

    // ITEM 12
        $questionnaire12->addTest($test);
        $questionnaire12->setLevel("A2");
        $questionnaire12->setConsigne('');
        $questionnaire12->setTheme('motiver son choix 02/10');
        $questionnaire12->setTypology('VF');
        $questionnaire12->setSource('certification/test validé (CELI) / modifié');
        $questionnaire12->setSupportType("enregistrement local (MLC)");
        $questionnaire12->setFocus('');
        $questionnaire12->setCognitiveOperation('');
        $questionnaire12->setFunction('');
        $questionnaire12->setReceptionType('');
        $questionnaire12->setDomain('');
        $questionnaire12->setGenre('');
        $questionnaire12->setSourceType('');
        $questionnaire12->setLanguageLevel('');
        $questionnaire12->setDurationGroup('');
        $questionnaire12->setFlow('');
        $questionnaire12->setWordCount('');
        $questionnaire12->setAuthor('');
        $questionnaire12->setAudioConsigne('');
        $questionnaire12->setAudioContexte('');
        $questionnaire12->setAudioItem('');
        $manager->persist($questionnaire12);

        $question12 = new Question();
        $question12->setQuestionnaire($questionnaire12);
        $manager->persist($question12);


    // ITEM 13
        $questionnaire13 = new Questionnaire();
        $questionnaire13->addTest($test);
        $questionnaire13->setLevel("A2");
        $questionnaire13->setConsigne('');
        $questionnaire13->setTheme('motiver son choix 03/10');
        $questionnaire13->setTypology('VF');
        $questionnaire13->setSource('certification/test validé (CELI) / modifié');
        $questionnaire13->setSupportType("enregistrement local (MLC)");
        $questionnaire13->setFocus('');
        $questionnaire13->setCognitiveOperation('');
        $questionnaire13->setFunction('');
        $questionnaire13->setReceptionType('');
        $questionnaire13->setDomain('');
        $questionnaire13->setGenre('');
        $questionnaire13->setSourceType('');
        $questionnaire13->setLanguageLevel('');
        $questionnaire13->setDurationGroup('');
        $questionnaire13->setFlow('');
        $questionnaire13->setWordCount('');
        $questionnaire13->setAuthor('');
        $questionnaire13->setAudioConsigne('');
        $questionnaire13->setAudioContexte('');
        $questionnaire13->setAudioItem('');
        $manager->persist($questionnaire13);

        $question13 = new Question();
        $question13->setQuestionnaire($questionnaire13);
        $manager->persist($question13);

    // ITEM 14
        $questionnaire14->addTest($test);
        $questionnaire14->setLevel("A2");
        $questionnaire14->setConsigne('');
        $questionnaire14->setTheme('motiver son choix 04/10');
        $questionnaire14->setTypology('VF');
        $questionnaire14->setSource('certification/test validé (CELI) / modifié');
        $questionnaire14->setSupportType("enregistrement local (MLC)");
        $questionnaire14->setFocus('');
        $questionnaire14->setCognitiveOperation('');
        $questionnaire14->setFunction('');
        $questionnaire14->setReceptionType('');
        $questionnaire14->setDomain('');
        $questionnaire14->setGenre('');
        $questionnaire14->setSourceType('');
        $questionnaire14->setLanguageLevel('');
        $questionnaire14->setDurationGroup('');
        $questionnaire14->setFlow('');
        $questionnaire14->setWordCount('');
        $questionnaire14->setAuthor('');
        $questionnaire14->setAudioConsigne('');
        $questionnaire14->setAudioContexte('');
        $questionnaire14->setAudioItem('');
        $manager->persist($questionnaire14);

        $question14 = new Question();
        $question14->setQuestionnaire($questionnaire14);
        $manager->persist($question14);

    // ITEM 15
        $questionnaire15->addTest($test);
        $questionnaire15->setLevel("A2");
        $questionnaire15->setConsigne('');
        $questionnaire15->setTheme('motiver son choix 05/10');
        $questionnaire15->setTypology('VF');
        $questionnaire15->setSource('certification/test validé (CELI) / modifié');
        $questionnaire15->setSupportType("enregistrement local (MLC)");
        $questionnaire15->setFocus('');
        $questionnaire15->setCognitiveOperation('');
        $questionnaire15->setFunction('');
        $questionnaire15->setReceptionType('');
        $questionnaire15->setDomain('');
        $questionnaire15->setGenre('');
        $questionnaire15->setSourceType('');
        $questionnaire15->setLanguageLevel('');
        $questionnaire15->setDurationGroup('');
        $questionnaire15->setFlow('');
        $questionnaire15->setWordCount('');
        $questionnaire15->setAuthor('');
        $questionnaire15->setAudioConsigne('');
        $questionnaire15->setAudioContexte('');
        $questionnaire15->setAudioItem('');
        $manager->persist($questionnaire15);

        $question15 = new Question();
        $question15->setQuestionnaire($questionnaire15);
        $manager->persist($question15);

    // ITEM 16
        $questionnaire16->addTest($test);
        $questionnaire16->setLevel("A2");
        $questionnaire16->setConsigne('');
        $questionnaire16->setTheme('motiver son choix 06/10');
        $questionnaire16->setTypology('VF');
        $questionnaire16->setSource('certification/test validé (CELI) / modifié');
        $questionnaire16->setSupportType("enregistrement local (MLC)");
        $questionnaire16->setFocus('');
        $questionnaire16->setCognitiveOperation('');
        $questionnaire16->setFunction('');
        $questionnaire16->setReceptionType('');
        $questionnaire16->setDomain('');
        $questionnaire16->setGenre('');
        $questionnaire16->setSourceType('');
        $questionnaire16->setLanguageLevel('');
        $questionnaire16->setDurationGroup('');
        $questionnaire16->setFlow('');
        $questionnaire16->setWordCount('');
        $questionnaire16->setAuthor('');
        $questionnaire16->setAudioConsigne('');
        $questionnaire16->setAudioContexte('');
        $questionnaire16->setAudioItem('');
        $manager->persist($questionnaire16);

        $question16 = new Question();
        $question16->setQuestionnaire($questionnaire16);
        $manager->persist($question16);


    // ITEM 17
        $questionnaire17->addTest($test);
        $questionnaire17->setLevel("A2");
        $questionnaire17->setConsigne('');
        $questionnaire17->setTheme('motiver son choix 07/10');
        $questionnaire17->setTypology('VF');
        $questionnaire17->setSource('certification/test validé (CELI) / modifié');
        $questionnaire17->setSupportType("enregistrement local (MLC)");
        $questionnaire17->setFocus('');
        $questionnaire17->setCognitiveOperation('');
        $questionnaire17->setFunction('');
        $questionnaire17->setReceptionType('');
        $questionnaire17->setDomain('');
        $questionnaire17->setGenre('');
        $questionnaire17->setSourceType('');
        $questionnaire17->setLanguageLevel('');
        $questionnaire17->setDurationGroup('');
        $questionnaire17->setFlow('');
        $questionnaire17->setWordCount('');
        $questionnaire17->setAuthor('');
        $questionnaire17->setAudioConsigne('');
        $questionnaire17->setAudioContexte('');
        $questionnaire17->setAudioItem('');
        $manager->persist($questionnaire17);

        $question17 = new Question();
        $question17->setQuestionnaire($questionnaire17);
        $manager->persist($question17);

    // ITEM 18
        $questionnaire18->addTest($test);
        $questionnaire18->setLevel("A2");
        $questionnaire18->setConsigne('');
        $questionnaire18->setTheme('motiver son choix 08/10');
        $questionnaire18->setTypology('VF');
        $questionnaire18->setSource('certification/test validé (CELI) / modifié');
        $questionnaire18->setSupportType("enregistrement local (MLC)");
        $questionnaire18->setFocus('');
        $questionnaire18->setCognitiveOperation('');
        $questionnaire18->setFunction('');
        $questionnaire18->setReceptionType('');
        $questionnaire18->setDomain('');
        $questionnaire18->setGenre('');
        $questionnaire18->setSourceType('');
        $questionnaire18->setLanguageLevel('');
        $questionnaire18->setDurationGroup('');
        $questionnaire18->setFlow('');
        $questionnaire18->setWordCount('');
        $questionnaire18->setAuthor('');
        $questionnaire18->setAudioConsigne('');
        $questionnaire18->setAudioContexte('');
        $questionnaire18->setAudioItem('');
        $manager->persist($questionnaire18);

        $question18 = new Question();
        $question18->setQuestionnaire($questionnaire18);
        $manager->persist($question18);


    // ITEM 19
        $questionnaire19->addTest($test);
        $questionnaire19->setLevel("A2");
        $questionnaire19->setConsigne('');
        $questionnaire19->setTheme('motiver son choix 09/10');
        $questionnaire19->setTypology('VF');
        $questionnaire19->setSource('certification/test validé (CELI) / modifié');
        $questionnaire19->setSupportType("enregistrement local (MLC)");
        $questionnaire19->setFocus('');
        $questionnaire19->setCognitiveOperation('');
        $questionnaire19->setFunction('');
        $questionnaire19->setReceptionType('');
        $questionnaire19->setDomain('');
        $questionnaire19->setGenre('');
        $questionnaire19->setSourceType('');
        $questionnaire19->setLanguageLevel('');
        $questionnaire19->setDurationGroup('');
        $questionnaire19->setFlow('');
        $questionnaire19->setWordCount('');
        $questionnaire19->setAuthor('');
        $questionnaire19->setAudioConsigne('');
        $questionnaire19->setAudioContexte('');
        $questionnaire19->setAudioItem('');
        $manager->persist($questionnaire19);

        $question19 = new Question();
        $question19->setQuestionnaire($questionnaire19);
        $manager->persist($question19);

    // ITEM 20
        $questionnaire20->addTest($test);
        $questionnaire20->setLevel("A2");
        $questionnaire20->setConsigne('');
        $questionnaire20->setTheme('motiver son choix 10/10');
        $questionnaire20->setTypology('VF');
        $questionnaire20->setSource('certification/test validé (CELI) / modifié');
        $questionnaire20->setSupportType("enregistrement local (MLC)");
        $questionnaire20->setFocus('');
        $questionnaire20->setCognitiveOperation('');
        $questionnaire20->setFunction('');
        $questionnaire20->setReceptionType('');
        $questionnaire20->setDomain('');
        $questionnaire20->setGenre('');
        $questionnaire20->setSourceType('');
        $questionnaire20->setLanguageLevel('');
        $questionnaire20->setDurationGroup('');
        $questionnaire20->setFlow('');
        $questionnaire20->setWordCount('');
        $questionnaire20->setAuthor('');
        $questionnaire20->setAudioConsigne('');
        $questionnaire20->setAudioContexte('');
        $questionnaire20->setAudioItem('');
        $manager->persist($questionnaire20);

        $question20 = new Question();
        $question20->setQuestionnaire($questionnaire20);
        $manager->persist($question20);

    // ITEM 21
        $questionnaire21->addTest($test);
        $questionnaire21->setLevel("A2");
        $questionnaire21->setConsigne('');
        $questionnaire21->setTheme('ameublement');
        $questionnaire21->setTypology('QRU');
        $questionnaire21->setSource('méthodes et manuels (Allegro 2, Edilingua, p. 22, unità 2) / modifié');
        $questionnaire21->setSupportType("enregistrement local (MLC)");
        $questionnaire21->setFocus('');
        $questionnaire21->setCognitiveOperation('');
        $questionnaire21->setFunction('');
        $questionnaire21->setReceptionType('');
        $questionnaire21->setDomain('');
        $questionnaire21->setGenre('');
        $questionnaire21->setSourceType('');
        $questionnaire21->setLanguageLevel('');
        $questionnaire21->setDurationGroup('');
        $questionnaire21->setFlow('');
        $questionnaire21->setWordCount('');
        $questionnaire21->setAuthor('');
        $questionnaire21->setAudioConsigne('');
        $questionnaire21->setAudioContexte('');
        $questionnaire21->setAudioItem('');
        $manager->persist($questionnaire21);

        $question21_1 = new Question();
        $question21_1->setQuestionnaire($questionnaire21);
        $manager->persist($question21_1);

        $question21_2 = new Question();
        $question21_2->setQuestionnaire($questionnaire21);
        $manager->persist($question21_2);

        $question21_3 = new Question();
        $question21_3->setQuestionnaire($questionnaire21);
        $manager->persist($question21_3);

        $question21_4 = new Question();
        $question21_4->setQuestionnaire($questionnaire21);
        $manager->persist($question21_4);

    // ITEM 22
        $questionnaire22->addTest($test);
        $questionnaire22->setLevel("A2");
        $questionnaire22->setConsigne('');
        $questionnaire22->setTheme('au secrétariat');
        $questionnaire22->setTypology('QRU');
        $questionnaire22->setSource('certification/test validé (CILS)');
        $questionnaire22->setSupportType("enregistrement local (MLC)");
        $questionnaire22->setFocus('');
        $questionnaire22->setCognitiveOperation('');
        $questionnaire22->setFunction('');
        $questionnaire22->setReceptionType('');
        $questionnaire22->setDomain('');
        $questionnaire22->setGenre('');
        $questionnaire22->setSourceType('');
        $questionnaire22->setLanguageLevel('');
        $questionnaire22->setDurationGroup('');
        $questionnaire22->setFlow('');
        $questionnaire22->setWordCount('');
        $questionnaire22->setAuthor('');
        $questionnaire22->setAudioConsigne('');
        $questionnaire22->setAudioContexte('');
        $questionnaire22->setAudioItem('');
        $manager->persist($questionnaire22);

        $question22 = new Question();
        $question22->setQuestionnaire($questionnaire22);
        $manager->persist($question22);

    // ITEM 23
        $questionnaire23->addTest($test);
        $questionnaire23->setLevel("A2");
        $questionnaire23->setConsigne('');
        $questionnaire23->setTheme('location voiture');
        $questionnaire23->setTypology('QRU');
        $questionnaire23->setSource('certification/test validé (CILS) / modifié ');
        $questionnaire23->setSupportType("enregistrement local (MLC)");
        $questionnaire23->setFocus('');
        $questionnaire23->setCognitiveOperation('');
        $questionnaire23->setFunction('');
        $questionnaire23->setReceptionType('');
        $questionnaire23->setDomain('');
        $questionnaire23->setGenre('');
        $questionnaire23->setSourceType('');
        $questionnaire23->setLanguageLevel('');
        $questionnaire23->setDurationGroup('');
        $questionnaire23->setFlow('');
        $questionnaire23->setWordCount('');
        $questionnaire23->setAuthor('');
        $questionnaire23->setAudioConsigne('');
        $questionnaire23->setAudioContexte('');
        $questionnaire23->setAudioItem('');
        $manager->persist($questionnaire23);

        $question23 = new Question();
        $question23->setQuestionnaire($questionnaire23);
        $manager->persist($question23);


    // ITEM 24
        $questionnaire24->addTest($test);
        $questionnaire24->setLevel("A2");
        $questionnaire24->setConsigne('');
        $questionnaire24->setTheme('billetterie théatre');
        $questionnaire24->setTypology('QRU');
        $questionnaire24->setSource('Conçu en interne');
        $questionnaire24->setSupportType("enregistrement local (MLC)");
        $questionnaire24->setFocus('');
        $questionnaire24->setCognitiveOperation('');
        $questionnaire24->setFunction('');
        $questionnaire24->setReceptionType('');
        $questionnaire24->setDomain('');
        $questionnaire24->setGenre('');
        $questionnaire24->setSourceType('');
        $questionnaire24->setLanguageLevel('');
        $questionnaire24->setDurationGroup('');
        $questionnaire24->setFlow('');
        $questionnaire24->setWordCount('');
        $questionnaire24->setAuthor('');
        $questionnaire24->setAudioConsigne('');
        $questionnaire24->setAudioContexte('');
        $questionnaire24->setAudioItem('');
        $manager->persist($questionnaire24);

        $question24 = new Question();
        $question24->setQuestionnaire($questionnaire24);
        $manager->persist($question24);

    // ITEM 25
        $questionnaire25->addTest($test);
        $questionnaire25->setLevel("A2");
        $questionnaire25->setConsigne('');
        $questionnaire25->setTheme('invitations');
        $questionnaire25->setTypology('TVF');
        $questionnaire25->setSource('méthodes et manuels (Allegro 2, Edilingua, p. 14, piste n° 5)');
        $questionnaire25->setSupportType("enregistrement local (MLC)");
        $questionnaire25->setFocus('');
        $questionnaire25->setCognitiveOperation('');
        $questionnaire25->setFunction('');
        $questionnaire25->setReceptionType('');
        $questionnaire25->setDomain('');
        $questionnaire25->setGenre('');
        $questionnaire25->setSourceType('');
        $questionnaire25->setLanguageLevel('');
        $questionnaire25->setDurationGroup('');
        $questionnaire25->setFlow('');
        $questionnaire25->setWordCount('');
        $questionnaire25->setAuthor('');
        $questionnaire25->setAudioConsigne('');
        $questionnaire25->setAudioContexte('');
        $questionnaire25->setAudioItem('');
        $manager->persist($questionnaire25);

        $question25_1 = new Question();
        $question25_1->setQuestionnaire($questionnaire25);
        $manager->persist($question25_1);

        $question25_2 = new Question();
        $question25_2->setQuestionnaire($questionnaire25);
        $manager->persist($question25_2);

        $question25_3 = new Question();
        $question25_3->setQuestionnaire($questionnaire25);
        $manager->persist($question25_3);

        $question25_4 = new Question();
        $question25_4->setQuestionnaire($questionnaire25);
        $manager->persist($question25_4);

        $question25_5 = new Question();
        $question25_5->setQuestionnaire($questionnaire25);
        $manager->persist($question25_5);


    // ITEM 26
        $questionnaire26->addTest($test);
        $questionnaire26->setLevel("A2");
        $questionnaire26->setConsigne('');
        $questionnaire26->setTheme('recette tiramisù');
        $questionnaire26->setTypology('TVF');
        $questionnaire26->setSource('méthodes et manuels (Se ascoltando..., Livello A1 - A2, Guerra Edizioni, p. 35 piste n° 29) / modifié');
        $questionnaire26->setSupportType("enregistrement local (MLC)");
        $questionnaire26->setFocus('');
        $questionnaire26->setCognitiveOperation('');
        $questionnaire26->setFunction('');
        $questionnaire26->setReceptionType('');
        $questionnaire26->setDomain('');
        $questionnaire26->setGenre('');
        $questionnaire26->setSourceType('');
        $questionnaire26->setLanguageLevel('');
        $questionnaire26->setDurationGroup('');
        $questionnaire26->setFlow('');
        $questionnaire26->setWordCount('');
        $questionnaire26->setAuthor('');
        $questionnaire26->setAudioConsigne('');
        $questionnaire26->setAudioContexte('');
        $questionnaire26->setAudioItem('');
        $manager->persist($questionnaire26);

        $question26 = new Question();
        $question26->setQuestionnaire($questionnaire26);
        $manager->persist($question26);

    // ITEM 27
        $questionnaire27->addTest($test);
        $questionnaire27->setLevel("A2");
        $questionnaire27->setConsigne('');
        $questionnaire27->setTheme('présentation travail 1/5');
        $questionnaire27->setTypology('TVF');
        $questionnaire27->setSource('certification/test validé (Prove CELI, sessione giugno 2007_CO_A2 http://www.cvcl.it/Mediacenter/FE/CategoriaMedia.aspx?idc=214&explicit=SIhtt) / modifié');
        $questionnaire27->setSupportType("enregistrement local (MLC)");
        $questionnaire27->setFocus('');
        $questionnaire27->setCognitiveOperation('');
        $questionnaire27->setFunction('');
        $questionnaire27->setReceptionType('');
        $questionnaire27->setDomain('');
        $questionnaire27->setGenre('');
        $questionnaire27->setSourceType('');
        $questionnaire27->setLanguageLevel('');
        $questionnaire27->setDurationGroup('');
        $questionnaire27->setFlow('');
        $questionnaire27->setWordCount('');
        $questionnaire27->setAuthor('');
        $questionnaire27->setAudioConsigne('');
        $questionnaire27->setAudioContexte('');
        $questionnaire27->setAudioItem('');
        $manager->persist($questionnaire27);

        $question27 = new Question();
        $question27->setQuestionnaire($questionnaire27);
        $manager->persist($question27);

    // ITEM 28
        $questionnaire28->addTest($test);
        $questionnaire28->setLevel("A2");
        $questionnaire28->setConsigne('');
        $questionnaire28->setTheme('présentation travail 2/5');
        $questionnaire28->setTypology('TVF');
        $questionnaire28->setSource('certification/test validé (Prove CELI, sessione giugno 2007_CO_A2 http://www.cvcl.it/Mediacenter/FE/CategoriaMedia.aspx?idc=214&explicit=SIhtt) / modifié');
        $questionnaire28->setSupportType("enregistrement local (MLC)");
        $questionnaire28->setFocus('');
        $questionnaire28->setCognitiveOperation('');
        $questionnaire28->setFunction('');
        $questionnaire28->setReceptionType('');
        $questionnaire28->setDomain('');
        $questionnaire28->setGenre('');
        $questionnaire28->setSourceType('');
        $questionnaire28->setLanguageLevel('');
        $questionnaire28->setDurationGroup('');
        $questionnaire28->setFlow('');
        $questionnaire28->setWordCount('');
        $questionnaire28->setAuthor('');
        $questionnaire28->setAudioConsigne('');
        $questionnaire28->setAudioContexte('');
        $questionnaire28->setAudioItem('');
        $manager->persist($questionnaire28);

        $question28 = new Question();
        $question28->setQuestionnaire($questionnaire28);
        $manager->persist($question28);

    // ITEM 29
        $questionnaire29->addTest($test);
        $questionnaire29->setLevel("A2");
        $questionnaire29->setConsigne('');
        $questionnaire29->setTheme('présentation travail 3/5');
        $questionnaire29->setTypology('TVF');
        $questionnaire29->setSource('certification/test validé (Prove CELI, sessione giugno 2007_CO_A2 http://www.cvcl.it/Mediacenter/FE/CategoriaMedia.aspx?idc=214&explicit=SIhtt) / modifié');
        $questionnaire29->setSupportType("enregistrement local (MLC)");
        $questionnaire29->setFocus('');
        $questionnaire29->setCognitiveOperation('');
        $questionnaire29->setFunction('');
        $questionnaire29->setReceptionType('');
        $questionnaire29->setDomain('');
        $questionnaire29->setGenre('');
        $questionnaire29->setSourceType('');
        $questionnaire29->setLanguageLevel('');
        $questionnaire29->setDurationGroup('');
        $questionnaire29->setFlow('');
        $questionnaire29->setWordCount('');
        $questionnaire29->setAuthor('');
        $questionnaire29->setAudioConsigne('');
        $questionnaire29->setAudioContexte('');
        $questionnaire29->setAudioItem('');
        $manager->persist($questionnaire29);

        $question29 = new Question();
        $question29->setQuestionnaire($questionnaire29);
        $manager->persist($question29);

    // ITEM 30
        $questionnaire30->addTest($test);
        $questionnaire30->setLevel("A2");
        $questionnaire30->setConsigne('');
        $questionnaire30->setTheme('présentation travail 4/5');
        $questionnaire30->setTypology('TVF');
        $questionnaire30->setSource('certification/test validé (Prove CELI, sessione giugno 2007_CO_A2 http://www.cvcl.it/Mediacenter/FE/CategoriaMedia.aspx?idc=214&explicit=SIhtt) / modifié');
        $questionnaire30->setSupportType("enregistrement local (MLC)");
        $questionnaire30->setFocus('');
        $questionnaire30->setCognitiveOperation('');
        $questionnaire30->setFunction('');
        $questionnaire30->setReceptionType('');
        $questionnaire30->setDomain('');
        $questionnaire30->setGenre('');
        $questionnaire30->setSourceType('');
        $questionnaire30->setLanguageLevel('');
        $questionnaire30->setDurationGroup('');
        $questionnaire30->setFlow('');
        $questionnaire30->setWordCount('');
        $questionnaire30->setAuthor('');
        $questionnaire30->setAudioConsigne('');
        $questionnaire30->setAudioContexte('');
        $questionnaire30->setAudioItem('');
        $manager->persist($questionnaire30);

        $question30 = new Question();
        $question30->setQuestionnaire($questionnaire30);
        $manager->persist($question30);

    // ITEM 31
        $questionnaire31->addTest($test);
        $questionnaire31->setLevel("A2");
        $questionnaire31->setConsigne('');
        $questionnaire31->setTheme('présentation travail 5/5');
        $questionnaire31->setTypology('TVF');
        $questionnaire31->setSource('certification/test validé (Prove CELI, sessione giugno 2007_CO_A2 http://www.cvcl.it/Mediacenter/FE/CategoriaMedia.aspx?idc=214&explicit=SIhtt) / modifié');
        $questionnaire31->setSupportType("enregistrement local (MLC)");
        $questionnaire31->setFocus('');
        $questionnaire31->setCognitiveOperation('');
        $questionnaire31->setFunction('');
        $questionnaire31->setReceptionType('');
        $questionnaire31->setDomain('');
        $questionnaire31->setGenre('');
        $questionnaire31->setSourceType('');
        $questionnaire31->setLanguageLevel('');
        $questionnaire31->setDurationGroup('');
        $questionnaire31->setFlow('');
        $questionnaire31->setWordCount('');
        $questionnaire31->setAuthor('');
        $questionnaire31->setAudioConsigne('');
        $questionnaire31->setAudioContexte('');
        $questionnaire31->setAudioItem('');
        $manager->persist($questionnaire31);

        $question31 = new Question();
        $question31->setQuestionnaire($questionnaire31);
        $manager->persist($question31);

    // ITEM 32
        $questionnaire32->addTest($test);
        $questionnaire32->setLevel("A2");
        $questionnaire32->setConsigne('');
        $questionnaire32->setTheme('Absence à l\'entraînement');
        $questionnaire32->setTypology('TVF');
        $questionnaire32->setSource('Conçu en interne');
        $questionnaire32->setSupportType("enregistrement local (MLC)");
        $questionnaire32->setFocus('');
        $questionnaire32->setCognitiveOperation('');
        $questionnaire32->setFunction('');
        $questionnaire32->setReceptionType('');
        $questionnaire32->setDomain('');
        $questionnaire32->setGenre('');
        $questionnaire32->setSourceType('');
        $questionnaire32->setLanguageLevel('');
        $questionnaire32->setDurationGroup('');
        $questionnaire32->setFlow('');
        $questionnaire32->setWordCount('');
        $questionnaire32->setAuthor('');
        $questionnaire32->setAudioConsigne('');
        $questionnaire32->setAudioContexte('');
        $questionnaire32->setAudioItem('');
        $manager->persist($questionnaire32);

        $question32 = new Question();
        $question32->setQuestionnaire($questionnaire32);
        $manager->persist($question32);

    // ITEM 33
        $questionnaire33->addTest($test);
        $questionnaire33->setLevel("A2");
        $questionnaire33->setConsigne('');
        $questionnaire33->setTheme('Avant le départ');
        $questionnaire33->setTypology('TVF');
        $questionnaire33->setSource('Conçu en interne');
        $questionnaire33->setSupportType("enregistrement local (MLC)");
        $questionnaire33->setFocus('');
        $questionnaire33->setCognitiveOperation('');
        $questionnaire33->setFunction('');
        $questionnaire33->setReceptionType('');
        $questionnaire33->setDomain('');
        $questionnaire33->setGenre('');
        $questionnaire33->setSourceType('');
        $questionnaire33->setLanguageLevel('');
        $questionnaire33->setDurationGroup('');
        $questionnaire33->setFlow('');
        $questionnaire33->setWordCount('');
        $questionnaire33->setAuthor('');
        $questionnaire33->setAudioConsigne('');
        $questionnaire33->setAudioContexte('');
        $questionnaire33->setAudioItem('');
        $manager->persist($questionnaire33);

        $question33 = new Question();
        $question33->setQuestionnaire($questionnaire33);
        $manager->persist($question33);

    // ITEM 34
        $questionnaire34->addTest($test);
        $questionnaire34->setLevel("A2");
        $questionnaire34->setConsigne('');
        $questionnaire34->setTheme('Examen');
        $questionnaire34->setTypology('TVF');
        $questionnaire34->setSource('Conçu en interne');
        $questionnaire34->setSupportType("enregistrement local (MLC)");
        $questionnaire34->setFocus('');
        $questionnaire34->setCognitiveOperation('');
        $questionnaire34->setFunction('');
        $questionnaire34->setReceptionType('');
        $questionnaire34->setDomain('');
        $questionnaire34->setGenre('');
        $questionnaire34->setSourceType('');
        $questionnaire34->setLanguageLevel('');
        $questionnaire34->setDurationGroup('');
        $questionnaire34->setFlow('');
        $questionnaire34->setWordCount('');
        $questionnaire34->setAuthor('');
        $questionnaire34->setAudioConsigne('');
        $questionnaire34->setAudioContexte('');
        $questionnaire34->setAudioItem('');
        $manager->persist($questionnaire34);

        $question34 = new Question();
        $question34->setQuestionnaire($questionnaire34);
        $manager->persist($question34);

    // ITEM 35
        $questionnaire35->addTest($test);
        $questionnaire35->setLevel("A2");
        $questionnaire35->setConsigne('');
        $questionnaire35->setTheme('Faire les courses');
        $questionnaire35->setTypology('TVF');
        $questionnaire35->setSource('Conçu en interne');
        $questionnaire35->setSupportType("enregistrement local (MLC)");
        $questionnaire35->setFocus('');
        $questionnaire35->setCognitiveOperation('');
        $questionnaire35->setFunction('');
        $questionnaire35->setReceptionType('');
        $questionnaire35->setDomain('');
        $questionnaire35->setGenre('');
        $questionnaire35->setSourceType('');
        $questionnaire35->setLanguageLevel('');
        $questionnaire35->setDurationGroup('');
        $questionnaire35->setFlow('');
        $questionnaire35->setWordCount('');
        $questionnaire35->setAuthor('');
        $questionnaire35->setAudioConsigne('');
        $questionnaire35->setAudioContexte('');
        $questionnaire35->setAudioItem('');
        $manager->persist($questionnaire35);

        $question35 = new Question();
        $question35->setQuestionnaire($questionnaire35);
        $manager->persist($question35);

    // ITEM 36
        $questionnaire36->addTest($test);
        $questionnaire36->setLevel("A2");
        $questionnaire36->setConsigne('');
        $questionnaire36->setTheme('Nouvelle télévisée');
        $questionnaire36->setTypology('TVF');
        $questionnaire36->setSource('Conçu en interne');
        $questionnaire36->setSupportType("enregistrement local (MLC)");
        $questionnaire36->setFocus('');
        $questionnaire36->setCognitiveOperation('');
        $questionnaire36->setFunction('');
        $questionnaire36->setReceptionType('');
        $questionnaire36->setDomain('');
        $questionnaire36->setGenre('');
        $questionnaire36->setSourceType('');
        $questionnaire36->setLanguageLevel('');
        $questionnaire36->setDurationGroup('');
        $questionnaire36->setFlow('');
        $questionnaire36->setWordCount('');
        $questionnaire36->setAuthor('');
        $questionnaire36->setAudioConsigne('');
        $questionnaire36->setAudioContexte('');
        $questionnaire36->setAudioItem('');
        $manager->persist($questionnaire36);

        $question36 = new Question();
        $question36->setQuestionnaire($questionnaire36);
        $manager->persist($question36);

    // ITEM 37
        $questionnaire37->addTest($test);
        $questionnaire37->setLevel("A2");
        $questionnaire37->setConsigne('');
        $questionnaire37->setTheme('Rendre CD');
        $questionnaire37->setTypology('TVF');
        $questionnaire37->setSource('Conçu en interne');
        $questionnaire37->setSupportType("enregistrement local (MLC)");
        $questionnaire37->setFocus('');
        $questionnaire37->setCognitiveOperation('');
        $questionnaire37->setFunction('');
        $questionnaire37->setReceptionType('');
        $questionnaire37->setDomain('');
        $questionnaire37->setGenre('');
        $questionnaire37->setSourceType('');
        $questionnaire37->setLanguageLevel('');
        $questionnaire37->setDurationGroup('');
        $questionnaire37->setFlow('');
        $questionnaire37->setWordCount('');
        $questionnaire37->setAuthor('');
        $questionnaire37->setAudioConsigne('');
        $questionnaire37->setAudioContexte('');
        $questionnaire37->setAudioItem('');
        $manager->persist($questionnaire37);

        $question37 = new Question();
        $question37->setQuestionnaire($questionnaire37);
        $manager->persist($question37);

    // ITEM 38
        $questionnaire38->addTest($test);
        $questionnaire38->setLevel("A2");
        $questionnaire38->setConsigne('');
        $questionnaire38->setTheme('Souvenirs');
        $questionnaire38->setTypology('TVF');
        $questionnaire38->setSource('Conçu en interne');
        $questionnaire38->setSupportType("enregistrement local (MLC)");
        $questionnaire38->setFocus('');
        $questionnaire38->setCognitiveOperation('');
        $questionnaire38->setFunction('');
        $questionnaire38->setReceptionType('');
        $questionnaire38->setDomain('');
        $questionnaire38->setGenre('');
        $questionnaire38->setSourceType('');
        $questionnaire38->setLanguageLevel('');
        $questionnaire38->setDurationGroup('');
        $questionnaire38->setFlow('');
        $questionnaire38->setWordCount('');
        $questionnaire38->setAuthor('');
        $questionnaire38->setAudioConsigne('');
        $questionnaire38->setAudioContexte('');
        $questionnaire38->setAudioItem('');
        $manager->persist($questionnaire38);

        $question38 = new Question();
        $question38->setQuestionnaire($questionnaire38);
        $manager->persist($question38);

    // ITEM 39
        $questionnaire39->addTest($test);
        $questionnaire39->setLevel("A2");
        $questionnaire39->setConsigne('');
        $questionnaire39->setTheme('Dans la cuisine');
        $questionnaire39->setTypology('TVF');
        $questionnaire39->setSource('Conçu en interne');
        $questionnaire39->setSupportType("enregistrement local (MLC)");
        $questionnaire39->setFocus('');
        $questionnaire39->setCognitiveOperation('');
        $questionnaire39->setFunction('');
        $questionnaire39->setReceptionType('');
        $questionnaire39->setDomain('');
        $questionnaire39->setGenre('');
        $questionnaire39->setSourceType('');
        $questionnaire39->setLanguageLevel('');
        $questionnaire39->setDurationGroup('');
        $questionnaire39->setFlow('');
        $questionnaire39->setWordCount('');
        $questionnaire39->setAuthor('');
        $questionnaire39->setAudioConsigne('');
        $questionnaire39->setAudioContexte('');
        $questionnaire39->setAudioItem('');
        $manager->persist($questionnaire39);

        $question39 = new Question();
        $question39->setQuestionnaire($questionnaire39);
        $manager->persist($question39);

        $manager->flush();
    }
}