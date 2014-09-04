<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Questionnaire;

class QuestionnaireManager
{
    protected $entityManager;
    protected $editorLogManager;

    public function __construct($entityManager, $editorLogManager)
    {
        $this->entityManager = $entityManager;
        $this->editorLogManager = $editorLogManager;
    }

    public function createQuestionnaire()
    {
        $em = $this->entityManager;

        $questionnaire = new Questionnaire();
        $questionnaire->setTheme("");
        $questionnaire->setTextTitle("");
        $questionnaire->setListeningLimit(0);
        $questionnaire->setDialogue(0);
        $questionnaire->setFixedOrder(0);
        $questionnaire->setStatus($em->getRepository('InnovaSelfBundle:Status')->find(1));
        $em->persist($questionnaire);

        $em->flush();

        $this->editorLogManager->createEditorLog("editor_create", "task", $questionnaire);

        return $questionnaire;
    }

    public function setTypology(Questionnaire $questionnaire, $typologyName)
    {
        $em = $this->entityManager;
        $arrayLikeTypos = array("TQRU", "TQRM", "TVFNM", "TVF");

        if (!$typology = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($typologyName)) {
            $typology = null;
            foreach ($questionnaire->getQuestions()[0]->getSubquestions() as $subquestion) {
                $subquestion->setTypology(null);
                $em->persist($subquestion);
            }
        } else {
            if (!in_array($typology->getName(), $arrayLikeTypos)) {
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

    public function isUnique($theme, $language)
    {
        $em = $this->entityManager;

        $isUnique = true;

        if ($em->getRepository('InnovaSelfBundle:Questionnaire')->findBy(array('theme' =>$theme, 'language'=>$language))) {
            $isUnique = false;
        }

        return $isUnique;
    }
}
