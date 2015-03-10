<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Session;
use Innova\SelfBundle\Form\Type\SessionType;
use Innova\SelfBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

/**
 * Session controller.
 *
 * @Route("admin/editor")
 * @ParamConverter("test", isOptional="true", class="InnovaSelfBundle:Test",  options={"id" = "testId"})
 * @ParamConverter("session", isOptional="true", class="InnovaSelfBundle:Session", options={"id" = "sessionId"})
 * @ParamConverter("user", isOptional="true", class="InnovaSelfBundle:User", options={"id" = "userId"})
 */
class SessionController extends Controller
{
    /**
     *
     * @Route("/test/{testId}/sessions", name="editor_test_sessions")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Editor:session/list.html.twig")
     */
    public function listAction(Test $test)
    {
        return array("test" => $test);
    }

    /**
     *
     * @Route("/test/{testId}/session/create", name="editor_test_create_session")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Editor:session/new.html.twig")
     */
    public function newAction(Test $test, Request $request)
    {
        $session = new Session();
        $session->setName('Nouvelle session');
        $session->setActif(false);
        $session->setTest($test);

        $form = $this->handleForm($session, $request, $test);
        if (!$form) {
            $this->get("session")->getFlashBag()->set('info', "La session a bien été créée");

            return $this->redirect($this->generateUrl('editor_test_sessions', array('testId' => $test->getId())));
        }

        return array('form' => $form->createView(), 'test' => $test);
    }

    /**
     *
     * @Route("/session/{sessionId}/remove", name="editor_test_delete_session", options = {"expose"=true})
     * @Method("DELETE")
     * @Template("InnovaSelfBundle:Editor:session/list.html.twig")
     */
    public function deleteAction(Session $session)
    {
        $testId = $session->getTest()->getId();
        $em = $this->getDoctrine()->getManager();
        $em->remove($session);
        $em->flush();

        $this->get("session")->getFlashBag()->set('info', "La session a bien été supprimée");

        return $this->redirect($this->generateUrl('editor_test_sessions', array('testId' => $testId)));
    }

    /**
     *
     * @Route("/test/{testId}/session/{sessionId}", name="editor_test_edit_session")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Editor:session/new.html.twig")
     */
    public function editAction(Test $test, Session $session, Request $request)
    {
        $form = $this->handleForm($session, $request, $test);

        if (!$form) {
            $this->get("session")->getFlashBag()->set('info', "La session a bien été modifiée");

            return $this->redirect($this->generateUrl('editor_test_sessions', array('testId' => $test->getId())));
        }

        return array('form' => $form->createView(), 'test' => $test);
    }

    /**
     *
     * @Route("/session/{sessionId}/results", name="editor_test_session_results")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:session/results.html.twig")
     */
    public function resultsAction(Session $session)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository("InnovaSelfBundle:User")->findBySession($session);

        return array('session' => $session, 'users' => $users);
    }

    /**
     *
     * @Route("/user/{userId}/session/{sessionId}/results", name="editor_session_user_results")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:session/userResults.html.twig")
     */
    public function userResultsAction(User $user, Session $session)
    {
        $em = $this->getDoctrine()->getManager();

        $score = $this->get("self.score.manager")->calculateScoreByTest($session->getTest(), $session);

        return array("score" => $score, "session" => $session, "user" => $user);
    }

    /**
     * Handles session form
     */
    private function handleForm(Session $session, $request, Test $test)
    {
        $form = $this->get('form.factory')->createBuilder(new SessionType(), $session)->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($session);
                $em->flush();

                return;
            }
        }

        return $form;
    }
}
