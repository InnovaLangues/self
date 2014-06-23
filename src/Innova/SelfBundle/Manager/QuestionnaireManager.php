<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Questionnaire;

class QuestionnaireManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createQuestionnaire($test)
    {
        $em = $this->entityManager;

        $questionnaire = new Questionnaire();
        $questionnaire->setTheme("");
        $questionnaire->addTest($test);
        $questionnaire->setListeningLimit(0);
        $questionnaire->setDialogue(0);
        $questionnaire->setFixedOrder(0);
        $em->persist($questionnaire);

        $em->flush();

        return $questionnaire;
    }

    public function setTypology($questionnaire, $typologyName)
    {
        $em = $this->entityManager;

        if (!$typology = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($typologyName)) {
            $typology = null;
            foreach ($questionnaire->getQuestions()[0]->getSubquestions() as $subquestion) {
                $subquestion->setTypology(null);
                $em->persist($subquestion);
            }
        } else {
            if (mb_substr($typology->getName(), 0, 3) == "APP") {
                foreach ($questionnaire->getQuestions()[0]->getSubquestions() as $subquestion) {
                    $subquestion->setTypology($typology);
                    $em->persist($subquestion);
                }

            } else {
                $typologySubquestion = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName(mb_substr($typologyName, 1));
                foreach ($questionnaire->getQuestions()[0]->getSubquestions() as $subquestion) {
                    $subquestion->setTypology($typologySubquestion);
                    $em->persist($subquestion);
                }
            }
        }

        $questionnaire->getQuestions()[0]->setTypology($typology);
        $em->persist($questionnaire);
        $em->flush();

        return $typology;
    }

    public function isUnique($title)
    {
        $em = $this->entityManager;

        $isUnique = true;
        if ($tasksWithSameTitle = $em->getRepository('InnovaSelfBundle:Questionnaire')->findByTheme($title)) {
            $isUnique = false;
        }

        return $isUnique;
    }
}
