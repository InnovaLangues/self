<?php

namespace Innova\SelfBundle\Controller;

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
use Symfony\Component\HttpFoundation\Response;

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
     *
     * @Route("/sessions/active/{isActive}", name="editor_sessions_active")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Session:list.html.twig")
     */
    public function listByActivityAction($isActive)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        $sessionRepository = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Session');

        if ($this->get("self.right.manager")->checkRight("right.listsession", $currentUser)) {
            if ($currentUser->getPreferedLanguage()) {
                $sessions = $sessionRepository->findByLanguageByActivity($currentUser->getPreferedLanguage(), $isActive);
            } else {
                $sessions = $sessionRepository->findBy(array("actif" => $isActive), array("name" => "ASC"));
            }
        } else {
            $sessions = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Session')->findAllAuthorizedByActivity($currentUser, $isActive);
        }

        $subset = (!$isActive) ? "editor.session.inactives" : "editor.session.actives";

        return array("sessions" => $sessions, "subset" => $subset);
    }

    /**
     *
     * @Route("/test/{testId}/sessions", name="editor_test_sessions")
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Session:list.html.twig")
     */
    public function listByTestAction(Test $test)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.listsession", $currentUser, $test)) {
            $sessions = $test->getSessions();
        } else {
            $sessions = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Session')->findAuthorized($test, $currentUser);
        }

        return array("test" => $test, "sessions" => $sessions);
    }

    /**
     *
     * @Route("/test/{testId}/session/create", name="editor_test_create_session")
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:Session:new.html.twig")
     */
    public function createSessionAction(Test $test, Request $request)
    {
        $this->get("innova_voter")->isAllowed("right.createsession");

        $session = new Session();
        $session->setName('Nouvelle session');
        $session->setActif(false);
        $session->setTest($test);

        $form = $this->handleForm($session, $request);
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
     *
     * @Template("InnovaSelfBundle:Session:list.html.twig")
     */
    public function deleteSessionAction(Session $session)
    {
        $this->get("innova_voter")->isAllowed("right.deletesession", $session);

        $em = $this->getDoctrine()->getManager();
        $em->remove($session);
        $em->flush();

        $this->get("session")->getFlashBag()->set('info', "La session a bien été supprimée");
        $testId = $session->getTest()->getId();

        return $this->redirect($this->generateUrl('editor_test_sessions', array('testId' => $testId)));

    }

    /**
     *
     * @Route("/test/{testId}/session/{sessionId}/edit", name="editor_test_edit_session")
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:Session:new.html.twig")
     */
    public function editSessionAction(Test $test, Session $session, Request $request)
    {
        $this->get("innova_voter")->isAllowed("right.editsession", $session);

        $form = $this->handleForm($session, $request);
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
     *
     * @Template("InnovaSelfBundle:Session:results.html.twig")
     */
    public function getSessionResultsAction(Session $session)
    {
        $this->get("innova_voter")->isAllowed("right.individualresultssession", $session);

        $users = $this->getDoctrine()->getManager()->getRepository("InnovaSelfBundle:User")->findBySession($session);

        return array('session' => $session, 'users' => $users);
    }

    /**
     *
     * @Route("/user/{userId}/session/{sessionId}/results", name="editor_session_user_results")
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Session:userResults.html.twig")
     */
    public function getUserResultsAction(User $user, Session $session)
    {
        $this->get("innova_voter")->isAllowed("right.individualresultssession", $session);

        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        $sm = $this->get("self.score.manager");
        $levelFeedback = $sm->getGlobalLevelFromThreshold($session, $user);
        $eecFeedback = $sm->getSkillLevelFromThreshold($session, $user, "EEC");
        $coFeedback = $sm->getSkillLevelFromThreshold($session, $user, "CO");
        $ceFeedback = $sm->getSkillLevelFromThreshold($session, $user, "CE");
        $score = $sm->calculateScoreByTest($session->getTest(), $session, $user);

        return array(
            "score"         => $score,
            "session"       => $session,
            "levelFeedback" => $levelFeedback,
            "coFeedback"    => $coFeedback,
            "ceFeedback"    => $ceFeedback,
            "eecFeedback"   => $eecFeedback,
            "user"          => $user,
        );
    }

    /**
     *
     * @Route("/session/{sessionId}/export", name="editor_session_export_results")
     * @Method("GET")
     *
     */
    public function exportAction(Session $session)
    {
        $this->get("innova_voter")->isAllowed("right.exportresultssession", $session);

        $filename = $this->get("self.export.manager")->exportSession($session);
        $file = $this->get('kernel')->getRootDir()."/data/session/".$session->getId()."/".$filename;

        $response = new Response();
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($file));
        $response->headers->set('Content-Disposition', 'attachment; filename="'.basename($file).'";');
        $response->headers->set('Content-length', filesize($file));
        $response->sendHeaders();

        $response->setContent(file_get_contents($file));

        return $response;
    }

    /**
     *
     * @Route("/session/{sessionId}/export", name="editor_session_export_results_dates", options = {"expose"=true})
     * @Method("POST")
     *
     */
    public function exportByDatesAction(Request $request, Session $session)
    {
        $this->get("innova_voter")->isAllowed("right.exportresultssession", $session);

        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');
        $filename = $this->get("self.export.manager")->exportSession($session, $startDate, $endDate);
        $file = $this->get('kernel')->getRootDir()."/data/session/".$session->getId()."/".$filename;
        $response = new Response();
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($file));
        $response->headers->set('Content-Disposition', 'attachment; filename="'.basename($file).'";');
        $response->headers->set('Content-length', filesize($file));
        $response->sendHeaders();

        $response->setContent(file_get_contents($file));

        return $response;
    }

    /**
     *
     * @Route("/test/{testId}/create-session", name="create_session_for_export")
     * @Method("POST")
     *
     */
    public function createSessionForExportAction(Test $test)
    {
        if ($test->getSessions()->isEmpty()) {
            $em = $this->getDoctrine()->getManager();

            $session = new Session();
            $session->setName('Session '.$test->getId());
            $session->setActif(false);
            $session->setTest($test);
            $session->setPasswd("passwd");

            $em->persist($session);
            $em->flush();

            $test->addSession($session);
            $em->persist($test);
            $em->flush();

            $traces = $em->getRepository("InnovaSelfBundle:Trace")->findBy(array("session" => null, "test" => $test));

            foreach ($traces as $trace) {
                $trace->setSession($session);
                $em->persist($trace);
            }

            $em->flush();
        }

        $this->get("session")->getFlashBag()->set('info', "La session a bien été créée à partir des traces");

        return $this->redirect($this->generateUrl('csv-export-show', array('testId' => $test->getId(), 'tia' => 0)));
    }

    /**
     * Handles session form
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
