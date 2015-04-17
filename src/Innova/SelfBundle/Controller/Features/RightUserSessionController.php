<?php

namespace Innova\SelfBundle\Controller\Features;

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
 * @Route("right-user-session-management")
 * @ParamConverter("session", isOptional="true", class="InnovaSelfBundle:Session", options={"id" = "sessionId"})
 * @ParamConverter("rightUserSession", isOptional="true", class="InnovaSelfBundle:Right\RightUserSession", options={"id" = "rightId"})
 */
class RightUserSessionController extends Controller
{
    /**
     *
     * @Route("/session/{sessionId}/rights", name="editor_session_rights")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Features:Session/rights.html.twig")
     */
    public function handleRightsAction(Session $session)
    {
        $em = $this->getDoctrine()->getManager();
        $rights = $em->getRepository("InnovaSelfBundle:Right\RightUserSession")->findByTarget($session);

        return array("session" => $session, "rights" => $rights);
    }

    /**
     *
     * @Route("/session/{sessionId}/rights/add", name="editor_session_rights_add")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Features:Session/rights_form.html.twig")
     */
    public function createRightsAction(Session $session, Request $request)
    {
        $right = new RightUserSession();

        $form = $this->handleRightsForm($right, $session, $request);
        if (!$form) {
            $this->get("session")->getFlashBag()->set('info', "Les droits ont bien été créés");

            return $this->redirect($this->generateUrl('editor_session_rights', array('sessionId' => $session->getId())));
        }

        return array('form' => $form->createView(), 'session' => $session, 'right' => $right);
    }

    /**
     *
     * @Route("/session/{sessionId}/rights/{rightId}/edit", name="editor_session_rights_edit")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Features:Session/rights_form.html.twig")
     */
    public function editRightsAction(Session $session, RightUserSession $rightUserSession, Request $request)
    {
        $form = $this->handleRightsForm($rightUserSession, $session, $request);

        if (!$form) {
            $this->get("session")->getFlashBag()->set('info', "Les droits ont bien été modifiés");

            return $this->redirect($this->generateUrl('editor_session_rights', array('sessionId' => $session->getId())));
        }

        return array('form' => $form->createView(), 'session' => $session, 'rightUserSession' => $rightUserSession );
    }

    /**
     *
     * @Route("/session/{sessionId}/right/{rightId}/delete", name="editor_session_rights_delete", options = {"expose"=true})
     * @Method("GET")
     * @Template("InnovaSelfBundle:Features:Session/list.html.twig")
     */
    public function deleteRightAction(Session $session, RightUserSession $rightUserSession)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($rightUserSession);
        $em->flush();

        $this->get("session")->getFlashBag()->set('info', "Les droits ont bien été supprimés");

        return $this->redirect($this->generateUrl('editor_session_rights', array('sessionId' => $session->getId())));
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

                return;
            }
        }

        return $form;
    }
}
