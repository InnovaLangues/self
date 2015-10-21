<?php

namespace Innova\SelfBundle\Controller\Institution;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Institution\Institution;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Course controller.
 *
 * @Route("", service="innova_course")
 * @ParamConverter("institution", isOptional="true", class="InnovaSelfBundle:Institution\Institution", options={"id"="institutionId"})
 */
class CourseController
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * List courses for an institution
     *
     * @Route("/anonymous/institution/{{institutionId}}/courses", name="findCoursesByInstitution", options={"expose"=true})
     * @Method("POST")
     */
    public function selectCoursesAction(Institution $institution)
    {
        $courses = $this->entityManager->getRepository('InnovaSelfBundle:Institution\Course')->findByInstitution($institution, array('name'=>'asc'));

        return new JsonResponse($courses);
    }
}
