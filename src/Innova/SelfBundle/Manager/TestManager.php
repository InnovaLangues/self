<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Test;

class TestManager
{
    protected $entityManager;
    protected $securityContext;
    protected $questionnaireManager;
    protected $orderQuestionnaireTestManager;
    protected $phasedTestManager;
    protected $session;

    public function __construct(
        $entityManager,
        $securityContext,
        $questionnaireManager,
        $orderQuestionnaireTestManager,
        $phasedTestManager,
        $session
    ) {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
        $this->questionnaireManager = $questionnaireManager;
        $this->orderQuestionnaireTestManager = $orderQuestionnaireTestManager;
        $this->phasedTestManager = $phasedTestManager;
        $this->session = $session;
    }

    public function getTestsProgress($tests)
    {
        $userId = $this->securityContext->getToken()->getUser()->getId();

        $testsProgress = array();
        foreach ($tests as $test) {
            $countDone = $this->entityManager->getRepository('InnovaSelfBundle:Questionnaire')->countDoneYetByUserByTest($test->getId(), $userId);
            $countTotal = count($test->getOrderQuestionnaireTests());
            if ($countTotal < 1) {
                $countTotal = 1;
            }
            $number = $countDone/$countTotal*100;

            $testsProgress[] = number_format($number, 2, '.', ' ');
        }

        return $testsProgress;
    }

    public function toggleFavorite($test)
    {
        $user = $this->securityContext->getToken()->getUser();
        $favorites = $user->getFavoritesTests();
        if ($favorites->contains($test)) {
            $user->removeFavoritesTest($test);
            $isFavorite = false;
        } else {
            $user->addFavoritesTest($test);
            $isFavorite = true;
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $isFavorite;
    }

    public function duplicate(Test $test)
    {
        $name = $test->getName();
        $actif = $test->getActif();
        $language = $test->getLanguage();
        $orderedTasks = $test->getOrderQuestionnaireTests();

        $newTest = new Test();
        $newTest->setName("Copie de ".$name);
        $newTest->setActif($actif);
        $newTest->setLanguage($language);
        $newTest->setTestOrigin($test);

        foreach ($orderedTasks as $orderedTask) {
            $task = $orderedTask->getQuestionnaire();
            $newTask = $this->questionnaireManager->duplicate($task);
            $newOrderedTask = $this->orderQuestionnaireTestManager->createOrderQuestionnaireTest($newTest, $newTask);
            $newTest->addOrderQuestionnaireTest($newOrderedTask);
        }

        $this->entityManager->persist($newTest);
        $this->entityManager->flush();

        return $newTest;
    }

    public function toggleArchived(Test $test)
    {
        if ($test->isArchived()) {
            $test->setArchived(false);
        } else {
            $test->setArchived(true);
        }

        $this->entityManager->persist($test);
        $this->entityManager->flush();

        return $test;
    }

    public function togglePhased(Test $test)
    {
        if ($test->getPhased()) {
            $test->setPhased(false);
            $msg = 'Le test '.$test->getName().' n\'est plus un test a étape';
        } else {
            $test->setPhased(true);
            $msg = 'Le test '.$test->getName().' est maintenant un test a étape';
            $this->phasedTestManager->generateBaseComponents($test);
        }
        $this->entityManager->flush();

        $this->session->getFlashBag()->set('success', $msg);

        return $test;
    }
}
