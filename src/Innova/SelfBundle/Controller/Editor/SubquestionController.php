<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Innova\SelfBundle\Entity\Media;
use Innova\SelfBundle\Entity\Subquestion;
/**
 * Main controller.
 *
 * @Route("admin/editor/ajax")
 */
class SubquestionController extends Controller
{
    /**
     *
     * @Route("/questionnaires/create-subquestion", name="editor_questionnaire_create-subquestion", options={"expose"=true})
     * @Method("POST")
     */
    public function createSubquestionAction()
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->request->get('testId'));

        $questionnaireId = $request->request->get('questionnaireId');
        $questionnaireTypology = $request->request->get('questionnaireTypology');

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        $question = $questionnaire->getQuestions()[0];

        $subquestion = new Subquestion();
        if (mb_substr($questionnaireTypology, 0, 3) != "APP") {
            $typology = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName(mb_substr($questionnaireTypology, 1));

        } else {
            $typology = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($questionnaireTypology);
        }
        $subquestion->setTypology($typology);
        $subquestion->setQuestion($question);
        $em->persist($subquestion);
        $em->flush();

        $template = $this->renderView('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('test' => $test, 'questionnaire' => $questionnaire));

        return new Response($template);
    }

    /**
     *
     * @Route("/questionnaires/delete-subquestion", name="editor_questionnaire_delete_subquestion", options={"expose"=true})
     * @Method("POST")
     */
    public function deleteSubquestionAction()
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($request->request->get('testId'));

        $subquestionId = $request->request->get('subquestionId');
        $questionnaireId = $request->request->get('questionnaireId');

        $subquestion = $em->getRepository('InnovaSelfBundle:Subquestion')->find($subquestionId);
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);

        $em->remove($subquestion);
        $em->flush();

        $template = $this->renderView('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('test'=> $test, 'questionnaire' => $questionnaire));

        return new Response($template);
    }

}
