<?php

namespace Innova\SelfBundle\Manager\Editor;

use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\Typology;
use Innova\SelfBundle\Entity\Question;
use Innova\SelfBundle\Entity\Clue;
use Innova\SelfBundle\Form\Type\SubquestionType;
use Symfony\Component\HttpFoundation\Request;

class SubquestionManager
{
    protected $entityManager;
    protected $mediaManager;
    protected $propositionManager;
    protected $revisorManager;
    protected $formFactory;
    protected $templating;

    public function __construct(
        $entityManager,
        $mediaManager,
        $propositionManager,
        $revisorManager,
        $formFactory,
        $templating
    ) {
        $this->entityManager = $entityManager;
        $this->mediaManager = $mediaManager;
        $this->propositionManager = $propositionManager;
        $this->revisorManager = $revisorManager;
        $this->formFactory = $formFactory;
        $this->templating = $templating;
    }

    public function generateSubquestion(Questionnaire $questionnaire, Typology $typology)
    {
        $em = $this->entityManager;

        $question = $questionnaire->getQuestions()[0];
        $subquestion = $this->createSubquestion($typology, $question);
        $this->propositionManager->createVfPropositions($questionnaire, $subquestion, $typology);

        $em->persist($subquestion);
        $em->flush();
        $em->refresh($subquestion);

        $this->revisorManager->addRevisor($questionnaire);

        return $questionnaire;
    }

    public function createSubquestion(Typology $typology = null, Question $question)
    {
        $em = $this->entityManager;

        $subquestion = new Subquestion();
        $subquestion->setTypology($typology);
        $subquestion->setQuestion($question);
        $subquestion->setDisplayAnswer(false);

        $em->persist($subquestion);
        $em->flush();

        return $subquestion;
    }

    public function removeSubquestion(Subquestion $subquestion, Questionnaire $questionnaire)
    {
        $em = $this->entityManager;
        $this->revisorManager->addRevisor($questionnaire);
        $em->remove($subquestion);
        $em->flush();

        return;
    }

    public function displayIdentityForm(Subquestion $subquestion)
    {
        $form = $this->formFactory->createBuilder(new SubquestionType(), $subquestion)->getForm();

        $template = $this->templating->render('InnovaSelfBundle:Editor/partials:subquestion-identity.html.twig', array(
                                                                                'form' => $form->createView(),
                                                                                'subquestionId' => $subquestion->getId(),
                                                                                ));

        return $template;
    }

    public function setIdentityField(Request $request, Subquestion $subquestion)
    {
        $em = $this->entityManager;

        $form = $this->formFactory->createBuilder(new SubquestionType(), $subquestion)->getForm();
        $form->bind($request);

        if ($form->isValid()) {
            $em->persist($subquestion);
            $em->flush();
        }

        return;
    }

    public function duplicate(Subquestion $subquestion, Question $question)
    {
        $em = $this->entityManager;
        $questionnaire = $question->getQuestionnaire();

        $newSubquestion = $this->createSubquestion($subquestion->getTypology(), $question);
        $newSubquestion->setTitle($subquestion->getTitle());
        $newSubquestion->setLevel($subquestion->getLevel());
        $newSubquestion->setDifficultyIndex($subquestion->getDifficultyIndex());
        $newSubquestion->setDiscriminationIndex($subquestion->getDiscriminationIndex());
        $newSubquestion->setMedia($this->mediaManager->duplicate($subquestion->getMedia(), $questionnaire));
        $newSubquestion->setMediaAmorce($this->mediaManager->duplicate($subquestion->getMediaAmorce(), $questionnaire));
        $newSubquestion->setMediaSyllable($this->mediaManager->duplicate($subquestion->getMediaSyllable(), $questionnaire));
        $newSubquestion->setDisplayAnswer($subquestion->getDisplayAnswer());
        $newSubquestion->addFocuses($subquestion->getFocuses());
        $newSubquestion->addCognitiveOpsMains($subquestion->getCognitiveOpsMain());
        $newSubquestion->setRedundancy($subquestion->getRedundancy());

        if ($clue = $subquestion->getClue()) {
            $newClue = new Clue();
            $newClue->setClueType($clue->getClueType());
            $newClue->setMedia($this->mediaManager->duplicate($clue->getMedia(), $questionnaire));
            $em->persist($newClue);
            $newSubquestion->setClue($newClue);
        }
        $em->persist($newSubquestion);
        $em->flush();

        $propositions = $em->getRepository('InnovaSelfBundle:Proposition')->getBySubquestionExcludingAnswers($subquestion->getId());
        foreach ($propositions as $proposition) {
            $this->propositionManager->duplicate($proposition, $newSubquestion);
        }

        return $newSubquestion;
    }
}
