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
 * @Route("/admin")
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
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        $testRepo = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Test');

        if ($this->get('self.right.manager')->checkRight('right.listtest', $currentUser)) {
            $tests = ($currentUser->getPreferedLanguage())
                ? $testRepo->findByArchivedByLanguage(0, $currentUser->getPreferedLanguage())
                : $testRepo->findByArchived(false);
        } else {
            $tests = $testRepo->findAuthorized($currentUser);
        }

        return array('tests' => $tests, 'subset' => 'test.all');
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
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        $testRepo = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Test');

        $tests = ($this->get('self.right.manager')->checkRight('right.listtest', $currentUser))
            ? $testRepo->findBy(array('language' => $language, 'archived' => false))
            : $testRepo->findAuthorizedByLanguage($currentUser, $language);

        return array('tests' => $tests, 'subset' => $language->getName());
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
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        $testRepo = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Test');

        if ($this->get('self.right.manager')->checkRight('right.listtest', $currentUser)) {
            $tests = ($currentUser->getPreferedLanguage())
                ? $testRepo->findByArchivedByLanguage(1, $currentUser->getPreferedLanguage())
                : $testRepo->findByArchived(1);
        } else {
            $tests = $testRepo->findAuthorized($currentUser);
        }

        return array('tests' => $tests, 'subset' => 'test.archived');
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
        $tests = $this->get('self.test.manager')->getFavoriteTests();

        return array('tests' => $tests, 'subset' => 'test.favorites');
    }

    /**
     * Delete a test entity.
     *
     * @Route("/test/{testId}/delete", name="editor_test_delete")
     * @Method("DELETE")
     */
    public function deleteTestAction(Test $test)
    {
        $this->get('innova_voter')->isAllowed('right.deletetest', $test);

        $this->get('self.test.manager')->deleteTest($test);

        return $this->redirect($this->generateUrl('editor_tests_show'));
    }

    /**
     * Duplicate a test entity.
     *
     * @Route("/test/{testId}/duplicate", name="editor_test_duplicate")
     * @Method("GET")
     */
    public function duplicateTestAction(Test $test)
    {
        $this->get('innova_voter')->isAllowed('right.duplicatetest', $test);

        $this->get('self.test.manager')->duplicate($test);

        return $this->redirect($this->generateUrl('editor_tests_show'));
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
        $this->get('innova_voter')->isAllowed('right.createtest');

        $test = new Test();
        $form = $this->handleForm($test, $request);
        if (!$form) {
            $this->get('session')->getFlashBag()->set('success', 'Le test '.$test->getName().' a bien été créé.');

            return $this->redirect($this->generateUrl('editor_tests_show'));
        }

        return array('form' => $form->createView());
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
        $this->get('innova_voter')->isAllowed('right.edittest', $test);

        $form = $this->handleForm($test, $request);
        if (!$form) {
            $this->get('session')->getFlashBag()->set('success', 'Le test '.$test->getName().'a bien été modifié.');

            return $this->redirect($this->generateUrl('editor_tests_show'));
        }

        return array('form' => $form->createView(), 'test' => $test);
    }

    /**
     * @Route("/test/{testId}/favorite-toggle", name="test_favorite_toggle" , options={"expose"=true}))
     * @Method("GET")
     */
    public function toggleFavoriteAction(Test $test)
    {
        $this->get('self.test.manager')->toggleFavorite($test);

        return new JsonResponse();
    }

    /**
     * Handles test form.
     */
    private function handleForm(Test $test, $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->get('form.factory')->createBuilder(new TestType(), $test)->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                if (!$test->getId() && $test->getPhased()) {
                    $test = $this->get('self.phasedtest.manager')->generateBaseComponents($test);
                    $params = $this->get('self.phasedtest.manager')->initializeParams();
                    $test->setPhasedParams($params);
                }

                $entityManager->persist($test);
                $entityManager->flush();

                return;
            }
        }

        return $form;
    }
}
