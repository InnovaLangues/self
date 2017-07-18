<?php

namespace Innova\SelfBundle\Controller\Institution;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Innova\SelfBundle\Entity\Institution\Course;
use Innova\SelfBundle\Entity\Institution\Institution;
use Innova\SelfBundle\Form\Type\CourseEditType;

/**
 * Course controller.
 *
 * @Route("", service="innova_course")
 * @ParamConverter("institution", isOptional="true", class="InnovaSelfBundle:Institution\Institution", options={"id"="institutionId"})
 */
class CourseController
{
    protected $entityManager;
    protected $voter;
    protected $router;
    protected $formFactory;
    protected $session;

    public function __construct($entityManager, $voter, $router, $formFactory, $session)
    {
        $this->entityManager = $entityManager;
        $this->voter = $voter;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->session = $session;
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

    /**
     * List subcourses for a course
     *
     * @Route("/anonymous/institution/{{courseId}}/subcourses", name="findSubcoursesByCourse", options={"expose"=true})
     * @ParamConverter("course", class="InnovaSelfBundle:Institution\Course", options={"id" = "courseId"})
     * @Method("POST")
     */
    public function selectSubcoursesAction(Course $course)
    {
        $subcourses = $this->entityManager->getRepository('InnovaSelfBundle:Institution\Subcourse')->findByCourse($course, array('name'=>'asc'));

        return new JsonResponse($subcourses);
    }

    /**
     * List subcourse.
     *
     * @Route("/course/{courseId}", name="course_list_subcourse")
     * @ParamConverter("course", class="InnovaSelfBundle:Institution\Course", options={"id" = "courseId"})
     * @Method({"GET"})
     * @Template("InnovaSelfBundle:Institution:course.html.twig")
     */
    public function viewCourseAction(Course $course)
    {
        $this->voter->isAllowed('right.institution');

        return array('course' => $course);
    }

    /**
     * @Route("/course/{courseId}/edit", name="course_edit")
     * @ParamConverter("course", class="InnovaSelfBundle:Institution\Course", options={"id" = "courseId"})
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Institution:subcourse.html.twig")
     */
    public function editCourseAction(Course $course, Request $request)
    {
        $this->voter->isAllowed('right.institution');

        $form = $this->handleForm($course, $request);
        if (!$form) {
            $this->session->getFlashBag()->set('info', "La filère a bien été modifiée");

            return new RedirectResponse($this->router->generate('institution_view', ["institutionId"=> $course->getInstitution()->getId()]));
        }

        return array('form' => $form->createView(), 'course' => $course);
    }

    /**
     * Handles institution form.
     *
     * @param Request $request
     */
    private function handleForm(Course $course, Request $request)
    {
        $form = $this->formFactory->createBuilder(new CourseEditType, $course)->getForm();

        $subcourses = new ArrayCollection();
        foreach ($course->getSubcourses() as $subcourse) {
            $subcourses->add($subcourse);
        }

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->entityManager;

                foreach ($subcourses as $subcourse) {
                    if ($course->getSubcourses()->contains($subcourse) === false) {
                        $em->remove($subcourse);
                    }
                }

                foreach ($course->getSubcourses() as $subcourse) {
                    $subcourse->setCourse($course);
                }

                $em->persist($course);
                $em->flush();

                return;
            }
        }

        return $form;
    }
}
