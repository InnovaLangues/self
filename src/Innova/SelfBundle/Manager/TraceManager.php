<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Trace;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\User;

class TraceManager
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createTrace(Questionnaire $questionnaire, Test $test, User $user, $totalTime, $agent)
    {
        $em = $this->entityManager;

        $trace = new Trace();
        $trace->setDate(new \DateTime());
        $trace->setQuestionnaire($questionnaire);
        $trace->setTest($test);
        $trace->setUser($user);
        $trace->setTotalTime($totalTime);
        $trace->setListeningTime("");
        $trace->setListeningAfterAnswer("");
        $trace->setClickCorrectif("");
        $trace->setIp("");
        $trace->setuserAgent($agent);
        $trace->setDifficulty("");

        $em->persist($trace);
        $em->flush();

        return $trace;
    }

    public function deleteTestTrace(User $user, Test $test)
    {
        $em = $this->entityManager;
        $traces = $em->getRepository('InnovaSelfBundle:Trace')->findBy(array('user' => $user, 'test' => $test));

        foreach ($traces as $trace) {
            $em->remove($trace);
        }
        $em->flush();

        return $this;
    }

    public function deleteTaskTrace(User $user, Test $test, Questionnaire $questionnaire)
    {
        $em = $this->entityManager;
        $traces = $em->getRepository('InnovaSelfBundle:Trace')->findBy(array('user' => $user, 'test' => $test, 'questionnaire' => $questionnaire));

        foreach ($traces as $trace) {
            $em->remove($trace);
        }
        $em->flush();

        return $this;
    }
}
