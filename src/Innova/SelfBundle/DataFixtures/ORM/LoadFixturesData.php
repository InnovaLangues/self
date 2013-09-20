<?php

namespace Innova\SelfBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
    use Innova\SelfBundle\Entity\Level;
    use Innova\SelfBundle\Entity\Duration;
    use Innova\SelfBundle\Entity\Focus;
    use Innova\SelfBundle\Entity\Support;
    use Innova\SelfBundle\Entity\FunctionType;
    use Innova\SelfBundle\Entity\Source;
    use Innova\SelfBundle\Entity\Flow;
    use Innova\SelfBundle\Entity\LanguageLevel;
    use Innova\SelfBundle\Entity\SourceType;
    use Innova\SelfBundle\Entity\Domain;
    use Innova\SelfBundle\Entity\ReceptionType;
    use Innova\SelfBundle\Entity\Author;
    use Innova\SelfBundle\Entity\Instruction;
    use Innova\SelfBundle\Entity\Typology;
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

    /* LEVEL */
        $level1 = new Level();
        $level1->setName("A1");
        $manager->persist($level1);

        $level2 = new Level();
        $level2->setName("A2");
        $manager->persist($level2);

     /* DURATION */
        $duration1 = new Duration();
        $duration1->setName("brève");
        $manager->persist($duration1);

        $duration2 = new Duration();
        $duration2->setName("moyenne");
        $manager->persist($duration2);

        $duration3 = new Duration();
        $duration3->setName("longue");
        $manager->persist($duration3);

     /* FOCUS */
        $focus = new Focus();
        $focus->setName("lexical");
        $manager->persist($focus);

        $focus2 = new Focus();
        $focus2->setName("morphosyntaxique");
        $manager->persist($focus2);

        $focus3 = new Focus();
        $focus3->setName("communicatif");
        $manager->persist($focus3);

        $focus4 = new Focus();
        $focus4->setName("communicatif/pragmatique");
        $manager->persist($focus4);

        $focus5 = new Focus();
        $focus5->setName("communicatif/sociolinguistique");
        $manager->persist($focus5);


     /* SUPPORT */
        $support = new Support();
        $support->setName("enregistrement local (MLC)");
        $manager->persist($support);


    /* Typology */
        $typology = new Typology();
        $typology->setName("QRU");
        $manager->persist($typology);

        $typology2 = new Typology();
        $typology2->setName("TVF");
        $manager->persist($typology2);

        $typology3 = new Typology();
        $typology3->setName("VF");
        $manager->persist($typology3);

        $typology4 = new Typology();
        $typology4->setName("QRM");
        $manager->persist($typology4);

    /* SOURCE */
        $source1 = new Source();
        $source1->setName("conçu en interne");
        $manager->persist($source1);

        $source2 = new Source();
        $source2->setName("certification/test validé (CELI) / modifié");
        $manager->persist($source2);

        $source3 = new Source();
        $source3->setName("méthodes et manuels (Allegro 2, Edilingua, p. 14, piste n° 5)");
        $manager->persist($source3);

        $source4 = new Source();
        $source4->setName("certification/test validé (CILS)");
        $manager->persist($source4);

        $source5 = new Source();
        $source5->setName("certification/test validé (CILS) / modifié");
        $manager->persist($source5);

        $source6 = new Source();
        $source6->setName("certification/test validé (Prove CELI, sessione giugno 2007_CO_A2 http://www.cvcl.it/Mediacenter/FE/CategoriaMedia.aspx?idc=214&explicit=SIhtt) / modifié");
        $manager->persist($source6);

    /* INSTRUCTION */
        $instruction1 = new Instruction();
        $instruction1->setName("Sélectionnez la réponse correcte");
        $manager->persist($instruction1);

        $instruction2 = new Instruction();
        $instruction2->setName("Cochez la case vrai (V) ou faux (F)");
        $manager->persist($instruction2);

        $instruction3 = new Instruction();
        $instruction3->setName("Cochez la réponse correcte");
        $manager->persist($instruction3);

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
        $questionnaire1->setLevel($level2);
        $questionnaire1->setInstruction($instruction1);
        $questionnaire1->setTheme('à la boulangerie');
        $questionnaire1->setSource($source1);
        $questionnaire1->setSupport($support);
        $questionnaire1->setFocus();
        $questionnaire1->setCognitiveOperation();
        $questionnaire1->setFunctionType();
        $questionnaire1->setReceptionType();
        $questionnaire1->setDomain();
        $questionnaire1->setSourceType();
        $questionnaire1->setLanguageLevel();
        $questionnaire1->setDuration($duration1);
        $questionnaire1->setFlow();
        $questionnaire1->setAuthor();
        $questionnaire1->setAudioInstruction('1_consigne');
        $questionnaire1->setAudioContext('1_contexte');
        $questionnaire1->setAudioItem('1_item');
        $questionnaire1->setListeningLimit(2);
        $questionnaire1->setDialogue(1);
        $manager->persist($questionnaire1);

        $question1 = new Question();
        $question1->setQuestionnaire($questionnaire1);
        $question1->setTypology($typology);
        $question1->setInstruction();
        $manager->persist($question1);

        $subquestion1 = new Subquestion();
        $subquestion1->setQuestion($question1);
        $subquestion1->setTypology($typology);
        $manager->persist($subquestion1);

        $proposition1_1 = new Proposition();
        $proposition1_1->setSubquestion($subquestion1);
        $proposition1_1->setRightAnswer(1);
        $proposition1_1->setAudioUrl("1_option_1_1");
        $manager->persist($proposition1_1);

        $proposition1_2 = new Proposition();
        $proposition1_2->setSubquestion($subquestion1);
        $proposition1_2->setRightAnswer(0);
        $proposition1_2->setAudioUrl("1_option_1_2");
        $manager->persist($proposition1_2);

        $proposition1_3 = new Proposition();
        $proposition1_3->setSubquestion($subquestion1);
        $proposition1_3->setRightAnswer(0);
        $proposition1_3->setAudioUrl("1_option_1_3");
        $manager->persist($proposition1_3);


     // ITEM 2
        $questionnaire2->addTest($test);
        $questionnaire2->setLevel($level2);
        $questionnaire2->setInstruction($instruction1);
        $questionnaire2->setTheme('achat d’un CD');
        $questionnaire2->setSource($source1);
        $questionnaire2->setSupport($support);
        $questionnaire2->setFocus();
        $questionnaire2->setCognitiveOperation();
        $questionnaire2->setFunctionType();
        $questionnaire2->setReceptionType();
        $questionnaire2->setDomain();
        $questionnaire2->setSourceType();
        $questionnaire2->setLanguageLevel();
        $questionnaire2->setDuration($duration1);
        $questionnaire2->setFlow();
        $questionnaire2->setAuthor();
        $questionnaire2->setAudioInstruction('2_consigne');
        $questionnaire2->setAudioContext('');
        $questionnaire2->setAudioItem('2_item');
        $questionnaire2->setListeningLimit(1);
        $questionnaire2->setDialogue(1);
        $manager->persist($questionnaire2);

        $question2 = new Question();
        $question2->setQuestionnaire($questionnaire2);
        $question2->setTypology($typology);
        $question2->setInstruction();
        $manager->persist($question2);

        $subquestion2 = new Subquestion();
        $subquestion2->setQuestion($question2);
        $subquestion2->setTypology($typology);
        $manager->persist($subquestion2);

        $proposition2_1 = new Proposition();
        $proposition2_1->setSubquestion($subquestion2);
        $proposition2_1->setRightAnswer(0);
        $proposition2_1->setAudioUrl("2_option_1_1");
        $manager->persist($proposition2_1);

        $proposition2_2 = new Proposition();
        $proposition2_2->setSubquestion($subquestion2);
        $proposition2_2->setRightAnswer(1);
        $proposition2_2->setAudioUrl("2_option_1_2");
        $manager->persist($proposition2_2);

        $proposition2_3 = new Proposition();
        $proposition2_3->setSubquestion($subquestion2);
        $proposition2_3->setRightAnswer(0);
        $proposition2_3->setAudioUrl("2_option_1_3");
        $manager->persist($proposition2_3);


        // ITEM 25
        $questionnaire25->addTest($test);
        $questionnaire25->setLevel($level2);
        $questionnaire25->setInstruction($instruction2);
        $questionnaire25->setTheme('invitations');
        $questionnaire25->setSource($source3);
        $questionnaire25->setSupport($support);
        $questionnaire25->setFocus();
        $questionnaire25->setCognitiveOperation();
        $questionnaire25->setFunctionType();
        $questionnaire25->setReceptionType();
        $questionnaire25->setDomain();
        $questionnaire25->setSourceType();
        $questionnaire25->setLanguageLevel();
        $questionnaire25->setDuration($duration2);
        $questionnaire25->setFlow();
        $questionnaire25->setAuthor();
        $questionnaire25->setAudioInstruction('');
        $questionnaire25->setAudioContext('25_contexte');
        $questionnaire25->setAudioItem('25_item');
        $questionnaire25->setListeningLimit(2);
        $questionnaire25->setDialogue(1);
        $manager->persist($questionnaire25);

        $question25 = new Question();
        $question25->setQuestionnaire($questionnaire25);
        $question25->setTypology($typology2);
        $question25->setInstruction();
        $manager->persist($question25);

        $subquestion25_1 = new Subquestion();
        $subquestion25_1->setQuestion($question25);
        $subquestion25_1->setTypology($typology3);
        $subquestion25_1->setAudioUrl('25_option_1_1');
        $manager->persist($subquestion25_1);

        $subquestion25_2 = new Subquestion();
        $subquestion25_2->setQuestion($question25);
        $subquestion25_2->setTypology($typology3);
        $subquestion25_2->setAudioUrl('25_option_1_2');
        $manager->persist($subquestion25_2);

        $subquestion25_3 = new Subquestion();
        $subquestion25_3->setQuestion($question25);
        $subquestion25_3->setTypology($typology3);
        $subquestion25_3->setAudioUrl('25_option_1_3');
        $manager->persist($subquestion25_3);

        $subquestion25_4 = new Subquestion();
        $subquestion25_4->setQuestion($question25);
        $subquestion25_4->setTypology($typology3);
        $subquestion25_4->setAudioUrl('25_option_1_4');
        $manager->persist($subquestion25_4);

        $subquestion25_5 = new Subquestion();
        $subquestion25_5->setQuestion($question25);
        $subquestion25_5->setTypology($typology3);
        $subquestion25_5->setAudioUrl('25_option_1_5');
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

        // ITEM 32
        $questionnaire32->addTest($test);
        $questionnaire32->setLevel($level2);
        $questionnaire32->setInstruction($instruction1);
        $questionnaire32->setTheme('Absence à l\'entraînement');
        $questionnaire32->setSource($source1);
        $questionnaire32->setSupport($support);
        $questionnaire32->setFocus();
        $questionnaire32->setCognitiveOperation();
        $questionnaire32->setFunctionType();
        $questionnaire32->setReceptionType();
        $questionnaire32->setDomain();
        $questionnaire32->setSourceType();
        $questionnaire32->setLanguageLevel();
        $questionnaire32->setDuration($duration1);
        $questionnaire32->setFlow();
        $questionnaire32->setAuthor();
        $questionnaire32->setAudioInstruction('32_consigne');
        $questionnaire32->setAudioContext('32_contexte');
        $questionnaire32->setAudioItem('32_item');
        $questionnaire32->setListeningLimit(2);
        $questionnaire32->setDialogue(1);
        $manager->persist($questionnaire32);

        $question32 = new Question();
        $question32->setQuestionnaire($questionnaire32);
        $question32->setTypology($typology);
        $question32->setInstruction();
        $manager->persist($question32);

        $subquestion32 = new Subquestion();
        $subquestion32->setQuestion($question32);
        $subquestion32->setTypology($typology);
        $manager->persist($subquestion32);

        $proposition32_1 = new Proposition();
        $proposition32_1->setSubquestion($subquestion32);
        $proposition32_1->setRightAnswer(0);
        $proposition32_1->setAudioUrl("32_option_1_1");
        $manager->persist($proposition32_1);

        $proposition32_2 = new Proposition();
        $proposition32_2->setSubquestion($subquestion32);
        $proposition32_2->setRightAnswer(1);
        $proposition32_2->setAudioUrl("32_option_1_2");
        $manager->persist($proposition32_2);

        $proposition32_3 = new Proposition();
        $proposition32_3->setSubquestion($subquestion32);
        $proposition32_3->setRightAnswer(0);
        $proposition32_3->setAudioUrl("32_option_1_3");
        $manager->persist($proposition32_3);

         // ITEM 9
        $questionnaire9->addTest($test);
        $questionnaire9->setLevel($level2);
        $questionnaire9->setInstruction($instruction2);
        $questionnaire9->setTheme('dialogue entre amies');
        $questionnaire9->setSource($source1);
        $questionnaire9->setSupport($support);
        $questionnaire9->setFocus();
        $questionnaire9->setCognitiveOperation();
        $questionnaire9->setFunctionType();
        $questionnaire9->setReceptionType();
        $questionnaire9->setDomain();
        $questionnaire9->setSourceType();
        $questionnaire9->setLanguageLevel();
        $questionnaire9->setDuration($duration1);
        $questionnaire9->setFlow();
        $questionnaire9->setAuthor();
        $questionnaire9->setAudioInstruction('9_consigne');
        $questionnaire9->setAudioContext('9_contexte');
        $questionnaire9->setAudioItem('9_item');
        $questionnaire9->setListeningLimit(1);
        $questionnaire9->setDialogue(1);
        $manager->persist($questionnaire9);

        $question9 = new Question();
        $question9->setQuestionnaire($questionnaire9);
        $question9->setTypology($typology2);
        $question9->setInstruction();
        $manager->persist($question9);

        $subquestion9_1 = new Subquestion();
        $subquestion9_1->setQuestion($question9);
        $subquestion9_1->setTypology($typology3);
        $subquestion9_1->setAudioUrl("9_option_1_1");
        $manager->persist($subquestion9_1);

        $subquestion9_2 = new Subquestion();
        $subquestion9_2->setQuestion($question9);
        $subquestion9_2->setTypology($typology3);
        $subquestion9_2->setAudioUrl("9_option_1_2");
        $manager->persist($subquestion9_2);

        $subquestion9_3 = new Subquestion();
        $subquestion9_3->setQuestion($question9);
        $subquestion9_3->setTypology($typology3);
        $subquestion9_3->setAudioUrl("9_option_1_3");
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

    // ITEM 3
        $questionnaire3->addTest($test);
        $questionnaire3->setLevel($level2);
        $questionnaire3->setInstruction($instruction1);
        $questionnaire3->setTheme('bureau');
        $questionnaire3->setSource($source1);
        $questionnaire3->setSupport($support);
        $questionnaire3->setFocus();
        $questionnaire3->setCognitiveOperation();
        $questionnaire3->setFunctionType();
        $questionnaire3->setReceptionType();
        $questionnaire3->setDomain();
        $questionnaire3->setSourceType();
        $questionnaire3->setLanguageLevel();
        $questionnaire3->setDuration($duration1);
        $questionnaire3->setFlow();
        $questionnaire3->setAuthor();
        $questionnaire3->setAudioInstruction('3_consigne');
        $questionnaire3->setAudioContext('3_contexte');
        $questionnaire3->setAudioItem('3_item');
        $questionnaire3->setListeningLimit(1);
        $questionnaire3->setDialogue(1);
        $manager->persist($questionnaire3);

        $question3 = new Question();
        $question3->setQuestionnaire($questionnaire3);
        $question3->setTypology($typology);
        $question3->setInstruction();
        $manager->persist($question3);

        $subquestion3 = new Subquestion();
        $subquestion3->setQuestion($question3);
        $subquestion3->setTypology($typology);
        $manager->persist($subquestion3);

        $proposition3_1 = new Proposition();
        $proposition3_1->setSubquestion($subquestion3);
        $proposition3_1->setRightAnswer(1);
        $proposition3_1->setAudioUrl("3_option_1_1");
        $manager->persist($proposition3_1);

        $proposition3_2 = new Proposition();
        $proposition3_2->setSubquestion($subquestion3);
        $proposition3_2->setRightAnswer(0);
        $proposition3_2->setAudioUrl("3_option_1_2");
        $manager->persist($proposition3_2);

        $proposition3_3 = new Proposition();
        $proposition3_3->setSubquestion($subquestion3);
        $proposition3_3->setRightAnswer(0);
        $proposition3_3->setAudioUrl("3_option_1_3");
        $manager->persist($proposition3_3);

         // ITEM 23
        $questionnaire23->addTest($test);
        $questionnaire23->setLevel($level2);
        $questionnaire23->setInstruction($instruction1);
        $questionnaire23->setTheme('location voiture');
        $questionnaire23->setSource($source5);
        $questionnaire23->setSupport($support);
        $questionnaire23->setFocus();
        $questionnaire23->setCognitiveOperation();
        $questionnaire23->setFunctionType();
        $questionnaire23->setReceptionType();
        $questionnaire23->setDomain();
        $questionnaire23->setSourceType();
        $questionnaire23->setLanguageLevel();
        $questionnaire23->setDuration($duration1);
        $questionnaire23->setFlow();
        $questionnaire23->setAuthor();
        $questionnaire23->setAudioInstruction('23_consigne');
        $questionnaire23->setAudioContext('');
        $questionnaire23->setAudioItem('23_item');
        $questionnaire23->setListeningLimit(1);
        $questionnaire23->setDialogue(1);
        $manager->persist($questionnaire23);

        $question23 = new Question();
        $question23->setQuestionnaire($questionnaire23);
        $question23->setTypology($typology);
        $question23->setInstruction();
        $manager->persist($question23);

        $subquestion23 = new Subquestion();
        $subquestion23->setQuestion($question23);
        $subquestion23->setTypology($typology);
        $manager->persist($subquestion23);

        $proposition23_1 = new Proposition();
        $proposition23_1->setSubquestion($subquestion23);
        $proposition23_1->setRightAnswer(0);
        $proposition23_1->setTitle("");
        $proposition23_1->setAudioUrl("23_option_1_1");
        $manager->persist($proposition23_1);

        $proposition23_2 = new Proposition();
        $proposition23_2->setSubquestion($subquestion23);
        $proposition23_2->setRightAnswer(1);
        $proposition23_2->setTitle("");
        $proposition23_2->setAudioUrl("23_option_1_2");
        $manager->persist($proposition23_2);

        $proposition23_3 = new Proposition();
        $proposition23_3->setSubquestion($subquestion23);
        $proposition23_3->setRightAnswer(0);
        $proposition23_3->setTitle("");
        $proposition23_3->setAudioUrl("23_option_1_3");
        $manager->persist($proposition23_3);



        // ITEM 33
        $questionnaire33->addTest($test);
        $questionnaire33->setLevel($level2);
        $questionnaire33->setInstruction($instruction1);
        $questionnaire33->setTheme('Avant le départ');
        $questionnaire33->setSource($source1);
        $questionnaire33->setSupport($support);
        $questionnaire33->setFocus();
        $questionnaire33->setCognitiveOperation();
        $questionnaire33->setFunctionType();
        $questionnaire33->setReceptionType();
        $questionnaire33->setDomain();
        $questionnaire33->setSourceType();
        $questionnaire33->setLanguageLevel();
        $questionnaire33->setDuration($duration1);
        $questionnaire33->setFlow();
        $questionnaire33->setAuthor();
        $questionnaire33->setAudioInstruction('33_consigne');
        $questionnaire33->setAudioContext('33_contexte');
        $questionnaire33->setAudioItem('33_item');
        $questionnaire33->setListeningLimit(2);
        $questionnaire33->setDialogue(1);
        $manager->persist($questionnaire33);

        $question33 = new Question();
        $question33->setQuestionnaire($questionnaire33);
        $question33->setTypology($typology);
        $question33->setInstruction();
        $manager->persist($question33);

        $subquestion33 = new Subquestion();
        $subquestion33->setQuestion($question33);
        $subquestion33->setTypology($typology);
        $manager->persist($subquestion33);

        $proposition33_1 = new Proposition();
        $proposition33_1->setSubquestion($subquestion33);
        $proposition33_1->setRightAnswer(0);
        $proposition33_1->setAudioUrl("33_option_1_1");
        $manager->persist($proposition33_1);

        $proposition33_2 = new Proposition();
        $proposition33_2->setSubquestion($subquestion33);
        $proposition33_2->setRightAnswer(1);
        $proposition33_2->setAudioUrl("33_option_1_2");
        $manager->persist($proposition33_2);

        $proposition33_3 = new Proposition();
        $proposition33_3->setSubquestion($subquestion33);
        $proposition33_3->setRightAnswer(0);
        $proposition33_3->setAudioUrl("33_option_1_3");
        $manager->persist($proposition33_3);

         // ITEM 11
        $questionnaire11->addTest($test);
        $questionnaire11->setLevel($level2);
        $questionnaire11->setInstruction($instruction3);
        $questionnaire11->setTheme('motiver son choix 01/10');
        $questionnaire11->setSource($source2);
        $questionnaire11->setSupport($support);
        $questionnaire11->setFocus();
        $questionnaire11->setCognitiveOperation();
        $questionnaire11->setFunctionType();
        $questionnaire11->setReceptionType();
        $questionnaire11->setDomain();
        $questionnaire11->setSourceType();
        $questionnaire11->setLanguageLevel();
        $questionnaire11->setDuration($duration1);
        $questionnaire11->setFlow();
        $questionnaire11->setAuthor();
        $questionnaire11->setAudioInstruction('11_consigne');
        $questionnaire11->setAudioContext('11_contexte');
        $questionnaire11->setAudioItem('11_item');
        $questionnaire11->setListeningLimit(1);
        $questionnaire11->setDialogue(1);
        $manager->persist($questionnaire11);

        $question11 = new Question();
        $question11->setQuestionnaire($questionnaire11);
        $question11->setTypology($typology2);
        $question11->setInstruction();
        $manager->persist($question11);

        $subquestion11 = new Subquestion();
        $subquestion11->setQuestion($question11);
        $subquestion11->setTypology($typology3);
        $subquestion11->setAudioUrl("");
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
        $questionnaire12->setLevel($level2);
        $questionnaire12->setInstruction($instruction3);
        $questionnaire12->setTheme('motiver son choix 02/10');
        $questionnaire12->setSource($source2);
        $questionnaire12->setSupport($support);
        $questionnaire12->setFocus();
        $questionnaire12->setCognitiveOperation();
        $questionnaire12->setFunctionType();
        $questionnaire12->setReceptionType();
        $questionnaire12->setDomain();
        $questionnaire12->setSourceType();
        $questionnaire12->setLanguageLevel();
        $questionnaire12->setDuration($duration1);
        $questionnaire12->setFlow();
        $questionnaire12->setAuthor();
        $questionnaire12->setAudioInstruction('12_consigne');
        $questionnaire12->setAudioContext('12_contexte');
        $questionnaire12->setAudioItem('12_item');
        $questionnaire12->setListeningLimit(1);
        $questionnaire12->setDialogue(1);
        $manager->persist($questionnaire12);

        $question12 = new Question();
        $question12->setQuestionnaire($questionnaire12);
        $question12->setTypology($typology2);
        $question12->setInstruction();
        $manager->persist($question12);

        $subquestion12 = new Subquestion();
        $subquestion12->setQuestion($question12);
        $subquestion12->setTypology($typology3);
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
        $questionnaire13->setLevel($level2);
        $questionnaire13->setInstruction($instruction3);
        $questionnaire13->setTheme('motiver son choix 03/10');
        $questionnaire13->setSource($source2);
        $questionnaire13->setSupport($support);
        $questionnaire13->setFocus();
        $questionnaire13->setCognitiveOperation();
        $questionnaire13->setFunctionType();
        $questionnaire13->setReceptionType();
        $questionnaire13->setDomain();
        $questionnaire13->setSourceType();
        $questionnaire13->setLanguageLevel();
        $questionnaire13->setDuration($duration1);
        $questionnaire13->setFlow();
        $questionnaire13->setAuthor();
        $questionnaire13->setAudioInstruction('13_consigne');
        $questionnaire13->setAudioContext('13_contexte');
        $questionnaire13->setAudioItem('13_item');
        $questionnaire13->setListeningLimit(1);
        $questionnaire13->setDialogue(1);
        $manager->persist($questionnaire13);

        $question13 = new Question();
        $question13->setQuestionnaire($questionnaire13);
        $question13->setTypology($typology2);
        $question13->setInstruction();
        $manager->persist($question13);

        $subquestion13 = new Subquestion();
        $subquestion13->setQuestion($question13);
        $subquestion13->setTypology($typology3);
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
        $questionnaire14->setLevel($level2);
        $questionnaire14->setInstruction($instruction3);
        $questionnaire14->setTheme('motiver son choix 04/10');
        $questionnaire14->setSource($source2);
        $questionnaire14->setSupport($support);
        $questionnaire14->setFocus();
        $questionnaire14->setCognitiveOperation();
        $questionnaire14->setFunctionType();
        $questionnaire14->setReceptionType();
        $questionnaire14->setDomain();
        $questionnaire14->setSourceType();
        $questionnaire14->setLanguageLevel();
        $questionnaire14->setDuration($duration1);
        $questionnaire14->setFlow();
        $questionnaire14->setAuthor();
        $questionnaire14->setAudioInstruction('14_consigne');
        $questionnaire14->setAudioContext('14_contexte');
        $questionnaire14->setAudioItem('14_item');
        $questionnaire14->setListeningLimit(1);
        $questionnaire14->setDialogue(1);
        $manager->persist($questionnaire14);

        $question14 = new Question();
        $question14->setQuestionnaire($questionnaire14);
        $question14->setTypology($typology2);
        $question14->setInstruction();
        $manager->persist($question14);

        $subquestion14 = new Subquestion();
        $subquestion14->setQuestion($question14);
        $subquestion14->setTypology($typology3);
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
        $questionnaire15->setLevel($level2);
        $questionnaire15->setInstruction($instruction3);
        $questionnaire15->setTheme('motiver son choix 05/10');
        $questionnaire15->setSource($source2);
        $questionnaire15->setSupport($support);
        $questionnaire15->setFocus();
        $questionnaire15->setCognitiveOperation();
        $questionnaire15->setFunctionType();
        $questionnaire15->setReceptionType();
        $questionnaire15->setDomain();
        $questionnaire15->setSourceType();
        $questionnaire15->setLanguageLevel();
        $questionnaire15->setDuration($duration1);
        $questionnaire15->setFlow();
        $questionnaire15->setAuthor();
        $questionnaire15->setAudioInstruction('15_consigne');
        $questionnaire15->setAudioContext('15_contexte');
        $questionnaire15->setAudioItem('15_item');
        $questionnaire15->setListeningLimit(1);
        $questionnaire15->setDialogue(1);
        $manager->persist($questionnaire15);

        $question15 = new Question();
        $question15->setQuestionnaire($questionnaire15);
        $question15->setTypology($typology2);
        $question15->setInstruction();
        $manager->persist($question15);

        $subquestion15 = new Subquestion();
        $subquestion15->setQuestion($question15);
        $subquestion15->setTypology($typology3);
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

        // ITEM 34
        $questionnaire34->addTest($test);
        $questionnaire34->setLevel($level2);
        $questionnaire34->setInstruction($instruction1);
        $questionnaire34->setTheme('Examen');
        $questionnaire34->setSource($source1);
        $questionnaire34->setSupport($support);
        $questionnaire34->setFocus();
        $questionnaire34->setCognitiveOperation();
        $questionnaire34->setFunctionType();
        $questionnaire34->setReceptionType();
        $questionnaire34->setDomain();
        $questionnaire34->setSourceType();
        $questionnaire34->setLanguageLevel();
        $questionnaire34->setDuration($duration1);
        $questionnaire34->setFlow();
        $questionnaire34->setAuthor();
        $questionnaire34->setAudioInstruction('34_consigne');
        $questionnaire34->setAudioContext('34_contexte');
        $questionnaire34->setAudioItem('34_item');
        $questionnaire34->setListeningLimit(1);
        $questionnaire34->setDialogue(1);
        $manager->persist($questionnaire34);

        $question34 = new Question();
        $question34->setQuestionnaire($questionnaire34);
        $question34->setTypology($typology);
        $question34->setInstruction();
        $manager->persist($question34);

        $subquestion34 = new Subquestion();
        $subquestion34->setQuestion($question34);
        $subquestion34->setTypology($typology);
        $manager->persist($subquestion34);

        $proposition34_2 = new Proposition();
        $proposition34_2->setSubquestion($subquestion34);
        $proposition34_2->setRightAnswer(0);
        $proposition34_2->setAudioUrl("34_option_1_2");
        $manager->persist($proposition34_2);

        $proposition34_1 = new Proposition();
        $proposition34_1->setSubquestion($subquestion34);
        $proposition34_1->setRightAnswer(1);
        $proposition34_1->setAudioUrl("34_option_1_1");
        $manager->persist($proposition34_1);

        $proposition34_3 = new Proposition();
        $proposition34_3->setSubquestion($subquestion34);
        $proposition34_3->setRightAnswer(0);
        $proposition34_3->setAudioUrl("34_option_1_3");
        $manager->persist($proposition34_3);



    // ITEM 35
        $questionnaire35->addTest($test);
        $questionnaire35->setLevel($level2);
        $questionnaire35->setInstruction($instruction1);
        $questionnaire35->setTheme('Faire les courses');
        $questionnaire35->setSource($source1);
        $questionnaire35->setSupport($support);
        $questionnaire35->setFocus();
        $questionnaire35->setCognitiveOperation();
        $questionnaire35->setFunctionType();
        $questionnaire35->setReceptionType();
        $questionnaire35->setDomain();
        $questionnaire35->setSourceType();
        $questionnaire35->setLanguageLevel();
        $questionnaire35->setDuration($duration1);
        $questionnaire35->setFlow();
        $questionnaire35->setAuthor();
        $questionnaire35->setAudioInstruction('35_consigne');
        $questionnaire35->setAudioContext('35_contexte');
        $questionnaire35->setAudioItem('35_item');
        $questionnaire35->setListeningLimit(1);
        $questionnaire35->setDialogue(1);
        $manager->persist($questionnaire35);

        $question35 = new Question();
        $question35->setQuestionnaire($questionnaire35);
        $question35->setTypology($typology);
        $question35->setInstruction();
        $manager->persist($question35);

        $subquestion35 = new Subquestion();
        $subquestion35->setQuestion($question35);
        $subquestion35->setTypology($typology);
        $manager->persist($subquestion35);

        $proposition35_2 = new Proposition();
        $proposition35_2->setSubquestion($subquestion35);
        $proposition35_2->setRightAnswer(0);
        $proposition35_2->setAudioUrl("35_option_1_2");
        $manager->persist($proposition35_2);

        $proposition35_3 = new Proposition();
        $proposition35_3->setSubquestion($subquestion35);
        $proposition35_3->setRightAnswer(0);
        $proposition35_3->setAudioUrl("35_option_1_3");
        $manager->persist($proposition35_3);

        $proposition35_1 = new Proposition();
        $proposition35_1->setSubquestion($subquestion35);
        $proposition35_1->setRightAnswer(1);
        $proposition35_1->setAudioUrl("35_option_1_1");
        $manager->persist($proposition35_1);

         // ITEM 27
        $questionnaire27->addTest($test);
        $questionnaire27->setLevel($level2);
        $questionnaire27->setInstruction($instruction2);
        $questionnaire27->setTheme('présentation travail 1/5');
        $questionnaire27->setSource($source6);
        $questionnaire27->setSupport($support);
        $questionnaire27->setFocus();
        $questionnaire27->setCognitiveOperation();
        $questionnaire27->setFunctionType();
        $questionnaire27->setReceptionType();
        $questionnaire27->setDomain();
        $questionnaire27->setSourceType();
        $questionnaire27->setLanguageLevel();
        $questionnaire27->setDuration($duration2);
        $questionnaire27->setFlow();
        $questionnaire27->setAuthor();
        $questionnaire27->setAudioInstruction('');
        $questionnaire27->setAudioContext('27_contexte');
        $questionnaire27->setAudioItem('27_item');
        $questionnaire27->setListeningLimit(2);
        $questionnaire27->setDialogue(0);
        $manager->persist($questionnaire27);

        $question27 = new Question();
        $question27->setQuestionnaire($questionnaire27);
        $question27->setTypology($typology2);
        $question27->setInstruction();
        $manager->persist($question27);

        $subquestion27_1 = new Subquestion();
        $subquestion27_1->setQuestion($question27);
        $subquestion27_1->setTypology($typology3);
        $subquestion27_1->setAudioUrl('27_option_1_1');
        $manager->persist($subquestion27_1);

        $subquestion27_2 = new Subquestion();
        $subquestion27_2->setQuestion($question27);
        $subquestion27_2->setTypology($typology3);
        $subquestion27_2->setAudioUrl('27_option_1_2');
        $manager->persist($subquestion27_2);

        $subquestion27_3 = new Subquestion();
        $subquestion27_3->setQuestion($question27);
        $subquestion27_3->setTypology($typology3);
        $subquestion27_3->setAudioUrl('27_option_1_3');
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
        $questionnaire28->setLevel($level2);
        $questionnaire28->setInstruction($instruction2);
        $questionnaire28->setTheme('présentation travail 2/5');
        $questionnaire28->setSource($source6);
        $questionnaire28->setSupport($support);
        $questionnaire28->setFocus();
        $questionnaire28->setCognitiveOperation();
        $questionnaire28->setFunctionType();
        $questionnaire28->setReceptionType();
        $questionnaire28->setDomain();
        $questionnaire28->setSourceType();
        $questionnaire28->setLanguageLevel();
        $questionnaire28->setDuration($duration2);
        $questionnaire28->setFlow();
        $questionnaire28->setAuthor();
        $questionnaire28->setAudioInstruction('');
        $questionnaire28->setAudioContext('28_contexte');
        $questionnaire28->setAudioItem('28_item');
        $questionnaire28->setListeningLimit(2);
        $questionnaire28->setDialogue(0);
        $manager->persist($questionnaire28);

        $question28 = new Question();
        $question28->setQuestionnaire($questionnaire28);
        $question28->setTypology($typology2);
        $question28->setInstruction();
        $manager->persist($question28);

        $subquestion28_1 = new Subquestion();
        $subquestion28_1->setQuestion($question28);
        $subquestion28_1->setTypology($typology3);
        $subquestion28_1->setAudioUrl('28_option_1_1');
        $manager->persist($subquestion28_1);

        $subquestion28_2 = new Subquestion();
        $subquestion28_2->setQuestion($question28);
        $subquestion28_2->setTypology($typology3);
        $subquestion28_2->setAudioUrl('28_option_1_2');
        $manager->persist($subquestion28_2);

        $subquestion28_3 = new Subquestion();
        $subquestion28_3->setQuestion($question28);
        $subquestion28_3->setTypology($typology3);
        $subquestion28_3->setAudioUrl('28_option_1_3');
        $manager->persist($subquestion28_3);

        $subquestion28_4 = new Subquestion();
        $subquestion28_4->setQuestion($question28);
        $subquestion28_4->setTypology($typology3);
        $subquestion28_4->setAudioUrl('28_option_1_4');
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
        $questionnaire29->setLevel($level2);
        $questionnaire29->setInstruction($instruction2);
        $questionnaire29->setTheme('présentation travail 3/5');
        $questionnaire29->setSource($source6);
        $questionnaire29->setSupport($support);
        $questionnaire29->setFocus();
        $questionnaire29->setCognitiveOperation();
        $questionnaire29->setFunctionType();
        $questionnaire29->setReceptionType();
        $questionnaire29->setDomain();
        $questionnaire29->setSourceType();
        $questionnaire29->setLanguageLevel();
        $questionnaire29->setDuration($duration2);
        $questionnaire29->setFlow();
        $questionnaire29->setAuthor();
        $questionnaire29->setAudioInstruction('');
        $questionnaire29->setAudioContext('29_contexte');
        $questionnaire29->setAudioItem('29_item');
        $questionnaire29->setListeningLimit(2);
        $questionnaire29->setDialogue(0);
        $manager->persist($questionnaire29);

        $question29 = new Question();
        $question29->setQuestionnaire($questionnaire29);
        $question29->setTypology($typology2);
        $question29->setInstruction();
        $manager->persist($question29);

        $subquestion29_1 = new Subquestion();
        $subquestion29_1->setQuestion($question29);
        $subquestion29_1->setTypology($typology3);
        $subquestion29_1->setAudioUrl('29_option_1_1');
        $manager->persist($subquestion29_1);

        $subquestion29_2 = new Subquestion();
        $subquestion29_2->setQuestion($question29);
        $subquestion29_2->setTypology($typology3);
        $subquestion29_2->setAudioUrl('29_option_1_2');
        $manager->persist($subquestion29_2);

        $subquestion29_3 = new Subquestion();
        $subquestion29_3->setQuestion($question29);
        $subquestion29_3->setTypology($typology3);
        $subquestion29_3->setAudioUrl('29_option_1_3');
        $manager->persist($subquestion29_3);

        $subquestion29_4 = new Subquestion();
        $subquestion29_4->setQuestion($question29);
        $subquestion29_4->setTypology($typology3);
        $subquestion29_4->setAudioUrl('29_option_1_4');
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


    // ITEM 4
        $questionnaire4->addTest($test);
        $questionnaire4->setLevel($level2);
        $questionnaire4->setInstruction($instruction1);
        $questionnaire4->setTheme('dialogue maman-fils');
        $questionnaire4->setSource($source1);
        $questionnaire4->setSupport($support);
        $questionnaire4->setFocus();
        $questionnaire4->setCognitiveOperation();
        $questionnaire4->setFunctionType();
        $questionnaire4->setReceptionType();
        $questionnaire4->setDomain();
        $questionnaire4->setSourceType();
        $questionnaire4->setLanguageLevel();
        $questionnaire4->setDuration($duration2);
        $questionnaire4->setFlow();
        $questionnaire4->setAuthor();
        $questionnaire4->setAudioInstruction('4_consigne');
        $questionnaire4->setAudioContext('4_contexte');
        $questionnaire4->setAudioItem('4_item');
        $questionnaire4->setListeningLimit(2);
        $questionnaire4->setDialogue(1);
        $manager->persist($questionnaire4);

        $question4 = new Question();
        $question4->setQuestionnaire($questionnaire4);
        $question4->setTypology($typology);
        $question4->setInstruction();
        $manager->persist($question4);

        $subquestion4 = new Subquestion();
        $subquestion4->setQuestion($question4);
        $subquestion4->setTypology($typology);
        $manager->persist($subquestion4);


        $proposition4_2 = new Proposition();
        $proposition4_2->setSubquestion($subquestion4);
        $proposition4_2->setRightAnswer(0);
        $proposition4_2->setAudioUrl("4_option_1_2");
        $manager->persist($proposition4_2);

        $proposition4_1 = new Proposition();
        $proposition4_1->setSubquestion($subquestion4);
        $proposition4_1->setRightAnswer(1);
        $proposition4_1->setAudioUrl("4_option_1_1");
        $manager->persist($proposition4_1);

        $proposition4_3 = new Proposition();
        $proposition4_3->setSubquestion($subquestion4);
        $proposition4_3->setRightAnswer(0);
        $proposition4_3->setAudioUrl("4_option_1_3");
        $manager->persist($proposition4_3);

    // ITEM 5
        $questionnaire5->addTest($test);
        $questionnaire5->setLevel($level2);
        $questionnaire5->setInstruction($instruction1);
        $questionnaire5->setTheme('dialogue week-end');
        $questionnaire5->setSource($source1);
        $questionnaire5->setSupport($support);
        $questionnaire5->setFocus();
        $questionnaire5->setCognitiveOperation();
        $questionnaire5->setFunctionType();
        $questionnaire5->setReceptionType();
        $questionnaire5->setDomain();
        $questionnaire5->setSourceType();
        $questionnaire5->setLanguageLevel();
        $questionnaire5->setDuration($duration1);
        $questionnaire5->setFlow();
        $questionnaire5->setAuthor();
        $questionnaire5->setAudioInstruction('5_consigne');
        $questionnaire5->setAudioContext('5_contexte');
        $questionnaire5->setAudioItem('5_item');
        $questionnaire5->setListeningLimit(1);
        $questionnaire5->setDialogue(1);
        $manager->persist($questionnaire5);

        $question5 = new Question();
        $question5->setQuestionnaire($questionnaire5);
        $question5->setTypology($typology);
        $question5->setInstruction();
        $manager->persist($question5);

        $subquestion5 = new Subquestion();
        $subquestion5->setQuestion($question5);
        $subquestion5->setTypology($typology);
        $manager->persist($subquestion5);

        $proposition5_1 = new Proposition();
        $proposition5_1->setSubquestion($subquestion5);
        $proposition5_1->setRightAnswer(1);
        $proposition5_1->setAudioUrl("5_option_1_1");
        $manager->persist($proposition5_1);

        $proposition5_2 = new Proposition();
        $proposition5_2->setSubquestion($subquestion5);
        $proposition5_2->setRightAnswer(0);
        $proposition5_2->setAudioUrl("5_option_1_2");
        $manager->persist($proposition5_2);

        $proposition5_3 = new Proposition();
        $proposition5_3->setSubquestion($subquestion5);
        $proposition5_3->setRightAnswer(0);
        $proposition5_3->setAudioUrl("5_option_1_3");
        $manager->persist($proposition5_3);


        // ITEM 36
        $questionnaire36->addTest($test);
        $questionnaire36->setLevel($level2);
        $questionnaire36->setInstruction($instruction1);
        $questionnaire36->setTheme('Nouvelle télévisée');
        $questionnaire36->setSource($source1);
        $questionnaire36->setSupport($support);
        $questionnaire36->setFocus();
        $questionnaire36->setCognitiveOperation();
        $questionnaire36->setFunctionType();
        $questionnaire36->setReceptionType();
        $questionnaire36->setDomain();
        $questionnaire36->setSourceType();
        $questionnaire36->setLanguageLevel();
        $questionnaire36->setDuration($duration1);
        $questionnaire36->setFlow();
        $questionnaire36->setAuthor();
        $questionnaire36->setAudioInstruction('36_consigne');
        $questionnaire36->setAudioContext('36_contexte');
        $questionnaire36->setAudioItem('36_item');
        $questionnaire36->setListeningLimit(2);
        $questionnaire36->setDialogue(0);
        $manager->persist($questionnaire36);

        $question36 = new Question();
        $question36->setQuestionnaire($questionnaire36);
        $question36->setTypology($typology);
        $question36->setInstruction();
        $manager->persist($question36);

        $subquestion36 = new Subquestion();
        $subquestion36->setQuestion($question36);
        $subquestion36->setTypology($typology);
        $manager->persist($subquestion36);

        $proposition36_1 = new Proposition();
        $proposition36_1->setSubquestion($subquestion36);
        $proposition36_1->setRightAnswer(1);
        $proposition36_1->setAudioUrl("36_option_1_1");
        $manager->persist($proposition36_1);

        $proposition36_2 = new Proposition();
        $proposition36_2->setSubquestion($subquestion36);
        $proposition36_2->setRightAnswer(0);
        $proposition36_2->setAudioUrl("36_option_1_2");
        $manager->persist($proposition36_2);

        $proposition36_3 = new Proposition();
        $proposition36_3->setSubquestion($subquestion36);
        $proposition36_3->setRightAnswer(0);
        $proposition36_3->setAudioUrl("36_option_1_3");
        $manager->persist($proposition36_3);



    // ITEM 37
        $questionnaire37->addTest($test);
        $questionnaire37->setLevel($level2);
        $questionnaire37->setInstruction($instruction1);
        $questionnaire37->setTheme('Rendre CD');
        $questionnaire37->setSource($source1);
        $questionnaire37->setSupport($support);
        $questionnaire37->setFocus();
        $questionnaire37->setCognitiveOperation();
        $questionnaire37->setFunctionType();
        $questionnaire37->setReceptionType();
        $questionnaire37->setDomain();
        $questionnaire37->setSourceType();
        $questionnaire37->setLanguageLevel();
        $questionnaire37->setDuration($duration1);
        $questionnaire37->setFlow();
        $questionnaire37->setAuthor();
        $questionnaire37->setAudioInstruction('37_consigne');
        $questionnaire37->setAudioContext('37_contexte');
        $questionnaire37->setAudioItem('37_item');
        $questionnaire37->setListeningLimit(1);
        $questionnaire37->setDialogue(1);
        $manager->persist($questionnaire37);

        $question37 = new Question();
        $question37->setQuestionnaire($questionnaire37);
        $question37->setTypology($typology);
        $question37->setInstruction();
        $manager->persist($question37);

        $subquestion37 = new Subquestion();
        $subquestion37->setQuestion($question37);
        $subquestion37->setTypology($typology);
        $manager->persist($subquestion37);

        $proposition37_1 = new Proposition();
        $proposition37_1->setSubquestion($subquestion37);
        $proposition37_1->setRightAnswer(0);
        $proposition37_1->setAudioUrl("37_option_1_1");
        $manager->persist($proposition37_1);

        $proposition37_2 = new Proposition();
        $proposition37_2->setSubquestion($subquestion37);
        $proposition37_2->setRightAnswer(0);
        $proposition37_2->setAudioUrl("37_option_1_2");
        $manager->persist($proposition37_2);

        $proposition37_3 = new Proposition();
        $proposition37_3->setSubquestion($subquestion37);
        $proposition37_3->setRightAnswer(1);
        $proposition37_3->setAudioUrl("37_option_1_3");
        $manager->persist($proposition37_3);

        // ITEM 10
        $questionnaire10->addTest($test);
        $questionnaire10->setLevel($level2);
        $questionnaire10->setInstruction($instruction2);
        $questionnaire10->setTheme('expression d’une inquiétude');
        $questionnaire10->setSource($source2);
        $questionnaire10->setSupport($support);
        $questionnaire10->setFocus();
        $questionnaire10->setCognitiveOperation();
        $questionnaire10->setFunctionType();
        $questionnaire10->setReceptionType();
        $questionnaire10->setDomain();
        $questionnaire10->setSourceType();
        $questionnaire10->setLanguageLevel();
        $questionnaire10->setDuration($duration2);
        $questionnaire10->setFlow();
        $questionnaire10->setAuthor();
        $questionnaire10->setAudioInstruction('10_consigne');
        $questionnaire10->setAudioContext('');
        $questionnaire10->setAudioItem('10_item');
        $questionnaire10->setListeningLimit(2);
        $questionnaire10->setDialogue(1);
        $manager->persist($questionnaire10);

        $question10 = new Question();
        $question10->setQuestionnaire($questionnaire10);
        $question10->setTypology($typology2);
        $question10->setInstruction();
        $manager->persist($question10);

        $subquestion10_1 = new Subquestion();
        $subquestion10_1->setQuestion($question10);
        $subquestion10_1->setTypology($typology3);
        $subquestion10_1->setAudioUrl("10_option_1_1");
        $manager->persist($subquestion10_1);

        $subquestion10_2 = new Subquestion();
        $subquestion10_2->setQuestion($question10);
        $subquestion10_2->setTypology($typology3);
        $subquestion10_2->setAudioUrl("10_option_1_2");
        $manager->persist($subquestion10_2);

        $subquestion10_3 = new Subquestion();
        $subquestion10_3->setQuestion($question10);
        $subquestion10_3->setTypology($typology3);
        $subquestion10_3->setAudioUrl("10_option_1_3");
        $manager->persist($subquestion10_3);

        $subquestion10_4 = new Subquestion();
        $subquestion10_4->setQuestion($question10);
        $subquestion10_4->setTypology($typology3);
        $subquestion10_4->setAudioUrl("10_option_1_4");
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

        // ITEM 22
        $questionnaire22->addTest($test);
        $questionnaire22->setLevel($level2);
        $questionnaire22->setInstruction($instruction1);
        $questionnaire22->setTheme('au secrétariat');
        $questionnaire22->setSource($source4);
        $questionnaire22->setSupport($support);
        $questionnaire22->setFocus();
        $questionnaire22->setCognitiveOperation();
        $questionnaire22->setFunctionType();
        $questionnaire22->setReceptionType();
        $questionnaire22->setDomain();
        $questionnaire22->setSourceType();
        $questionnaire22->setLanguageLevel();
        $questionnaire22->setDuration($duration1);
        $questionnaire22->setFlow();
        $questionnaire22->setAuthor();
        $questionnaire22->setAudioInstruction('22_consigne');
        $questionnaire22->setAudioContext('');
        $questionnaire22->setAudioItem('22_item');
        $questionnaire22->setListeningLimit(1);
        $questionnaire22->setDialogue(1);
        $manager->persist($questionnaire22);

        $question22 = new Question();
        $question22->setQuestionnaire($questionnaire22);
        $question22->setTypology($typology);
        $question22->setInstruction();
        $manager->persist($question22);

        $subquestion22 = new Subquestion();
        $subquestion22->setQuestion($question22);
        $subquestion22->setTypology($typology);
        $manager->persist($subquestion22);

        $proposition22_1 = new Proposition();
        $proposition22_1->setSubquestion($subquestion22);
        $proposition22_1->setRightAnswer(1);
        $proposition22_1->setTitle("");
        $proposition22_1->setAudioUrl("22_option_1_1");
        $manager->persist($proposition22_1);

        $proposition22_2 = new Proposition();
        $proposition22_2->setSubquestion($subquestion22);
        $proposition22_2->setRightAnswer(0);
        $proposition22_2->setTitle("");
        $proposition22_2->setAudioUrl("22_option_1_2");
        $manager->persist($proposition22_2);

        $proposition22_3 = new Proposition();
        $proposition22_3->setSubquestion($subquestion22);
        $proposition22_3->setRightAnswer(0);
        $proposition22_3->setTitle("");
        $proposition22_3->setAudioUrl("22_option_1_3");
        $manager->persist($proposition22_3);

        // ITEM 38
        $questionnaire38->addTest($test);
        $questionnaire38->setLevel($level2);
        $questionnaire38->setInstruction($instruction1);
        $questionnaire38->setTheme('Souvenirs');
        $questionnaire38->setSource($source1);
        $questionnaire38->setSupport($support);
        $questionnaire38->setFocus();
        $questionnaire38->setCognitiveOperation();
        $questionnaire38->setFunctionType();
        $questionnaire38->setReceptionType();
        $questionnaire38->setDomain();
        $questionnaire38->setSourceType();
        $questionnaire38->setLanguageLevel();
        $questionnaire38->setDuration($duration1);
        $questionnaire38->setFlow();
        $questionnaire38->setAuthor();
        $questionnaire38->setAudioInstruction('38_consigne');
        $questionnaire38->setAudioContext('38_contexte');
        $questionnaire38->setAudioItem('38_item');
        $questionnaire38->setListeningLimit(2);
        $questionnaire38->setDialogue(1);
        $manager->persist($questionnaire38);

        $question38 = new Question();
        $question38->setQuestionnaire($questionnaire38);
        $question38->setTypology($typology);
        $question38->setInstruction();
        $manager->persist($question38);

        $subquestion38 = new Subquestion();
        $subquestion38->setQuestion($question38);
        $subquestion38->setTypology($typology);
        $manager->persist($subquestion38);

        $proposition38_1 = new Proposition();
        $proposition38_1->setSubquestion($subquestion38);
        $proposition38_1->setRightAnswer(1);
        $proposition38_1->setAudioUrl("38_option_1_1");
        $manager->persist($proposition38_1);

        $proposition38_2 = new Proposition();
        $proposition38_2->setSubquestion($subquestion38);
        $proposition38_2->setRightAnswer(0);
        $proposition38_2->setAudioUrl("38_option_1_2");
        $manager->persist($proposition38_2);

        $proposition38_3 = new Proposition();
        $proposition38_3->setSubquestion($subquestion38);
        $proposition38_3->setRightAnswer(0);
        $proposition38_3->setAudioUrl("38_option_1_3");
        $manager->persist($proposition38_3);

         // ITEM 16
        $questionnaire16->addTest($test);
        $questionnaire16->setLevel($level2);
        $questionnaire16->setInstruction($instruction3);
        $questionnaire16->setTheme('motiver son choix 06/10');
        $questionnaire16->setSource($source2);
        $questionnaire16->setSupport($support);
        $questionnaire16->setFocus();
        $questionnaire16->setCognitiveOperation();
        $questionnaire16->setFunctionType();
        $questionnaire16->setReceptionType();
        $questionnaire16->setDomain();
        $questionnaire16->setSourceType();
        $questionnaire16->setLanguageLevel();
        $questionnaire16->setDuration($duration1);
        $questionnaire16->setFlow();
        $questionnaire16->setAuthor();
        $questionnaire16->setAudioInstruction('16_consigne');
        $questionnaire16->setAudioContext('16_contexte');
        $questionnaire16->setAudioItem('16_item');
        $questionnaire16->setListeningLimit(1);
        $questionnaire16->setDialogue(1);
        $manager->persist($questionnaire16);

        $question16 = new Question();
        $question16->setQuestionnaire($questionnaire16);
        $question16->setTypology($typology2);
        $question16->setInstruction();
        $manager->persist($question16);

        $subquestion16 = new Subquestion();
        $subquestion16->setQuestion($question16);
        $subquestion16->setTypology($typology3);
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
        $questionnaire17->setLevel($level2);
        $questionnaire17->setInstruction($instruction3);
        $questionnaire17->setTheme('motiver son choix 07/10');
        $questionnaire17->setSource($source2);
        $questionnaire17->setSupport($support);
        $questionnaire17->setFocus();
        $questionnaire17->setCognitiveOperation();
        $questionnaire17->setFunctionType();
        $questionnaire17->setReceptionType();
        $questionnaire17->setDomain();
        $questionnaire17->setSourceType();
        $questionnaire17->setLanguageLevel();
        $questionnaire17->setDuration($duration1);
        $questionnaire17->setFlow();
        $questionnaire17->setAuthor();
        $questionnaire17->setAudioInstruction('17_consigne');
        $questionnaire17->setAudioContext('17_contexte');
        $questionnaire17->setAudioItem('17_item');
        $questionnaire17->setListeningLimit(1);
        $questionnaire17->setDialogue(1);
        $manager->persist($questionnaire17);

        $question17 = new Question();
        $question17->setQuestionnaire($questionnaire17);
        $question17->setTypology($typology2);
        $question17->setInstruction();
        $manager->persist($question17);

        $subquestion17 = new Subquestion();
        $subquestion17->setQuestion($question17);
        $subquestion17->setTypology($typology3);
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
        $questionnaire18->setLevel($level2);
        $questionnaire18->setInstruction($instruction3);
        $questionnaire18->setTheme('motiver son choix 08/10');
        $questionnaire18->setSource($source2);
        $questionnaire18->setSupport($support);
        $questionnaire18->setFocus();
        $questionnaire18->setCognitiveOperation();
        $questionnaire18->setFunctionType();
        $questionnaire18->setReceptionType();
        $questionnaire18->setDomain();
        $questionnaire18->setSourceType();
        $questionnaire18->setLanguageLevel();
        $questionnaire18->setDuration($duration1);
        $questionnaire18->setFlow();
        $questionnaire18->setAuthor();
        $questionnaire18->setAudioInstruction('18_consigne');
        $questionnaire18->setAudioContext('18_contexte');
        $questionnaire18->setAudioItem('18_item');
        $questionnaire18->setListeningLimit(1);
        $questionnaire18->setDialogue(1);
        $manager->persist($questionnaire18);

        $question18 = new Question();
        $question18->setQuestionnaire($questionnaire18);
        $question18->setTypology($typology2);
        $question18->setInstruction();
        $manager->persist($question18);

        $subquestion18 = new Subquestion();
        $subquestion18->setQuestion($question18);
        $subquestion18->setTypology($typology3);
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
        $questionnaire19->setLevel($level2);
        $questionnaire19->setInstruction($instruction3);
        $questionnaire19->setTheme('motiver son choix 09/10');
        $questionnaire19->setSource($source2);
        $questionnaire19->setSupport($support);
        $questionnaire19->setFocus();
        $questionnaire19->setCognitiveOperation();
        $questionnaire19->setFunctionType();
        $questionnaire19->setReceptionType();
        $questionnaire19->setDomain();
        $questionnaire19->setSourceType();
        $questionnaire19->setLanguageLevel();
        $questionnaire19->setDuration($duration1);
        $questionnaire19->setFlow();
        $questionnaire19->setAuthor();
        $questionnaire19->setAudioInstruction('19_consigne');
        $questionnaire19->setAudioContext('19_contexte');
        $questionnaire19->setAudioItem('19_item');
        $questionnaire19->setListeningLimit(1);
        $questionnaire19->setDialogue(1);
        $manager->persist($questionnaire19);

        $question19 = new Question();
        $question19->setQuestionnaire($questionnaire19);
        $question19->setTypology($typology2);
        $question19->setInstruction();
        $manager->persist($question19);

        $subquestion19 = new Subquestion();
        $subquestion19->setQuestion($question19);
        $subquestion19->setTypology($typology3);
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
        $questionnaire20->setLevel($level2);
        $questionnaire20->setInstruction($instruction3);
        $questionnaire20->setTheme('motiver son choix 10/10');
        $questionnaire20->setSource($source2);
        $questionnaire20->setSupport($support);
        $questionnaire20->setFocus();
        $questionnaire20->setCognitiveOperation();
        $questionnaire20->setFunctionType();
        $questionnaire20->setReceptionType();
        $questionnaire20->setDomain();
        $questionnaire20->setSourceType();
        $questionnaire20->setLanguageLevel();
        $questionnaire20->setDuration($duration1);
        $questionnaire20->setFlow();
        $questionnaire20->setAuthor();
        $questionnaire20->setAudioInstruction('20_consigne');
        $questionnaire20->setAudioContext('20_contexte');
        $questionnaire20->setAudioItem('20_item');
        $questionnaire20->setListeningLimit(1);
        $questionnaire20->setDialogue(1);
        $manager->persist($questionnaire20);

        $question20 = new Question();
        $question20->setQuestionnaire($questionnaire20);
        $question20->setTypology($typology3);
        $question20->setInstruction();
        $manager->persist($question20);

        $subquestion20 = new Subquestion();
        $subquestion20->setQuestion($question20);
        $subquestion20->setTypology($typology3);
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

        // ITEM 30
        $questionnaire30->addTest($test);
        $questionnaire30->setLevel($level2);
        $questionnaire30->setInstruction($instruction2);
        $questionnaire30->setTheme('présentation travail 4/5');
        $questionnaire30->setSource($source6);
        $questionnaire30->setSupport($support);
        $questionnaire30->setFocus();
        $questionnaire30->setCognitiveOperation();
        $questionnaire30->setFunctionType();
        $questionnaire30->setReceptionType();
        $questionnaire30->setDomain();
        $questionnaire30->setSourceType();
        $questionnaire30->setLanguageLevel();
        $questionnaire30->setDuration($duration2);
        $questionnaire30->setFlow();
        $questionnaire30->setAuthor();
        $questionnaire30->setAudioInstruction('30_consigne');
        $questionnaire30->setAudioContext('30_contexte');
        $questionnaire30->setAudioItem('30_item');
        $questionnaire30->setListeningLimit(2);
        $questionnaire30->setDialogue(0);
        $manager->persist($questionnaire30);

        $question30 = new Question();
        $question30->setQuestionnaire($questionnaire30);
        $question30->setTypology($typology2);
        $question30->setInstruction();
        $manager->persist($question30);

        $subquestion30_1 = new Subquestion();
        $subquestion30_1->setQuestion($question30);
        $subquestion30_1->setTypology($typology3);
        $subquestion30_1->setAudioUrl('30_option_1_1');
        $manager->persist($subquestion30_1);

        $subquestion30_2 = new Subquestion();
        $subquestion30_2->setQuestion($question30);
        $subquestion30_2->setTypology($typology3);
        $subquestion30_2->setAudioUrl('30_option_1_2');
        $manager->persist($subquestion30_2);

        $subquestion30_3 = new Subquestion();
        $subquestion30_3->setQuestion($question30);
        $subquestion30_3->setTypology($typology3);
        $subquestion30_3->setAudioUrl('30_option_1_3');
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
        $questionnaire31->setLevel($level2);
        $questionnaire31->setInstruction($instruction2);
        $questionnaire31->setTheme('présentation travail 5/5');
        $questionnaire31->setSource($source6);
        $questionnaire31->setSupport($support);
        $questionnaire31->setFocus();
        $questionnaire31->setCognitiveOperation();
        $questionnaire31->setFunctionType();
        $questionnaire31->setReceptionType();
        $questionnaire31->setDomain();
        $questionnaire31->setSourceType();
        $questionnaire31->setLanguageLevel();
        $questionnaire31->setDuration($duration2);
        $questionnaire31->setFlow();
        $questionnaire31->setAuthor();
        $questionnaire31->setAudioInstruction('31_consigne');
        $questionnaire31->setAudioContext('31_contexte');
        $questionnaire31->setAudioItem('31_item');
        $questionnaire31->setListeningLimit(2);
        $questionnaire31->setDialogue(0);
        $manager->persist($questionnaire31);

        $question31 = new Question();
        $question31->setQuestionnaire($questionnaire31);
        $question31->setTypology($typology2);
        $question31->setInstruction();
        $manager->persist($question31);

        $subquestion31_1 = new Subquestion();
        $subquestion31_1->setQuestion($question31);
        $subquestion31_1->setTypology($typology3);
        $subquestion31_1->setAudioUrl('31_option_1_1');
        $manager->persist($subquestion31_1);

        $subquestion31_2 = new Subquestion();
        $subquestion31_2->setQuestion($question31);
        $subquestion31_2->setTypology($typology3);
        $subquestion31_2->setAudioUrl('31_option_1_2');
        $manager->persist($subquestion31_2);

        $subquestion31_3 = new Subquestion();
        $subquestion31_3->setQuestion($question31);
        $subquestion31_3->setTypology($typology3);
        $subquestion31_3->setAudioUrl('31_option_1_3');
        $manager->persist($subquestion31_3);

        $subquestion31_4 = new Subquestion();
        $subquestion31_4->setQuestion($question31);
        $subquestion31_4->setTypology($typology3);
        $subquestion31_4->setAudioUrl('31_option_1_4');
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


    // ITEM 6
        $questionnaire6->addTest($test);
        $questionnaire6->setLevel($level2);
        $questionnaire6->setInstruction($instruction1);
        $questionnaire6->setTheme('la valise');
        $questionnaire6->setSource($source1);
        $questionnaire6->setSupport($support);
        $questionnaire6->setFocus();
        $questionnaire6->setCognitiveOperation();
        $questionnaire6->setFunctionType();
        $questionnaire6->setReceptionType();
        $questionnaire6->setDomain();
        $questionnaire6->setSourceType();
        $questionnaire6->setLanguageLevel();
        $questionnaire6->setDuration($duration1);
        $questionnaire6->setFlow();
        $questionnaire6->setAuthor();
        $questionnaire6->setAudioInstruction('6_consigne');
        $questionnaire6->setAudioContext('6_contexte');
        $questionnaire6->setAudioItem('6_item');
        $questionnaire6->setListeningLimit(1);
        $questionnaire6->setDialogue(1);
        $manager->persist($questionnaire6);

        $question6 = new Question();
        $question6->setQuestionnaire($questionnaire6);
        $question6->setTypology($typology);
        $question6->setInstruction();
        $manager->persist($question6);

        $subquestion6 = new Subquestion();
        $subquestion6->setQuestion($question6);
        $subquestion6->setTypology($typology);
        $manager->persist($subquestion6);

        $proposition6_1 = new Proposition();
        $proposition6_1->setSubquestion($subquestion6);
        $proposition6_1->setRightAnswer(1);
        $proposition6_1->setAudioUrl("6_option_1_1");
        $manager->persist($proposition6_1);

        $proposition6_2 = new Proposition();
        $proposition6_2->setSubquestion($subquestion6);
        $proposition6_2->setRightAnswer(0);
        $proposition6_2->setAudioUrl("6_option_1_2");
        $manager->persist($proposition6_2);

        $proposition6_3 = new Proposition();
        $proposition6_3->setSubquestion($subquestion6);
        $proposition6_3->setRightAnswer(0);
        $proposition6_3->setAudioUrl("6_option_1_3");
        $manager->persist($proposition6_3);

        // ITEM 24
        $questionnaire24->addTest($test);
        $questionnaire24->setLevel($level2);
        $questionnaire24->setInstruction($instruction1);
        $questionnaire24->setTheme('billetterie théatre');
        $questionnaire24->setSource($source1);
        $questionnaire24->setSupport($support);
        $questionnaire24->setFocus();
        $questionnaire24->setCognitiveOperation();
        $questionnaire24->setFunctionType();
        $questionnaire24->setReceptionType();
        $questionnaire24->setDomain();
        $questionnaire24->setSourceType();
        $questionnaire24->setLanguageLevel();
        $questionnaire24->setDuration($duration1);
        $questionnaire24->setFlow();
        $questionnaire24->setAuthor();
        $questionnaire24->setAudioInstruction('24_consigne');
        $questionnaire24->setAudioContext('');
        $questionnaire24->setAudioItem('24_item');
        $questionnaire24->setListeningLimit(1);
        $questionnaire24->setDialogue(1);
        $manager->persist($questionnaire24);

        $question24 = new Question();
        $question24->setQuestionnaire($questionnaire24);
        $question24->setTypology($typology);
        $question24->setInstruction();
        $manager->persist($question24);

        $subquestion24 = new Subquestion();
        $subquestion24->setQuestion($question24);
        $subquestion24->setTypology($typology);
        $manager->persist($subquestion24);

        $proposition24_1 = new Proposition();
        $proposition24_1->setSubquestion($subquestion24);
        $proposition24_1->setRightAnswer(0);
        $proposition24_1->setTitle("");
        $proposition24_1->setAudioUrl("24_option_1_1");
        $manager->persist($proposition24_1);

        $proposition24_2 = new Proposition();
        $proposition24_2->setSubquestion($subquestion24);
        $proposition24_2->setRightAnswer(1);
        $proposition24_2->setTitle("");
        $proposition24_2->setAudioUrl("24_option_1_2");
        $manager->persist($proposition24_2);

        $proposition24_3 = new Proposition();
        $proposition24_3->setSubquestion($subquestion24);
        $proposition24_3->setRightAnswer(0);
        $proposition24_3->setTitle("");
        $proposition24_3->setAudioUrl("24_option_1_3");
        $manager->persist($proposition24_3);




        // ITEM 39
        $questionnaire39->addTest($test);
        $questionnaire39->setLevel($level2);
        $questionnaire39->setInstruction($instruction1);
        $questionnaire39->setTheme('Dans la cuisine');
        $questionnaire39->setSource($source1);
        $questionnaire39->setSupport($support);
        $questionnaire39->setFocus();
        $questionnaire39->setCognitiveOperation();
        $questionnaire39->setFunctionType();
        $questionnaire39->setReceptionType();
        $questionnaire39->setDomain();
        $questionnaire39->setSourceType();
        $questionnaire39->setLanguageLevel();
        $questionnaire39->setDuration($duration1);
        $questionnaire39->setFlow();
        $questionnaire39->setAuthor();
        $questionnaire39->setAudioInstruction('39_consigne');
        $questionnaire39->setAudioContext('39_contexte');
        $questionnaire39->setAudioItem('39_item');
        $questionnaire39->setListeningLimit(1);
        $questionnaire39->setDialogue(1);
        $manager->persist($questionnaire39);

        $question39 = new Question();
        $question39->setQuestionnaire($questionnaire39);
        $question39->setTypology($typology);
        $question39->setInstruction();
        $manager->persist($question39);

        $subquestion39 = new Subquestion();
        $subquestion39->setQuestion($question39);
        $subquestion39->setTypology($typology);
        $manager->persist($subquestion39);

        $proposition39_1 = new Proposition();
        $proposition39_1->setSubquestion($subquestion39);
        $proposition39_1->setRightAnswer(1);
        $proposition39_1->setAudioUrl("39_option_1_1");
        $manager->persist($proposition39_1);

        $proposition39_2 = new Proposition();
        $proposition39_2->setSubquestion($subquestion39);
        $proposition39_2->setRightAnswer(0);
        $proposition39_2->setAudioUrl("39_option_1_2");
        $manager->persist($proposition39_2);

        $proposition39_3 = new Proposition();
        $proposition39_3->setSubquestion($subquestion39);
        $proposition39_3->setRightAnswer(0);
        $proposition39_3->setAudioUrl("39_option_1_3");
        $manager->persist($proposition39_3);

    // ITEM 7
        $questionnaire7->addTest($test);
        $questionnaire7->setLevel($level2);
        $questionnaire7->setInstruction($instruction1);
        $questionnaire7->setTheme('moment de relax');
        $questionnaire7->setSource($source1);
        $questionnaire7->setSupport($support);
        $questionnaire7->setFocus();
        $questionnaire7->setCognitiveOperation();
        $questionnaire7->setFunctionType();
        $questionnaire7->setReceptionType();
        $questionnaire7->setDomain();
        $questionnaire7->setSourceType();
        $questionnaire7->setLanguageLevel();
        $questionnaire7->setDuration($duration1);
        $questionnaire7->setFlow();
        $questionnaire7->setAuthor();
        $questionnaire7->setAudioInstruction('7_consigne');
        $questionnaire7->setAudioContext('7_contexte');
        $questionnaire7->setAudioItem('7_item');
        $questionnaire7->setListeningLimit(1);
        $questionnaire7->setDialogue(1);
        $manager->persist($questionnaire7);

        $question7 = new Question();
        $question7->setQuestionnaire($questionnaire7);
        $question7->setTypology($typology);
        $question7->setInstruction();
        $manager->persist($question7);

        $subquestion7 = new Subquestion();
        $subquestion7->setQuestion($question7);
        $subquestion7->setTypology($typology);
        $manager->persist($subquestion7);

        $proposition7_1 = new Proposition();
        $proposition7_1->setSubquestion($subquestion7);
        $proposition7_1->setRightAnswer(1);
        $proposition7_1->setAudioUrl("7_option_1_1");
        $manager->persist($proposition7_1);

        $proposition7_2 = new Proposition();
        $proposition7_2->setSubquestion($subquestion7);
        $proposition7_2->setRightAnswer(0);
        $proposition7_2->setAudioUrl("7_option_1_2");
        $manager->persist($proposition7_2);

        $proposition7_3 = new Proposition();
        $proposition7_3->setSubquestion($subquestion7);
        $proposition7_3->setRightAnswer(0);
        $proposition7_3->setAudioUrl("7_option_1_3");
        $manager->persist($proposition7_3);


         // ITEM 8
        $questionnaire8->addTest($test);
        $questionnaire8->setLevel($level2);
        $questionnaire8->setInstruction($instruction1);
        $questionnaire8->setTheme('réserver des billets au théâtre');
        $questionnaire8->setSource($source1);
        $questionnaire8->setSupport($support);
        $questionnaire8->setFocus();
        $questionnaire8->setCognitiveOperation();
        $questionnaire8->setFunctionType();
        $questionnaire8->setReceptionType();
        $questionnaire8->setDomain();
        $questionnaire8->setSourceType();
        $questionnaire8->setLanguageLevel();
        $questionnaire8->setDuration($duration1);
        $questionnaire8->setFlow();
        $questionnaire8->setAuthor();
        $questionnaire8->setAudioInstruction('8_consigne');
        $questionnaire8->setAudioContext('8_contexte');
        $questionnaire8->setAudioItem('8_item');
        $questionnaire8->setListeningLimit(1);
        $questionnaire8->setDialogue(1);
        $manager->persist($questionnaire8);

        $question8 = new Question();
        $question8->setQuestionnaire($questionnaire8);
        $question8->setTypology($typology);
        $question8->setInstruction();
        $manager->persist($question8);

        $subquestion8 = new Subquestion();
        $subquestion8->setQuestion($question8);
        $subquestion8->setTypology($typology);
        $manager->persist($subquestion8);

        $proposition8_1 = new Proposition();
        $proposition8_1->setSubquestion($subquestion8);
        $proposition8_1->setRightAnswer(1);
        $proposition8_1->setAudioUrl("8_option_1_1");
        $manager->persist($proposition8_1);

        $proposition8_2 = new Proposition();
        $proposition8_2->setSubquestion($subquestion8);
        $proposition8_2->setRightAnswer(0);
        $proposition8_2->setAudioUrl("8_option_1_2");
        $manager->persist($proposition8_2);

        $proposition8_3 = new Proposition();
        $proposition8_3->setSubquestion($subquestion8);
        $proposition8_3->setRightAnswer(0);
        $proposition8_3->setAudioUrl("8_option_1_3");
        $manager->persist($proposition8_3);

        $manager->flush();

    /*
    // ITEM 21
        $questionnaire21->addTest($test);
        $questionnaire21->setLevel($level2);
        $questionnaire21->setInstruction($instruction1);
        $questionnaire21->setTheme('ameublement');
        $questionnaire21->setSource('méthodes et manuels (Allegro 2, Edilingua, p. 22, unità 2) / modifié');
        $questionnaire21->setSupport($support);
        $questionnaire21->setFocus();
        $questionnaire21->setCognitiveOperation();
        $questionnaire21->setFunctionType();
        $questionnaire21->setReceptionType();
        $questionnaire21->setDomain();
        $questionnaire21->setSourceType();
        $questionnaire21->setLanguageLevel();
        $questionnaire21->setDuration($duration1);
        $questionnaire21->setFlow();
        $questionnaire21->setAuthor();
        $questionnaire21->setAudioInstruction('');
        $questionnaire21->setAudioContext('');
        $questionnaire21->setAudioItem('');
        $manager->persist($questionnaire21);

        $question21_1 = new Question();
        $question21_1->setQuestionnaire($questionnaire21);
        $question21_1->setTypology($typology);
        $question21_1->setInstruction();
        $manager->persist($question21_1);

        $question21_2 = new Question();
        $question21_2->setQuestionnaire($questionnaire21);
        $question21_2->setTypology($typology);
        $question21_2->setInstruction();
        $manager->persist($question21_2);

        $question21_3 = new Question();
        $question21_3->setQuestionnaire($questionnaire21);
        $question21_3->setTypology($typology);
        $question21_3->setInstruction();
        $manager->persist($question21_3);

        $question21_4 = new Question();
        $question21_4->setQuestionnaire($questionnaire21);
        $question21_4->setTypology($typology);
        $question21_4->setInstruction();
        $manager->persist($question21_4);

        $subquestion21_1 = new Subquestion();
        $subquestion21_1->setQuestion($question21_1);
        $subquestion21_1->setTypology($typology);
        $manager->persist($subquestion21_1);

        $subquestion21_2 = new Subquestion();
        $subquestion21_2->setQuestion($question21_2);
        $subquestion21_2->setTypology($typology);
        $manager->persist($subquestion21_2);

        $subquestion21_3 = new Subquestion();
        $subquestion21_3->setQuestion($question21_3);
        $subquestion21_3->setTypology($typology);
        $manager->persist($subquestion21_3);

        $subquestion21_4 = new Subquestion();
        $subquestion21_4->setQuestion($question21_4);
        $subquestion21_4->setTypology($typology);
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
    */









    /*
    // ITEM 26
        $questionnaire26->addTest($test);
        $questionnaire26->setLevel($level2);
        $questionnaire26->setInstruction($instruction2);
        $questionnaire26->setTheme('recette tiramisù');
        $questionnaire26->setSource('méthodes et manuels (Se ascoltando..., Livello A1 - A2, Guerra Edizioni, p. 35 piste n° 29) / modifié');
        $questionnaire26->setSupport($support);
        $questionnaire26->setFocus();
        $questionnaire26->setCognitiveOperation();
        $questionnaire26->setFunctionType();
        $questionnaire26->setReceptionType();
        $questionnaire26->setDomain();
        $questionnaire26->setSourceType();
        $questionnaire26->setLanguageLevel();
        $questionnaire26->setDuration($duration1);
        $questionnaire26->setFlow();
        $questionnaire26->setAuthor();
        $questionnaire26->setAudioInstruction('');
        $questionnaire26->setAudioContext('');
        $questionnaire26->setAudioItem('');
        $manager->persist($questionnaire26);

        $question26_1 = new Question();
        $question26_1->setQuestionnaire($questionnaire26);
        $question26_1->setTypology($typology2);
        $question26_1->setInstruction();
        $manager->persist($question26_1);

        $subquestion26_1_1 = new Subquestion();
        $subquestion26_1_1->setQuestion($question26_1);
        $subquestion26_1_1->setTypology($typology3);
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
        $subquestion26_1_2->setTypology($typology3);
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
        $subquestion26_1_3->setTypology($typology3);
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
        $subquestion26_1_4->setTypology($typology3);
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
        $question26_2->setTypology($typology2);
        $question26_2->setInstruction();
        $manager->persist($question26_2);

        $subquestion26_2_1 = new Subquestion();
        $subquestion26_2_1->setQuestion($question26_2);
        $subquestion26_2_1->setTypology($typology3);
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
        $subquestion26_2_2->setTypology($typology3);
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
        $subquestion26_2_3->setTypology($typology3);
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
    */




    }
}