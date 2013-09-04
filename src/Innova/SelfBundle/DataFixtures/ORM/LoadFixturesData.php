<?php

namespace Innova\SelfBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Question;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Proposition;

class LoadFixturesData implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $test = new Test();
        $test->setName('Test 1 - A2 italien');
        $manager->persist($test);

        $userAdmin = new User();
        $encoder = $this->container
            ->get('security.encoder_factory')
            ->getEncoder($userAdmin);

        $userAdmin->setUsername('admin');
        $userAdmin->setEnabled(1);
        $userAdmin->setEmail('system@example.com');

        $userAdmin->setPassword($encoder
            ->encodePassword('admin', $userAdmin->getSalt()));

        $userAdmin->setRoles(array('ROLE_SUPER_ADMIN'));
        $userAdmin->addTest($test);
        $manager->persist($userAdmin);

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
        $questionnaire1->setInstruction('');
        $questionnaire1->setTheme('à la boulangerie');
        $questionnaire1->setSource('Conçu en interne');
        $questionnaire1->setSupportType("enregistrement local (MLC)");
        $questionnaire1->setFocus('');
        $questionnaire1->setCognitiveOperation('');
        $questionnaire1->setFunction('');
        $questionnaire1->setReceptionType('');
        $questionnaire1->setDomain('');
        $questionnaire1->setType('');
        $questionnaire1->setSourceType('construit');
        $questionnaire1->setLanguageLevel('');
        $questionnaire1->setDurationGroup('');
        $questionnaire1->setFlow('');
        $questionnaire1->setWordCount('');
        $questionnaire1->setAuthor('');
        $questionnaire1->setAudioInstruction('');
        $questionnaire1->setAudioContext('');
        $questionnaire1->setAudioItem('');
        $manager->persist($questionnaire1);

        $question1 = new Question();
        $question1->setQuestionnaire($questionnaire1);
        $question1->setTypology("QRU");
        $question1->setInstruction("");
        $manager->persist($question1);

        $subquestion1 = new Subquestion();
        $subquestion1->setQuestion($question1);
        $subquestion1->setTypology("QRU");
        $manager->persist($subquestion1);

        $proposition1_1 = new Proposition();
        $proposition1_1->setSubquestion($subquestion1);
        $proposition1_1->setRightAnswer(1);
        $proposition1_1->setAudioUrl("");
        $manager->persist($proposition1_1);

        $proposition1_2 = new Proposition();
        $proposition1_2->setSubquestion($subquestion1);
        $proposition1_2->setRightAnswer(0);
        $proposition1_2->setAudioUrl("");
        $manager->persist($proposition1_2);

        $proposition1_3 = new Proposition();
        $proposition1_3->setSubquestion($subquestion1);
        $proposition1_3->setRightAnswer(0);
        $proposition1_3->setAudioUrl("");
        $manager->persist($proposition1_3);


     // ITEM 2
        $questionnaire2->addTest($test);
        $questionnaire2->setLevel("A2");
        $questionnaire2->setInstruction('');
        $questionnaire2->setTheme('achat d’un CD');
        $questionnaire2->setSource('Conçu en interne');
        $questionnaire2->setSupportType("enregistrement local (MLC)");
        $questionnaire2->setFocus('');
        $questionnaire2->setCognitiveOperation('');
        $questionnaire2->setFunction('');
        $questionnaire2->setReceptionType('');
        $questionnaire2->setDomain('');
        $questionnaire2->setType('');
        $questionnaire2->setSourceType('');
        $questionnaire2->setLanguageLevel('');
        $questionnaire2->setDurationGroup('');
        $questionnaire2->setFlow('');
        $questionnaire2->setWordCount('');
        $questionnaire2->setAuthor('');
        $questionnaire2->setAudioInstruction('');
        $questionnaire2->setAudioContext('');
        $questionnaire2->setAudioItem('');
        $manager->persist($questionnaire2);

        $question2 = new Question();
        $question2->setQuestionnaire($questionnaire2);
        $question2->setTypology("QRU");
        $question2->setInstruction("");
        $manager->persist($question2);

        $subquestion2 = new Subquestion();
        $subquestion2->setQuestion($question2);
        $subquestion2->setTypology("QRU");
        $manager->persist($subquestion2);

        $proposition2_1 = new Proposition();
        $proposition2_1->setSubquestion($subquestion2);
        $proposition2_1->setRightAnswer(0);
        $proposition2_1->setAudioUrl("");
        $manager->persist($proposition2_1);

        $proposition2_2 = new Proposition();
        $proposition2_2->setSubquestion($subquestion2);
        $proposition2_2->setRightAnswer(1);
        $proposition2_2->setAudioUrl("");
        $manager->persist($proposition2_2);

        $proposition2_3 = new Proposition();
        $proposition2_3->setSubquestion($subquestion2);
        $proposition2_3->setRightAnswer(0);
        $proposition2_3->setAudioUrl("");
        $manager->persist($proposition2_3);

    // ITEM 3
        $questionnaire3->addTest($test);
        $questionnaire3->setLevel("A2");
        $questionnaire3->setInstruction('');
        $questionnaire3->setTheme('bureau');
        $questionnaire3->setSource('Conçu en interne');
        $questionnaire3->setSupportType("enregistrement local (MLC)");
        $questionnaire3->setFocus('');
        $questionnaire3->setCognitiveOperation('');
        $questionnaire3->setFunction('');
        $questionnaire3->setReceptionType('');
        $questionnaire3->setDomain('');
        $questionnaire3->setType('');
        $questionnaire3->setSourceType('');
        $questionnaire3->setLanguageLevel('');
        $questionnaire3->setDurationGroup('');
        $questionnaire3->setFlow('');
        $questionnaire3->setWordCount('');
        $questionnaire3->setAuthor('');
        $questionnaire3->setAudioInstruction('');
        $questionnaire3->setAudioContext('');
        $questionnaire3->setAudioItem('');
        $manager->persist($questionnaire3);

        $question3 = new Question();
        $question3->setQuestionnaire($questionnaire3);
        $question3->setTypology("QRU");
        $question3->setInstruction("");
        $manager->persist($question3);

        $subquestion3 = new Subquestion();
        $subquestion3->setQuestion($question3);
        $subquestion3->setTypology("QRU");
        $manager->persist($subquestion3);

        $proposition3_1 = new Proposition();
        $proposition3_1->setSubquestion($subquestion3);
        $proposition3_1->setRightAnswer(1);
        $proposition3_1->setAudioUrl("");
        $manager->persist($proposition3_1);

        $proposition3_2 = new Proposition();
        $proposition3_2->setSubquestion($subquestion3);
        $proposition3_2->setRightAnswer(0);
        $proposition3_2->setAudioUrl("");
        $manager->persist($proposition3_2);

        $proposition3_3 = new Proposition();
        $proposition3_3->setSubquestion($subquestion3);
        $proposition3_3->setRightAnswer(0);
        $proposition3_3->setAudioUrl("");
        $manager->persist($proposition3_3);

    // ITEM 4
        $questionnaire4->addTest($test);
        $questionnaire4->setLevel("A2");
        $questionnaire4->setInstruction('');
        $questionnaire4->setTheme('dialogue maman-fils');
        $questionnaire4->setSource('Conçu en interne');
        $questionnaire4->setSupportType("enregistrement local (MLC)");
        $questionnaire4->setFocus('');
        $questionnaire4->setCognitiveOperation('');
        $questionnaire4->setFunction('');
        $questionnaire4->setReceptionType('');
        $questionnaire4->setDomain('');
        $questionnaire4->setType('');
        $questionnaire4->setSourceType('');
        $questionnaire4->setLanguageLevel('');
        $questionnaire4->setDurationGroup('');
        $questionnaire4->setFlow('');
        $questionnaire4->setWordCount('');
        $questionnaire4->setAuthor('');
        $questionnaire4->setAudioInstruction('');
        $questionnaire4->setAudioContext('');
        $questionnaire4->setAudioItem('');
        $manager->persist($questionnaire4);

        $question4 = new Question();
        $question4->setQuestionnaire($questionnaire4);
        $question4->setTypology("QRU");
        $question4->setInstruction("");
        $manager->persist($question4);

        $subquestion4 = new Subquestion();
        $subquestion4->setQuestion($question4);
        $subquestion4->setTypology("QRU");
        $manager->persist($subquestion4);

        $proposition4_1 = new Proposition();
        $proposition4_1->setSubquestion($subquestion4);
        $proposition4_1->setRightAnswer(1);
        $proposition4_1->setAudioUrl("");
        $manager->persist($proposition4_1);

        $proposition4_2 = new Proposition();
        $proposition4_2->setSubquestion($subquestion4);
        $proposition4_2->setRightAnswer(0);
        $proposition4_2->setAudioUrl("");
        $manager->persist($proposition4_2);

        $proposition4_3 = new Proposition();
        $proposition4_3->setSubquestion($subquestion4);
        $proposition4_3->setRightAnswer(0);
        $proposition4_3->setAudioUrl("");
        $manager->persist($proposition4_3);

    // ITEM 5    
        $questionnaire5->addTest($test);
        $questionnaire5->setLevel("A2");
        $questionnaire5->setInstruction('');
        $questionnaire5->setTheme('dialogue week-end');
        $questionnaire5->setSource('Conçu en interne');
        $questionnaire5->setSupportType("enregistrement local (MLC)");
        $questionnaire5->setFocus('');
        $questionnaire5->setCognitiveOperation('');
        $questionnaire5->setFunction('');
        $questionnaire5->setReceptionType('');
        $questionnaire5->setDomain('');
        $questionnaire5->setType('');
        $questionnaire5->setSourceType('');
        $questionnaire5->setLanguageLevel('');
        $questionnaire5->setDurationGroup('');
        $questionnaire5->setFlow('');
        $questionnaire5->setWordCount('');
        $questionnaire5->setAuthor('');
        $questionnaire5->setAudioInstruction('');
        $questionnaire5->setAudioContext('');
        $questionnaire5->setAudioItem('');
        $manager->persist($questionnaire5);

        $question5 = new Question();
        $question5->setQuestionnaire($questionnaire5);
        $question5->setTypology("QRU");
        $question5->setInstruction("");
        $manager->persist($question5);

        $subquestion5 = new Subquestion();
        $subquestion5->setQuestion($question5);
        $subquestion5->setTypology("QRU");
        $manager->persist($subquestion5);

        $proposition5_1 = new Proposition();
        $proposition5_1->setSubquestion($subquestion5);
        $proposition5_1->setRightAnswer(1);
        $proposition5_1->setAudioUrl("");
        $manager->persist($proposition5_1);

        $proposition5_2 = new Proposition();
        $proposition5_2->setSubquestion($subquestion5);
        $proposition5_2->setRightAnswer(0);
        $proposition5_2->setAudioUrl("");
        $manager->persist($proposition5_2);

        $proposition5_3 = new Proposition();
        $proposition5_3->setSubquestion($subquestion5);
        $proposition5_3->setRightAnswer(0);
        $proposition5_3->setAudioUrl("");
        $manager->persist($proposition5_3);

    // ITEM 6
        $questionnaire6->addTest($test);
        $questionnaire6->setLevel("A2");
        $questionnaire6->setInstruction('');
        $questionnaire6->setTheme('la valise');
        $questionnaire6->setSource('Conçu en interne');
        $questionnaire6->setSupportType("enregistrement local (MLC)");
        $questionnaire6->setFocus('');
        $questionnaire6->setCognitiveOperation('');
        $questionnaire6->setFunction('');
        $questionnaire6->setReceptionType('');
        $questionnaire6->setDomain('');
        $questionnaire6->setType('');
        $questionnaire6->setSourceType('');
        $questionnaire6->setLanguageLevel('');
        $questionnaire6->setDurationGroup('');
        $questionnaire6->setFlow('');
        $questionnaire6->setWordCount('');
        $questionnaire6->setAuthor('');
        $questionnaire6->setAudioInstruction('');
        $questionnaire6->setAudioContext('');
        $questionnaire6->setAudioItem('');
        $manager->persist($questionnaire6);

        $question6 = new Question();
        $question6->setQuestionnaire($questionnaire6);
        $question6->setTypology("QRU");
        $question6->setInstruction("");
        $manager->persist($question6);

        $subquestion6 = new Subquestion();
        $subquestion6->setQuestion($question6);
        $subquestion6->setTypology("QRU");
        $manager->persist($subquestion6);

        $proposition6_1 = new Proposition();
        $proposition6_1->setSubquestion($subquestion6);
        $proposition6_1->setRightAnswer(1);
        $proposition6_1->setAudioUrl("");
        $manager->persist($proposition6_1);

        $proposition6_2 = new Proposition();
        $proposition6_2->setSubquestion($subquestion6);
        $proposition6_2->setRightAnswer(0);
        $proposition6_2->setAudioUrl("");
        $manager->persist($proposition6_2);

        $proposition6_3 = new Proposition();
        $proposition6_3->setSubquestion($subquestion6);
        $proposition6_3->setRightAnswer(0);
        $proposition6_3->setAudioUrl("");
        $manager->persist($proposition6_3);

    // ITEM 7   
        $questionnaire7->addTest($test);
        $questionnaire7->setLevel("A2");
        $questionnaire7->setInstruction('');
        $questionnaire7->setTheme('moment de relax');
        $questionnaire7->setSource('Conçu en interne');
        $questionnaire7->setSupportType("enregistrement local (MLC)");
        $questionnaire7->setFocus('');
        $questionnaire7->setCognitiveOperation('');
        $questionnaire7->setFunction('');
        $questionnaire7->setReceptionType('');
        $questionnaire7->setDomain('');
        $questionnaire7->setType('');
        $questionnaire7->setSourceType('');
        $questionnaire7->setLanguageLevel('');
        $questionnaire7->setDurationGroup('');
        $questionnaire7->setFlow('');
        $questionnaire7->setWordCount('');
        $questionnaire7->setAuthor('');
        $questionnaire7->setAudioInstruction('');
        $questionnaire7->setAudioContext('');
        $questionnaire7->setAudioItem('');
        $manager->persist($questionnaire7);

        $question7 = new Question();
        $question7->setQuestionnaire($questionnaire7);
        $question7->setTypology("QRU");
        $question7->setInstruction("");
        $manager->persist($question7);

        $subquestion7 = new Subquestion();
        $subquestion7->setQuestion($question7);
        $subquestion7->setTypology("QRU");
        $manager->persist($subquestion7);

        $proposition7_1 = new Proposition();
        $proposition7_1->setSubquestion($subquestion7);
        $proposition7_1->setRightAnswer(1);
        $proposition7_1->setAudioUrl("");
        $manager->persist($proposition7_1);

        $proposition7_2 = new Proposition();
        $proposition7_2->setSubquestion($subquestion7);
        $proposition7_2->setRightAnswer(0);
        $proposition7_2->setAudioUrl("");
        $manager->persist($proposition7_2);

        $proposition7_3 = new Proposition();
        $proposition7_3->setSubquestion($subquestion7);
        $proposition7_3->setRightAnswer(0);
        $proposition7_3->setAudioUrl("");
        $manager->persist($proposition7_3);


    // ITEM 8   
        $questionnaire8->addTest($test);
        $questionnaire8->setLevel("A2");
        $questionnaire8->setInstruction('');
        $questionnaire8->setTheme('réserver des billets au théâtre');
        $questionnaire8->setSource('Conçu en interne');
        $questionnaire8->setSupportType("enregistrement local (MLC)");
        $questionnaire8->setFocus('');
        $questionnaire8->setCognitiveOperation('');
        $questionnaire8->setFunction('');
        $questionnaire8->setReceptionType('');
        $questionnaire8->setDomain('');
        $questionnaire8->setType('');
        $questionnaire8->setSourceType('');
        $questionnaire8->setLanguageLevel('');
        $questionnaire8->setDurationGroup('');
        $questionnaire8->setFlow('');
        $questionnaire8->setWordCount('');
        $questionnaire8->setAuthor('');
        $questionnaire8->setAudioInstruction('');
        $questionnaire8->setAudioContext('');
        $questionnaire8->setAudioItem('');
        $manager->persist($questionnaire8);

        $question8 = new Question();
        $question8->setQuestionnaire($questionnaire8);
        $question8->setTypology("QRU");
        $question8->setInstruction("");
        $manager->persist($question8);

        $subquestion8 = new Subquestion();
        $subquestion8->setQuestion($question8);
        $subquestion8->setTypology("QRU");
        $manager->persist($subquestion8);

        $proposition8_1 = new Proposition();
        $proposition8_1->setSubquestion($subquestion8);
        $proposition8_1->setRightAnswer(1);
        $proposition8_1->setAudioUrl("");
        $manager->persist($proposition8_1);

        $proposition8_2 = new Proposition();
        $proposition8_2->setSubquestion($subquestion8);
        $proposition8_2->setRightAnswer(0);
        $proposition8_2->setAudioUrl("");
        $manager->persist($proposition8_2);

        $proposition8_3 = new Proposition();
        $proposition8_3->setSubquestion($subquestion8);
        $proposition8_3->setRightAnswer(0);
        $proposition8_3->setAudioUrl("");
        $manager->persist($proposition8_3);


    // ITEM 9
        $questionnaire9->addTest($test);
        $questionnaire9->setLevel("A2");
        $questionnaire9->setInstruction('');
        $questionnaire9->setTheme('dialogue entre amies');
        $questionnaire9->setSource('Conçu en interne');
        $questionnaire9->setSupportType("enregistrement local (MLC)");
        $questionnaire9->setFocus('');
        $questionnaire9->setCognitiveOperation('');
        $questionnaire9->setFunction('');
        $questionnaire9->setReceptionType('');
        $questionnaire9->setDomain('');
        $questionnaire9->setType('');
        $questionnaire9->setSourceType('');
        $questionnaire9->setLanguageLevel('');
        $questionnaire9->setDurationGroup('');
        $questionnaire9->setFlow('');
        $questionnaire9->setWordCount('');
        $questionnaire9->setAuthor('');
        $questionnaire9->setAudioInstruction('');
        $questionnaire9->setAudioContext('');
        $questionnaire9->setAudioItem('');
        $manager->persist($questionnaire9);

        $question9 = new Question();
        $question9->setQuestionnaire($questionnaire9);
        $question9->setTypology("TVF");
        $question9->setInstruction("");
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

        $proposition9_1_1 = new Proposition();
        $proposition9_1_1->setSubquestion($subquestion9_1);
        $proposition9_1_1->setRightAnswer(0);
        $proposition9_1_1->setTitle("Vrai");
        $proposition9_1_1->setAudioUrl("");
        $manager->persist($proposition9_1_1);

        $proposition9_1_2 = new Proposition();
        $proposition9_1_2->setSubquestion($subquestion9_1);
        $proposition9_1_2->setRightAnswer(1);
        $proposition9_1_2->setTitle("Faux");
        $proposition9_1_2->setAudioUrl("");
        $manager->persist($proposition9_1_2);

        $proposition9_2_1 = new Proposition();
        $proposition9_2_1->setSubquestion($subquestion9_2);
        $proposition9_2_1->setRightAnswer(0);
        $proposition9_2_1->setTitle("Vrai");
        $proposition9_2_1->setAudioUrl("");
        $manager->persist($proposition9_2_1);

        $proposition9_2_2 = new Proposition();
        $proposition9_2_2->setSubquestion($subquestion9_2);
        $proposition9_2_2->setRightAnswer(1);
        $proposition9_2_2->setTitle("Faux");
        $proposition9_2_2->setAudioUrl("");
        $manager->persist($proposition9_2_2);

        $proposition9_3_1 = new Proposition();
        $proposition9_3_1->setSubquestion($subquestion9_3);
        $proposition9_3_1->setRightAnswer(1);
        $proposition9_3_1->setTitle("Vrai");
        $proposition9_3_1->setAudioUrl("");
        $manager->persist($proposition9_3_1);

        $proposition9_3_2 = new Proposition();
        $proposition9_3_2->setSubquestion($subquestion9_3);
        $proposition9_3_2->setRightAnswer(0);
        $proposition9_3_2->setTitle("Faux");
        $proposition9_3_2->setAudioUrl("");
        $manager->persist($proposition9_3_2);

    // ITEM 10   
        $questionnaire10->addTest($test);
        $questionnaire10->setLevel("A2");
        $questionnaire10->setInstruction('');
        $questionnaire10->setTheme('expression d’une inquiétude');
        $questionnaire10->setSource('certification/test validé (CELI) / modifié');
        $questionnaire10->setSupportType("enregistrement local (MLC)");
        $questionnaire10->setFocus('');
        $questionnaire10->setCognitiveOperation('');
        $questionnaire10->setFunction('');
        $questionnaire10->setReceptionType('');
        $questionnaire10->setDomain('');
        $questionnaire10->setType('');
        $questionnaire10->setSourceType('');
        $questionnaire10->setLanguageLevel('');
        $questionnaire10->setDurationGroup('');
        $questionnaire10->setFlow('');
        $questionnaire10->setWordCount('');
        $questionnaire10->setAuthor('');
        $questionnaire10->setAudioInstruction('');
        $questionnaire10->setAudioContext('');
        $questionnaire10->setAudioItem('');
        $manager->persist($questionnaire10);

        $question10 = new Question();
        $question10->setQuestionnaire($questionnaire10);
        $question10->setTypology("TVF");
        $question10->setInstruction("");
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

        $proposition10_1_1 = new Proposition();
        $proposition10_1_1->setSubquestion($subquestion10_1);
        $proposition10_1_1->setRightAnswer(1);
        $proposition10_1_1->setTitle("Vrai");
        $proposition10_1_1->setAudioUrl("");
        $manager->persist($proposition10_1_1);

        $proposition10_1_2 = new Proposition();
        $proposition10_1_2->setSubquestion($subquestion10_1);
        $proposition10_1_2->setRightAnswer(0);
        $proposition10_1_2->setTitle("Faux");
        $proposition10_1_2->setAudioUrl("");
        $manager->persist($proposition10_1_2);

        $proposition10_2_1 = new Proposition();
        $proposition10_2_1->setSubquestion($subquestion10_2);
        $proposition10_2_1->setRightAnswer(0);
        $proposition10_2_1->setTitle("Vrai");
        $proposition10_2_1->setAudioUrl("");
        $manager->persist($proposition10_2_1);

        $proposition10_2_2 = new Proposition();
        $proposition10_2_2->setSubquestion($subquestion10_2);
        $proposition10_2_2->setRightAnswer(1);
        $proposition10_2_2->setTitle("Faux");
        $proposition10_2_2->setAudioUrl("");
        $manager->persist($proposition10_2_2);

        $proposition10_3_1 = new Proposition();
        $proposition10_3_1->setSubquestion($subquestion10_3);
        $proposition10_3_1->setRightAnswer(1);
        $proposition10_3_1->setTitle("Vrai");
        $proposition10_3_1->setAudioUrl("");
        $manager->persist($proposition10_3_1);

        $proposition10_3_2 = new Proposition();
        $proposition10_3_2->setSubquestion($subquestion10_3);
        $proposition10_3_2->setRightAnswer(0);
        $proposition10_3_2->setTitle("Faux");
        $proposition10_3_2->setAudioUrl("");
        $manager->persist($proposition10_3_2);

        $proposition10_4_1 = new Proposition();
        $proposition10_4_1->setSubquestion($subquestion10_4);
        $proposition10_4_1->setRightAnswer(0);
        $proposition10_4_1->setTitle("Vrai");
        $proposition10_4_1->setAudioUrl("");
        $manager->persist($proposition10_4_1);

        $proposition10_4_2 = new Proposition();
        $proposition10_4_2->setSubquestion($subquestion10_4);
        $proposition10_4_2->setRightAnswer(1);
        $proposition10_4_2->setTitle("Faux");
        $proposition10_4_2->setAudioUrl("");
        $manager->persist($proposition10_4_2);

    // ITEM 11   
        $questionnaire11->addTest($test);
        $questionnaire11->setLevel("A2");
        $questionnaire11->setInstruction('');
        $questionnaire11->setTheme('motiver son choix 01/10');
        $questionnaire11->setSource('certification/test validé (CELI) / modifié');
        $questionnaire11->setSupportType("enregistrement local (MLC)");
        $questionnaire11->setFocus('');
        $questionnaire11->setCognitiveOperation('');
        $questionnaire11->setFunction('');
        $questionnaire11->setReceptionType('');
        $questionnaire11->setDomain('');
        $questionnaire11->setType('');
        $questionnaire11->setSourceType('');
        $questionnaire11->setLanguageLevel('');
        $questionnaire11->setDurationGroup('');
        $questionnaire11->setFlow('');
        $questionnaire11->setWordCount('');
        $questionnaire11->setAuthor('');
        $questionnaire11->setAudioInstruction('');
        $questionnaire11->setAudioContext('');
        $questionnaire11->setAudioItem('');
        $manager->persist($questionnaire11);

        $question11 = new Question();
        $question11->setQuestionnaire($questionnaire11);
        $question11->setTypology("TVF");
        $question11->setInstruction("");
        $manager->persist($question11);

        $subquestion11 = new Subquestion();
        $subquestion11->setQuestion($question11);
        $subquestion11->setTypology("VF");
        $manager->persist($subquestion11);

        $proposition11_1 = new Proposition();
        $proposition11_1->setSubquestion($subquestion11);
        $proposition11_1->setRightAnswer(1);
        $proposition11_1->setTitle("Dà la spiegazione");
        $proposition11_1->setAudioUrl("");
        $manager->persist($proposition11_1);

        $proposition11_2 = new Proposition();
        $proposition11_2->setSubquestion($subquestion11);
        $proposition11_2->setRightAnswer(0);
        $proposition11_2->setTitle("Non dà la spiegazione");
        $proposition11_2->setAudioUrl("");
        $manager->persist($proposition11_2);

        
        

    // ITEM 12
        $questionnaire12->addTest($test);
        $questionnaire12->setLevel("A2");
        $questionnaire12->setInstruction('');
        $questionnaire12->setTheme('motiver son choix 02/10');
        $questionnaire12->setSource('certification/test validé (CELI) / modifié');
        $questionnaire12->setSupportType("enregistrement local (MLC)");
        $questionnaire12->setFocus('');
        $questionnaire12->setCognitiveOperation('');
        $questionnaire12->setFunction('');
        $questionnaire12->setReceptionType('');
        $questionnaire12->setDomain('');
        $questionnaire12->setType('');
        $questionnaire12->setSourceType('');
        $questionnaire12->setLanguageLevel('');
        $questionnaire12->setDurationGroup('');
        $questionnaire12->setFlow('');
        $questionnaire12->setWordCount('');
        $questionnaire12->setAuthor('');
        $questionnaire12->setAudioInstruction('');
        $questionnaire12->setAudioContext('');
        $questionnaire12->setAudioItem('');
        $manager->persist($questionnaire12);

        $question12 = new Question();
        $question12->setQuestionnaire($questionnaire12);
        $question12->setTypology("TVF");
        $question12->setInstruction("");
        $manager->persist($question12);

        $subquestion12 = new Subquestion();
        $subquestion12->setQuestion($question12);
        $subquestion12->setTypology("VF");
        $manager->persist($subquestion12);

        $proposition12_1 = new Proposition();
        $proposition12_1->setSubquestion($subquestion12);
        $proposition12_1->setRightAnswer(1);
        $proposition12_1->setTitle("Dà la spiegazione");
        $proposition12_1->setAudioUrl("");
        $manager->persist($proposition12_1);

        $proposition12_2 = new Proposition();
        $proposition12_2->setSubquestion($subquestion12);
        $proposition12_2->setRightAnswer(0);
        $proposition12_2->setTitle("Non dà la spiegazione");
        $proposition12_2->setAudioUrl("");
        $manager->persist($proposition12_2);

      
    // ITEM 13
        $questionnaire13 = new Questionnaire();
        $questionnaire13->addTest($test);
        $questionnaire13->setLevel("A2");
        $questionnaire13->setInstruction('');
        $questionnaire13->setTheme('motiver son choix 03/10');
        $questionnaire13->setSource('certification/test validé (CELI) / modifié');
        $questionnaire13->setSupportType("enregistrement local (MLC)");
        $questionnaire13->setFocus('');
        $questionnaire13->setCognitiveOperation('');
        $questionnaire13->setFunction('');
        $questionnaire13->setReceptionType('');
        $questionnaire13->setDomain('');
        $questionnaire13->setType('');
        $questionnaire13->setSourceType('');
        $questionnaire13->setLanguageLevel('');
        $questionnaire13->setDurationGroup('');
        $questionnaire13->setFlow('');
        $questionnaire13->setWordCount('');
        $questionnaire13->setAuthor('');
        $questionnaire13->setAudioInstruction('');
        $questionnaire13->setAudioContext('');
        $questionnaire13->setAudioItem('');
        $manager->persist($questionnaire13);

        $question13 = new Question();
        $question13->setQuestionnaire($questionnaire13);
        $question13->setTypology("TVF");
        $question13->setInstruction("");
        $manager->persist($question13);

        $subquestion13 = new Subquestion();
        $subquestion13->setQuestion($question13);
        $subquestion13->setTypology("VF");
        $manager->persist($subquestion13);

        $proposition13_1 = new Proposition();
        $proposition13_1->setSubquestion($subquestion13);
        $proposition13_1->setRightAnswer(0);
        $proposition13_1->setTitle("Dà la spiegazione");
        $proposition13_1->setAudioUrl("");
        $manager->persist($proposition13_1);

        $proposition13_2 = new Proposition();
        $proposition13_2->setSubquestion($subquestion13);
        $proposition13_2->setRightAnswer(1);
        $proposition13_2->setTitle("Non dà la spiegazione");
        $proposition13_2->setAudioUrl("");
        $manager->persist($proposition13_2);

        
    // ITEM 14
        $questionnaire14->addTest($test);
        $questionnaire14->setLevel("A2");
        $questionnaire14->setInstruction('');
        $questionnaire14->setTheme('motiver son choix 04/10');
        $questionnaire14->setSource('certification/test validé (CELI) / modifié');
        $questionnaire14->setSupportType("enregistrement local (MLC)");
        $questionnaire14->setFocus('');
        $questionnaire14->setCognitiveOperation('');
        $questionnaire14->setFunction('');
        $questionnaire14->setReceptionType('');
        $questionnaire14->setDomain('');
        $questionnaire14->setType('');
        $questionnaire14->setSourceType('');
        $questionnaire14->setLanguageLevel('');
        $questionnaire14->setDurationGroup('');
        $questionnaire14->setFlow('');
        $questionnaire14->setWordCount('');
        $questionnaire14->setAuthor('');
        $questionnaire14->setAudioInstruction('');
        $questionnaire14->setAudioContext('');
        $questionnaire14->setAudioItem('');
        $manager->persist($questionnaire14);

        $question14 = new Question();
        $question14->setQuestionnaire($questionnaire14);
        $question14->setTypology("TVF");
        $question14->setInstruction("");
        $manager->persist($question14);

        $subquestion14 = new Subquestion();
        $subquestion14->setQuestion($question14);
        $subquestion14->setTypology("VF");
        $manager->persist($subquestion14);

        $proposition14_1 = new Proposition();
        $proposition14_1->setSubquestion($subquestion14);
        $proposition14_1->setRightAnswer(0);
        $proposition14_1->setTitle("Dà la spiegazione");
        $proposition14_1->setAudioUrl("");
        $manager->persist($proposition14_1);

        $proposition14_2 = new Proposition();
        $proposition14_2->setSubquestion($subquestion14);
        $proposition14_2->setRightAnswer(1);
        $proposition14_2->setTitle("Non dà la spiegazione");
        $proposition14_2->setAudioUrl("");
        $manager->persist($proposition14_2);

      
    // ITEM 15
        $questionnaire15->addTest($test);
        $questionnaire15->setLevel("A2");
        $questionnaire15->setInstruction('');
        $questionnaire15->setTheme('motiver son choix 05/10');
        $questionnaire15->setSource('certification/test validé (CELI) / modifié');
        $questionnaire15->setSupportType("enregistrement local (MLC)");
        $questionnaire15->setFocus('');
        $questionnaire15->setCognitiveOperation('');
        $questionnaire15->setFunction('');
        $questionnaire15->setReceptionType('');
        $questionnaire15->setDomain('');
        $questionnaire15->setType('');
        $questionnaire15->setSourceType('');
        $questionnaire15->setLanguageLevel('');
        $questionnaire15->setDurationGroup('');
        $questionnaire15->setFlow('');
        $questionnaire15->setWordCount('');
        $questionnaire15->setAuthor('');
        $questionnaire15->setAudioInstruction('');
        $questionnaire15->setAudioContext('');
        $questionnaire15->setAudioItem('');
        $manager->persist($questionnaire15);

        $question15 = new Question();
        $question15->setQuestionnaire($questionnaire15);
        $question15->setTypology("TVF");
        $question15->setInstruction("");
        $manager->persist($question15);

        $subquestion15 = new Subquestion();
        $subquestion15->setQuestion($question15);
        $subquestion15->setTypology("VF");
        $manager->persist($subquestion15);

        $proposition15_1 = new Proposition();
        $proposition15_1->setSubquestion($subquestion15);
        $proposition15_1->setRightAnswer(0);
        $proposition15_1->setTitle("Dà la spiegazione");
        $proposition15_1->setAudioUrl("");
        $manager->persist($proposition15_1);

        $proposition15_2 = new Proposition();
        $proposition15_2->setSubquestion($subquestion15);
        $proposition15_2->setRightAnswer(1);
        $proposition15_2->setTitle("Non dà la spiegazione");
        $proposition15_2->setAudioUrl("");
        $manager->persist($proposition15_2);

    // ITEM 16
        $questionnaire16->addTest($test);
        $questionnaire16->setLevel("A2");
        $questionnaire16->setInstruction('');
        $questionnaire16->setTheme('motiver son choix 06/10');
        $questionnaire16->setSource('certification/test validé (CELI) / modifié');
        $questionnaire16->setSupportType("enregistrement local (MLC)");
        $questionnaire16->setFocus('');
        $questionnaire16->setCognitiveOperation('');
        $questionnaire16->setFunction('');
        $questionnaire16->setReceptionType('');
        $questionnaire16->setDomain('');
        $questionnaire16->setType('');
        $questionnaire16->setSourceType('');
        $questionnaire16->setLanguageLevel('');
        $questionnaire16->setDurationGroup('');
        $questionnaire16->setFlow('');
        $questionnaire16->setWordCount('');
        $questionnaire16->setAuthor('');
        $questionnaire16->setAudioInstruction('');
        $questionnaire16->setAudioContext('');
        $questionnaire16->setAudioItem('');
        $manager->persist($questionnaire16);

        $question16 = new Question();
        $question16->setQuestionnaire($questionnaire16);
        $question16->setTypology("TVF");
        $question16->setInstruction("");
        $manager->persist($question16);

        $subquestion16 = new Subquestion();
        $subquestion16->setQuestion($question16);
        $subquestion16->setTypology("VF");
        $manager->persist($subquestion16);

        $proposition16_1 = new Proposition();
        $proposition16_1->setSubquestion($subquestion16);
        $proposition16_1->setRightAnswer(0);
        $proposition16_1->setTitle("Dà la spiegazione");
        $proposition16_1->setAudioUrl("");
        $manager->persist($proposition16_1);

        $proposition16_2 = new Proposition();
        $proposition16_2->setSubquestion($subquestion16);
        $proposition16_2->setRightAnswer(1);
        $proposition16_2->setTitle("Non dà la spiegazione");
        $proposition16_2->setAudioUrl("");
        $manager->persist($proposition16_2);


    // ITEM 17
        $questionnaire17->addTest($test);
        $questionnaire17->setLevel("A2");
        $questionnaire17->setInstruction('');
        $questionnaire17->setTheme('motiver son choix 07/10');
        $questionnaire17->setSource('certification/test validé (CELI) / modifié');
        $questionnaire17->setSupportType("enregistrement local (MLC)");
        $questionnaire17->setFocus('');
        $questionnaire17->setCognitiveOperation('');
        $questionnaire17->setFunction('');
        $questionnaire17->setReceptionType('');
        $questionnaire17->setDomain('');
        $questionnaire17->setType('');
        $questionnaire17->setSourceType('');
        $questionnaire17->setLanguageLevel('');
        $questionnaire17->setDurationGroup('');
        $questionnaire17->setFlow('');
        $questionnaire17->setWordCount('');
        $questionnaire17->setAuthor('');
        $questionnaire17->setAudioInstruction('');
        $questionnaire17->setAudioContext('');
        $questionnaire17->setAudioItem('');
        $manager->persist($questionnaire17);

        $question17 = new Question();
        $question17->setQuestionnaire($questionnaire17);
        $question17->setTypology("TVF");
        $question17->setInstruction("");
        $manager->persist($question17);

        $subquestion17 = new Subquestion();
        $subquestion17->setQuestion($question17);
        $subquestion17->setTypology("VF");
        $manager->persist($subquestion17);

        $proposition17_1 = new Proposition();
        $proposition17_1->setSubquestion($subquestion17);
        $proposition17_1->setRightAnswer(1);
        $proposition17_1->setTitle("Dà la spiegazione");
        $proposition17_1->setAudioUrl("");
        $manager->persist($proposition17_1);

        $proposition17_2 = new Proposition();
        $proposition17_2->setSubquestion($subquestion17);
        $proposition17_2->setRightAnswer(0);
        $proposition17_2->setTitle("Non dà la spiegazione");
        $proposition17_2->setAudioUrl("");
        $manager->persist($proposition17_2);

    

    // ITEM 18
        $questionnaire18->addTest($test);
        $questionnaire18->setLevel("A2");
        $questionnaire18->setInstruction('');
        $questionnaire18->setTheme('motiver son choix 08/10');
        $questionnaire18->setSource('certification/test validé (CELI) / modifié');
        $questionnaire18->setSupportType("enregistrement local (MLC)");
        $questionnaire18->setFocus('');
        $questionnaire18->setCognitiveOperation('');
        $questionnaire18->setFunction('');
        $questionnaire18->setReceptionType('');
        $questionnaire18->setDomain('');
        $questionnaire18->setType('');
        $questionnaire18->setSourceType('');
        $questionnaire18->setLanguageLevel('');
        $questionnaire18->setDurationGroup('');
        $questionnaire18->setFlow('');
        $questionnaire18->setWordCount('');
        $questionnaire18->setAuthor('');
        $questionnaire18->setAudioInstruction('');
        $questionnaire18->setAudioContext('');
        $questionnaire18->setAudioItem('');
        $manager->persist($questionnaire18);

        $question18 = new Question();
        $question18->setQuestionnaire($questionnaire18);
        $question18->setTypology("TVF");
        $question18->setInstruction("");
        $manager->persist($question18);

        $subquestion18 = new Subquestion();
        $subquestion18->setQuestion($question18);
        $subquestion18->setTypology("VF");
        $manager->persist($subquestion18);

        $proposition18_1 = new Proposition();
        $proposition18_1->setSubquestion($subquestion18);
        $proposition18_1->setRightAnswer(0);
        $proposition18_1->setTitle("Dà la spiegazione");
        $proposition18_1->setAudioUrl("");
        $manager->persist($proposition18_1);

        $proposition18_2 = new Proposition();
        $proposition18_2->setSubquestion($subquestion18);
        $proposition18_2->setRightAnswer(1);
        $proposition18_2->setTitle("Non dà la spiegazione");
        $proposition18_2->setAudioUrl("");
        $manager->persist($proposition18_2);

      

    // ITEM 19
        $questionnaire19->addTest($test);
        $questionnaire19->setLevel("A2");
        $questionnaire19->setInstruction('');
        $questionnaire19->setTheme('motiver son choix 09/10');
        $questionnaire19->setSource('certification/test validé (CELI) / modifié');
        $questionnaire19->setSupportType("enregistrement local (MLC)");
        $questionnaire19->setFocus('');
        $questionnaire19->setCognitiveOperation('');
        $questionnaire19->setFunction('');
        $questionnaire19->setReceptionType('');
        $questionnaire19->setDomain('');
        $questionnaire19->setType('');
        $questionnaire19->setSourceType('');
        $questionnaire19->setLanguageLevel('');
        $questionnaire19->setDurationGroup('');
        $questionnaire19->setFlow('');
        $questionnaire19->setWordCount('');
        $questionnaire19->setAuthor('');
        $questionnaire19->setAudioInstruction('');
        $questionnaire19->setAudioContext('');
        $questionnaire19->setAudioItem('');
        $manager->persist($questionnaire19);

        $question19 = new Question();
        $question19->setQuestionnaire($questionnaire19);
        $question19->setTypology("TVF");
        $question19->setInstruction("");
        $manager->persist($question19);

        $subquestion19 = new Subquestion();
        $subquestion19->setQuestion($question19);
        $subquestion19->setTypology("VF");
        $manager->persist($subquestion19);

        $proposition19_1 = new Proposition();
        $proposition19_1->setSubquestion($subquestion19);
        $proposition19_1->setRightAnswer(0);
        $proposition19_1->setTitle("Dà la spiegazione");
        $proposition19_1->setAudioUrl("");
        $manager->persist($proposition19_1);

        $proposition19_2 = new Proposition();
        $proposition19_2->setSubquestion($subquestion19);
        $proposition19_2->setRightAnswer(1);
        $proposition19_2->setTitle("Non dà la spiegazione");
        $proposition19_2->setAudioUrl("");
        $manager->persist($proposition19_2);


       
    // ITEM 20
        $questionnaire20->addTest($test);
        $questionnaire20->setLevel("A2");
        $questionnaire20->setInstruction('');
        $questionnaire20->setTheme('motiver son choix 10/10');
        $questionnaire20->setSource('certification/test validé (CELI) / modifié');
        $questionnaire20->setSupportType("enregistrement local (MLC)");
        $questionnaire20->setFocus('');
        $questionnaire20->setCognitiveOperation('');
        $questionnaire20->setFunction('');
        $questionnaire20->setReceptionType('');
        $questionnaire20->setDomain('');
        $questionnaire20->setType('');
        $questionnaire20->setSourceType('');
        $questionnaire20->setLanguageLevel('');
        $questionnaire20->setDurationGroup('');
        $questionnaire20->setFlow('');
        $questionnaire20->setWordCount('');
        $questionnaire20->setAuthor('');
        $questionnaire20->setAudioInstruction('');
        $questionnaire20->setAudioContext('');
        $questionnaire20->setAudioItem('');
        $manager->persist($questionnaire20);

        $question20 = new Question();
        $question20->setQuestionnaire($questionnaire20);
        $question20->setTypology("VF");
        $question20->setInstruction("");
        $manager->persist($question20);

        $subquestion20 = new Subquestion();
        $subquestion20->setQuestion($question20);
        $subquestion20->setTypology("VF");
        $manager->persist($subquestion20);

        $proposition20_1 = new Proposition();
        $proposition20_1->setSubquestion($subquestion20);
        $proposition20_1->setRightAnswer(1);
        $proposition20_1->setTitle("Dà la spiegazione");
        $proposition20_1->setAudioUrl("");
        $manager->persist($proposition20_1);

        $proposition20_2 = new Proposition();
        $proposition20_2->setSubquestion($subquestion20);
        $proposition20_2->setRightAnswer(0);
        $proposition20_2->setTitle("Non dà la spiegazione");
        $proposition20_2->setAudioUrl("");
        $manager->persist($proposition20_2);


        

    // ITEM 21
        $questionnaire21->addTest($test);
        $questionnaire21->setLevel("A2");
        $questionnaire21->setInstruction('');
        $questionnaire21->setTheme('ameublement');
        $questionnaire21->setSource('méthodes et manuels (Allegro 2, Edilingua, p. 22, unità 2) / modifié');
        $questionnaire21->setSupportType("enregistrement local (MLC)");
        $questionnaire21->setFocus('');
        $questionnaire21->setCognitiveOperation('');
        $questionnaire21->setFunction('');
        $questionnaire21->setReceptionType('');
        $questionnaire21->setDomain('');
        $questionnaire21->setType('');
        $questionnaire21->setSourceType('');
        $questionnaire21->setLanguageLevel('');
        $questionnaire21->setDurationGroup('');
        $questionnaire21->setFlow('');
        $questionnaire21->setWordCount('');
        $questionnaire21->setAuthor('');
        $questionnaire21->setAudioInstruction('');
        $questionnaire21->setAudioContext('');
        $questionnaire21->setAudioItem('');
        $manager->persist($questionnaire21);

        $question21 = new Question();
        $question21->setQuestionnaire($questionnaire21);
        $question21->setTypology("QRU");
        $question21->setInstruction("");
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

        $proposition21_1_1 = new Proposition();
        $proposition21_1_1->setSubquestion($subquestion21_1);
        $proposition21_1_1->setRightAnswer(1);
        $proposition21_1_1->setTitle("");
        $proposition21_1_1->setAudioUrl("");
        $manager->persist($proposition21_1_1);

        $proposition21_1_2 = new Proposition();
        $proposition21_1_2->setSubquestion($subquestion21_1);
        $proposition21_1_2->setRightAnswer(0);
        $proposition21_1_2->setTitle("");
        $proposition21_1_2->setAudioUrl("");
        $manager->persist($proposition21_1_2);

        $proposition21_1_3 = new Proposition();
        $proposition21_1_3->setSubquestion($subquestion21_1);
        $proposition21_1_3->setRightAnswer(0);
        $proposition21_1_3->setTitle("");
        $proposition21_1_3->setAudioUrl("");
        $manager->persist($proposition21_1_3);

        $proposition21_2_1 = new Proposition();
        $proposition21_2_1->setSubquestion($subquestion21_2);
        $proposition21_2_1->setRightAnswer(0);
        $proposition21_2_1->setTitle("");
        $proposition21_2_1->setAudioUrl("");
        $manager->persist($proposition21_2_1);

        $proposition21_2_2 = new Proposition();
        $proposition21_2_2->setSubquestion($subquestion21_2);
        $proposition21_2_2->setRightAnswer(1);
        $proposition21_2_2->setTitle("");
        $proposition21_2_2->setAudioUrl("");
        $manager->persist($proposition21_2_2);

        $proposition21_2_3 = new Proposition();
        $proposition21_2_3->setSubquestion($subquestion21_2);
        $proposition21_2_3->setRightAnswer(0);
        $proposition21_2_3->setTitle("");
        $proposition21_2_3->setAudioUrl("");
        $manager->persist($proposition21_2_3);

        $proposition21_3_1 = new Proposition();
        $proposition21_3_1->setSubquestion($subquestion21_3);
        $proposition21_3_1->setRightAnswer(1);
        $proposition21_3_1->setTitle("");
        $proposition21_3_1->setAudioUrl("");
        $manager->persist($proposition21_3_1);

        $proposition21_3_2 = new Proposition();
        $proposition21_3_2->setSubquestion($subquestion21_3);
        $proposition21_3_2->setRightAnswer(0);
        $proposition21_3_2->setTitle("");
        $proposition21_3_2->setAudioUrl("");
        $manager->persist($proposition21_3_2);

        $proposition21_3_3 = new Proposition();
        $proposition21_3_3->setSubquestion($subquestion21_3);
        $proposition21_3_3->setRightAnswer(0);
        $proposition21_3_3->setTitle("");
        $proposition21_3_3->setAudioUrl("");
        $manager->persist($proposition21_3_3);

        $proposition21_4_1 = new Proposition();
        $proposition21_4_1->setSubquestion($subquestion21_4);
        $proposition21_4_1->setRightAnswer(0);
        $proposition21_4_1->setTitle("");
        $proposition21_4_1->setAudioUrl("");
        $manager->persist($proposition21_4_1);

        $proposition21_4_2 = new Proposition();
        $proposition21_4_2->setSubquestion($subquestion21_4);
        $proposition21_4_2->setRightAnswer(1);
        $proposition21_4_2->setTitle("");
        $proposition21_4_2->setAudioUrl("");
        $manager->persist($proposition21_4_2);

        $proposition21_4_3 = new Proposition();
        $proposition21_4_3->setSubquestion($subquestion21_4);
        $proposition21_4_3->setRightAnswer(0);
        $proposition21_4_3->setTitle("");
        $proposition21_4_3->setAudioUrl("");
        $manager->persist($proposition21_4_3);

    // ITEM 22
        $questionnaire22->addTest($test);
        $questionnaire22->setLevel("A2");
        $questionnaire22->setInstruction('');
        $questionnaire22->setTheme('au secrétariat');
        $questionnaire22->setSource('certification/test validé (CILS)');
        $questionnaire22->setSupportType("enregistrement local (MLC)");
        $questionnaire22->setFocus('');
        $questionnaire22->setCognitiveOperation('');
        $questionnaire22->setFunction('');
        $questionnaire22->setReceptionType('');
        $questionnaire22->setDomain('');
        $questionnaire22->setType('');
        $questionnaire22->setSourceType('');
        $questionnaire22->setLanguageLevel('');
        $questionnaire22->setDurationGroup('');
        $questionnaire22->setFlow('');
        $questionnaire22->setWordCount('');
        $questionnaire22->setAuthor('');
        $questionnaire22->setAudioInstruction('');
        $questionnaire22->setAudioContext('');
        $questionnaire22->setAudioItem('');
        $manager->persist($questionnaire22);

        $question22 = new Question();
        $question22->setQuestionnaire($questionnaire22);
        $question22->setTypology("QRU");
        $question22->setInstruction("");
        $manager->persist($question22);

        $subquestion22 = new Subquestion();
        $subquestion22->setQuestion($question22);
        $subquestion22->setTypology("QRU");
        $manager->persist($subquestion22);

        $proposition22_1 = new Proposition();
        $proposition22_1->setSubquestion($subquestion22);
        $proposition22_1->setRightAnswer(1);
        $proposition22_1->setTitle("");
        $proposition22_1->setAudioUrl("");
        $manager->persist($proposition22_1);

        $proposition22_2 = new Proposition();
        $proposition22_2->setSubquestion($subquestion22);
        $proposition22_2->setRightAnswer(0);
        $proposition22_2->setTitle("");
        $proposition22_2->setAudioUrl("");
        $manager->persist($proposition22_2);

        $proposition22_3 = new Proposition();
        $proposition22_3->setSubquestion($subquestion22);
        $proposition22_3->setRightAnswer(0);
        $proposition22_3->setTitle("");
        $proposition22_3->setAudioUrl("");
        $manager->persist($proposition22_3);

    // ITEM 23
        $questionnaire23->addTest($test);
        $questionnaire23->setLevel("A2");
        $questionnaire23->setInstruction('');
        $questionnaire23->setTheme('location voiture');
        $questionnaire23->setSource('certification/test validé (CILS) / modifié ');
        $questionnaire23->setSupportType("enregistrement local (MLC)");
        $questionnaire23->setFocus('');
        $questionnaire23->setCognitiveOperation('');
        $questionnaire23->setFunction('');
        $questionnaire23->setReceptionType('');
        $questionnaire23->setDomain('');
        $questionnaire23->setType('');
        $questionnaire23->setSourceType('');
        $questionnaire23->setLanguageLevel('');
        $questionnaire23->setDurationGroup('');
        $questionnaire23->setFlow('');
        $questionnaire23->setWordCount('');
        $questionnaire23->setAuthor('');
        $questionnaire23->setAudioInstruction('');
        $questionnaire23->setAudioContext('');
        $questionnaire23->setAudioItem('');
        $manager->persist($questionnaire23);

        $question23 = new Question();
        $question23->setQuestionnaire($questionnaire23);
        $question23->setTypology("QRU");
        $question23->setInstruction("");
        $manager->persist($question23);

        $subquestion23 = new Subquestion();
        $subquestion23->setQuestion($question23);
        $subquestion23->setTypology("QRU");
        $manager->persist($subquestion23);

        $proposition23_1 = new Proposition();
        $proposition23_1->setSubquestion($subquestion23);
        $proposition23_1->setRightAnswer(0);
        $proposition23_1->setTitle("");
        $proposition23_1->setAudioUrl("");
        $manager->persist($proposition23_1);

        $proposition23_2 = new Proposition();
        $proposition23_2->setSubquestion($subquestion23);
        $proposition23_2->setRightAnswer(1);
        $proposition23_2->setTitle("");
        $proposition23_2->setAudioUrl("");
        $manager->persist($proposition23_2);

        $proposition23_3 = new Proposition();
        $proposition23_3->setSubquestion($subquestion23);
        $proposition23_3->setRightAnswer(0);
        $proposition23_3->setTitle("");
        $proposition23_3->setAudioUrl("");
        $manager->persist($proposition23_3);

    // ITEM 24
        $questionnaire24->addTest($test);
        $questionnaire24->setLevel("A2");
        $questionnaire24->setInstruction('');
        $questionnaire24->setTheme('billetterie théatre');
        $questionnaire24->setSource('Conçu en interne');
        $questionnaire24->setSupportType("enregistrement local (MLC)");
        $questionnaire24->setFocus('');
        $questionnaire24->setCognitiveOperation('');
        $questionnaire24->setFunction('');
        $questionnaire24->setReceptionType('');
        $questionnaire24->setDomain('');
        $questionnaire24->setType('');
        $questionnaire24->setSourceType('');
        $questionnaire24->setLanguageLevel('');
        $questionnaire24->setDurationGroup('');
        $questionnaire24->setFlow('');
        $questionnaire24->setWordCount('');
        $questionnaire24->setAuthor('');
        $questionnaire24->setAudioInstruction('');
        $questionnaire24->setAudioContext('');
        $questionnaire24->setAudioItem('');
        $manager->persist($questionnaire24);

        $question24 = new Question();
        $question24->setQuestionnaire($questionnaire24);
        $question24->setTypology("QRU");
        $question24->setInstruction("");
        $manager->persist($question24);

        $subquestion24 = new Subquestion();
        $subquestion24->setQuestion($question24);
        $subquestion24->setTypology("QRU");
        $manager->persist($subquestion24);

        $proposition24_1 = new Proposition();
        $proposition24_1->setSubquestion($subquestion24);
        $proposition24_1->setRightAnswer(0);
        $proposition24_1->setTitle("");
        $proposition24_1->setAudioUrl("");
        $manager->persist($proposition24_1);

        $proposition24_2 = new Proposition();
        $proposition24_2->setSubquestion($subquestion24);
        $proposition24_2->setRightAnswer(1);
        $proposition24_2->setTitle("");
        $proposition24_2->setAudioUrl("");
        $manager->persist($proposition24_2);

        $proposition24_3 = new Proposition();
        $proposition24_3->setSubquestion($subquestion24);
        $proposition24_3->setRightAnswer(0);
        $proposition24_3->setTitle("");
        $proposition24_3->setAudioUrl("");
        $manager->persist($proposition24_3);
    // ITEM 25
        $questionnaire25->addTest($test);
        $questionnaire25->setLevel("A2");
        $questionnaire25->setInstruction('');
        $questionnaire25->setTheme('invitations');
        $questionnaire25->setSource('méthodes et manuels (Allegro 2, Edilingua, p. 14, piste n° 5)');
        $questionnaire25->setSupportType("enregistrement local (MLC)");
        $questionnaire25->setFocus('');
        $questionnaire25->setCognitiveOperation('');
        $questionnaire25->setFunction('');
        $questionnaire25->setReceptionType('');
        $questionnaire25->setDomain('');
        $questionnaire25->setType('');
        $questionnaire25->setSourceType('');
        $questionnaire25->setLanguageLevel('');
        $questionnaire25->setDurationGroup('');
        $questionnaire25->setFlow('');
        $questionnaire25->setWordCount('');
        $questionnaire25->setAuthor('');
        $questionnaire25->setAudioInstruction('');
        $questionnaire25->setAudioContext('');
        $questionnaire25->setAudioItem('');
        $manager->persist($questionnaire25);

        $question25 = new Question();
        $question25->setQuestionnaire($questionnaire25);
        $question25->setTypology("TVF");
        $question25->setInstruction("");
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

        $proposition25_1_1 = new Proposition();
        $proposition25_1_1->setSubquestion($subquestion25_1);
        $proposition25_1_1->setRightAnswer(0);
        $proposition25_1_1->setTitle("Vrai");
        $proposition25_1_1->setAudioUrl("");
        $manager->persist($proposition25_1_1);

        $proposition25_1_2 = new Proposition();
        $proposition25_1_2->setSubquestion($subquestion25_1);
        $proposition25_1_2->setRightAnswer(1);
        $proposition25_1_2->setTitle("Faux");
        $proposition25_1_2->setAudioUrl("");
        $manager->persist($proposition25_1_2);

        $proposition25_2_1 = new Proposition();
        $proposition25_2_1->setSubquestion($subquestion25_2);
        $proposition25_2_1->setRightAnswer(1);
        $proposition25_2_1->setTitle("Vrai");
        $proposition25_2_1->setAudioUrl("");
        $manager->persist($proposition25_2_1);

        $proposition25_2_2 = new Proposition();
        $proposition25_2_2->setSubquestion($subquestion25_2);
        $proposition25_2_2->setRightAnswer(0);
        $proposition25_2_2->setTitle("Faux");
        $proposition25_2_2->setAudioUrl("");
        $manager->persist($proposition25_2_2);

        $proposition25_3_1 = new Proposition();
        $proposition25_3_1->setSubquestion($subquestion25_3);
        $proposition25_3_1->setRightAnswer(1);
        $proposition25_3_1->setTitle("Vrai");
        $proposition25_3_1->setAudioUrl("");
        $manager->persist($proposition25_3_1);

        $proposition25_3_2 = new Proposition();
        $proposition25_3_2->setSubquestion($subquestion25_3);
        $proposition25_3_2->setRightAnswer(0);
        $proposition25_3_2->setTitle("Faux");
        $proposition25_3_2->setAudioUrl("");
        $manager->persist($proposition25_3_2);

        $proposition25_4_1 = new Proposition();
        $proposition25_4_1->setSubquestion($subquestion25_4);
        $proposition25_4_1->setRightAnswer(0);
        $proposition25_4_1->setTitle("Vrai");
        $proposition25_4_1->setAudioUrl("");
        $manager->persist($proposition25_4_1);

        $proposition25_4_2 = new Proposition();
        $proposition25_4_2->setSubquestion($subquestion25_4);
        $proposition25_4_2->setRightAnswer(1);
        $proposition25_4_2->setTitle("Faux");
        $proposition25_4_2->setAudioUrl("");
        $manager->persist($proposition25_4_2);

        $proposition25_5_1 = new Proposition();
        $proposition25_5_1->setSubquestion($subquestion25_5);
        $proposition25_5_1->setRightAnswer(0);
        $proposition25_5_1->setTitle("Vrai");
        $proposition25_5_1->setAudioUrl("");
        $manager->persist($proposition25_5_1);

        $proposition25_5_2 = new Proposition();
        $proposition25_5_2->setSubquestion($subquestion25_5);
        $proposition25_5_2->setRightAnswer(1);
        $proposition25_5_2->setTitle("Faux");
        $proposition25_5_2->setAudioUrl("");
        $manager->persist($proposition25_5_2);

    // ITEM 26
        $questionnaire26->addTest($test);
        $questionnaire26->setLevel("A2");
        $questionnaire26->setInstruction('');
        $questionnaire26->setTheme('recette tiramisù');
        $questionnaire26->setSource('méthodes et manuels (Se ascoltando..., Livello A1 - A2, Guerra Edizioni, p. 35 piste n° 29) / modifié');
        $questionnaire26->setSupportType("enregistrement local (MLC)");
        $questionnaire26->setFocus('');
        $questionnaire26->setCognitiveOperation('');
        $questionnaire26->setFunction('');
        $questionnaire26->setReceptionType('');
        $questionnaire26->setDomain('');
        $questionnaire26->setType('');
        $questionnaire26->setSourceType('');
        $questionnaire26->setLanguageLevel('');
        $questionnaire26->setDurationGroup('');
        $questionnaire26->setFlow('');
        $questionnaire26->setWordCount('');
        $questionnaire26->setAuthor('');
        $questionnaire26->setAudioInstruction('');
        $questionnaire26->setAudioContext('');
        $questionnaire26->setAudioItem('');
        $manager->persist($questionnaire26);

        $question26_1 = new Question();
        $question26_1->setQuestionnaire($questionnaire26);
        $question26_1->setTypology("TVF");
        $question26_1->setInstruction("");
        $manager->persist($question26_1);

        $subquestion26_1_1 = new Subquestion();
        $subquestion26_1_1->setQuestion($question26_1);
        $subquestion26_1_1->setTypology("VF");
        $manager->persist($subquestion26_1_1);

        $proposition26_1_1_1 = new Proposition();
        $proposition26_1_1_1->setSubquestion($subquestion26_1_1);
        $proposition26_1_1_1->setRightAnswer(0);
        $proposition26_1_1_1->setTitle("Vrai");
        $proposition26_1_1_1->setAudioUrl("");
        $manager->persist($proposition26_1_1_1);

        $proposition26_1_1_2 = new Proposition();
        $proposition26_1_1_2->setSubquestion($subquestion26_1_1);
        $proposition26_1_1_2->setRightAnswer(1);
        $proposition26_1_1_2->setTitle("Faux");
        $proposition26_1_1_2->setAudioUrl("");
        $manager->persist($proposition26_1_1_2);


        $subquestion26_1_2 = new Subquestion();
        $subquestion26_1_2->setQuestion($question26_1);
        $subquestion26_1_2->setTypology("VF");
        $manager->persist($subquestion26_1_2);

        $proposition26_1_2_1 = new Proposition();
        $proposition26_1_2_1->setSubquestion($subquestion26_1_2);
        $proposition26_1_2_1->setRightAnswer(1);
        $proposition26_1_2_1->setTitle("Vrai");
        $proposition26_1_2_1->setAudioUrl("");
        $manager->persist($proposition26_1_2_1);

        $proposition26_1_2_2 = new Proposition();
        $proposition26_1_2_2->setSubquestion($subquestion26_1_2);
        $proposition26_1_2_2->setRightAnswer(0);
        $proposition26_1_2_2->setTitle("Faux");
        $proposition26_1_2_2->setAudioUrl("");
        $manager->persist($proposition26_1_2_2);


        $subquestion26_1_3 = new Subquestion();
        $subquestion26_1_3->setQuestion($question26_1);
        $subquestion26_1_3->setTypology("VF");
        $manager->persist($subquestion26_1_3);

        $proposition26_1_3_1 = new Proposition();
        $proposition26_1_3_1->setSubquestion($subquestion26_1_3);
        $proposition26_1_3_1->setRightAnswer(1);
        $proposition26_1_3_1->setTitle("Vrai");
        $proposition26_1_3_1->setAudioUrl("");
        $manager->persist($proposition26_1_3_1);

        $proposition26_1_3_2 = new Proposition();
        $proposition26_1_3_2->setSubquestion($subquestion26_1_3);
        $proposition26_1_3_2->setRightAnswer(0);
        $proposition26_1_3_2->setTitle("Faux");
        $proposition26_1_3_2->setAudioUrl("");
        $manager->persist($proposition26_1_3_2);

        $subquestion26_1_4 = new Subquestion();
        $subquestion26_1_4->setQuestion($question26_1);
        $subquestion26_1_4->setTypology("VF");
        $manager->persist($subquestion26_1_4);

        $proposition26_1_4_1 = new Proposition();
        $proposition26_1_4_1->setSubquestion($subquestion26_1_4);
        $proposition26_1_4_1->setRightAnswer(0);
        $proposition26_1_4_1->setTitle("Vrai");
        $proposition26_1_4_1->setAudioUrl("");
        $manager->persist($proposition26_1_4_1);

        $proposition26_1_4_2 = new Proposition();
        $proposition26_1_4_2->setSubquestion($subquestion26_1_4);
        $proposition26_1_4_2->setRightAnswer(1);
        $proposition26_1_4_2->setTitle("Faux");
        $proposition26_1_4_2->setAudioUrl("");
        $manager->persist($proposition26_1_4_2);

        $question26_2 = new Question();
        $question26_2->setQuestionnaire($questionnaire26);
        $question26_2->setTypology("TVF");
        $question26_2->setInstruction("");
        $manager->persist($question26_2);

        $subquestion26_2_1 = new Subquestion();
        $subquestion26_2_1->setQuestion($question26_2);
        $subquestion26_2_1->setTypology("VF");
        $manager->persist($subquestion26_2_1);

        $proposition26_2_1_1 = new Proposition();
        $proposition26_2_1_1->setSubquestion($subquestion26_2_1);
        $proposition26_2_1_1->setRightAnswer(1);
        $proposition26_2_1_1->setTitle("Vrai");
        $proposition26_2_1_1->setAudioUrl("");
        $manager->persist($proposition26_2_1_1);

        $proposition26_2_1_2 = new Proposition();
        $proposition26_2_1_2->setSubquestion($subquestion26_2_1);
        $proposition26_2_1_2->setRightAnswer(0);
        $proposition26_2_1_2->setTitle("Faux");
        $proposition26_2_1_2->setAudioUrl("");
        $manager->persist($proposition26_2_1_2);

        $subquestion26_2_2 = new Subquestion();
        $subquestion26_2_2->setQuestion($question26_2);
        $subquestion26_2_2->setTypology("VF");
        $manager->persist($subquestion26_2_2);

        $proposition26_2_2_1 = new Proposition();
        $proposition26_2_2_1->setSubquestion($subquestion26_2_2);
        $proposition26_2_2_1->setRightAnswer(0);
        $proposition26_2_2_1->setTitle("Vrai");
        $proposition26_2_2_1->setAudioUrl("");
        $manager->persist($proposition26_2_2_1);

        $proposition26_2_2_2 = new Proposition();
        $proposition26_2_2_2->setSubquestion($subquestion26_2_2);
        $proposition26_2_2_2->setRightAnswer(1);
        $proposition26_2_2_2->setTitle("Faux");
        $proposition26_2_2_2->setAudioUrl("");
        $manager->persist($proposition26_2_2_2);

        $subquestion26_2_3 = new Subquestion();
        $subquestion26_2_3->setQuestion($question26_2);
        $subquestion26_2_3->setTypology("VF");
        $manager->persist($subquestion26_2_3); 

        $proposition26_2_3_1 = new Proposition();
        $proposition26_2_3_1->setSubquestion($subquestion26_2_3);
        $proposition26_2_3_1->setRightAnswer(0);
        $proposition26_2_3_1->setTitle("Vrai");
        $proposition26_2_3_1->setAudioUrl("");
        $manager->persist($proposition26_2_3_1);

        $proposition26_2_3_2 = new Proposition();
        $proposition26_2_3_2->setSubquestion($subquestion26_2_3);
        $proposition26_2_3_2->setRightAnswer(1);
        $proposition26_2_3_2->setTitle("Faux");
        $proposition26_2_3_2->setAudioUrl("");
        $manager->persist($proposition26_2_3_2);



    // ITEM 27
        $questionnaire27->addTest($test);
        $questionnaire27->setLevel("A2");
        $questionnaire27->setInstruction('');
        $questionnaire27->setTheme('présentation travail 1/5');
        $questionnaire27->setSource('certification/test validé (Prove CELI, sessione giugno 2007_CO_A2 http://www.cvcl.it/Mediacenter/FE/CategoriaMedia.aspx?idc=214&explicit=SIhtt) / modifié');
        $questionnaire27->setSupportType("enregistrement local (MLC)");
        $questionnaire27->setFocus('');
        $questionnaire27->setCognitiveOperation('');
        $questionnaire27->setFunction('');
        $questionnaire27->setReceptionType('');
        $questionnaire27->setDomain('');
        $questionnaire27->setType('');
        $questionnaire27->setSourceType('');
        $questionnaire27->setLanguageLevel('');
        $questionnaire27->setDurationGroup('');
        $questionnaire27->setFlow('');
        $questionnaire27->setWordCount('');
        $questionnaire27->setAuthor('');
        $questionnaire27->setAudioInstruction('');
        $questionnaire27->setAudioContext('');
        $questionnaire27->setAudioItem('');
        $manager->persist($questionnaire27);

        $question27 = new Question();
        $question27->setQuestionnaire($questionnaire27);
        $question27->setTypology("TVF");
        $question27->setInstruction("");
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

        $proposition27_1_1 = new Proposition();
        $proposition27_1_1->setSubquestion($subquestion27_1);
        $proposition27_1_1->setRightAnswer(1);
        $proposition27_1_1->setTitle("Vrai");
        $proposition27_1_1->setAudioUrl("");
        $manager->persist($proposition27_1_1);

        $proposition27_1_2 = new Proposition();
        $proposition27_1_2->setSubquestion($subquestion27_1);
        $proposition27_1_2->setRightAnswer(0);
        $proposition27_1_2->setTitle("Faux");
        $proposition27_1_2->setAudioUrl("");
        $manager->persist($proposition27_1_2);

        $proposition27_2_1 = new Proposition();
        $proposition27_2_1->setSubquestion($subquestion27_2);
        $proposition27_2_1->setRightAnswer(1);
        $proposition27_2_1->setTitle("Vrai");
        $proposition27_2_1->setAudioUrl("");
        $manager->persist($proposition27_2_1);

        $proposition27_2_2 = new Proposition();
        $proposition27_2_2->setSubquestion($subquestion27_2);
        $proposition27_2_2->setRightAnswer(0);
        $proposition27_2_2->setTitle("Faux");
        $proposition27_2_2->setAudioUrl("");
        $manager->persist($proposition27_2_2);

        $proposition27_3_1 = new Proposition();
        $proposition27_3_1->setSubquestion($subquestion27_3);
        $proposition27_3_1->setRightAnswer(0);
        $proposition27_3_1->setTitle("Vrai");
        $proposition27_3_1->setAudioUrl("");
        $manager->persist($proposition27_3_1);

        $proposition27_3_2 = new Proposition();
        $proposition27_3_2->setSubquestion($subquestion27_3);
        $proposition27_3_2->setRightAnswer(1);
        $proposition27_3_2->setTitle("Faux");
        $proposition27_3_2->setAudioUrl("");
        $manager->persist($proposition27_3_2);

    // ITEM 28
        $questionnaire28->addTest($test);
        $questionnaire28->setLevel("A2");
        $questionnaire28->setInstruction('');
        $questionnaire28->setTheme('présentation travail 2/5');
        $questionnaire28->setSource('certification/test validé (Prove CELI, sessione giugno 2007_CO_A2 http://www.cvcl.it/Mediacenter/FE/CategoriaMedia.aspx?idc=214&explicit=SIhtt) / modifié');
        $questionnaire28->setSupportType("enregistrement local (MLC)");
        $questionnaire28->setFocus('');
        $questionnaire28->setCognitiveOperation('');
        $questionnaire28->setFunction('');
        $questionnaire28->setReceptionType('');
        $questionnaire28->setDomain('');
        $questionnaire28->setType('');
        $questionnaire28->setSourceType('');
        $questionnaire28->setLanguageLevel('');
        $questionnaire28->setDurationGroup('');
        $questionnaire28->setFlow('');
        $questionnaire28->setWordCount('');
        $questionnaire28->setAuthor('');
        $questionnaire28->setAudioInstruction('');
        $questionnaire28->setAudioContext('');
        $questionnaire28->setAudioItem('');
        $manager->persist($questionnaire28);

        $question28 = new Question();
        $question28->setQuestionnaire($questionnaire28);
        $question28->setTypology("TVF");
        $question28->setInstruction("");
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

        $proposition28_1_1 = new Proposition();
        $proposition28_1_1->setSubquestion($subquestion28_1);
        $proposition28_1_1->setRightAnswer(0);
        $proposition28_1_1->setTitle("Vrai");
        $proposition28_1_1->setAudioUrl("");
        $manager->persist($proposition28_1_1);

        $proposition28_1_2 = new Proposition();
        $proposition28_1_2->setSubquestion($subquestion28_1);
        $proposition28_1_2->setRightAnswer(1);
        $proposition28_1_2->setTitle("Faux");
        $proposition28_1_2->setAudioUrl("");
        $manager->persist($proposition28_1_2);

        $proposition28_2_1 = new Proposition();
        $proposition28_2_1->setSubquestion($subquestion28_2);
        $proposition28_2_1->setRightAnswer(1);
        $proposition28_2_1->setTitle("Vrai");
        $proposition28_2_1->setAudioUrl("");
        $manager->persist($proposition28_2_1);

        $proposition28_2_2 = new Proposition();
        $proposition28_2_2->setSubquestion($subquestion28_2);
        $proposition28_2_2->setRightAnswer(0);
        $proposition28_2_2->setTitle("Faux");
        $proposition28_2_2->setAudioUrl("");
        $manager->persist($proposition28_2_2);

        $proposition28_3_1 = new Proposition();
        $proposition28_3_1->setSubquestion($subquestion28_3);
        $proposition28_3_1->setRightAnswer(1);
        $proposition28_3_1->setTitle("Vrai");
        $proposition28_3_1->setAudioUrl("");
        $manager->persist($proposition28_3_1);

        $proposition28_3_2 = new Proposition();
        $proposition28_3_2->setSubquestion($subquestion28_3);
        $proposition28_3_2->setRightAnswer(0);
        $proposition28_3_2->setTitle("Faux");
        $proposition28_3_2->setAudioUrl("");
        $manager->persist($proposition28_3_2);

        $proposition28_4_1 = new Proposition();
        $proposition28_4_1->setSubquestion($subquestion28_4);
        $proposition28_4_1->setRightAnswer(1);
        $proposition28_4_1->setTitle("Vrai");
        $proposition28_4_1->setAudioUrl("");
        $manager->persist($proposition28_4_1);

        $proposition28_4_2 = new Proposition();
        $proposition28_4_2->setSubquestion($subquestion28_4);
        $proposition28_4_2->setRightAnswer(0);
        $proposition28_4_2->setTitle("Faux");
        $proposition28_4_2->setAudioUrl("");
        $manager->persist($proposition28_4_2);

    // ITEM 29
        $questionnaire29->addTest($test);
        $questionnaire29->setLevel("A2");
        $questionnaire29->setInstruction('');
        $questionnaire29->setTheme('présentation travail 3/5');
        $questionnaire29->setSource('certification/test validé (Prove CELI, sessione giugno 2007_CO_A2 http://www.cvcl.it/Mediacenter/FE/CategoriaMedia.aspx?idc=214&explicit=SIhtt) / modifié');
        $questionnaire29->setSupportType("enregistrement local (MLC)");
        $questionnaire29->setFocus('');
        $questionnaire29->setCognitiveOperation('');
        $questionnaire29->setFunction('');
        $questionnaire29->setReceptionType('');
        $questionnaire29->setDomain('');
        $questionnaire29->setType('');
        $questionnaire29->setSourceType('');
        $questionnaire29->setLanguageLevel('');
        $questionnaire29->setDurationGroup('');
        $questionnaire29->setFlow('');
        $questionnaire29->setWordCount('');
        $questionnaire29->setAuthor('');
        $questionnaire29->setAudioInstruction('');
        $questionnaire29->setAudioContext('');
        $questionnaire29->setAudioItem('');
        $manager->persist($questionnaire29);

        $question29 = new Question();
        $question29->setQuestionnaire($questionnaire29);
        $question29->setTypology("TVF");
        $question29->setInstruction("");
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

        $proposition29_1_1 = new Proposition();
        $proposition29_1_1->setSubquestion($subquestion29_1);
        $proposition29_1_1->setRightAnswer(0);
        $proposition29_1_1->setTitle("Vrai");
        $proposition29_1_1->setAudioUrl("");
        $manager->persist($proposition29_1_1);

        $proposition29_1_2 = new Proposition();
        $proposition29_1_2->setSubquestion($subquestion29_1);
        $proposition29_1_2->setRightAnswer(1);
        $proposition29_1_2->setTitle("Faux");
        $proposition29_1_2->setAudioUrl("");
        $manager->persist($proposition29_1_2);

        $proposition29_2_1 = new Proposition();
        $proposition29_2_1->setSubquestion($subquestion29_2);
        $proposition29_2_1->setRightAnswer(1);
        $proposition29_2_1->setTitle("Vrai");
        $proposition29_2_1->setAudioUrl("");
        $manager->persist($proposition29_2_1);

        $proposition29_2_2 = new Proposition();
        $proposition29_2_2->setSubquestion($subquestion29_2);
        $proposition29_2_2->setRightAnswer(0);
        $proposition29_2_2->setTitle("Faux");
        $proposition29_2_2->setAudioUrl("");
        $manager->persist($proposition29_2_2);

        $proposition29_3_1 = new Proposition();
        $proposition29_3_1->setSubquestion($subquestion29_3);
        $proposition29_3_1->setRightAnswer(0);
        $proposition29_3_1->setTitle("Vrai");
        $proposition29_3_1->setAudioUrl("");
        $manager->persist($proposition29_3_1);

        $proposition29_3_2 = new Proposition();
        $proposition29_3_2->setSubquestion($subquestion29_3);
        $proposition29_3_2->setRightAnswer(1);
        $proposition29_3_2->setTitle("Faux");
        $proposition29_3_2->setAudioUrl("");
        $manager->persist($proposition29_3_2);

        $proposition29_4_1 = new Proposition();
        $proposition29_4_1->setSubquestion($subquestion29_4);
        $proposition29_4_1->setRightAnswer(0);
        $proposition29_4_1->setTitle("Vrai");
        $proposition29_4_1->setAudioUrl("");
        $manager->persist($proposition29_4_1);

        $proposition29_4_2 = new Proposition();
        $proposition29_4_2->setSubquestion($subquestion29_4);
        $proposition29_4_2->setRightAnswer(1);
        $proposition29_4_2->setTitle("Faux");
        $proposition29_4_2->setAudioUrl("");
        $manager->persist($proposition29_4_2);


      

    // ITEM 30
        $questionnaire30->addTest($test);
        $questionnaire30->setLevel("A2");
        $questionnaire30->setInstruction('');
        $questionnaire30->setTheme('présentation travail 4/5');
        $questionnaire30->setSource('certification/test validé (Prove CELI, sessione giugno 2007_CO_A2 http://www.cvcl.it/Mediacenter/FE/CategoriaMedia.aspx?idc=214&explicit=SIhtt) / modifié');
        $questionnaire30->setSupportType("enregistrement local (MLC)");
        $questionnaire30->setFocus('');
        $questionnaire30->setCognitiveOperation('');
        $questionnaire30->setFunction('');
        $questionnaire30->setReceptionType('');
        $questionnaire30->setDomain('');
        $questionnaire30->setType('');
        $questionnaire30->setSourceType('');
        $questionnaire30->setLanguageLevel('');
        $questionnaire30->setDurationGroup('');
        $questionnaire30->setFlow('');
        $questionnaire30->setWordCount('');
        $questionnaire30->setAuthor('');
        $questionnaire30->setAudioInstruction('');
        $questionnaire30->setAudioContext('');
        $questionnaire30->setAudioItem('');
        $manager->persist($questionnaire30);

        $question30 = new Question();
        $question30->setQuestionnaire($questionnaire30);
        $question30->setTypology("TVF");
        $question30->setInstruction("");
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

        $proposition30_1_1 = new Proposition();
        $proposition30_1_1->setSubquestion($subquestion30_1);
        $proposition30_1_1->setRightAnswer(1);
        $proposition30_1_1->setTitle("Vrai");
        $proposition30_1_1->setAudioUrl("");
        $manager->persist($proposition30_1_1);

        $proposition30_1_2 = new Proposition();
        $proposition30_1_2->setSubquestion($subquestion30_1);
        $proposition30_1_2->setRightAnswer(0);
        $proposition30_1_2->setTitle("Faux");
        $proposition30_1_2->setAudioUrl("");
        $manager->persist($proposition30_1_2);

        $proposition30_2_1 = new Proposition();
        $proposition30_2_1->setSubquestion($subquestion30_2);
        $proposition30_2_1->setRightAnswer(0);
        $proposition30_2_1->setTitle("Vrai");
        $proposition30_2_1->setAudioUrl("");
        $manager->persist($proposition30_2_1);

        $proposition30_2_2 = new Proposition();
        $proposition30_2_2->setSubquestion($subquestion30_2);
        $proposition30_2_2->setRightAnswer(1);
        $proposition30_2_2->setTitle("Faux");
        $proposition30_2_2->setAudioUrl("");
        $manager->persist($proposition30_2_2);

        $proposition30_3_1 = new Proposition();
        $proposition30_3_1->setSubquestion($subquestion30_3);
        $proposition30_3_1->setRightAnswer(1);
        $proposition30_3_1->setTitle("Vrai");
        $proposition30_3_1->setAudioUrl("");
        $manager->persist($proposition30_3_1);

        $proposition30_3_2 = new Proposition();
        $proposition30_3_2->setSubquestion($subquestion30_3);
        $proposition30_3_2->setRightAnswer(0);
        $proposition30_3_2->setTitle("Faux");
        $proposition30_3_2->setAudioUrl("");
        $manager->persist($proposition30_3_2);

        
    // ITEM 31
        $questionnaire31->addTest($test);
        $questionnaire31->setLevel("A2");
        $questionnaire31->setInstruction('');
        $questionnaire31->setTheme('présentation travail 5/5');
        $questionnaire31->setSource('certification/test validé (Prove CELI, sessione giugno 2007_CO_A2 http://www.cvcl.it/Mediacenter/FE/CategoriaMedia.aspx?idc=214&explicit=SIhtt) / modifié');
        $questionnaire31->setSupportType("enregistrement local (MLC)");
        $questionnaire31->setFocus('');
        $questionnaire31->setCognitiveOperation('');
        $questionnaire31->setFunction('');
        $questionnaire31->setReceptionType('');
        $questionnaire31->setDomain('');
        $questionnaire31->setType('');
        $questionnaire31->setSourceType('');
        $questionnaire31->setLanguageLevel('');
        $questionnaire31->setDurationGroup('');
        $questionnaire31->setFlow('');
        $questionnaire31->setWordCount('');
        $questionnaire31->setAuthor('');
        $questionnaire31->setAudioInstruction('');
        $questionnaire31->setAudioContext('');
        $questionnaire31->setAudioItem('');
        $manager->persist($questionnaire31);

        $question31 = new Question();
        $question31->setQuestionnaire($questionnaire31);
        $question31->setTypology("TVF");
        $question31->setInstruction("");
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

        $proposition31_1_1 = new Proposition();
        $proposition31_1_1->setSubquestion($subquestion31_1);
        $proposition31_1_1->setRightAnswer(0);
        $proposition31_1_1->setTitle("Vrai");
        $proposition31_1_1->setAudioUrl("");
        $manager->persist($proposition31_1_1);

        $proposition31_1_2 = new Proposition();
        $proposition31_1_2->setSubquestion($subquestion31_1);
        $proposition31_1_2->setRightAnswer(1);
        $proposition31_1_2->setTitle("Faux");
        $proposition31_1_2->setAudioUrl("");
        $manager->persist($proposition31_1_2);

        $proposition31_2_1 = new Proposition();
        $proposition31_2_1->setSubquestion($subquestion31_2);
        $proposition31_2_1->setRightAnswer(0);
        $proposition31_2_1->setTitle("Vrai");
        $proposition31_2_1->setAudioUrl("");
        $manager->persist($proposition31_2_1);

        $proposition31_2_2 = new Proposition();
        $proposition31_2_2->setSubquestion($subquestion31_2);
        $proposition31_2_2->setRightAnswer(1);
        $proposition31_2_2->setTitle("Faux");
        $proposition31_2_2->setAudioUrl("");
        $manager->persist($proposition31_2_2);

        $proposition31_3_1 = new Proposition();
        $proposition31_3_1->setSubquestion($subquestion31_3);
        $proposition31_3_1->setRightAnswer(1);
        $proposition31_3_1->setTitle("Vrai");
        $proposition31_3_1->setAudioUrl("");
        $manager->persist($proposition31_3_1);

        $proposition31_3_2 = new Proposition();
        $proposition31_3_2->setSubquestion($subquestion31_3);
        $proposition31_3_2->setRightAnswer(0);
        $proposition31_3_2->setTitle("Faux");
        $proposition31_3_2->setAudioUrl("");
        $manager->persist($proposition31_3_2);

        $proposition31_4_1 = new Proposition();
        $proposition31_4_1->setSubquestion($subquestion31_4);
        $proposition31_4_1->setRightAnswer(0);
        $proposition31_4_1->setTitle("Vrai");
        $proposition31_4_1->setAudioUrl("");
        $manager->persist($proposition31_4_1);

        $proposition31_4_2 = new Proposition();
        $proposition31_4_2->setSubquestion($subquestion31_4);
        $proposition31_4_2->setRightAnswer(1);
        $proposition31_4_2->setTitle("Faux");
        $proposition31_4_2->setAudioUrl("");
        $manager->persist($proposition31_4_2);

        

    // ITEM 32
        $questionnaire32->addTest($test);
        $questionnaire32->setLevel("A2");
        $questionnaire32->setInstruction('');
        $questionnaire32->setTheme('Absence à l\'entraînement');
        $questionnaire32->setSource('Conçu en interne');
        $questionnaire32->setSupportType("enregistrement local (MLC)");
        $questionnaire32->setFocus('');
        $questionnaire32->setCognitiveOperation('');
        $questionnaire32->setFunction('');
        $questionnaire32->setReceptionType('');
        $questionnaire32->setDomain('');
        $questionnaire32->setType('');
        $questionnaire32->setSourceType('');
        $questionnaire32->setLanguageLevel('');
        $questionnaire32->setDurationGroup('');
        $questionnaire32->setFlow('');
        $questionnaire32->setWordCount('');
        $questionnaire32->setAuthor('');
        $questionnaire32->setAudioInstruction('');
        $questionnaire32->setAudioContext('');
        $questionnaire32->setAudioItem('');
        $manager->persist($questionnaire32);

        $question32 = new Question();
        $question32->setQuestionnaire($questionnaire32);
        $question32->setTypology("QRU");
        $question32->setInstruction("");
        $manager->persist($question32);

        $subquestion32 = new Subquestion();
        $subquestion32->setQuestion($question32);
        $subquestion32->setTypology("QRU");
        $manager->persist($subquestion32);

        $proposition32_1 = new Proposition();
        $proposition32_1->setSubquestion($subquestion32);
        $proposition32_1->setRightAnswer(0);
        $proposition32_1->setAudioUrl("");
        $manager->persist($proposition32_1);

        $proposition32_2 = new Proposition();
        $proposition32_2->setSubquestion($subquestion32);
        $proposition32_2->setRightAnswer(1);
        $proposition32_2->setAudioUrl("");
        $manager->persist($proposition32_2);

        $proposition32_3 = new Proposition();
        $proposition32_3->setSubquestion($subquestion32);
        $proposition32_3->setRightAnswer(0);
        $proposition32_3->setAudioUrl("");
        $manager->persist($proposition32_3);

      

    // ITEM 33
        $questionnaire33->addTest($test);
        $questionnaire33->setLevel("A2");
        $questionnaire33->setInstruction('');
        $questionnaire33->setTheme('Avant le départ');
        $questionnaire33->setSource('Conçu en interne');
        $questionnaire33->setSupportType("enregistrement local (MLC)");
        $questionnaire33->setFocus('');
        $questionnaire33->setCognitiveOperation('');
        $questionnaire33->setFunction('');
        $questionnaire33->setReceptionType('');
        $questionnaire33->setDomain('');
        $questionnaire33->setType('');
        $questionnaire33->setSourceType('');
        $questionnaire33->setLanguageLevel('');
        $questionnaire33->setDurationGroup('');
        $questionnaire33->setFlow('');
        $questionnaire33->setWordCount('');
        $questionnaire33->setAuthor('');
        $questionnaire33->setAudioInstruction('');
        $questionnaire33->setAudioContext('');
        $questionnaire33->setAudioItem('');
        $manager->persist($questionnaire33);

        $question33 = new Question();
        $question33->setQuestionnaire($questionnaire33);
        $question33->setTypology("QRU");
        $question33->setInstruction("");
        $manager->persist($question33);

        $subquestion33 = new Subquestion();
        $subquestion33->setQuestion($question33);
        $subquestion33->setTypology("QRU");
        $manager->persist($subquestion33);

        $proposition33_1 = new Proposition();
        $proposition33_1->setSubquestion($subquestion33);
        $proposition33_1->setRightAnswer(0);
        $proposition33_1->setAudioUrl("");
        $manager->persist($proposition33_1);

        $proposition33_2 = new Proposition();
        $proposition33_2->setSubquestion($subquestion33);
        $proposition33_2->setRightAnswer(1);
        $proposition33_2->setAudioUrl("");
        $manager->persist($proposition33_2);

        $proposition33_3 = new Proposition();
        $proposition33_3->setSubquestion($subquestion33);
        $proposition33_3->setRightAnswer(0);
        $proposition33_3->setAudioUrl("");
        $manager->persist($proposition33_3);


      

    // ITEM 34
        $questionnaire34->addTest($test);
        $questionnaire34->setLevel("A2");
        $questionnaire34->setInstruction('');
        $questionnaire34->setTheme('Examen');
        $questionnaire34->setSource('Conçu en interne');
        $questionnaire34->setSupportType("enregistrement local (MLC)");
        $questionnaire34->setFocus('');
        $questionnaire34->setCognitiveOperation('');
        $questionnaire34->setFunction('');
        $questionnaire34->setReceptionType('');
        $questionnaire34->setDomain('');
        $questionnaire34->setType('');
        $questionnaire34->setSourceType('');
        $questionnaire34->setLanguageLevel('');
        $questionnaire34->setDurationGroup('');
        $questionnaire34->setFlow('');
        $questionnaire34->setWordCount('');
        $questionnaire34->setAuthor('');
        $questionnaire34->setAudioInstruction('');
        $questionnaire34->setAudioContext('');
        $questionnaire34->setAudioItem('');
        $manager->persist($questionnaire34);

        $question34 = new Question();
        $question34->setQuestionnaire($questionnaire34);
        $question34->setTypology("QRU");
        $question34->setInstruction("");
        $manager->persist($question34);

        $subquestion34 = new Subquestion();
        $subquestion34->setQuestion($question34);
        $subquestion34->setTypology("QRU");
        $manager->persist($subquestion34);

        $proposition34_1 = new Proposition();
        $proposition34_1->setSubquestion($subquestion34);
        $proposition34_1->setRightAnswer(1);
        $proposition34_1->setAudioUrl("");
        $manager->persist($proposition34_1);

        $proposition34_2 = new Proposition();
        $proposition34_2->setSubquestion($subquestion34);
        $proposition34_2->setRightAnswer(0);
        $proposition34_2->setAudioUrl("");
        $manager->persist($proposition34_2);

        $proposition34_3 = new Proposition();
        $proposition34_3->setSubquestion($subquestion34);
        $proposition34_3->setRightAnswer(0);
        $proposition34_3->setAudioUrl("");
        $manager->persist($proposition34_3);

      

    // ITEM 35
        $questionnaire35->addTest($test);
        $questionnaire35->setLevel("A2");
        $questionnaire35->setInstruction('');
        $questionnaire35->setTheme('Faire les courses');
        $questionnaire35->setSource('Conçu en interne');
        $questionnaire35->setSupportType("enregistrement local (MLC)");
        $questionnaire35->setFocus('');
        $questionnaire35->setCognitiveOperation('');
        $questionnaire35->setFunction('');
        $questionnaire35->setReceptionType('');
        $questionnaire35->setDomain('');
        $questionnaire35->setType('');
        $questionnaire35->setSourceType('');
        $questionnaire35->setLanguageLevel('');
        $questionnaire35->setDurationGroup('');
        $questionnaire35->setFlow('');
        $questionnaire35->setWordCount('');
        $questionnaire35->setAuthor('');
        $questionnaire35->setAudioInstruction('');
        $questionnaire35->setAudioContext('');
        $questionnaire35->setAudioItem('');
        $manager->persist($questionnaire35);

        $question35 = new Question();
        $question35->setQuestionnaire($questionnaire35);
        $question35->setTypology("QRU");
        $question35->setInstruction("");
        $manager->persist($question35);

        $subquestion35 = new Subquestion();
        $subquestion35->setQuestion($question35);
        $subquestion35->setTypology("QRU");
        $manager->persist($subquestion35);

        $proposition35_1 = new Proposition();
        $proposition35_1->setSubquestion($subquestion35);
        $proposition35_1->setRightAnswer(1);
        $proposition35_1->setAudioUrl("");
        $manager->persist($proposition35_1);

        $proposition35_2 = new Proposition();
        $proposition35_2->setSubquestion($subquestion35);
        $proposition35_2->setRightAnswer(0);
        $proposition35_2->setAudioUrl("");
        $manager->persist($proposition35_2);

        $proposition35_3 = new Proposition();
        $proposition35_3->setSubquestion($subquestion35);
        $proposition35_3->setRightAnswer(0);
        $proposition35_3->setAudioUrl("");
        $manager->persist($proposition35_3);

       
    // ITEM 36
        $questionnaire36->addTest($test);
        $questionnaire36->setLevel("A2");
        $questionnaire36->setInstruction('');
        $questionnaire36->setTheme('Nouvelle télévisée');
        $questionnaire36->setSource('Conçu en interne');
        $questionnaire36->setSupportType("enregistrement local (MLC)");
        $questionnaire36->setFocus('');
        $questionnaire36->setCognitiveOperation('');
        $questionnaire36->setFunction('');
        $questionnaire36->setReceptionType('');
        $questionnaire36->setDomain('');
        $questionnaire36->setType('');
        $questionnaire36->setSourceType('');
        $questionnaire36->setLanguageLevel('');
        $questionnaire36->setDurationGroup('');
        $questionnaire36->setFlow('');
        $questionnaire36->setWordCount('');
        $questionnaire36->setAuthor('');
        $questionnaire36->setAudioInstruction('');
        $questionnaire36->setAudioContext('');
        $questionnaire36->setAudioItem('');
        $manager->persist($questionnaire36);

        $question36 = new Question();
        $question36->setQuestionnaire($questionnaire36);
        $question36->setTypology("QRU");
        $question36->setInstruction("");
        $manager->persist($question36);

        $subquestion36 = new Subquestion();
        $subquestion36->setQuestion($question36);
        $subquestion36->setTypology("QRU");
        $manager->persist($subquestion36);

        $proposition36_1 = new Proposition();
        $proposition36_1->setSubquestion($subquestion36);
        $proposition36_1->setRightAnswer(1);
        $proposition36_1->setAudioUrl("");
        $manager->persist($proposition36_1);

        $proposition36_2 = new Proposition();
        $proposition36_2->setSubquestion($subquestion36);
        $proposition36_2->setRightAnswer(0);
        $proposition36_2->setAudioUrl("");
        $manager->persist($proposition36_2);

        $proposition36_3 = new Proposition();
        $proposition36_3->setSubquestion($subquestion36);
        $proposition36_3->setRightAnswer(0);
        $proposition36_3->setAudioUrl("");
        $manager->persist($proposition36_3);

        

    // ITEM 37
        $questionnaire37->addTest($test);
        $questionnaire37->setLevel("A2");
        $questionnaire37->setInstruction('');
        $questionnaire37->setTheme('Rendre CD');
        $questionnaire37->setSource('Conçu en interne');
        $questionnaire37->setSupportType("enregistrement local (MLC)");
        $questionnaire37->setFocus('');
        $questionnaire37->setCognitiveOperation('');
        $questionnaire37->setFunction('');
        $questionnaire37->setReceptionType('');
        $questionnaire37->setDomain('');
        $questionnaire37->setType('');
        $questionnaire37->setSourceType('');
        $questionnaire37->setLanguageLevel('');
        $questionnaire37->setDurationGroup('');
        $questionnaire37->setFlow('');
        $questionnaire37->setWordCount('');
        $questionnaire37->setAuthor('');
        $questionnaire37->setAudioInstruction('');
        $questionnaire37->setAudioContext('');
        $questionnaire37->setAudioItem('');
        $manager->persist($questionnaire37);

        $question37 = new Question();
        $question37->setQuestionnaire($questionnaire37);
        $question37->setTypology("QRU");
        $question37->setInstruction("");
        $manager->persist($question37);

        $subquestion37 = new Subquestion();
        $subquestion37->setQuestion($question37);
        $subquestion37->setTypology("QRU");
        $manager->persist($subquestion37);

        $proposition37_1 = new Proposition();
        $proposition37_1->setSubquestion($subquestion37);
        $proposition37_1->setRightAnswer(0);
        $proposition37_1->setAudioUrl("");
        $manager->persist($proposition37_1);

        $proposition37_2 = new Proposition();
        $proposition37_2->setSubquestion($subquestion37);
        $proposition37_2->setRightAnswer(0);
        $proposition37_2->setAudioUrl("");
        $manager->persist($proposition37_2);

        $proposition37_3 = new Proposition();
        $proposition37_3->setSubquestion($subquestion37);
        $proposition37_3->setRightAnswer(1);
        $proposition37_3->setAudioUrl("");
        $manager->persist($proposition37_3);

        

    // ITEM 38
        $questionnaire38->addTest($test);
        $questionnaire38->setLevel("A2");
        $questionnaire38->setInstruction('');
        $questionnaire38->setTheme('Souvenirs');
        $questionnaire38->setSource('Conçu en interne');
        $questionnaire38->setSupportType("enregistrement local (MLC)");
        $questionnaire38->setFocus('');
        $questionnaire38->setCognitiveOperation('');
        $questionnaire38->setFunction('');
        $questionnaire38->setReceptionType('');
        $questionnaire38->setDomain('');
        $questionnaire38->setType('');
        $questionnaire38->setSourceType('');
        $questionnaire38->setLanguageLevel('');
        $questionnaire38->setDurationGroup('');
        $questionnaire38->setFlow('');
        $questionnaire38->setWordCount('');
        $questionnaire38->setAuthor('');
        $questionnaire38->setAudioInstruction('');
        $questionnaire38->setAudioContext('');
        $questionnaire38->setAudioItem('');
        $manager->persist($questionnaire38);

        $question38 = new Question();
        $question38->setQuestionnaire($questionnaire38);
        $question38->setTypology("QRU");
        $question38->setInstruction("");
        $manager->persist($question38);

        $subquestion38 = new Subquestion();
        $subquestion38->setQuestion($question38);
        $subquestion38->setTypology("QRU");
        $manager->persist($subquestion38);

        $proposition38_1 = new Proposition();
        $proposition38_1->setSubquestion($subquestion38);
        $proposition38_1->setRightAnswer(1);
        $proposition38_1->setAudioUrl("");
        $manager->persist($proposition38_1);

        $proposition38_2 = new Proposition();
        $proposition38_2->setSubquestion($subquestion38);
        $proposition38_2->setRightAnswer(0);
        $proposition38_2->setAudioUrl("");
        $manager->persist($proposition38_2);

        $proposition38_3 = new Proposition();
        $proposition38_3->setSubquestion($subquestion38);
        $proposition38_3->setRightAnswer(0);
        $proposition38_3->setAudioUrl("");
        $manager->persist($proposition38_3);

        

    // ITEM 39
        $questionnaire39->addTest($test);
        $questionnaire39->setLevel("A2");
        $questionnaire39->setInstruction('');
        $questionnaire39->setTheme('Dans la cuisine');
        $questionnaire39->setSource('Conçu en interne');
        $questionnaire39->setSupportType("enregistrement local (MLC)");
        $questionnaire39->setFocus('');
        $questionnaire39->setCognitiveOperation('');
        $questionnaire39->setFunction('');
        $questionnaire39->setReceptionType('');
        $questionnaire39->setDomain('');
        $questionnaire39->setType('');
        $questionnaire39->setSourceType('');
        $questionnaire39->setLanguageLevel('');
        $questionnaire39->setDurationGroup('');
        $questionnaire39->setFlow('');
        $questionnaire39->setWordCount('');
        $questionnaire39->setAuthor('');
        $questionnaire39->setAudioInstruction('');
        $questionnaire39->setAudioContext('');
        $questionnaire39->setAudioItem('');
        $manager->persist($questionnaire39);

        $question39 = new Question();
        $question39->setQuestionnaire($questionnaire39);
        $question39->setTypology("QRU");
        $question39->setInstruction("");
        $manager->persist($question39);

        $subquestion39 = new Subquestion();
        $subquestion39->setQuestion($question39);
        $subquestion39->setTypology("QRU");
        $manager->persist($subquestion39);

        $proposition39_1 = new Proposition();
        $proposition39_1->setSubquestion($subquestion39);
        $proposition39_1->setRightAnswer(1);
        $proposition39_1->setAudioUrl("");
        $manager->persist($proposition39_1);

        $proposition39_2 = new Proposition();
        $proposition39_2->setSubquestion($subquestion39);
        $proposition39_2->setRightAnswer(0);
        $proposition39_2->setAudioUrl("");
        $manager->persist($proposition39_2);

        $proposition39_3 = new Proposition();
        $proposition39_3->setSubquestion($subquestion39);
        $proposition39_3->setRightAnswer(0);
        $proposition39_3->setAudioUrl("");
        $manager->persist($proposition39_3);

        $manager->flush();
    }
}