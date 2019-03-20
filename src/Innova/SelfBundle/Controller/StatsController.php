<?php

namespace Innova\SelfBundle\Controller;

use Innova\SelfBundle\Entity\Session;
use Innova\SelfBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Innova\SelfBundle\Entity\Institution\Institution;

/**
 * PhasedTest controller.
 *
 * @Route("/admin")
 * @ParamConverter("institution", isOptional="true", class="InnovaSelfBundle:Institution\Institution", options={"id" = "institutionId"})
 */
class StatsController extends Controller
{
    /**
     * @Route("/stats", name="stats")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Stats:index.html.twig")
     */
    public function indexAction()
    {
        $this->get('innova_voter')->isAllowed('right.stats');

        return array();
    }

    /**
     * @Route("/stats/sessions/{isActive}", name="stats_sessions")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Stats:sessions.html.twig")
     */
    public function sessionsAction($isActive): array
    {
        $this->get('innova_voter')->isAllowed('right.stats');

        /**
         * @var Session[] $sessions
         */
        $sessions = $this->get('self.session.manager')->listSessionByActivity($isActive);

        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository(User::class);

        $stats = [];

        foreach ($sessions as $session) {
            $stats[] = [
                'name' => $session->getName(),
                'test' => $session->getTest()->getName(),
                'language' => $session->getTest()->getLanguage()->getName(),
                'userCount' => $userRepository->countBySession($session),
                'todayUserCount' => $userRepository->countBySession($session, new \DateTime('midnight'))
            ];
        }

        return ['stats' => $stats];
    }

    /**
     * @Route("/stats/sessions", name="stats_sessions_by_date")
     * @Method("POST")
     * @Template("InnovaSelfBundle:Stats:sessions.html.twig")
     */
    public function sessionsByDateAction(Request $request)
    {
        $this->get('innova_voter')->isAllowed('right.stats');

        $sessionType = $request->get('session_type');
        if ($sessionType == 'all') {
            $sessions = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Session')->findAll();
        } else {
            $activity = ($sessionType == 'active') ? 1 : 0;
            $sessions = $this->get('self.session.manager')->listSessionByActivity($activity);
        }

        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');

        $format = 'Y-m-d H:i:s';

        $startDate = (!$startDate)
            ? date_create_from_format($format, '1970-01-01 00:00:00')
            : date_create_from_format($format, $startDate);

        $endDate = (!$endDate)
            ? date($format)
            : date_create_from_format($format, $endDate);

        $data_sessions = [];

        foreach ($sessions as $session) {
            $data_sessions[] = [
                'name' => $session->getName(),
                'test' => $session->getTest()->getName(),
                'language' => $session->getTest()->getLanguage()->getName(),
                'usercount' => count($this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:User')->findLightBySessionAndDates($session, $startDate, $endDate)),
            ];
        }

        return array('data_sessions' => $data_sessions);
    }

    /**
     * @Route("/stats/institutions", name="stats_institutions")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Stats:institutions.html.twig")
     */
    public function institutionsAction()
    {
        $this->get('innova_voter')->isAllowed('right.stats');

        $institutions = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Institution\Institution')->findAll();

        $data_institutions = [];

        foreach ($institutions as $institution) {
            $data_institutions[] = [
                'name' => $institution->getName(),
                'id' => $institution->getId(),
                'usercount' => count($this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:User')->findLightByInstitution($institution)),
            ];
        }

        return array('data_institutions' => $data_institutions);
    }

    /**
     * @Route("/stats/courses/{institutionId}", name="stats_courses")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Stats:courses.html.twig")
     */
    public function coursesAction(Institution $institution)
    {
        $this->get('innova_voter')->isAllowed('right.stats');

        $courses = $institution->getCourses();

        $data_courses = [];

        foreach ($courses as $course) {
            $data_courses[] = [
                'name' => $course->getName(),
                'usercount' => count($this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:User')->findByCourse($course)),
            ];
        }

        return [
            'institution' => $institution,
            'data_courses' => $data_courses,
        ];
    }
}
