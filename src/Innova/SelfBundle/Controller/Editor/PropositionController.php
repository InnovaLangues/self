<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Question;
use Innova\SelfBundle\Entity\OrderQuestionnaireTest;
use Innova\SelfBundle\Entity\MediaLimit;


/**
 * Proposition Controller for editor
 *
 * @Route("admin/editor")
 */
class PropositionController extends Controller
{
    /**
     *
     * @Route("/questionnaires/toggle_right_answer", name="editor_questionnaire_toggle_right_anwser", options={"expose"=true})
     * @Method("POST")
     */
    public function toggleRightAnswserAction()
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->request->get('testId'));
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($request->request->get('questionnaireId'));
        $propositionId = $request->request->get('propositionId');
        $proposition = $em->getRepository('InnovaSelfBundle:Proposition')->find($propositionId);

        if($proposition->getRightAnswer() == true){
            $proposition->setRightAnswer(false);
        } else {
            $proposition->setRightAnswer(true);
        }
       
        $em->persist($proposition);
        $em->flush();

        $template = $this->renderView('InnovaSelfBundle:Editor/partials:proposition.html.twig',array('test' => $test, 'questionnaire' => $questionnaire, 'proposition' => $proposition));

        return new Response($template);
    }
}

