<?php

namespace Innova\SelfBundle\Controller\Player;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Trace;
use Innova\SelfBundle\Entity\Answer;

class TraceController extends Controller
{
    /**
     * Save Trace and display a form to set the difficulty
     *
     * @Route("trace_submit", name="trace_submit")
     * @Method({"GET", "POST"})
     * @Template("")
     */
    public function saveTraceAction()
    {
        $em = $this->getDoctrine()->getManager();

        $post = $this->get('request')->request->all();
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($post["questionnaireId"]);
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($post["testId"]);
        $user = $this->get('security.context')->getToken()->getUser();

        $countTrace = $em->getRepository('InnovaSelfBundle:Questionnaire')
            ->countTraceByUserByTestByQuestionnaire($test->getId(), $questionnaire->getId(), $user->getId());

        if ($countTrace > 0) {
            $this->get('session')->getFlashBag()->set('notice', 'Vous avez déjà répondu à cette question.');

            return array("traceId" => 0, "testId" => $test->getId());
        }

        $trace = $this->createTrace($questionnaire, $test, $user, $post["totalTime"]);    

        $this->parsePost($post, $trace);

        $session = $this->container->get('request')->getSession();
        $session->set('traceId', $trace->getId());
        $session->set('testId', $post["testId"]);

        return $this->redirect($this->generateUrl('display_difficulty'));
    }


    /**
     * display a form to set the difficulty
     *
     * @Route("display_difficulty", name="display_difficulty")
     * @Template("InnovaSelfBundle:Player:common/difficulty.html.twig")
     * @Method("GET")
     */
    public function displayDifficultyFormAction()
    {

        $session = $this->container->get('request')->getSession();
        $traceId = $session->get('traceId');
        $testId = $session->get('testId');

        return array("traceId" => $traceId, "testId" => $testId);
    }


    /**
     * Parse post var
     */
    private function parsePost($post, $trace)
    {
        $this->get('session')->getFlashBag()->set('success', 'Votre réponse a bien été enregistrée.');

        foreach ($post as $subquestionId => $postVar) {
            if (is_array($postVar)) {
                foreach ($postVar as $key => $propositionId) {
                    $this->createAnswer($trace, $propositionId, $subquestionId);
                }
            }
        }
    }


    /**
     * Create and return a trace
     */
    private function createTrace($questionnaire, $test, $user, $totalTime)
    {
        $em = $this->getDoctrine()->getManager();

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


    /**
     * create and return an answer
     */
    private function createAnswer($trace, $propositionId, $subquestionId)
    {
        $em = $this->getDoctrine()->getManager();

        $answer = new Answer();

        $answer->setTrace($trace);
        $proposition = $em->getRepository('InnovaSelfBundle:Proposition')->find($propositionId);
        $answer->setProposition($proposition);
        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($subquestionId);
        $answer->setSubquestion($subquestion);
        $em->persist($answer);

        $em->flush();

        return $answer; 
    }


    /**
     * update a trace to set the difficulty
     *
     * @Route("trace_setDifficulty", name="trace_setDifficulty")
     * @Method("POST")
     */
    public function traceSetDifficultyAction()
    {

        $em = $this->getDoctrine()->getManager();
        $post = $this->get('request')->request->all();

        $trace = $em->getRepository('InnovaSelfBundle:Trace')->find($post["traceId"]);
        $trace->setDifficulty($post["difficulty"]);
        $em->persist($trace);
        $em->flush();

        return $this->redirect($this->generateUrl('test_start', array('id' => $post["testId"])));
    }

}
