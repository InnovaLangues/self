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

        return array(
            'tests' => $tests
        );
    }

    /**
     * Lists all Test entities.
     *
     * @Route("/tests/language/{languageId}", name="editor_tests_by_language_show")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:listTests.html.twig")
     */
    public function listTestsByLanguageAction($languageId)
    {
        $em = $this->getDoctrine()->getManager();

        $language = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($languageId);
        $tests = $em->getRepository('InnovaSelfBundle:Test')->findByLanguage($language);

        return array(
            'tests' => $tests
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

        return array();
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

        return array(
                    'test' => $test,
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
        $language = $em->getRepository('InnovaSelfBundle:Language')->find($request->request->get('test-language'));

        $test->setLanguage($language);
        // changer la langue des tâches de ce test !

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

    /**
     * Edits a test entity.
     *
     * @Route("/test/{testId}/delete", name="editor_test_delete")
     * @Method("DELETE")
     * @Template("")
     */
    public function deleteTestAction($testId)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);
        foreach ($test->getOrderQuestionnaireTests() as $order) {
            $em->remove($order);
        }

        foreach ($test->getMediaClicks() as $mediaClick) {
            $em->remove($mediaClick);
        }

         foreach ($test->getTraces() as $trace) {
            $em->remove($trace);
        }

        $em->remove($test);
        $em->flush();

        return $this->redirect($this->generateUrl('editor_tests_show'));
    }

}
