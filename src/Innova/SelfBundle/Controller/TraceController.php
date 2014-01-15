<?php

namespace Innova\SelfBundle\Controller;

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
     * @Template("InnovaSelfBundle:Trace:difficulty.html.twig")
     */
    public function saveTraceAction()
    {
        $em = $this->getDoctrine()->getManager();

        $post = $this->get('request')->request->all();

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($post["questionnaireId"]);
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($post["testId"]);
        $user = $this->get('security.context')->getToken()->getUser();

        $countTrace = $em->getRepository('InnovaSelfBundle:Questionnaire')
            ->CountTraceByUserByTestByQuestionnaire($test->getId(), $questionnaire->getId(), $user->getId());

        /* If I already have a TRACE, the validation is not allowed.*/
        if ($countTrace > 0)
        {
            $this->get('session')->getFlashBag()->set('notice', 'Vous avez déjà répondu à cette question.');

            $traceId = 0;
            return array("traceId" => $traceId, "testId" => $test->getId());
        }

        $trace = new Trace();

        $trace->setDate(new \DateTime());
        $trace->setQuestionnaire($questionnaire);
        $trace->setTest($test);
        $trace->setUser($user);
        $trace->setTotalTime($post["totalTime"]);
        $trace->setListeningTime("");
        $trace->setListeningAfterAnswer("");
        $trace->setClickCorrectif("");
        $trace->setIp("");
        $trace->setuserAgent("");
        $trace->setDifficulty("");

        $em->persist($trace);
        $em->flush();

        $this->get('session')->getFlashBag()->set('success', 'Votre réponse a bien été prise en compte.');

        $traceId = $trace->getId();

        foreach ($post as $subquestionId => $postVar){
            if (is_array($postVar)){
                foreach ($postVar as $key => $propositionId){
                    $answer = new Answer();
                    $answer->setTrace($trace);
                    $proposition = $em->getRepository('InnovaSelfBundle:Proposition')->find($propositionId);
                    $answer->setProposition($proposition);
                    $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($subquestionId);
                    $answer->setSubquestion($subquestion);
                    $em->persist($answer);
                }
            }
        }

        $em->flush();

        return array("traceId" => $traceId, "testId" => $post["testId"]);

    }

    /**
     * update a trace to set the difficulty
     *
     * @Route("trace_setDifficulty", name="trace_setDifficulty")
     * @Method("POST")
     */
    public function trace_setDifficultyAction()
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
