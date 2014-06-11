<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Question;
use Innova\SelfBundle\Entity\Subquestion;
use Innova\SelfBundle\Entity\OrderQuestionnaireTest;
use Innova\SelfBundle\Entity\Media;
/**
 * Questionnaire controller.
 *
 * @Route("admin/editor")
 */
class QuestionnaireController extends Controller
{
    /**
     * Lists all Questionnaire entities.
     *
     * @Route("/tests", name="editor_tests_show")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:listTests.html.twig")
     */
    public function listTestsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tests = $em->getRepository('InnovaSelfBundle:Test')->findAll();

        return array(
            'tests' => $tests,
        );
    }

    /**
     * Lists all Questionnaire entities.
     *
     * @Route("/test/{testId}/questionnaires", name="editor_test_questionnaires_show")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:listQuestionnaires.html.twig")
     */
    public function listQuestionnairesAction($testId)
    {
        $em = $this->getDoctrine()->getManager();

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);
        $orders = $em->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')->findByTest($testId);

        return array(
            'test' => $test,
            'orders' => $orders
        );
    }

    /**
     * Finds and displays a Questionnaire entity.
     *
     * @Route("/test/{testId}/questionnaire/{questionnaireId}", name="editor_questionnaire_show", requirements={"questionnaireId" = "\d+"})
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:index.html.twig")
     */
    public function showAction($testId, $questionnaireId)
    {

        $em = $this->getDoctrine()->getManager();

        $test = $em->getRepository('InnovaSelfBundle:test')->find($testId);
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);

        if (!$questionnaire) {
            throw $this->createNotFoundException('Unable to find Questionnaire entity ! ');
        }

        return array(
            'test' => $test,
            'questionnaire' => $questionnaire
        );
    }

    /**
     * Creates a new Questionnaire entity.
     *
     * @Route("/test/{testId}/questionnaire/create", name="editor_questionnaire_create")
     * @Method("GET")
     * @Template("")
     */
    public function createQuestionnaireAction($testId)
    {

        $em = $this->getDoctrine()->getManager();

        $questionnaire = new Questionnaire();
        $questionnaire->setTheme("");

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);
        $questionnaire->addTest($test);
        $questionnaire->setListeningLimit(0);
        $questionnaire->setDialogue(0);
        $questionnaire->setFixedOrder(0);
        $em->persist($questionnaire);

        $question = new Question();
        $question->setQuestionnaire($questionnaire);
        $em->persist($question);

        $orderQuestionnaireTest = new OrderQuestionnaireTest();
        $orderQuestionnaireTest->setTest($test);
        $orderQuestionnaireTest->setQuestionnaire($questionnaire);
        $orderMax = count($em->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')->findByTest($test));
        $orderQuestionnaireTest->setDisplayOrder($orderMax + 1);
        $em->persist($orderQuestionnaireTest);

        $em->flush();

        return $this->redirect($this->generateUrl(
                            'editor_questionnaire_show',
                            array(
                                'testId' => $testId,
                                'questionnaireId' => $questionnaire->getId()
                            )
                ));

    }

    /**
     * Updates a Questionnaire entity
     *
     * @Route("/questionnaires/{id}", name="editor_questionnaire_edit")
     * @Method("PUT")
     * @Template("")
     */
    public function editAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($id);

        if (!$questionnaire) {
            throw $this->createNotFoundException('Unable to find Questionnaire entity.');
        }

        $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Le questionnaire a été créé.'
                );

        return $this->redirect($this->generateUrl(
                        'editor_questionnaire_show',
                        array('id' => $entity->getId()))
                    );
    }

     /**
     * Delete a Questionnaire entity
     *
     * @Route("/questionnaires/{id}", name="editor_questionnaire_delete")
     * @Method("DELETE")
     * @Template("")
     */
    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($id);

        if (!$questionnaire) {
            throw $this->createNotFoundException('Unable to find Questionnaire entity.');
        }

        $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Le questionnaire a été supprimé.'
                );

        return $this->redirect($this->generateUrl(
                        'editor_questionnaire_show',
                        array('id' => $entity->getId()))
                    );
    }

    /**
     *
     * @Route("/questionnaires/set-theme", name="editor_questionnaire_set-theme", options={"expose"=true})
     * @Method("POST")
     */
    public function setThemeAction()
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();
        $questionnaireId = $request->request->get('questionnaireId');
        $theme = $request->request->get('theme');

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        $questionnaire->setTheme($theme);
        $em->persist($questionnaire);
        $em->flush();

        return new JsonResponse(
            array(
                'theme' => $questionnaire->getTheme(),
            )
        );
    }

    /**
     *
     * @Route("/questionnaires/set-fixed-order", name="editor_questionnaire_set-fixed-order", options={"expose"=true})
     * @Method("POST")
     */
    public function setFixedOrderAction()
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();
        $questionnaireId = $request->request->get('questionnaireId');
        $isChecked = $request->request->get('isChecked');

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        $questionnaire->setFixedOrder($isChecked);
        $em->persist($questionnaire);
        $em->flush();

        return new JsonResponse(
            array()
        );
    }


    /**
     *
     * @Route("/questionnaires/set-skill", name="editor_questionnaire_set-skill", options={"expose"=true})
     * @Method("POST")
     */
    public function setSkillAction()
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();
        $questionnaireId = $request->request->get('questionnaireId');
        $skillName = $request->request->get('skill');

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        if (!$skill = $em->getRepository('InnovaSelfBundle:Skill')->findOneByName($skillName)) {
            $skill = null;
        }

        $questionnaire->setSkill($skill);
        $em->persist($questionnaire);
        $em->flush();

        return new JsonResponse(
            array(
                'skill' => $skill,
            )
        );
    }

    /**
     *
     * @Route("/questionnaires/set-level", name="editor_questionnaire_set-level", options={"expose"=true})
     * @Method("POST")
     */
    public function setLevelAction()
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();
        $questionnaireId = $request->request->get('questionnaireId');
        $levelName = $request->request->get('level');

        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        if (!$level = $em->getRepository('InnovaSelfBundle:Level')->findOneByName($levelName)) {
            $level = null;
        }
        $questionnaire->setLevel($level);
        $em->persist($questionnaire);
        $em->flush();

        return new JsonResponse(
            array(
                'level' => $level,
            )
        );
    }

    /**
     *
     * @Route("/questionnaires/set-typology", name="editor_questionnaire_set-typology", options={"expose"=true})
     * @Method("POST")
     */
    public function setTypologyAction()
    {
        /* $msg = ""; */
        $request = $this->get('request');
        $questionnaireId = $request->request->get('questionnaireId');
        $testId = $request->request->get('testId');
        $typologyName = $request->request->get('typology');

        $em = $this->getDoctrine()->getManager();
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);

        if (!$typology = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName($typologyName)) {
            $typology = null;
            foreach ($questionnaire->getQuestions()[0]->getSubquestions() as $subquestion) {
                $subquestion->setTypology(null);
                $em->persist($subquestion);
            }
        } else {
            if (mb_substr($typology->getName(), 0, 3) == "APP") {
                foreach ($questionnaire->getQuestions()[0]->getSubquestions() as $subquestion) {
                    $subquestion->setTypology($typology);
                    $em->persist($subquestion);
                }

            } else {
                $typologySubquestion = $em->getRepository('InnovaSelfBundle:Typology')->findOneByName(mb_substr($typologyName, 1));
                foreach ($questionnaire->getQuestions()[0]->getSubquestions() as $subquestion) {
                    $subquestion->setTypology($typologySubquestion);
                    $em->persist($subquestion);
                }
            }
        }

        /*
        // on teste s'il n'y a pas de subquestion
        // (pour éviter un conflit entre la typo de la question et des subq)
        if (count($questionnaire->getQuestions()[0]->getSubquestions()) > 0 ) {
            $msg = "Vous ne pouvez pas éditer la typologie s'il y a déjà des subquestions !";
        } else {
        */
            $questionnaire->getQuestions()[0]->setTypology($typology);
            $em->persist($questionnaire);
            $em->flush();
        /*
        }
        */

        $typologyName = "-";
        if ($typology = $questionnaire->getQuestions()[0]->getTypology()) {
            $typologyName = $typology->getName();
        }

        $template = $this->renderView('InnovaSelfBundle:Editor/partials:subquestions.html.twig',array('test' => $test, 'questionnaire' => $questionnaire));

        return new JsonResponse(
            array(
                /*'msg' => $msg,*/
                'typology'=> $typologyName,
                'subquestions' => $template
            )
        );
    }


}
