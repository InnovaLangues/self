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

    public function createTrace(Questionnaire $questionnaire, Test $test, User $user, $totalTime)
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
        $trace->setuserAgent("");
        $trace->setDifficulty("");

        $em->persist($trace);
        $em->flush();

        return $trace;
    }
}
