<?php

namespace Innova\SelfBundle\Controller\Right;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Session;
use Innova\SelfBundle\Entity\Right\RightUserSession;
use Innova\SelfBundle\Form\Type\Right\RightUserSessionType;
use Symfony\Component\HttpFoundation\Request;

/**
 * RightUserSession controller.
 *
 * @Route("/admin")
 * @ParamConverter("session", isOptional="true", class="InnovaSelfBundle:Session", options={"id" = "sessionId"})
 * @ParamConverter("rightUserSession", isOptional="true", class="InnovaSelfBundle:Right\RightUserSession", options={"id" = "rightId"})
 */
class RightUserSessionController extends Controller
{
    /**
     *
     * @Route("/session/{sessionId}/rights", name="editor_session_rights")
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Session:rights.html.twig")
     */
    public function handleRightsAction(Session $session)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.editrightssession", $currentUser)) {
            $em = $this->getDoctrine()->getManager();
            $rights = $em->getRepository("InnovaSelfBundle:Right\RightUserSession")->findByTarget($session);

            return array("session" => $session, "rights" => $rights);
        }

        return;
    }

    /**
     *
     * @Route("/session/{sessionId}/rights/add", name="editor_session_rights_add")
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:Session:rights_form.html.twig")
     */
    public function createRightsAction(Session $session, Request $request)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.editrightssession", $currentUser)) {
            $right = new RightUserSession();

            $form = $this->handleRightsForm($right, $session, $request);
            if (!$form) {
                $this->get("session")->getFlashBag()->set('info', "Les droits ont bien été créés");

                return $this->redirect($this->generateUrl('editor_session_rights', array('sessionId' => $session->getId())));
            }

            return array('form' => $form->createView(), 'session' => $session, 'right' => $right);
        }

        return;
    }

    /**
     *
     * @Route("/session/{sessionId}/rights/{rightId}/edit", name="editor_session_rights_edit")
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:Session:rights_form.html.twig")
     */
    public function editRightsAction(Session $session, RightUserSession $rightUserSession, Request $request)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.editrightssession", $currentUser)) {
            $form = $this->handleRightsForm($rightUserSession, $session, $request);

            if (!$form) {
                $this->get("session")->getFlashBag()->set('info', "Les droits ont bien été modifiés");

                return $this->redirect($this->generateUrl('editor_session_rights', array('sessionId' => $session->getId())));
            }

            return array('form' => $form->createView(), 'session' => $session, 'rightUserSession' => $rightUserSession);
        }

        return;
    }

    /**
     *
     * @Route("/session/{sessionId}/right/{rightId}/delete", name="editor_session_rights_delete", options = {"expose"=true})
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Session:list.html.twig")
     */
    public function deleteRightAction(Session $session, RightUserSession $rightUserSession)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.editrightssession", $currentUser)) {
            $user = $rightUserSession->getUser();
            $em = $this->getDoctrine()->getManager();
            $em->remove($rightUserSession);
            $em->flush();

            $this->get("self.right.manager")->adminToggle($user);

            $this->get("session")->getFlashBag()->set('info', "Les droits ont bien été supprimés");

            return $this->redirect($this->generateUrl('editor_session_rights', array('sessionId' => $session->getId())));
        }

        return;
    }

    /**
     * Handles session form
     */
    private function handleRightsForm(RightUserSession $rightUserSession, Session $session, $request)
    {
        $form = $this->get('form.factory')->createBuilder(new RightUserSessionType(), $rightUserSession)->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $rightUserSession->setTarget($session);
                $em->persist($rightUserSession);
                $em->flush();

                $this->get("self.right.manager")->adminToggle($rightUserSession->getUser());

                return;
            }
        }

        return $form;
    }
}
