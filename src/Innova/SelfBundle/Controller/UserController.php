<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Session;

/**
 * User controller.
 *
 * @ParamConverter("user", isOptional="true", class="InnovaSelfBundle:User", options={"id" = "userId"})
 * @ParamConverter("session", isOptional="true", class="InnovaSelfBundle:Session", options={"id" = "sessionId"})
 */
class UserController extends Controller
{
    /**
     * Lists users.
     *
     * @Route("/admin/users/{subset}", name="admin_user")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($subset)
    {
        $this->get('innova_voter')->isAllowed('right.listuser');

        $userRepo = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:User');
        switch ($subset) {
            case 'connected':
                $users = $this->get('self.user.manager')->getConnected();
                break;
            case 'last':
                $users = $userRepo->findBy(array(), array('id' => 'DESC'), $limit = 1000, $offset = null);
                break;
        }

        return array(
            'entities' => $users,
            'subset' => 'user.'.$subset,
        );
    }

    /**
     * Lists users.
     *
     * @Route("/admin/users/search/", name="admin_user_search")
     * @Method("POST")
     * @Template("InnovaSelfBundle:User:index.html.twig")
     */
    public function searchAction()
    {
        $this->get('innova_voter')->isAllowed('right.listuser');

        $search = $this->get('request')->request->get('search');
        $userRepo = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:User');
        $users = $userRepo->getBySomethingLike($search);

        return array(
            'entities' => $users,
            'subset' => 'Recherche de '.$search,
        );
    }

    /**
     * Displays a user entity.
     *
     * @Route("/admin/user/{id}", name="admin_user_show", requirements={"id": "\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $this->get('innova_voter')->isAllowed('right.listuser');

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('InnovaSelfBundle:User')->find($id);
        $sessionsWithTraces = $em->getRepository('InnovaSelfBundle:Session')->findWithTraces($user);

        return array(
            'sessions' => $sessionsWithTraces,
            'user' => $user,
        );
    }

    /**
     * Delete trace for a given user and a given session.
     *
     * @Route("/admin/user/{userId}/session/{sessionId}/delete-trace", name="delete-session-trace")
     * @Method("DELETE")
     */
    public function deleteSessionTraceAction(User $user, Session $session)
    {
        $this->get('innova_voter')->isAllowed('right.deletetraceuser');

        if ($this->get('self.trace.manager')->deleteSessionTrace($user, $session)) {
            $this->get('session')->getFlashBag()->set('success', 'Les traces de cet utilisateur pour la session '.$session->getName().' ('.$session->getTest()->getName().') ont été supprimées');
        }

        return $this->redirect($this->generateUrl('admin_user_show', array('id' => $user->getId())));
    }

    /**
     * get traces for a given user and a given session.
     *
     * @Route("/admin/user/{userId}/session/{sessionId}/traces", name="get-session-traces")
     * @Method("GET")
     * @Template("InnovaSelfBundle:User:traces_infos.html.twig")
     */
    public function getSessionTracesAction(User $user, Session $session)
    {
        $traceRepo = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Trace');
        $traces = $traceRepo->findBy(array('user' => $user, 'session' => $session));

        return array(
            'traces' => $traces,
            'user' => $user,
            'session' => $session,
        );
    }

    /**
     * Delete trace for a given user and a given test.
     *
     * @Route("/admin/user/{userId}/delete", name="delete-user")
     * @Method("DELETE")
     */
    public function deleteUserAction(User $user)
    {
        $this->get('innova_voter')->isAllowed('right.deleteuser');

        $this->get('self.user.manager')->deleteUser($user);

        return $this->redirect($this->generateUrl('admin_user', array('subset' => 'last')));
    }

    /**
     * @Route("/admin/user/create", name="user_create")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:User:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $this->get('innova_voter')->isAllowed('right.createuser');

        $user = new User();
        $form = $this->get('self.user.manager')->handleForm($user, $request);
        if (!$form) {
            $this->get('session')->getFlashBag()->add('info', "L'utilisateur a bien été créée");

            return $this->redirect($this->generateUrl('admin_user_show', array('id' => $user->getId())));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/admin/user/{userId}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:User:new.html.twig")
     */
    public function editAction(User $user, Request $request)
    {
        $this->get('innova_voter')->isAllowed('right.edituser');

        $form = $this->get('self.user.manager')->handleForm($user, $request);
        if (!$form) {
            $this->get('session')->getFlashBag()->set('info', "L'utilisateur a bien été modifié");

            return $this->redirect($this->generateUrl('admin_user_show', array('id' => $user->getId())));
        }

        return array('form' => $form->createView(), 'user' => $user);
    }

    /**
     * @Route("/admin/user/{userId}/change-passwd", name="passwd_edit")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:User:passwd.html.twig")
     */
    public function editPasswordAction(User $user, Request $request)
    {
        $this->get('innova_voter')->isAllowed('right.editpassworduser');

        if ($request->isMethod('POST')) {
            $um = $this->get('fos_user.user_manager');
            $user->setPlainPassword($request->request->get('passwd'));
            $um->updateUser($user, true);

            $this->get('session')->getFlashBag()->set('info', 'Le mot de passe a bien été modifié');

            return $this->redirect($this->generateUrl('admin_user_show', array('id' => $user->getId())));
        }

        return array('user' => $user);
    }

    /**
     * @Route("/user/self_display", name="self_user_display")
     * @Method("GET")
     * @Template("InnovaSelfBundle:User:show.html.twig")
     */
    public function selfDisplayAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return array(
            'user' => $user,
        );
    }

    /**
     * @Route("/user/self-edit", name="self_user_edit")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:User:new.html.twig")
     */
    public function selfEditAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->get('self.user.manager')->handleForm($user, $request);

        if (!$form) {
            $this->get('session')->getFlashBag()->set('info', 'Les informations ont bien été modifiées');

            return $this->redirect($this->generateUrl('self_user_display'));
        }

        return array('form' => $form->createView(), 'user' => $user);
    }

    /**
     * @Route("/user/all/rights", name="get_users_for_rights", options={"expose"=true})
     * @Method("GET")
     */
    public function getUserForRights(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $request->query->get('q');
        $users = $em->getRepository('InnovaSelfBundle:User')->getBySomethingLike($query);

        return new JsonResponse(array('users' => $users));
    }
}
