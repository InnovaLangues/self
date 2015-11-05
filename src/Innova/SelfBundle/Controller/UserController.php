<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\User;

/**
 * User controller.
 *
 * @ParamConverter("user", isOptional="true", class="InnovaSelfBundle:User", options={"id" = "userId"})
 */
class UserController extends Controller
{
    /**
     * Lists all users.
     *
     * @Route("/admin/users/", name="admin_user")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $userRepo = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:User');
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $users = ($this->get('self.right.manager')->checkRight('right.listuser', $currentUser))
            ? $userRepo->findAllLight()
            : $userRepo->findAuthorized($currentUser);

        return array(
            'entities' => $users,
            'subset' => 'user.all',
        );
    }

    /**
     * Lists connected users.
     *
     * @Route("/admin/users/connected", name="admin_users_connected")
     * @Method("GET")
     * @Template("InnovaSelfBundle:User:index.html.twig")
     */
    public function connectedAction()
    {
        $this->get('innova_voter')->isAllowed('right.listuser');

        $connectedUsers = $this->get('self.user.manager')->getConnected();

        return array(
            'entities' => $connectedUsers,
            'subset' => 'user.connected',
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
        $tests = $em->getRepository('InnovaSelfBundle:Test')->findAll();
        $testsWithTraces = array();

        foreach ($tests as $test) {
            $count = $em->getRepository('InnovaSelfBundle:Questionnaire')->countDoneYetByUserByTest($test->getId(), $user->getId());
            $questionnaires = $em->getRepository('InnovaSelfBundle:Questionnaire')->getQuestionnairesDoneYetByUserByTest($test->getId(), $user->getId());
            if ($count > 0) {
                $testsWithTraces[] = array($test, $count, $questionnaires);
            }
        }

        return array(
            'tests' => $testsWithTraces,
            'user' => $user,
        );
    }

    /**
     * Delete trace for a given user and a given test.
     *
     * @Route("/admin/user/{userId}/test/{testId}/delete-trace", name="delete-test-trace")
     * @Method("DELETE")
     */
    public function deleteTestTraceAction($userId, $testId)
    {
        $this->get('innova_voter')->isAllowed('right.deletetraceuser');

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('InnovaSelfBundle:User')->find($userId);
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);

        if ($this->get('self.trace.manager')->deleteTestTrace($user, $test)) {
            $this->get('session')->getFlashBag()->set('success', 'Les traces de cet utilisateur pour le test '.$test->getName().' ont été supprimées');
        }

        return $this->redirect($this->generateUrl('admin_user_show', array('id' => $userId)));
    }

    /**
     * Delete trace for a given user and a given test.
     *
     * @Route("/admin/user/{userId}/test/{testId}/questionnaire/{questionnaireId}/delete-trace", name="delete-task-trace")
     * @Method("DELETE")
     */
    public function deleteTaskTraceAction($userId, $testId, $questionnaireId)
    {
        $this->get('innova_voter')->isAllowed('right.deletetraceuser');

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('InnovaSelfBundle:User')->find($userId);
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);

        if ($this->get('self.trace.manager')->deleteTaskTrace($user, $test, $questionnaire)) {
            $this->get('session')->getFlashBag()->set('success', 'Les traces de cet utilisateur pour la tâche '.$questionnaire->getTheme().' ont été supprimées');
        }

        return $this->redirect($this->generateUrl('admin_user_show', array('id' => $userId)));
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

        return $this->redirect($this->generateUrl('admin_user'));
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
}
