<?php
namespace Innova\SelfBundle\Controller\Features;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Right\Right;

/**
 * Test controller.
 *
 * @Route("/admin/users")
 * @ParamConverter("user", isOptional="true", class="InnovaSelfBundle:User", options={"id" = "userId"})
 * @ParamConverter("right", isOptional="true", class="InnovaSelfBundle:Right\Right", options={"id" = "rightId"})
 */
class AdminUserController extends Controller
{
    /**
     * Lists all Test entities.
     *
     * @Route("/", name="admin_user")
     * @Method("GET")
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
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="admin_user_show")
     * @Method("GET")
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
     * @Route("/delete-test-trace/user/{userId}/test/{testId}", name="delete-test-trace")
     * @Method("DELETE")
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
     * @Route("/delete-task-trace/user/{userId}/test/{testId}/questionnaire/{questionnaireId}", name="delete-task-trace")
     * @Method("DELETE")
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
     * @Route("/delete-user/{userId}", name="delete-user")
     * @Method("DELETE")
     */
    public function deleteUserAction($userId)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.deleteuser", $currentUser)) {
            $em = $this->getDoctrine()->getManager();

            $user = $em->getRepository('InnovaSelfBundle:User')->find($userId);
            if ($this->get("self.user.manager")->deleteUser($user)) {
                $this->get('session')->getFlashBag()->set('success', "L'utilisateur a bien été supprimé.");
            }

            return $this->redirect($this->generateUrl('admin_user'));
        }

        return;
    }

     /**
     *
     * @Route("/user/create", name="user_create")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Features:AdminUser/new.html.twig")
     */
    public function newAction(Request $request)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.createuser", $currentUser)) {
            $user = new User();

            $form = $this->get("self.user.manager")->handleForm($user, $request);
            if (!$form) {
                $this->get("session")->getFlashBag()->set('info', "L'utilisateur a bien été créée");

                return $this->redirect($this->generateUrl('admin_user_show', array('id' => $user->getId())));
            }

            return array('form' => $form->createView());
        }

        return;
    }

    /**
     *
     * @Route("/user/{userId}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Features:AdminUser/new.html.twig")
     */
    public function editAction(User $user, Request $request)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.edituser", $currentUser)) {
            $form = $this->get("self.user.manager")->handleForm($user, $request);

            if (!$form) {
                $this->get("session")->getFlashBag()->set('info', "L'utilisateur a bien été modifié");

                return $this->redirect($this->generateUrl('admin_user_show', array('id' => $user->getId())));
            }

            return array('form' => $form->createView(), 'user' => $user);
        }

        return;
    }

    /**
     *
     * @Route("/user/{userId}/passwd", name="passwd_edit")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Features:AdminUser/passwd.html.twig")
     */
    public function editPasswordAction(User $user, Request $request)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.editpassworduser", $currentUser)) {
            if ($request->isMethod('POST')) {
                $password = $request->request->get('passwd');
                $user->setPlainPassword($password);
                $this->get("session")->getFlashBag()->set('info', "Le mot de passe a bien été modifié");

                return $this->redirect($this->generateUrl('admin_user_show', array('id' => $user->getId())));
            }

            return array('user' => $user);
        }

        return;
    }

    /**
     *
     * @Route("/user/{userId}/edit_rights", name="admin_user_rights")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Features:AdminUser/rights.html.twig")
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
     * @Route("/user/{userId}/{rightId}", name="admin_user_toggle_right")
     * @Method({"GET"})
     * @Template("InnovaSelfBundle:Features:AdminUser/rights.html.twig")
     */
    public function toggleRight(User $user, Right $right)
    {
        $currentUser = $this->get('security.context')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.editrightsuser", $currentUser)) {
            $this->get("self.right.manager")->toggleRight($right, $user);
            $this->get("session")->getFlashBag()->set('info', "Les permissions ont bien été modifiées");

            return $this->redirect($this->generateUrl('admin_user_rights', array('userId' => $user->getId())));
        }

        return;
    }
}
