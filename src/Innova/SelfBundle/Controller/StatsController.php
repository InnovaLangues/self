<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
        $this->get('innova_voter')->isAllowed('right.generalParameters');

        return array();
    }

    /**
     * @Route("/stats/session/{isActive}", name="stats_sessions")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Stats:sessions.html.twig")
     */
    public function sessionsAction($isActive)
    {
        $this->get('innova_voter')->isAllowed('right.generalParameters');

        $sessions = $this->get('self.session.manager')->listSessionByActivity($isActive);

        $data_sessions = [];

        foreach ($sessions as $session) {
            $data_sessions[] = [
                'name' => $session->getName(),
                'test' => $session->getTest()->getName(),
                'language' => $session->getTest()->getLanguage()->getName(),
                'usercount' => count($this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:User')->findBySession($session)),
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
        $this->get('innova_voter')->isAllowed('right.generalParameters');

        $institutions = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Institution\Institution')->findAll();

        $data_institutions = [];

        foreach ($institutions as $institution) {
            $data_institutions[] = [
                'name' => $institution->getName(),
                'id' => $institution->getId(),
                'usercount' => count($this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:User')->findByInstitution($institution)),
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
        $this->get('innova_voter')->isAllowed('right.generalParameters');

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
