<?php

namespace Innova\SelfBundle\Controller;

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
     * @Template("InnovaSelfBundle:Test:list.html.twig")
     */
    public function listTestsAction()
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.listtest", $currentUser)) {
            $tests = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Test')->findByArchived(false);
        } else {
            $tests = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Test')->findAuthorized($currentUser);
        }

        return array('tests' => $tests);
    }

    /**
     * Lists all Test entities.
     *
     * @Route("/tests/language/{languageId}", name="editor_tests_by_language_show")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Test:list.html.twig")
     */
    public function listTestsByLanguageAction(Language $language)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.listtest", $currentUser)) {
            $tests = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Test')->findBy(array("language" => $language, "archived" => false));
        } else {
            $tests = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Test')->findAuthorizedByLanguage($currentUser, $language);
        }

        return array('tests' => $tests);
    }

    /**
     * Lists archived Test entities.
     *
     * @Route("/tests/archived", name="editor_tests_archived_show")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Test:list.html.twig")
     */
    public function listArchivedTestsAction()
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.listtest", $currentUser)) {
            $tests = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Test')->findByArchived(true);

            return array('tests' => $tests);
        }

        return;
    }

    /**
     * Lists favorites Test entities.
     *
     * @Route("/tests/favorites", name="editor_tests_my_favorites")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Test:list.html.twig")
     */
    public function listFavoritesAction()
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.listtest", $currentUser)) {
            $tests = $currentUser->getFavoritesTests();

            return array('tests' => $tests);
        }

        return;
    }

    /**
     * Edits a test entity.
     *
     * @Route("/test/{testId}/delete", name="editor_test_delete")
     * @Method("DELETE")
     */
    public function deleteTestAction(Test $test)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.deletetest", $currentUser, $test)) {
            $testName = $test->getName();
            $em = $this->getDoctrine()->getManager();
            $em->remove($test);
            $em->flush();

            $this->get('session')->getFlashBag()->set('success', 'Le test '.$testName.' a bien été supprimé.');

            return $this->redirect($this->generateUrl('editor_tests_show'));
        }

        return;
    }

    /**
     * duplicate a test entity.
     *
     * @Route("/test/{testId}/duplicate", name="editor_test_duplicate")
     * @Method("GET")
     */
    public function duplicateTestAction(Test $test)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.duplicatetest", $currentUser, $test)) {
            $this->get("self.test.manager")->duplicate($test);
            $this->get('session')->getFlashBag()->set('success', 'Le test '.$test->getName().' a bien été dupliqué.');

            return $this->redirect($this->generateUrl('editor_tests_show'));
        }

        return;
    }

    /**
     * Display form to create a new Questionnaire entity.
     *
     * @Route("/test/create", name="editor_test_create")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Test:form.html.twig")
     */
    public function newAction(Request $request)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.createtest", $currentUser)) {
            $test = new Test();
            $form = $this->handleForm($test, $request);
            if (!$form) {
                $this->get("session")->getFlashBag()->set('success', "Le test ".$test->getName()." a bien été créé.");

                return $this->redirect($this->generateUrl('editor_tests_show'));
            }

            return array('form' => $form->createView());
        }

        return;
    }

    /**
     * Edits a test entity.
     *
     * @Route("/test/{testId}/edit", name="editor_test_edit")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Test:form.html.twig")
     */
    public function editAction(Test $test, Request $request)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.edittest", $currentUser, $test)) {
            $form = $this->handleForm($test, $request);

            if (!$form) {
                $this->get("session")->getFlashBag()->set('success', "Le test ".$test->getName()."a bien été modifié.");

                return $this->redirect($this->generateUrl('editor_tests_show'));
            }

            return array('form' => $form->createView(), 'test' => $test);
        }

        return;
    }

    /**
     * @Route("/test/{testId}/favorite-toggle", name="test_favorite_toggle" , options={"expose"=true}))
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
                    $params = $this->get("self.phasedtest.manager")->initializeParams();
                    $test->setPhasedParams($params);
                }

                $em->persist($test);
                $em->flush();

                return;
            }
        }

        return $form;
    }
}
