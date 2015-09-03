<?php
namespace Innova\SelfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Right\Right;
use FOS\HttpCacheBundle\Configuration\InvalidateRoute;

/**
 * User controller.
 *
 * @ParamConverter("user", isOptional="true", class="InnovaSelfBundle:User", options={"id" = "userId"})
 * @ParamConverter("right", isOptional="true", class="InnovaSelfBundle:Right\Right", options={"id" = "rightId"})
 */
class UserController extends Controller
{
    /**
     * Lists all users
     *
     * @Route("/admin/users/", name="admin_user")
     * @Method("GET")
     *
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.listuser", $currentUser)) {
            $entities = $em->getRepository('InnovaSelfBundle:User')->findAll();
        } else {
            $entities = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:User')->findAuthorized($currentUser);
        }

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all users
     *
     * @Route("/admin/users/connected", name="admin_users_connected")
     * @Method("GET")
     * @Template()
     */
    public function connectedAction()
    {
        $em = $this->getDoctrine()->getManager();
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.listuser", $currentUser)) {
            $connectedUsers = $this->get('self.user.manager')->getConnected();
        }

        return array(
            'connectedUsers' => $connectedUsers,
        );
    }

    /**
     * Displays a user entity.
     *
     * @Route("/admin/user/{id}", name="admin_user_show", requirements={"id": "\d+"})
     * @Method("GET")
     *
     * @Template()
     */
    public function showAction($id)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.listuser", $currentUser)) {
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
                'tests'  => $testsWithTraces,
                'user'   => $user,
            );
        }

        return;
    }

    /**
     * Delete trace for a given user and a given test
     *
     * @Route("/admin/user/{userId}/test/{testId}/delete-trace", name="delete-test-trace")
     * @Method("DELETE")
     *
     */
    public function deleteTestTraceAction($userId, $testId)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.deletetraceuser", $currentUser)) {
            $em = $this->getDoctrine()->getManager();

            $user = $em->getRepository('InnovaSelfBundle:User')->find($userId);
            $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);

            if ($this->get("self.trace.manager")->deleteTestTrace($user, $test)) {
                $this->get('session')->getFlashBag()->set('success', 'Les traces de cet utilisateur pour le test '.$test->getName().' ont été supprimées');
            }

            return $this->redirect($this->generateUrl('admin_user_show', array('id' => $userId)));
        }

        return;
    }

    /**
     * Delete trace for a given user and a given test
     *
     * @Route("/admin/user/{userId}/test/{testId}/questionnaire/{questionnaireId}/delete-trace", name="delete-task-trace")
     * @Method("DELETE")
     *
     */
    public function deleteTaskTraceAction($userId, $testId, $questionnaireId)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.deletetraceuser", $currentUser)) {
            $em = $this->getDoctrine()->getManager();

            $user = $em->getRepository('InnovaSelfBundle:User')->find($userId);
            $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);
            $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);

            if ($this->get("self.trace.manager")->deleteTaskTrace($user, $test, $questionnaire)) {
                $this->get('session')->getFlashBag()->set('success', 'Les traces de cet utilisateur pour la tâche '.$questionnaire->getTheme().' ont été supprimées');
            }

            return $this->redirect($this->generateUrl('admin_user_show', array('id' => $userId)));
        }

        return;
    }

    /**
     * Delete trace for a given user and a given test
     *
     * @Route("/admin/user/{userId}/delete", name="delete-user")
     * @Method("DELETE")
     *
     */
    public function deleteUserAction($userId)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.deleteuser", $currentUser)) {
            $em = $this->getDoctrine()->getManager();

            $user = $em->getRepository('InnovaSelfBundle:User')->find($userId);
            if ($this->get("self.user.manager")->deleteUser($user)) {
                $this->get('session')->getFlashBag()->set('success', "L'utilisateur a bien été supprimé.");

                $cacheManager = $this->get('fos_http_cache.cache_manager');
                $cacheManager->invalidateRoute('admin_user');
            }

            return $this->redirect($this->generateUrl('admin_user'));
        }

        return;
    }

     /**
     *
     * @Route("/admin/user/create", name="user_create")
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:User:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.createuser", $currentUser)) {
            $user = new User();

            $form = $this->get("self.user.manager")->handleForm($user, $request);
            if (!$form) {
                $this->get("session")->getFlashBag()->add('info', "L'utilisateur a bien été créée");

                $cacheManager = $this->get('fos_http_cache.cache_manager');
                $cacheManager->invalidateRoute('admin_user');

                return $this->redirect($this->generateUrl('admin_user_show', array('id' => $user->getId())));
            }

            return array('form' => $form->createView());
        }

        return;
    }

    /**
     *
     * @Route("/admin/user/{userId}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:User:new.html.twig")
     */
    public function editAction(User $user, Request $request)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.edituser", $currentUser)) {
            $form = $this->get("self.user.manager")->handleForm($user, $request);

            if (!$form) {
                $this->get("session")->getFlashBag()->set('info', "L'utilisateur a bien été modifié");

                $cacheManager = $this->get('fos_http_cache.cache_manager');
                $cacheManager->invalidateRoute('admin_user');

                return $this->redirect($this->generateUrl('admin_user_show', array('id' => $user->getId())));
            }

            return array('form' => $form->createView(), 'user' => $user);
        }

        return;
    }

    /**
     *
     * @Route("/admin/user/{userId}/change-passwd", name="passwd_edit")
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:User:passwd.html.twig")
     */
    public function editPasswordAction(User $user, Request $request)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.editpassworduser", $currentUser)) {
            if ($request->isMethod('POST')) {
                $um = $this->get('fos_user.user_manager');
                $user->setPlainPassword($request->request->get('passwd'));
                $um->updateUser($user, true);

                $this->get("session")->getFlashBag()->set('info', "Le mot de passe a bien été modifié");

                return $this->redirect($this->generateUrl('admin_user_show', array('id' => $user->getId())));
            }

            return array('user' => $user);
        }

        return;
    }

    /**
     *
     * @Route("/admin/user/{userId}/edit-rights", name="admin_user_rights")
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:User:rights.html.twig")
     */
    public function displayRightsAction(User $user)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.editrightsuser", $currentUser)) {
            $em = $this->getDoctrine()->getManager();

            $groups = $em->getRepository('InnovaSelfBundle:Right\RightGroup')->findAll();

            return array('groups' => $groups, 'user' => $user);
        }

        return;
    }

    /**
     *
     * @Route("/admin/user/{userId}/right/{rightId}", name="admin_user_toggle_right")
     * @Method({"GET"})
     *
     * @Template("InnovaSelfBundle:User:rights.html.twig")
     */
    public function toggleRightAction(User $user, Right $right)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.editrightsuser", $currentUser)) {
            $this->get("self.right.manager")->toggleRight($right, $user);
            $this->get("session")->getFlashBag()->set('info', "Les permissions ont bien été modifiées");

            return $this->redirect($this->generateUrl('admin_user_rights', array('userId' => $user->getId())));
        }

        return;
    }

    /**
     * @Route("/user/self_display", name="self_user_display")
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:User:show.html.twig")
     */
    public function selfDisplayAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        return array(
            'user'   => $user,
        );
    }

    /**
     * @Route("/user/self-edit", name="self_user_edit")
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:User:new.html.twig")
     */
    public function selfEditAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->get("self.user.manager")->handleForm($user, $request);

        if (!$form) {
            $this->get("session")->getFlashBag()->set('info', "Les informations ont bien été modifiées");

            return $this->redirect($this->generateUrl('self_user_display'));
        }

        return array('form' => $form->createView(), 'user' => $user);
    }
}
