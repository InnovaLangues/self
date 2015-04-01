<?php

namespace Innova\SelfBundle\Manager\Editor;

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
    protected $mediaManager;
    protected $questionManager;

    public function __construct(
        $entityManager,
        $securityContext,
        $questionnaireRevisorsManager,
        $templating,
        $formFactory,
        $mediaManager,
        $questionManager
    ) {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
        $this->user = $this->securityContext->getToken()->getUser();
        $this->questionnaireRevisorsManager = $questionnaireRevisorsManager;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->mediaManager = $mediaManager;
        $this->questionManager = $questionManager;
    }

    public function createQuestionnaire()
    {
        $em = $this->entityManager;

        $questionnaire = new Questionnaire();
        $questionnaire->setStatus($em->getRepository('InnovaSelfBundle:QuestionnaireIdentity\Status')->findAll()[0]);
        $questionnaire->setAuthor($this->user);

        $em->persist($questionnaire);
        $em->flush();

        return $questionnaire;
    }

    public function editQuestionnaireField(Questionnaire $questionnaire, $field, $value)
    {
        $em = $this->entityManager;

        if ($field == "contexte") {
            $questionnaire->setMediaContext($value);
        } elseif ($field == "texte") {
            $questionnaire->setMediaText($value);
        } elseif ($field == "feedback") {
            $questionnaire->setMediaFeedback($value);
        } elseif ($field == "blank-text") {
            $questionnaire->setMediaBlankText($value);
        } elseif ($field == "functional-instruction") {
            $questionnaire->setMediaFunctionalInstruction($value);
        } elseif ($field == "instruction") {
            $questionnaire->setMediaInstruction($value);
        }
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

    public function setIdentityField(Questionnaire $questionnaire, $field, $value)
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

    public function duplicate(Questionnaire $task)
    {
        $em = $this->entityManager;

        $newTask = new Questionnaire();
        $newTask->setLevel($task->getLevel());
        $newTask->setAuthor($task->getAuthor());
        $newTask->setAuthorMore($task->getAuthorMore());
        $newTask->setLanguageLevel($task->getLanguageLevel());
        $newTask->setStatus($task->getStatus());
        $newTask->setTheme("Copie de ".$task->getTheme());
        $newTask->setTextTitle($task->getTextTitle());
        $newTask->setDialogue($task->getDialogue());
        $newTask->setFixedOrder($task->getFixedOrder());
        $newTask->setLanguage($task->getLanguage());
        $newTask->setSkill($task->getSkill());
        $newTask->setLevelProof($task->getLevelProof());
        $newTask->setAuthorRight($task->getAuthorRight());
        $newTask->setAuthorRightMore($task->getAuthorRightMore());
        $newTask->setSource($task->getSource());
        $newTask->setSourceMore($task->getSourceMore());
        $newTask->setSourceOperation($task->getSourceOperation());
        $newTask->setDomain($task->getDomain());
        $newTask->setRegister($task->getRegister());
        $newTask->setReception($task->getReception());
        $newTask->setLength($task->getLength());
        $newTask->setFlow($task->getFlow());
        $newTask->setMediaInstruction($this->mediaManager->duplicate($task->getMediaInstruction(), $newTask));
        $newTask->setMediaContext($this->mediaManager->duplicate($task->getMediaContext(), $newTask));
        $newTask->setMediaText($this->mediaManager->duplicate($task->getMediaText(), $newTask));
        $newTask->setMediaFunctionalInstruction($this->mediaManager->duplicate($task->getMediaFunctionalInstruction(), $newTask));
        $newTask->setMediaFeedback($this->mediaManager->duplicate($task->getMediaFeedback(), $newTask));
        $newTask->setMediaBlankText($this->mediaManager->duplicate($task->getMediaBlankText(), $newTask));
        $newTask->addSourceTypes($task->getSourceTypes());
        $newTask->addChannels($task->getChannels());
        $newTask->addGenres($task->getGenres());
        $newTask->addVarieties($task->getVarieties());

        $questions = $task->getQuestions();
        foreach ($questions as $question) {
            $this->questionManager->duplicate($question, $newTask);
        }

        $em->persist($newTask);
        $em->flush();

        return $newTask;
    }
}
