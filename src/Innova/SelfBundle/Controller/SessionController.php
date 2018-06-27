<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Session;
use Innova\SelfBundle\Form\Type\SessionType;
use Innova\SelfBundle\Entity\User;

/**
 * Session controller.
 *
 * @Route("/admin")
 * @ParamConverter("test", isOptional="true", class="InnovaSelfBundle:Test",  options={"id" = "testId"})
 * @ParamConverter("session", isOptional="true", class="InnovaSelfBundle:Session", options={"id" = "sessionId"})
 * @ParamConverter("user", isOptional="true", class="InnovaSelfBundle:User", options={"id" = "userId"})
 */
class SessionController extends Controller
{
    /**
     * @Route("/sessions/active/{isActive}", name="editor_sessions_active")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Session:list.html.twig")
     */
    public function listByActivityAction($isActive)
    {
        $sessions = $this->get('self.session.manager')->listSessionByActivity($isActive);
        $subset = (!$isActive) ? 'editor.session.inactives' : 'editor.session.actives';

        return array('sessions' => $sessions, 'subset' => $subset);
    }

    /**
     * @Route("/test/{testId}/sessions", name="editor_test_sessions")
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Session:list.html.twig")
     */
    public function listByTestAction(Test $test)
    {
        $sessions = $this->get('self.session.manager')->listSessionByTest($test);

        return array('test' => $test, 'sessions' => $sessions, 'subset' => 'pour '.$test->getName());
    }

    /**
     * @Route("/test/{testId}/session/create", name="editor_test_create_session")
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:Session:new.html.twig")
     */
    public function createSessionAction(Test $test, Request $request)
    {
        $this->get('innova_voter')->isAllowed('right.createsession');

        $session = $this->get('self.session.manager')->createSession($test, 'Nouvelle session', false, '', false);

        $form = $this->handleForm($session, $request);
        if (!$form) {
            $this->get('session')->getFlashBag()->set('info', 'La session a bien été créée');

            return $this->redirect($this->generateUrl('editor_test_sessions', array('testId' => $test->getId())));
        }

        return array('form' => $form->createView(), 'test' => $test);
    }

    /**
     * @Route("/session/{sessionId}/remove", name="editor_test_delete_session", options = {"expose"=true})
     * @Method("DELETE")
     *
     * @Template("InnovaSelfBundle:Session:list.html.twig")
     */
    public function deleteSessionAction(Session $session)
    {
        $this->get('innova_voter')->isAllowed('right.deletesession', $session);

        $testId = $session->getTest()->getId();
        $this->get('self.session.manager')->deleteSession($session);

        return $this->redirect($this->generateUrl('editor_test_sessions', array('testId' => $testId)));
    }

    /**
     * @Route("/test/{testId}/session/{sessionId}/edit", name="editor_test_edit_session")
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:Session:new.html.twig")
     */
    public function editSessionAction(Test $test, Session $session, Request $request)
    {
        $this->get('innova_voter')->isAllowed('right.editsession', $session);

        $form = $this->handleForm($session, $request);
        if (!$form) {
            $this->get('session')->getFlashBag()->set('info', 'La session a bien été modifiée');

            return $this->redirect($this->generateUrl('editor_test_sessions', array('testId' => $test->getId())));
        }

        return array('form' => $form->createView(), 'test' => $test);
    }

    /**
     * @Route("/session/{sessionId}/invalidate-results", name="editor_test_invalidate_results_session")
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Session:new.html.twig")
     */
    public function invalidateResultsAction(Session $session)
    {
        $this->get('innova_voter')->isAllowed('right.individualresultssession', $session);

        $this->get('self.session.manager')->invalidateResults($session);

        return $this->redirect($this->generateUrl('editor_test_session_results', array('sessionId' => $session->getId())));
    }

    /**
     * @Route("/session/{sessionId}/user/{userId}/invalidate-results", name="editor_test_invalidate_results_session_user")
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Session:new.html.twig")
     */
    public function invalidateUserResultsAction(Session $session, User $user)
    {
        $this->get('innova_voter')->isAllowed('right.individualresultssession', $session);

        $this->get('self.session.manager')->invalidateUserResults($session, $user);

        return $this->redirect($this->generateUrl('editor_test_session_results', array('sessionId' => $session->getId())));
    }

    /**
     * @Route("/session/{sessionId}/results", name="editor_test_session_results")
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Session:results.html.twig")
     */
    public function getSessionResultsAction(Session $session)
    {
        $this->get('innova_voter')->isAllowed('right.individualresultssession', $session);

        $users = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:User')->findBySession($session);

        return array('session' => $session, 'users' => $users);
    }

    /**
     * @Route("/user/{userId}/session/{sessionId}/results", name="editor_session_user_results")
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Session:userResults.html.twig")
     */
    public function getUserResultsAction(User $user, Session $session)
    {
        $this->get('innova_voter')->isAllowed('right.individualresultssession', $session);

        $sm = $this->get('self.score.manager');
        $levelFeedback = $sm->getGlobalScore($session, $user);
        $eecFeedback = $sm->getSkillScore($session, $user, 'EEC');
        $coFeedback = $sm->getSkillScore($session, $user, 'CO');
        $ceFeedback = $sm->getSkillScore($session, $user, 'CE');
        $score = $sm->calculateScoreByTest($session->getTest(), $session, $user);

        return array(
            'score' => $score,
            'session' => $session,
            'levelFeedback' => $levelFeedback,
            'coFeedback' => $coFeedback,
            'ceFeedback' => $ceFeedback,
            'eecFeedback' => $eecFeedback,
            'user' => $user,
        );
    }

    /**
     * @Route("/session/{sessionId}/export", name="editor_session_export_results")
     * @Method("GET")
     */
    public function exportAction(Session $session)
    {
        $this->get('innova_voter')->isAllowed('right.exportresultssession', $session);

        $filename = $this->get('self.export.manager')->exportSession($session);
        $file = $this->get('kernel')->getRootDir().'/data/session/'.$session->getId().'/'.$filename;

        $response = $this->get('self.export.manager')->generateResponse($file);

        return $response;
    }

    /**
     * @Route("/session/{sessionId}/export", name="editor_session_export_results_dates", options = {"expose"=true})
     * @Method("POST")
     */
    public function exportByDatesAction(Request $request, Session $session)
    {
        $this->get('innova_voter')->isAllowed('right.exportresultssession', $session);

        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');

        $filename = $this->get('self.export.manager')->exportSession($session, $startDate, $endDate);
        $file = $this->get('kernel')->getRootDir().'/data/session/'.$session->getId().'/'.$filename;

        $response = $this->get('self.export.manager')->generateResponse($file);

        return $response;
    }

    /**
     * Delete trace for a given user and a given session.
     *
     * @Route("/session/{sessionId}/user/{userId}/delete-trace", name="delete-session-user-trace")
     * @Method("GET")
     */
    public function deleteSessionUserTraceAction(User $user, Session $session)
    {
        $this->get('innova_voter')->isAllowed('right.deletetracesession', $session);

        if ($this->get('self.trace.manager')->deleteSessionTrace($user, $session)) {
            $this->get('session')->getFlashBag()->set('success', 'Les traces de l\'utilisateur '.$user->getUsername().' ont été supprimées');
        }

        return $this->redirect($this->generateUrl('editor_test_session_results', array('sessionId' => $session->getId())));
    }

    /**
     * @Route("/test/{testId}/create-session", name="create_session_for_export")
     * @Method("POST")
     */
    public function createSessionForExportAction(Test $test)
    {
        $this->get('self.session.manager')->createSessionforExport($test);

        return $this->redirect($this->generateUrl('csv-export-show', array('testId' => $test->getId(), 'tia' => 0)));
    }

    /**
     * @Route("/session/{sessionId}/infos", name="session_infos")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Session:infos.html.twig")
     */
    public function displayInfos(Session $session)
    {
        $users = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:User')->findLightBySession($session);
        $todayUsers = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:User')->findLightBySession($session, new \DateTime('midnight'));
        $lastTrace = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Trace')->getLastBySession($session);

        return [
            'session' => $session,
            'users' => $users,
            'todayUsers' => $todayUsers,
            'lastTrace' => $lastTrace
        ];
    }

    /**
     * Handles session form.
     *
     * @param Request $request
     */
    private function handleForm(Session $session, $request)
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
