<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Form\Type\TaskInfosType;
use Symfony\Component\HttpFoundation\JsonResponse;

class QuestionnaireManager
{
    protected $entityManager;
    protected $securityContext;
    protected $user;
    protected $questionnaireRevisorsManager;
    protected $templating;
    protected $formFactory;

    public function __construct($entityManager, $securityContext, $questionnaireRevisorsManager, $templating, $formFactory)
    {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
        $this->user = $this->securityContext->getToken()->getUser();
        $this->questionnaireRevisorsManager = $questionnaireRevisorsManager;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
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
        $questionnaire->setStatus($em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Status')->find(1));
        $questionnaire->setAuthor($this->user);

        $em->persist($questionnaire);
        $em->flush();

        return $questionnaire;
    }

    public function setTypology(Questionnaire $questionnaire, $typologyName)
    {
        $em = $this->entityManager;

        if (!$typology = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($typologyName)) {
            $typology = null;
            foreach ($questionnaire->getQuestions()[0]->getSubquestions() as $subquestion) {
                $subquestion->setTypology(null);
                $em->persist($subquestion);
            }
        } else {
            foreach ($questionnaire->getQuestions()[0]->getSubquestions() as $subquestion) {
                $subquestion->setTypology($typology);
                $em->persist($subquestion);
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

        if ($em->getRepository('InnovaSelfBundle:Questionnaire')->findBy(array('theme' => $theme, 'language' => $language))) {
            $isUnique = false;
        }

        return $isUnique;
    }

    public function setIdentityField($questionnaire, $field, $value)
    {
        $em = $this->entityManager;

        switch ($field) {
            case 'fixedOrder':
                $questionnaire->setFixedOrder($value);
                break;
            case 'theme':
                $questionnaire->setTheme($value);
                break;
             case 'skill':
                if ($skill = $em->getRepository('InnovaSelfBundle:Skill')->find($value)) {
                    $questionnaire->setSkill($skill);
                    $em->persist($questionnaire);
                    $em->flush();
                    $form = $this->formFactory->createBuilder(new TaskInfosType(), $questionnaire)->getForm();
                    $this->questionnaireRevisorsManager->addRevisor($questionnaire);

                    $template = $this->templating->render('InnovaSelfBundle:Editor/partials:general-infos.html.twig',
                        array(
                                'questionnaire' => $questionnaire,
                                'taskInfosForm' => $form->createView(),
                        ));

                    return new JsonResponse(array('template' => $template, 'test' => "test"));
                }
                break;
            case 'typology':
                if ($typology = $em->getRepository('InnovaSelfBundle:Typology')->find($value)) {
                    $this->setTypology($questionnaire, $typology->getName());
                    $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestions.html.twig', array('questionnaire' => $questionnaire));
                    $this->questionnaireRevisorsManager->addRevisor($questionnaire);

                    return new JsonResponse(array('subquestions' => $template));
                }
                break;
        }

        $this->questionnaireRevisorsManager->addRevisor($questionnaire);

        $em->persist($questionnaire);
        $em->flush();

        return new JsonResponse(array());
    }
}
