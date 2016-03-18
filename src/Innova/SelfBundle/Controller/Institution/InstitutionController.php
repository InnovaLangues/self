<?php

namespace Innova\SelfBundle\Controller\Institution;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use Innova\SelfBundle\Form\Type\InstitutionType;
use Innova\SelfBundle\Entity\Institution\Institution;

/**
 * Institution controller.
 *
 * @Route("/admin", service="innova_institution")
 * @ParamConverter("institution", isOptional="true", class="InnovaSelfBundle:Institution\Institution", options={"id" = "institutionId"})
 */
class InstitutionController
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
     * List institutions.
     *
     * @Route("/institutions", name="institutions")
     * @Method({"GET"})
     * @Template("InnovaSelfBundle:Institution:list.html.twig")
     */
    public function listInstitutionAction()
    {
        $this->voter->isAllowed('right.institution');

        $institutions = $this->entityManager->getRepository('InnovaSelfBundle:Institution\Institution')->findBy(array(), array('name' => 'asc'));

        return array('institutions' => $institutions);
    }

    /**
     * List institutions.
     *
     * @Route("/institution/new", name="institution_create")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Institution:create.html.twig")
     */
    public function createInstitutionAction(Request $request)
    {
        $this->voter->isAllowed('right.institution');

        $institution = new Institution();
        $form = $this->handleForm($institution, $request);
        if (!$form) {
            $this->session->getFlashBag()->set('info', "L'institution a bien été créée");

            return new RedirectResponse($this->router->generate('institutions'));
        }

        return array('form' => $form->createView(), 'institution' => $institution);
    }

    /**
     * List institutions.
     *
     * @Route("/institution/{institutionId}", name="institution_view")
     * @Method({"GET"})
     * @Template("InnovaSelfBundle:Institution:view.html.twig")
     */
    public function viewInstitutionAction(Institution $institution)
    {
        $this->voter->isAllowed('right.institution');

        return array('institution' => $institution);
    }

    /**
     * Delete institutions.
     *
     * @Route("/institution/{institutionId}/delete", name="institution_delete")
     * @Method("DELETE")
     */
    public function deleteInstitutionAction(Institution $institution)
    {
        $this->voter->isAllowed('right.institution');

        $em = $this->entityManager;
        $em->remove($institution);
        $em->flush();
        $this->session->getFlashBag()->set('info', "L'institution a bien été supprimée");

        return new RedirectResponse($this->router->generate('institutions'));
    }

    /**
     * List institutions.
     *
     * @Route("/institution/{institutionId}/edit", name="institution_edit")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Institution:create.html.twig")
     */
    public function editInstitutionAction(Institution $institution, Request $request)
    {
        $this->voter->isAllowed('right.institution');

        $form = $this->handleForm($institution, $request);
        if (!$form) {
            $this->session->getFlashBag()->set('info', "L'institution a bien été modifiée");

            return new RedirectResponse($this->router->generate('institutions'));
        }

        return array('form' => $form->createView(), 'institution' => $institution);
    }

    /**
     * Handles institution form.
     *
     * @param Request $request
     */
    private function handleForm(Institution $institution, Request $request)
    {
        $form = $this->formFactory->createBuilder(new InstitutionType(), $institution)->getForm();

        $courses = new ArrayCollection();
        foreach ($institution->getCourses() as $course) {
            $courses->add($course);
        }

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->entityManager;

                foreach ($courses as $course) {
                    if ($institution->getCourses()->contains($course) === false) {
                        $em->remove($course);
                    }
                }

                foreach ($institution->getCourses() as $course) {
                    $course->setInstitution($institution);
                }

                $img = $form['file']->getData();
                if ($img) {
                    $fileName = $img->getClientOriginalName();
                    $img->move(__DIR__.'/../../../../../web/upload/media/', $fileName);
                    $institution->setPath($fileName);
                }

                $em->persist($institution);
                $em->flush();

                return;
            }
        }

        return $form;
    }
}
