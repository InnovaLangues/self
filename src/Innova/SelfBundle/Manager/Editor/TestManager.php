<?php

namespace Innova\SelfBundle\Manager\Editor;

use Innova\SelfBundle\Entity\Test;

class TestManager
{
    protected $entityManager;
    protected $securityContext;
    protected $questionnaireManager;
    protected $orderQuestionnaireTestManager;
    protected $phasedTestManager;
    protected $componentManager;
    protected $session;
    protected $user;

    public function __construct(
        $entityManager,
        $securityContext,
        $questionnaireManager,
        $orderQuestionnaireTestManager,
        $phasedTestManager,
        $componentManager,
        $session
    ) {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
        $this->questionnaireManager = $questionnaireManager;
        $this->orderQuestionnaireTestManager = $orderQuestionnaireTestManager;
        $this->phasedTestManager = $phasedTestManager;
        $this->componentManager = $componentManager;
        $this->session = $session;
        $this->user = $this->securityContext->getToken()->getUser();
    }

    public function toggleFavorite(Test $test)
    {
        $favorites = $this->user->getFavoritesTests();
        if ($favorites->contains($test)) {
            $this->user->removeFavoritesTest($test);
        } else {
            $this->user->addFavoritesTest($test);
        }
        $this->entityManager->persist($this->user);
        $this->entityManager->flush();

        return;
    }

    public function duplicate(Test $test)
    {
        $name = $test->getName();
        $language = $test->getLanguage();
        $difficulty = $test->getDifficulty();
        $orderedTasks = $test->getOrderQuestionnaireTests();
        $components = $test->getComponents();
        $phased = $test->getPhased();

        $newTest = new Test();
        $newTest->setName('Copie de '.$name);
        $newTest->setLanguage($language);
        $newTest->setPhased($phased);
        $newTest->setArchived(false);
        $newTest->setTestOrigin($test);
        $newTest->setDifficulty($difficulty);

        foreach ($orderedTasks as $orderedTask) {
            $task = $orderedTask->getQuestionnaire();
            $newTask = $this->questionnaireManager->duplicate($task);
            $newOrderedTask = $this->orderQuestionnaireTestManager->createOrderQuestionnaireTest($newTest, $newTask);
            $newTest->addOrderQuestionnaireTest($newOrderedTask);
        }

        foreach ($components as $component) {
            $newComponent = $this->componentManager->duplicate($component, $newTest);
            $newTest->addComponent($newComponent);
        }

        if ($phased) {
            $params = $this->phasedTestManager->initializeParams();
            $newTest->setPhasedParams($params);
        }

        $this->entityManager->persist($newTest);
        $this->entityManager->flush();

        $this->session->getFlashBag()->set('success', 'Le test '.$test->getName().' a bien été dupliqué.');

        return $newTest;
    }

    public function toggleArchived(Test $test)
    {
        if ($test->isArchived()) {
            $test->setArchived(false);
            $msg = 'Le test '.$test->getName().' a été désarchivé';
        } else {
            $test->setArchived(true);
            $msg = 'Le test '.$test->getName().' a été archivé';
        }

        $this->entityManager->persist($test);
        $this->entityManager->flush();

        $this->session->getFlashBag()->set('success', $msg);

        return $test;
    }

    public function deleteTest(Test $test)
    {
        $testName = $test->getName();
        $this->entityManager > remove($test);
        $this->entityManager > flush();

        $this->session->getFlashBag()->set('success', 'Le test '.$testName.' a bien été supprimé.');

        return;
    }

    public function getFavoriteTests()
    {
        $tests = $this->user->getFavoritesTests();

        return $tests;
    }
}
