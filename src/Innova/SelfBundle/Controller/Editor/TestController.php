<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Form\Type\TestType;
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
     * Edits a test entity.
     *
     * @Route("/test/{testId}/delete", name="editor_test_delete")
     * @Method("DELETE")
     */
    public function deleteTestAction(Test $test)
    {
        $testName = $test->getName();

        $em = $this->getDoctrine()->getManager();
        $em->remove($test);
        $em->flush();

        $this->get('session')->getFlashBag()->set('success', 'Le test '.$testName.' a bien été supprimé.');

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
        $this->get('session')->getFlashBag()->set('success', 'Le test '.$test->getName().' a bien été dupliqué.');

        return $this->redirect($this->generateUrl('editor_tests_show'));
    }

    /**
     * Display form to create a new Questionnaire entity.
     *
     * @Route("/test/newform", name="editor_test_create")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Editor:editTestForm.html.twig")
     */
    public function newAction(Request $request)
    {
        $test = new Test();
        $form = $this->handleForm($test, $request);
        if (!$form) {
            $this->get("session")->getFlashBag()->set('success', "Le test ".$test->getName()." a bien été créé.");

            return $this->redirect($this->generateUrl('editor_tests_show'));
        }

        return array('form' => $form->createView());
    }

    /**
     * Edits a test entity.
     *
     * @Route("/test/{testId}/edit", name="editor_test_edit")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Editor:editTestForm.html.twig")
     */
    public function editAction(Test $test, Request $request)
    {
        $form = $this->handleForm($test, $request);

        if (!$form) {
            $this->get("session")->getFlashBag()->set('success', "Le test ".$test->getName()."a bien été modifié.");

            return $this->redirect($this->generateUrl('editor_tests_show'));
        }

        return array('form' => $form->createView(), 'test' => $test);
    }

    /**
     * @Route("/favorite/toggle/{testId}", name="test_favorite_toggle" , options={"expose"=true}))
     * @Method("GET")
     */
    public function toggleFavoriteAction(Test $test)
    {
        $this->get("self.test.manager")->toggleFavorite($test);

        return new JsonResponse();
    }

    /**
     * Handles test form
     */
    private function handleForm(Test $test, $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('form.factory')->createBuilder(new TestType(), $test)->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                if (!$test->getId() && $test->getPhased()) {
                    $test = $this->get("self.phasedtest.manager")->generateBaseComponents($test);
                }

                $em->persist($test);
                $em->flush();

                return;
            }
        }

        return $form;
    }
}
