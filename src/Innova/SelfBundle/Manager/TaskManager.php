<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Language;

class TaskManager
{
    protected $entityManager;
    protected $securityContext;
    protected $templating;

    public function __construct($entityManager, $securityContext, $templating)
    {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
        $this->templating = $templating;
        $this->currentUser = $this->securityContext->getToken()->getUser();
        $this->taskRepo = $this->entityManager->getRepository('InnovaSelfBundle:Questionnaire');
    }

    public function listQuestionnaires()
    {
        $questionnaires = ($language = $this->currentUser->getPreferedLanguage())
            ? $this->taskRepo->findByLanguage($language)
            : $this->taskRepo->findAll();

        return $questionnaires;
    }

    public function listQuestionnairesByLanguage(Language $language)
    {
        $questionnaires = $this->taskRepo->findByLanguage($language);

        return $questionnaires;
    }

    public function listTestQuestionnaires(Test $test)
    {
        if ($test->getPhased()) {
            $template = $this->templating->render('InnovaSelfBundle:Editor/phased:test.html.twig', array('test' => $test));
        } else {
            $orders = $test->getOrderQuestionnaireTests();
            $potentials = $this->taskRepo->getPotentialByTest($test);
            $template = $this->templating->render('InnovaSelfBundle:Editor:listTestQuestionnaires.html.twig', array('test' => $test, 'orders' => $orders, 'potentialQuestionnaires' => $potentials));
        }

        return $template;
    }

    public function listOrphans()
    {
        $questionnaires = $this->taskRepo->findOrphans();

        return $questionnaires;
    }

    public function getPotentialQuestionnaires(Test $test)
    {
        $potentials = $this->taskRepo->getPotentialByTest($test);
        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:potentialQuestionnaires.html.twig', array('test' => $test, 'potentialQuestionnaires' => $potentials));

        return $template;
    }

    public function deleteTask(Questionnaire $questionnaire)
    {
        $this->entityManager->remove($questionnaire);
        $this->entityManager->flush();

        return;
    }
}
