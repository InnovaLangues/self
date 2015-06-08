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

    public function getScoreBySkillByLevelForComponent(Test $test, Session $session, Component $component, User $user)
    {
        $traces = $this->traceRepo->findBy(array('user' => $user, 'test' => $test, 'session' => $session, 'component' => $component));
        $scores = $this->getScoresFromTraces($traces);

        return $scores;
    }

    public function calculateScoreByTest(Test $test, Session $session, User $user)
    {
        $traces = $this->traceRepo->findBy(array('user' => $user, 'test' => $test, 'session' => $session));
        $scores = $this->getScoresFromTraces($traces);

        return $scores;
    }

    public function orientateToStep(User $user, Session $session, Component $component)
    {
        $test = $session->getTest();
        $scores = $this->getScoreBySkillByLevelForComponent($test, $session, $component, $user);
        $rightAnswers = $this->countCorrectAnswers($scores);

        $thresholdToStep3 = $test->getPhasedParams()->getThresholdToStep3();
        $thresholdToStep3Leveled = $test->getPhasedParams()->getThresholdToStep3Leveled();
        $thresholdToStep3Level = $test->getPhasedParams()->getThresholdToStep3Level();
        $rightAnswersStep3Level = $this->countCorrectAnswersByLevel($scores, $thresholdToStep3Level);

        if ($rightAnswers >= $thresholdToStep3 && $rightAnswersStep3Level >= $thresholdToStep3Leveled) {
            $nextComponentTypeName = "step3";
        } else {
            $thresholdToStep2 = $test->getPhasedParams()->getThresholdToStep2();
            $thresholdToStep2Leveled = $test->getPhasedParams()->getThresholdToStep2Leveled();
            $thresholdToStep2Level = $test->getPhasedParams()->getThresholdToStep2Level();
            $rightAnswersStep2Level = $this->countCorrectAnswersByLevel($scores, $thresholdToStep2Level);
            if ($rightAnswers >= $thresholdToStep2 && $rightAnswersStep2Level >= $thresholdToStep2Leveled) {
                $nextComponentTypeName = "step2";
            } else {
                $nextComponentTypeName = "step1";
            }
        }

        return $nextComponentTypeName;
    }

    public function getGlobalLevelFromThreshold($session, $user)
    {
        $test = $session->getTest();

        if ($test->getPhased()) {
            $params = $test->getPhasedParams();

            if ($traces = $this->traceRepo->findBy(array('user' => $user, 'test' => $test, 'session' => $session))) {
                $lastTrace = end($traces);
                $component = $lastTrace->getComponent();
                $componentType = $component->getComponentType();

                $thresholds = $this->entityManager->getRepository('InnovaSelfBundle:PhasedTest\GeneralScoreThreshold')->findBy(
                    array("phasedParam" => $params, "componentType" => $componentType),
                    array('rightAnswers' => 'DESC')
                );

                $traces = $this->traceRepo->findBy(array('user' => $user, 'test' => $test, 'session' => $session, 'component' => $component));
                $scoresLastComponent = $this->getScoresFromTraces($traces);
                $correctAnswers = $this->countCorrectAnswers($scoresLastComponent);

                foreach ($thresholds as $threshold) {
                    if ($correctAnswers >= $threshold->getRightAnswers()) {
                        return $threshold->getDescription();
                    }
                }
            }
        }

        return;
    }

    private function getScoresFromTraces($traces)
    {
        $scores = $this->initializeScoreArray();

        foreach ($traces as $trace) {
            $session = $trace->getSession();
            $subquestions = $trace->getQuestionnaire()->getQuestions()[0]->getSubquestions();
            $user = $trace->getUser();

            foreach ($subquestions as $subquestion) {
                $questionnaire = $subquestion->getQuestion()->getQuestionnaire();
                $skill = $questionnaire->getSkill()->getName();

                if ($subquestion->getLevel()) {
                    $level = $subquestion->getLevel()->getName();
                } elseif ($questionnaire->getLevel()) {
                    $level = $questionnaire->getLevel()->getName();
                }

                if ($level) {
                    if ($this->subquestionCorrect($subquestion, $session, null, $user)) {
                        $scores[$skill][$level]["correct"]++;
                    }
                    $scores[$skill][$level]["count"]++;
                }
            }
        }

        return $scores;
    }

    private function countCorrectAnswers($scores)
    {
        $correctAnswers = 0;
        foreach ($scores as $skill => $levels) {
            foreach ($levels as $level) {
                $correctAnswers += $level["correct"];
            }
        }

        return $correctAnswers;
    }

    private function countCorrectAnswersByLevel($scores, $level)
    {
        $levelName = $level->getName();
        $correctAnswers = 0;

        foreach ($scores as $skill => $levels) {
            $correctAnswers += $scores[$skill][$levelName]["correct"];
        }

        return $correctAnswers;
    }

    private function subquestionCorrect(Subquestion $subquestion, Session $session, Component $component = null, User $user)
    {
        $correct = true;
        $rightProps = $this->propositionRepo->findBy(array("subquestion" => $subquestion, "rightAnswer" => true));

        $choices = $this->propositionRepo->getByUserTraceAndSubquestion($subquestion, $user, $component, $session);

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
