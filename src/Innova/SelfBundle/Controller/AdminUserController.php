<?php
namespace Innova\SelfBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Form\UserType;
use Innova\SelfBundle\Entity\Test;

/**
 * Test controller.
 *
 * @Route("/admin/users")
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

        $entities = $em->getRepository('InnovaSelfBundle:User')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Admin User entity.
     *
     * @Route("/{id}", name="admin_user_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
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
            'user'   => $user
        );
    }


    /**
     * Delete trace for a given user and a given test
     *
     * @Route("/delete-test-trace/user/{userId}/test/{testId}", name="delete-test-trace")
     * @Method("DELETE")
     */
    public function deleteTestTraceAction($userId, $testId)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('InnovaSelfBundle:User')->find($userId);
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);

        if($this->get("self.trace.manager")->deleteTestTrace($user, $test)){
            $this->get('session')->getFlashBag()->set('success', 'Les traces de cet utilisateur pour le test '.$test->getName().' ont été supprimées');
        }

        return $this->redirect($this->generateUrl('admin_user_show', array('id' => $userId)));
    }

    /**
     * Delete trace for a given user and a given test
     *
     * @Route("/delete-task-trace/user/{userId}/test/{testId}/questionnaire/{questionnaireId}", name="delete-task-trace")
     * @Method("DELETE")
     */
    public function deleteTaskTraceAction($userId, $testId, $questionnaireId)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('InnovaSelfBundle:User')->find($userId);
        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);
        $questionnaire = $em->getRepository('InnovaSelfBundle:Questionnaire')->find($questionnaireId);

        if($this->get("self.trace.manager")->deleteTaskTrace($user, $test, $questionnaire)){
            $this->get('session')->getFlashBag()->set('success', 'Les traces de cet utilisateur pour la tâche '.$questionnaire->getTheme().' ont été supprimées');
        }

        return $this->redirect($this->generateUrl('admin_user_show', array('id' => $userId)));
    }

    /**
     * Delete trace for a given user and a given test
     *
     * @Route("/delete-user/{userId}", name="delete-user")
     * @Method("DELETE")
     */
    public function deleteUserAction($userId)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('InnovaSelfBundle:User')->find($userId);
        if($this->get("self.user.manager")->deleteUser($user)){
            $this->get('session')->getFlashBag()->set('success', "L'utilisateur a bien été supprimé.");
        }

        return $this->redirect($this->generateUrl('admin_user'));
    }
}
