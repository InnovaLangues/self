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
class FixtureCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('self:fixtures:load')
            ->setDescription('Optimize Load Fixtures')
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
        $test = $this->createTest("Italien CE", "Italian");

        /*******************************************
                    QUESTIONNAIRE 6
        ********************************************/
        // CREATION QUESTIONNAIRE
        $questionnaire_1 = $this->createQuestionnaire("A1_CE_cours_bibliotheque", "A1", "CE", $test);
        $questionnaire_1->setMediaInstruction($this->mediaText("Rispondi alle domande. Una sola risposta è corretta"));
        $questionnaire_1->setMediaContext($this->mediaText("Brochure informativa in biblioteca"));
        $questionnaire_1->setMediaText($this->mediaText("Società per la Biblioteca Circolante di Sesto Fiorentino"));
        // CREATION QUESTION
        $questionnaire_1_1 = $this->createQuestion("TQRU", $questionnaire_1);
        // CREATION SUBQUESTION
        $questionnaire_1_1_1 = $this->createSubquestion("QRU", $questionnaire_1_1, "1.I corsi dell’associazione sono");
        // CREATION PROPOSITIONS
        $questionnaire_1_1_1_1 = $this->createProposition("rivolti agli anziani.", false, $questionnaire_1_1_1);
        $questionnaire_1_1_1_2 = $this->createProposition("aperti a tutti.", false, $questionnaire_1_1_1);
        $questionnaire_1_1_1_3 = $this->createProposition("solo per i soci.", true, $questionnaire_1_1_1);

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
            $subquestion->setMediaAmorce($this->mediaText($amorce));
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
        $proposition->setMedia($this->mediaText($text));
        $proposition->setRightAnswer($rightAnswer);

        $em->persist($proposition);

        return $proposition;
    }

    /**
     *
     */
    protected function mediaText($name)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        // TODO : l'appel à la fonction qui traite le markdown !!
        // Création dans "Media"
        $media = new Media();
        $media->setMediaType($em->getRepository('InnovaSelfBundle:MediaType')->findOneByName("texte"));

        $media->setName($name);
        $media->setDescription("");
        $media->setUrl("");

        $em->persist($media);

        return $media;
    }

}
