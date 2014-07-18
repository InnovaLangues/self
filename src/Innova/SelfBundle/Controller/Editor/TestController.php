<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Test;

/**
 * Test controller.
 *
 * @Route("admin/editor")
 */
class TestController extends Controller
{

    /**
     * Lists all Test entities.
     *
     * @Route("/tests", name="editor_tests_show")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:listTests.html.twig")
     */
    public function listTestsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tests = $em->getRepository('InnovaSelfBundle:Test')->findAll();
        $taskCount = array();
        foreach ($tests as $test) {
            $taskCount[] = count($orderQuestionnaireTests = $em->getRepository('InnovaSelfBundle:OrderQuestionnaireTest')->findByTest($test));
        }

        return array(
            'tests' => $tests,
            'taskCount' => $taskCount
        );
    }


    /**
     * Display form to create a new Questionnaire entity.
     *
     * @Route("/test/newform", name="editor_test_create_form")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:createTestForm.html.twig")
     */
    public function createTestFormAction()
    {
        $em = $this->getDoctrine()->getManager();
        $languages = $em->getRepository('InnovaSelfBundle:Language')->findAll();

        return array('languages' => $languages);
    }

    /**
     * Creates a new Test entity.
     *
     * @Route("/test/create", name="editor_test_create")
     * @Method("POST")
     * @Template("")
     */
    public function createTestAction()
    {

        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');

        $test = new Test();
        $test->setName($request->request->get('test-name'));
        $test->setLanguage($em->getRepository('InnovaSelfBundle:Language')->find($request->request->get('test-language')));

        $em->persist($test);
        $em->flush();

        return $this->redirect($this->generateUrl('editor_tests_show'));
    }

    /**
     * Display form to edit a test entity.
     *
     * @Route("/test/{testId}/editform", name="editor_test_edit_form")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:editTestForm.html.twig")
     */
    public function editTestFormAction($testId)
    {
        $em = $this->getDoctrine()->getManager();
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);

        $languages = $em->getRepository('InnovaSelfBundle:Language')->findAll();

        return array(
                    'test' => $test,
                    'languages' => $languages
        );
    }

    /**
     * Edits a test entity.
     *
     * @Route("/test/{testId}/edit", name="editor_test_edit")
     * @Method("POST")
     * @Template("")
     */
    public function editTestAction($testId)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);
        $test->setName($request->request->get('test-name'));
        $test->setLanguage($em->getRepository('InnovaSelfBundle:Language')->find($request->request->get('test-language')));

        $display = $request->request->get('test-display');
        if ($display == "actif") {
            $test->setActif(true);
        } else {
            $test->setActif(false);
        }

        $em->persist($test);
        $em->flush();

        return $this->redirect($this->generateUrl('editor_tests_show'));
    }
}
