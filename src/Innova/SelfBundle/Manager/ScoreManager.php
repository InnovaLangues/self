<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Session;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\PhasedTest\Component;

class ScoreManager
{
    protected $entityManager;
    protected $securityContext;
    protected $user;

    public function __construct($entityManager, $securityContext)
    {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
        $this->user = $this->securityContext->getToken()->getUser();
        $this->traceRepo = $this->entityManager->getRepository('InnovaSelfBundle:Trace');
        $this->propositionRepo = $this->entityManager->getRepository('InnovaSelfBundle:Proposition');
        $this->skillRepo = $this->entityManager->getRepository('InnovaSelfBundle:Skill');
        $this->levelRepo = $this->entityManager->getRepository('InnovaSelfBundle:Level');
    }

    public function calculateScoreByComponent(Test $test, Session $session, Component $component)
    {
        $score = 0;
        $nbSubquestions = 0;
        $traces = $this->traceRepo->findBy(array('user' => $this->user, 'test' => $test, 'session' => $session, 'component' => $component));
        foreach ($traces as $trace) {
            $subquestions = $trace->getQuestionnaire()->getQuestions()[0]->getSubquestions();
            foreach ($subquestions as $subquestion) {
                $nbSubquestions++;
                if ($this->subquestionCorrect($subquestion, $session, $component)) {
                    $score++;
                }
            }
        }

        return $score/$nbSubquestions*100;
    }

    public function calculateScoreByTest(Test $test, Session $session, User $user)
    {
        $scores = $this->initializeScoreArray();

        $traces = $this->traceRepo->findBy(array('user' => $user, 'test' => $test, 'session' => $session));
        foreach ($traces as $trace) {
            $subquestions = $trace->getQuestionnaire()->getQuestions()[0]->getSubquestions();
            foreach ($subquestions as $subquestion) {
                $questionnaire = $subquestion->getQuestion()->getQuestionnaire();
                $skill = $questionnaire->getSkill()->getName();
                $level = $questionnaire->getLevel()->getName();

                if ($this->subquestionCorrect($subquestion, $session, null)) {
                    $scores[$skill][$level]["correct"]++;
                }

                $scores[$skill][$level]["count"]++;
            }
        }

        return $scores;
    }

    private function subquestionCorrect(Subquestion $subquestion, Session $session, Component $component = null)
    {
        $correct = true;
        $rightProps = $this->propositionRepo->findBy(array("subquestion" => $subquestion, "rightAnswer" => true));

        $choices = $this->propositionRepo->getByUserTraceAndSubquestion($subquestion, $this->user, $component, $session);

        // Teste si les choix de l'étudiant sont présents dans les bonnes réponses.
        foreach ($choices as $choice) {
            if (!in_array($choice, $rightProps)) {
                $correct = false;
            }
        }

        // Teste si le nombre de réponses équivaut au nombre de réponses attendues.
        if (count($rightProps) !== count($choices)) {
            $correct = false;
        }

        return $correct;
    }

    private function initializeScoreArray()
    {
        $skills = $this->skillRepo->findAll();
        $levels = $this->levelRepo->findBy(array(), array('name' => 'ASC'));

        $scores = array();

        foreach ($skills as $skill) {
            $skillName = $skill->getName();
            $scores[$skillName] = array();
            foreach ($levels as $level) {
                $levelName = $level->getName();
                $scores[$skillName][$levelName] = array();
                $scores[$skillName][$levelName]["count"] = 0;
                $scores[$skillName][$levelName]["correct"] = 0;
            }
        }

        return $scores;
    }
}
