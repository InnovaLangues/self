<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Language;

/**
 * Test controller.
 *
 * @Route("admin/editor")
 * @ParamConverter("test",      isOptional="true", class="InnovaSelfBundle:Test",       options={"id" = "testId"})
 * @ParamConverter("language",  isOptional="true", class="InnovaSelfBundle:Language",   options={"id" = "languageId"})
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
        $tests = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Test')->findByArchived(false);

        return array('tests' => $tests);
    }

    /**
     * Lists all Test entities.
     *
     * @Route("/tests/language/{languageId}", name="editor_tests_by_language_show")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:listTests.html.twig")
     */
    public function listTestsByLanguageAction(Language $language)
    {
        $tests = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Test')->findBy(array("language" => $language, "archived" => false));

        return array('tests' => $tests);
    }

    /**
     * Lists archived Test entities.
     *
     * @Route("/tests/archived", name="editor_tests_archived_show")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:listTests.html.twig")
     */
    public function listArchivedTestsAction()
    {
        $tests = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Test')->findByArchived(true);

        return array('tests' => $tests);
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
        return array();
    }

    /**
     * Creates a new Test entity.
     *
     * @Route("/test/create", name="editor_test_create")
     * @Method("POST")
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

        $this->get('session')->getFlashBag()->set('success', 'Le test '.$test->getName().' a été créé');

        return $this->redirect($this->generateUrl('editor_tests_show'));
    }

    /**
     * Display form to edit a test entity.
     *
     * @Route("/test/{testId}/editform", name="editor_test_edit_form")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:editTestForm.html.twig")
     */
    public function editTestFormAction(Test $test)
    {
        return array('test' => $test);
    }

    /**
     * Edits a test entity.
     *
     * @Route("/test/{testId}/edit", name="editor_test_edit")
     * @Method("POST")
     */
    public function editTestAction(Test $test)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');

        $test->setName($request->request->get('test-name'));
        $language = $em->getRepository('InnovaSelfBundle:Language')->find($request->request->get('test-language'));

        $test->setLanguage($language);
        foreach ($test->getOrderQuestionnaireTests() as $order) {
            $questionnaire = $order->getQuestionnaire();
            $questionnaire->setLanguage($language);
            $em->persist($questionnaire);
        }

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
     */
    public function deleteTestAction(Test $test)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($test);
        $em->flush();

        return $this->redirect($this->generateUrl('editor_tests_show'));
    }

    /**
     * duplicate a test entity.
     *
     * @Route("/test/{testId}/duplicate", name="editor_test_duplicate")
     * @Method("GET")
     */
    public function duplicateTestAction(Test $test)
    {
        $this->get("self.test.manager")->duplicate($test);
        $this->get('session')->getFlashBag()->set('success', 'Le test '.$test->getName().' a été dupliqué');

        return $this->redirect($this->generateUrl('editor_tests_show'));
    }

    /**
     * Archive a test entity.
     *
     * @Route("/test/{testId}/archive", name="editor_test_archive")
     * @Method("GET")
     */
    public function archiveTestAction(Test $test)
    {
        $this->get("self.test.manager")->toggleArchived($test);

        return $this->redirect($this->generateUrl('editor_tests_show'));
    }
}
