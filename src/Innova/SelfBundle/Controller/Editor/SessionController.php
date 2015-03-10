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
use Symfony\Component\HttpFoundation\Request;

/**
 * Session controller.
 *
 * @Route("admin/editor")
 * @ParamConverter("test", isOptional="true", class="InnovaSelfBundle:Test",  options={"id" = "testId"})
 * @ParamConverter("session", isOptional="true", class="InnovaSelfBundle:Session", options={"id" = "sessionId"})
 */
class SessionController extends Controller
{
    /**
     *
     * @Route("/test/{testId}/sessions", name="editor_test_sessions")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Editor:session/list.html.twig")
     */
    public function listAction(Test $test)
    {
        return array("test" => $test);
    }

    /**
     *
     * @Route("/test/{testId}/session/create/", name="editor_test_create_session")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Editor:session/new.html.twig")
     */
    public function newAction(Test $test, Request $request)
    {
        $session = new Session();
        $session->setName('Nouvelle session');
        $session->setActif(false);

        $form = $this->get('form.factory')->createBuilder(new SessionType(), $session)->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $session->setTest($test);

            $em = $this->getDoctrine()->getManager();
            $em->persist($session);
            $em->flush();

            return $this->redirect($this->generateUrl('editor_test_edit_session', array('sessionId' => $session->getId(), 'testId' => $test->getId())));
        }

        return array('form' => $form->createView(), 'test' => $test);
    }

    /**
     *
     * @Route("test/{testId}/session/{sessionId}/", name="editor_test_edit_session")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Editor:session/new.html.twig")
     */
    public function editAction(Test $test, Session $session, Request $request)
    {
        $form = $this->get('form.factory')->createBuilder(new SessionType(), $session)->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($session);
            $em->flush();

            return $this->redirect($this->generateUrl('editor_test_edit_session', array('sessionId' => $session->getId(), 'testId' => $test->getId())));
        }

        return array('form' => $form->createView(), 'test' => $test);
    }
}
