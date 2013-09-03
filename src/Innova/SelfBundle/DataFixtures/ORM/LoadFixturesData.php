<?php

namespace Innova\SelfBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Question;
use Innova\SelfBundle\Entity\Subquestion;

class LoadFixturesData implements FixtureInterface
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
        $question1->setTypology("QRU");
        $question1->setConsigne("");
        $manager->persist($question1);

        $subquestion1 = new Subquestion();
        $subquestion1->setQuestion($question1);
        $subquestion1->setTypology("QRU");
        $manager->persist($subquestion1);

     // ITEM 2
        $questionnaire2->addTest($test);
        $questionnaire2->setLevel("A2");
        $questionnaire2->setConsigne('');
        $questionnaire2->setTheme('achat d’un CD');
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
        $question2->setTypology("QRU");
        $question2->setConsigne("");
        $manager->persist($question2);

        $subquestion2 = new Subquestion();
        $subquestion2->setQuestion($question2);
        $subquestion2->setTypology("QRU");
        $manager->persist($subquestion2);

    // ITEM 3
        $questionnaire3->addTest($test);
        $questionnaire3->setLevel("A2");
        $questionnaire3->setConsigne('');
        $questionnaire3->setTheme('bureau');
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
        $question3->setTypology("QRU");
        $question3->setConsigne("");
        $manager->persist($question3);

        $subquestion3 = new Subquestion();
        $subquestion3->setQuestion($question3);
        $subquestion3->setTypology("QRU");
        $manager->persist($subquestion3);

    // ITEM 4
        $questionnaire4->addTest($test);
        $questionnaire4->setLevel("A2");
        $questionnaire4->setConsigne('');
        $questionnaire4->setTheme('dialogue maman-fils');
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
        $question4->setTypology("QRU");
        $question4->setConsigne("");
        $manager->persist($question4);

        $subquestion4 = new Subquestion();
        $subquestion4->setQuestion($question4);
        $subquestion4->setTypology("QRU");
        $manager->persist($subquestion4);

    // ITEM 5    
        $questionnaire5->addTest($test);
        $questionnaire5->setLevel("A2");
        $questionnaire5->setConsigne('');
        $questionnaire5->setTheme('dialogue week-end');
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
        $question5->setTypology("QRU");
        $question5->setConsigne("");
        $manager->persist($question5);

        $subquestion5 = new Subquestion();
        $subquestion5->setQuestion($question5);
        $subquestion5->setTypology("QRU");
        $manager->persist($subquestion5);

    // ITEM 6
        $questionnaire6->addTest($test);
        $questionnaire6->setLevel("A2");
        $questionnaire6->setConsigne('');
        $questionnaire6->setTheme('la valise');
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
        $question6->setTypology("QRU");
        $question6->setConsigne("");
        $manager->persist($question6);

        $subquestion6 = new Subquestion();
        $subquestion6->setQuestion($question6);
        $subquestion6->setTypology("QRU");
        $manager->persist($subquestion6);

    // ITEM 7   
        $questionnaire7->addTest($test);
        $questionnaire7->setLevel("A2");
        $questionnaire7->setConsigne('');
        $questionnaire7->setTheme('moment de relax');
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
        $question7->setTypology("QRU");
        $question7->setConsigne("");
        $manager->persist($question7);

        $subquestion7 = new Subquestion();
        $subquestion7->setQuestion($question7);
        $subquestion7->setTypology("QRU");
        $manager->persist($subquestion7);


    // ITEM 8   
        $questionnaire8->addTest($test);
        $questionnaire8->setLevel("A2");
        $questionnaire8->setConsigne('');
        $questionnaire8->setTheme('réserver des billets au théâtre');
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
        $question8->setTypology("QRU");
        $question8->setConsigne("");
        $manager->persist($question8);

        $subquestion8 = new Subquestion();
        $subquestion8->setQuestion($question8);
        $subquestion8->setTypology("QRU");
        $manager->persist($subquestion8);

    // ITEM 9   
        $questionnaire9->addTest($test);
        $questionnaire9->setLevel("A2");
        $questionnaire9->setConsigne('');
        $questionnaire9->setTheme('dialogue entre amies');
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

        $question9 = new Question();
        $question9->setQuestionnaire($questionnaire9);
        $question9->setTypology("TVF");
        $question9->setConsigne("");
        $manager->persist($question9);

        $subquestion9_1 = new Subquestion();
        $subquestion9_1->setQuestion($question9);
        $subquestion9_1->setTypology("VF");
        $manager->persist($subquestion9_1);

        $subquestion9_2 = new Subquestion();
        $subquestion9_2->setQuestion($question9);
        $subquestion9_2->setTypology("VF");
        $manager->persist($subquestion9_2);

        $subquestion9_3 = new Subquestion();
        $subquestion9_3->setQuestion($question9);
        $subquestion9_3->setTypology("VF");
        $manager->persist($subquestion9_3);


    // ITEM 10   
        $questionnaire10->addTest($test);
        $questionnaire10->setLevel("A2");
        $questionnaire10->setConsigne('');
        $questionnaire10->setTheme('expression d’une inquiétude');
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

        $question10 = new Question();
        $question10->setQuestionnaire($questionnaire10);
        $question10->setTypology("TVF");
        $question10->setConsigne("");
        $manager->persist($question10);

        $subquestion10_1 = new Subquestion();
        $subquestion10_1->setQuestion($question10);
        $subquestion10_1->setTypology("VF");
        $manager->persist($subquestion10_1);

        $subquestion10_2 = new Subquestion();
        $subquestion10_2->setQuestion($question10);
        $subquestion10_2->setTypology("VF");
        $manager->persist($subquestion10_2);

        $subquestion10_3 = new Subquestion();
        $subquestion10_3->setQuestion($question10);
        $subquestion10_3->setTypology("VF");
        $manager->persist($subquestion10_3);

        $subquestion10_4 = new Subquestion();
        $subquestion10_4->setQuestion($question10);
        $subquestion10_4->setTypology("VF");
        $manager->persist($subquestion10_4);

    // ITEM 11   
        $questionnaire11->addTest($test);
        $questionnaire11->setLevel("A2");
        $questionnaire11->setConsigne('');
        $questionnaire11->setTheme('motiver son choix 01/10');
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
        $question11->setTypology("VF");
        $question11->setConsigne("");
        $manager->persist($question11);

        $subquestion11 = new Subquestion();
        $subquestion11->setQuestion($question11);
        $subquestion11->setTypology("VF");
        $manager->persist($subquestion11);

    // ITEM 12
        $questionnaire12->addTest($test);
        $questionnaire12->setLevel("A2");
        $questionnaire12->setConsigne('');
        $questionnaire12->setTheme('motiver son choix 02/10');
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
        $question12->setTypology("VF");
        $question12->setConsigne("");
        $manager->persist($question12);

        $subquestion12 = new Subquestion();
        $subquestion12->setQuestion($question12);
        $subquestion12->setTypology("VF");
        $manager->persist($subquestion12);

      
    // ITEM 13
        $questionnaire13 = new Questionnaire();
        $questionnaire13->addTest($test);
        $questionnaire13->setLevel("A2");
        $questionnaire13->setConsigne('');
        $questionnaire13->setTheme('motiver son choix 03/10');
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
        $question13->setTypology("VF");
        $question13->setConsigne("");
        $manager->persist($question13);

        $subquestion13 = new Subquestion();
        $subquestion13->setQuestion($question13);
        $subquestion13->setTypology("VF");
        $manager->persist($subquestion13);

        
    // ITEM 14
        $questionnaire14->addTest($test);
        $questionnaire14->setLevel("A2");
        $questionnaire14->setConsigne('');
        $questionnaire14->setTheme('motiver son choix 04/10');
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
        $question14->setTypology("VF");
        $question14->setConsigne("");
        $manager->persist($question14);

        $subquestion14 = new Subquestion();
        $subquestion14->setQuestion($question14);
        $subquestion14->setTypology("VF");
        $manager->persist($subquestion14);

      
    // ITEM 15
        $questionnaire15->addTest($test);
        $questionnaire15->setLevel("A2");
        $questionnaire15->setConsigne('');
        $questionnaire15->setTheme('motiver son choix 05/10');
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
        $question15->setTypology("VF");
        $question15->setConsigne("");
        $manager->persist($question15);

        $subquestion15 = new Subquestion();
        $subquestion15->setQuestion($question15);
        $subquestion15->setTypology("VF");
        $manager->persist($subquestion15);

      

    // ITEM 16
        $questionnaire16->addTest($test);
        $questionnaire16->setLevel("A2");
        $questionnaire16->setConsigne('');
        $questionnaire16->setTheme('motiver son choix 06/10');
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
        $question16->setTypology("VF");
        $question16->setConsigne("");
        $manager->persist($question16);

        $subquestion16 = new Subquestion();
        $subquestion16->setQuestion($question16);
        $subquestion16->setTypology("VF");
        $manager->persist($subquestion16);


    // ITEM 17
        $questionnaire17->addTest($test);
        $questionnaire17->setLevel("A2");
        $questionnaire17->setConsigne('');
        $questionnaire17->setTheme('motiver son choix 07/10');
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
        $question17->setTypology("VF");
        $question17->setConsigne("");
        $manager->persist($question17);

        $subquestion17 = new Subquestion();
        $subquestion17->setQuestion($question17);
        $subquestion17->setTypology("VF");
        $manager->persist($subquestion17);

    

    // ITEM 18
        $questionnaire18->addTest($test);
        $questionnaire18->setLevel("A2");
        $questionnaire18->setConsigne('');
        $questionnaire18->setTheme('motiver son choix 08/10');
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
        $question18->setTypology("VF");
        $question18->setConsigne("");
        $manager->persist($question18);

        $subquestion18 = new Subquestion();
        $subquestion18->setQuestion($question18);
        $subquestion18->setTypology("VF");
        $manager->persist($subquestion18);

      

    // ITEM 19
        $questionnaire19->addTest($test);
        $questionnaire19->setLevel("A2");
        $questionnaire19->setConsigne('');
        $questionnaire19->setTheme('motiver son choix 09/10');
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
        $question19->setTypology("VF");
        $question19->setConsigne("");
        $manager->persist($question19);

        $subquestion19 = new Subquestion();
        $subquestion19->setQuestion($question19);
        $subquestion19->setTypology("VF");
        $manager->persist($subquestion19);

       
    // ITEM 20
        $questionnaire20->addTest($test);
        $questionnaire20->setLevel("A2");
        $questionnaire20->setConsigne('');
        $questionnaire20->setTheme('motiver son choix 10/10');
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
        $question20->setTypology("VF");
        $question20->setConsigne("");
        $manager->persist($question20);

        $subquestion20 = new Subquestion();
        $subquestion20->setQuestion($question20);
        $subquestion20->setTypology("VF");
        $manager->persist($subquestion20);

        

    // ITEM 21
        $questionnaire21->addTest($test);
        $questionnaire21->setLevel("A2");
        $questionnaire21->setConsigne('');
        $questionnaire21->setTheme('ameublement');
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

        $question21 = new Question();
        $question21->setQuestionnaire($questionnaire21);
        $question21->setTypology("QRU");
        $question21->setConsigne("");
        $manager->persist($question21);

        $subquestion21_1 = new Subquestion();
        $subquestion21_1->setQuestion($question21);
        $subquestion21_1->setTypology("QRU");
        $manager->persist($subquestion21_1);

        $subquestion21_2 = new Subquestion();
        $subquestion21_2->setQuestion($question21);
        $subquestion21_2->setTypology("QRU");
        $manager->persist($subquestion21_2);

        $subquestion21_3 = new Subquestion();
        $subquestion21_3->setQuestion($question21);
        $subquestion21_3->setTypology("QRU");
        $manager->persist($subquestion21_3);

        $subquestion21_4 = new Subquestion();
        $subquestion21_4->setQuestion($question21);
        $subquestion21_4->setTypology("QRU");
        $manager->persist($subquestion21_4);

    // ITEM 22
        $questionnaire22->addTest($test);
        $questionnaire22->setLevel("A2");
        $questionnaire22->setConsigne('');
        $questionnaire22->setTheme('au secrétariat');
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
        $question22->setTypology("QRU");
        $question22->setConsigne("");
        $manager->persist($question22);

        $subquestion22 = new Subquestion();
        $subquestion22->setQuestion($question22);
        $subquestion22->setTypology("QRU");
        $manager->persist($subquestion22);

    // ITEM 23
        $questionnaire23->addTest($test);
        $questionnaire23->setLevel("A2");
        $questionnaire23->setConsigne('');
        $questionnaire23->setTheme('location voiture');
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
        $question23->setTypology("QRU");
        $question23->setConsigne("");
        $manager->persist($question23);

        $subquestion23 = new Subquestion();
        $subquestion23->setQuestion($question23);
        $subquestion23->setTypology("QRU");
        $manager->persist($subquestion23);


    // ITEM 24
        $questionnaire24->addTest($test);
        $questionnaire24->setLevel("A2");
        $questionnaire24->setConsigne('');
        $questionnaire24->setTheme('billetterie théatre');
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
        $question24->setTypology("QRU");
        $question24->setConsigne("");
        $manager->persist($question24);

        $subquestion24 = new Subquestion();
        $subquestion24->setQuestion($question24);
        $subquestion24->setTypology("QRU");
        $manager->persist($subquestion24);

       
    // ITEM 25
        $questionnaire25->addTest($test);
        $questionnaire25->setLevel("A2");
        $questionnaire25->setConsigne('');
        $questionnaire25->setTheme('invitations');
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

        $question25 = new Question();
        $question25->setQuestionnaire($questionnaire25);
        $question25->setTypology("TVF");
        $question25->setConsigne("");
        $manager->persist($question25);

        $subquestion25_1 = new Subquestion();
        $subquestion25_1->setQuestion($question25);
        $subquestion25_1->setTypology("VF");
        $manager->persist($subquestion25_1);

        $subquestion25_2 = new Subquestion();
        $subquestion25_2->setQuestion($question25);
        $subquestion25_2->setTypology("VF");
        $manager->persist($subquestion25_2);

        $subquestion25_3 = new Subquestion();
        $subquestion25_3->setQuestion($question25);
        $subquestion25_3->setTypology("VF");
        $manager->persist($subquestion25_3);

        $subquestion25_4 = new Subquestion();
        $subquestion25_4->setQuestion($question25);
        $subquestion25_4->setTypology("VF");
        $manager->persist($subquestion25_4);

        $subquestion25_5 = new Subquestion();
        $subquestion25_5->setQuestion($question25);
        $subquestion25_5->setTypology("VF");
        $manager->persist($subquestion25_5);



    // ITEM 26
        $questionnaire26->addTest($test);
        $questionnaire26->setLevel("A2");
        $questionnaire26->setConsigne('');
        $questionnaire26->setTheme('recette tiramisù');
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

        $question26_1 = new Question();
        $question26_1->setQuestionnaire($questionnaire26);
        $question26_1->setTypology("TVF");
        $question26_1->setConsigne("");
        $manager->persist($question26_1);

        $subquestion26_1_1 = new Subquestion();
        $subquestion26_1_1->setQuestion($question26_1);
        $subquestion26_1_1->setTypology("VF");
        $manager->persist($subquestion26_1_1);

        $subquestion26_1_2 = new Subquestion();
        $subquestion26_1_2->setQuestion($question26_1);
        $subquestion26_1_2->setTypology("VF");
        $manager->persist($subquestion26_1_2);

        $subquestion26_1_3 = new Subquestion();
        $subquestion26_1_3->setQuestion($question26_1);
        $subquestion26_1_3->setTypology("VF");
        $manager->persist($subquestion26_1_3);

        $subquestion26_1_4 = new Subquestion();
        $subquestion26_1_4->setQuestion($question26_1);
        $subquestion26_1_4->setTypology("VF");
        $manager->persist($subquestion26_1_4);

        $question26_2 = new Question();
        $question26_2->setQuestionnaire($questionnaire26);
        $question26_2->setTypology("TVF");
        $question26_2->setConsigne("");
        $manager->persist($question26_2);

        $subquestion26_2_1 = new Subquestion();
        $subquestion26_2_1->setQuestion($question26_2);
        $subquestion26_2_1->setTypology("VF");
        $manager->persist($subquestion26_2_1);

        $subquestion26_2_2 = new Subquestion();
        $subquestion26_2_2->setQuestion($question26_2);
        $subquestion26_2_2->setTypology("VF");
        $manager->persist($subquestion26_2_2);

        $subquestion26_2_3 = new Subquestion();
        $subquestion26_2_3->setQuestion($question26_2);
        $subquestion26_2_3->setTypology("VF");
        $manager->persist($subquestion26_2_3); 

    // ITEM 27
        $questionnaire27->addTest($test);
        $questionnaire27->setLevel("A2");
        $questionnaire27->setConsigne('');
        $questionnaire27->setTheme('présentation travail 1/5');
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
        $question27->setTypology("TVF");
        $question27->setConsigne("");
        $manager->persist($question27);

        $subquestion27_1 = new Subquestion();
        $subquestion27_1->setQuestion($question27);
        $subquestion27_1->setTypology("VF");
        $manager->persist($subquestion27_1);

        $subquestion27_2 = new Subquestion();
        $subquestion27_2->setQuestion($question27);
        $subquestion27_2->setTypology("VF");
        $manager->persist($subquestion27_2);

        $subquestion27_3 = new Subquestion();
        $subquestion27_3->setQuestion($question27);
        $subquestion27_3->setTypology("VF");
        $manager->persist($subquestion27_3);

    // ITEM 28
        $questionnaire28->addTest($test);
        $questionnaire28->setLevel("A2");
        $questionnaire28->setConsigne('');
        $questionnaire28->setTheme('présentation travail 2/5');
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
        $question28->setTypology("TVF");
        $question28->setConsigne("");
        $manager->persist($question28);

        $subquestion28_1 = new Subquestion();
        $subquestion28_1->setQuestion($question28);
        $subquestion28_1->setTypology("VF");
        $manager->persist($subquestion28_1);

        $subquestion28_2 = new Subquestion();
        $subquestion28_2->setQuestion($question28);
        $subquestion28_2->setTypology("VF");
        $manager->persist($subquestion28_2);

        $subquestion28_3 = new Subquestion();
        $subquestion28_3->setQuestion($question28);
        $subquestion28_3->setTypology("VF");
        $manager->persist($subquestion28_3);

        $subquestion28_4 = new Subquestion();
        $subquestion28_4->setQuestion($question28);
        $subquestion28_4->setTypology("VF");
        $manager->persist($subquestion28_4);

        

    // ITEM 29
        $questionnaire29->addTest($test);
        $questionnaire29->setLevel("A2");
        $questionnaire29->setConsigne('');
        $questionnaire29->setTheme('présentation travail 3/5');
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
        $question29->setTypology("TVF");
        $question29->setConsigne("");
        $manager->persist($question29);

        $subquestion29_1 = new Subquestion();
        $subquestion29_1->setQuestion($question29);
        $subquestion29_1->setTypology("VF");
        $manager->persist($subquestion29_1);

        $subquestion29_2 = new Subquestion();
        $subquestion29_2->setQuestion($question29);
        $subquestion29_2->setTypology("VF");
        $manager->persist($subquestion29_2);

        $subquestion29_3 = new Subquestion();
        $subquestion29_3->setQuestion($question29);
        $subquestion29_3->setTypology("VF");
        $manager->persist($subquestion29_3);

        $subquestion29_4 = new Subquestion();
        $subquestion29_4->setQuestion($question29);
        $subquestion29_4->setTypology("VF");
        $manager->persist($subquestion29_4);

      

    // ITEM 30
        $questionnaire30->addTest($test);
        $questionnaire30->setLevel("A2");
        $questionnaire30->setConsigne('');
        $questionnaire30->setTheme('présentation travail 4/5');
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
        $question30->setTypology("TVF");
        $question30->setConsigne("");
        $manager->persist($question30);

        $subquestion30_1 = new Subquestion();
        $subquestion30_1->setQuestion($question30);
        $subquestion30_1->setTypology("VF");
        $manager->persist($subquestion30_1);

        $subquestion30_2 = new Subquestion();
        $subquestion30_2->setQuestion($question30);
        $subquestion30_2->setTypology("VF");
        $manager->persist($subquestion30_2);

        $subquestion30_3 = new Subquestion();
        $subquestion30_3->setQuestion($question30);
        $subquestion30_3->setTypology("VF");
        $manager->persist($subquestion30_3);

        
    // ITEM 31
        $questionnaire31->addTest($test);
        $questionnaire31->setLevel("A2");
        $questionnaire31->setConsigne('');
        $questionnaire31->setTheme('présentation travail 5/5');
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
        $question31->setTypology("TVF");
        $question31->setConsigne("");
        $manager->persist($question31);

        $subquestion31_1 = new Subquestion();
        $subquestion31_1->setQuestion($question31);
        $subquestion31_1->setTypology("VF");
        $manager->persist($subquestion31_1);

        $subquestion31_2 = new Subquestion();
        $subquestion31_2->setQuestion($question31);
        $subquestion31_2->setTypology("VF");
        $manager->persist($subquestion31_2);

        $subquestion31_3 = new Subquestion();
        $subquestion31_3->setQuestion($question31);
        $subquestion31_3->setTypology("VF");
        $manager->persist($subquestion31_3);

        $subquestion31_4 = new Subquestion();
        $subquestion31_4->setQuestion($question31);
        $subquestion31_4->setTypology("VF");
        $manager->persist($subquestion31_4);

        

    // ITEM 32
        $questionnaire32->addTest($test);
        $questionnaire32->setLevel("A2");
        $questionnaire32->setConsigne('');
        $questionnaire32->setTheme('Absence à l\'entraînement');
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
        $question32->setTypology("QRU");
        $question32->setConsigne("");
        $manager->persist($question32);

        $subquestion32 = new Subquestion();
        $subquestion32->setQuestion($question32);
        $subquestion32->setTypology("QRU");
        $manager->persist($subquestion32);

      

    // ITEM 33
        $questionnaire33->addTest($test);
        $questionnaire33->setLevel("A2");
        $questionnaire33->setConsigne('');
        $questionnaire33->setTheme('Avant le départ');
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
        $question33->setTypology("QRU");
        $question33->setConsigne("");
        $manager->persist($question33);

        $subquestion33 = new Subquestion();
        $subquestion33->setQuestion($question33);
        $subquestion33->setTypology("QRU");
        $manager->persist($subquestion33);


      

    // ITEM 34
        $questionnaire34->addTest($test);
        $questionnaire34->setLevel("A2");
        $questionnaire34->setConsigne('');
        $questionnaire34->setTheme('Examen');
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
        $question34->setTypology("QRU");
        $question34->setConsigne("");
        $manager->persist($question34);

        $subquestion34 = new Subquestion();
        $subquestion34->setQuestion($question34);
        $subquestion34->setTypology("QRU");
        $manager->persist($subquestion34);

      

    // ITEM 35
        $questionnaire35->addTest($test);
        $questionnaire35->setLevel("A2");
        $questionnaire35->setConsigne('');
        $questionnaire35->setTheme('Faire les courses');
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
        $question35->setTypology("QRU");
        $question35->setConsigne("");
        $manager->persist($question35);

        $subquestion35 = new Subquestion();
        $subquestion35->setQuestion($question35);
        $subquestion35->setTypology("QRU");
        $manager->persist($subquestion35);

       
    // ITEM 36
        $questionnaire36->addTest($test);
        $questionnaire36->setLevel("A2");
        $questionnaire36->setConsigne('');
        $questionnaire36->setTheme('Nouvelle télévisée');
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
        $question36->setTypology("QRU");
        $question36->setConsigne("");
        $manager->persist($question36);

        $subquestion36 = new Subquestion();
        $subquestion36->setQuestion($question36);
        $subquestion36->setTypology("QRU");
        $manager->persist($subquestion36);

        

    // ITEM 37
        $questionnaire37->addTest($test);
        $questionnaire37->setLevel("A2");
        $questionnaire37->setConsigne('');
        $questionnaire37->setTheme('Rendre CD');
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
        $question37->setTypology("QRU");
        $question37->setConsigne("");
        $manager->persist($question37);

        $subquestion37 = new Subquestion();
        $subquestion37->setQuestion($question37);
        $subquestion37->setTypology("QRU");
        $manager->persist($subquestion37);

        

    // ITEM 38
        $questionnaire38->addTest($test);
        $questionnaire38->setLevel("A2");
        $questionnaire38->setConsigne('');
        $questionnaire38->setTheme('Souvenirs');
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
        $question38->setTypology("QRU");
        $question38->setConsigne("");
        $manager->persist($question38);

        $subquestion38 = new Subquestion();
        $subquestion38->setQuestion($question38);
        $subquestion38->setTypology("QRU");
        $manager->persist($subquestion38);

        

    // ITEM 39
        $questionnaire39->addTest($test);
        $questionnaire39->setLevel("A2");
        $questionnaire39->setConsigne('');
        $questionnaire39->setTheme('Dans la cuisine');
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
        $question39->setTypology("QRU");
        $question39->setConsigne("");
        $manager->persist($question39);

        $subquestion39 = new Subquestion();
        $subquestion39->setQuestion($question39);
        $subquestion39->setTypology("QRU");
        $manager->persist($subquestion39);

        $manager->flush();
    }
}