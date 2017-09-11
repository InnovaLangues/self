<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Trace;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\PhasedTest\Component;
use Innova\SelfBundle\Entity\Session;
use Symfony\Component\HttpFoundation\Request;

class TraceManager
{
    protected $entityManager;
    protected $mediaManager;
    protected $propositionManager;
    protected $answerManager;
    protected $securityContext;
    protected $session;

    public function __construct($entityManager, $mediaManager, $propositionManager, $answerManager, $securityContext, $session)
    {
        $this->entityManager = $entityManager;
        $this->mediaManager = $mediaManager;
        $this->propositionManager = $propositionManager;
        $this->answerManager = $answerManager;
        $this->securityContext = $securityContext;
        $this->session = $session;
        $this->user = $this->securityContext->getToken()->getUser();
    }

    public function saveTrace(Test $test, Session $session, Questionnaire $questionnaire, Request $request)
    {
        $em = $this->entityManager;
        $post = $request->request->all();

        $component = (isset($post['componentId']))
            ? $em->getRepository('InnovaSelfBundle:PhasedTest\Component')->find($post['componentId'])
            : null;

        $trace = $em->getRepository('InnovaSelfBundle:Trace')->findByUserByTestByQuestionnaire($test, $questionnaire, $this->user, $component, $session);

        if (count($trace) > 0) {
            $this->session->getFlashBag()->set('danger', 'Vous avez déjà répondu à cette question.');
        } else {
            $agent = $request->headers->get('User-Agent');
            $trace = $this->createTrace($questionnaire, $test, $this->user, $post['totalTime'], $agent, $component, $session);
            if (!$this->parsePost($post, $trace)) {
                $answers = $em->getRepository('InnovaSelfBundle:Answer')->findByTrace($trace);
                foreach ($answers as $answer) {
                    $em->remove($answer);
                }
                $em->remove($trace);
                $em->flush();
            }
        }

        return $trace;
    }

    public function setDifficulty(Trace $trace, Request $request)
    {
        $post = $request->request->all();

        $trace->setDifficulty($post['difficulty']);
        $this->entityManager->persist($trace);
        $this->entityManager->flush();

        return;
    }

    private function createTrace(Questionnaire $questionnaire, Test $test, User $user, $totalTime, $agent, Component $component = null, Session $session)
    {
        $em = $this->entityManager;

        $trace = new Trace();
        $trace->setDate(new \DateTime());
        $trace->setQuestionnaire($questionnaire);
        $trace->setTest($test);
        $trace->setUser($user);
        $trace->setTotalTime($totalTime);
        $trace->setuserAgent($agent);
        $trace->setComponent($component);
        $trace->setSession($session);
        $trace->setDifficulty('');

        $em->persist($trace);
        $em->flush();

        return $trace;
    }

    public function deleteSessionTrace(User $user, Session $session)
    {
        $em = $this->entityManager;
        $traces = $em->getRepository('InnovaSelfBundle:Trace')->findBy(['user' => $user, 'session' => $session]);
        $mediaClicks = $em->getRepository('InnovaSelfBundle:Media\MediaClick')->findBy(['user' => $user, 'session' => $session]);

        foreach ($traces as $trace) {
            $em->remove($trace);
        }

        foreach ($mediaClicks as $mediaClick) {
            $em->remove($mediaClick);
        }

        $em->flush();

        return $this;
    }

    /**
     * Parse post var.
     */
    private function parsePost($post, Trace $trace)
    {
        $em = $this->entityManager;

        foreach ($post as $subquestionId => $postVar) {
            $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($subquestionId);
            if (is_array($postVar)) {
                foreach ($postVar as $key => $propositionId) {
                    if ($subquestion->getTypology()->getName() != 'TLQROC') {
                        $proposition = $em->getRepository('InnovaSelfBundle:Proposition')->find($propositionId);
                        if ($subquestion->getPropositions()->contains($proposition)) {
                            $this->answerManager->createAnswer($trace, $subquestion, $proposition);
                        } else {
                            return false;
                        }
                    } else {
                        $this->createAnswerProposition($trace, $propositionId, $subquestion);
                    }
                }
            }
        }

        return true;
    }

    /**
     * si la proposition N'est PAS de type numéric alors on est dans le cas d'une SAISIE.
     */
    private function createAnswerProposition(Trace $trace, $saisie, Subquestion $subquestion)
    {
        $typo = $subquestion->getTypology()->getName();

        if ($typo == 'TLQROC') {
            $propositions = $subquestion->getPropositions();
            $rightAnswer = false;
            $propositionFound = null;

            // Il faut concaténer la syllabe avec la saisie.
            if ($subquestion->getMediaSyllable()) {
                $syllableAnswer = $subquestion->getMediaSyllable()->getDescription();
                $saisie = $syllableAnswer.$saisie;
            }

            $saisie = trim($saisie);

            foreach ($propositions as $proposition) {
                $text = $proposition->getMedia()->getName();
                if (strtolower($text) == htmlentities(strtolower($saisie))) {
                    $propositionFound = $proposition;
                    if ($proposition->getRightAnswer() === true) {
                        $rightAnswer = true;
                    } else {
                        $rightAnswer = false;
                    }
                    break;
                }
            }

            if ($propositionFound === null) {
                $media = $this->mediaManager->createMedia(null, 'texte', $saisie, $saisie, null, 0, 'reponse');
                $proposition = $this->propositionManager->createProposition($subquestion, $media, $rightAnswer);
            } else {
                $proposition = $propositionFound;
            }
        }

        $answer = $this->answerManager->createAnswer($trace, $subquestion, $proposition);

        return $answer;
    }
}
