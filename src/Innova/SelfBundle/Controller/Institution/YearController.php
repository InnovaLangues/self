<?php

namespace Innova\SelfBundle\Controller\Institution;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Innova\SelfBundle\Entity\Institution\Year;
use Innova\SelfBundle\Form\Type\YearType;


/**
 * Year controller.
 *
 * @Route("", service="innova_year")
 * @ParamConverter("year", isOptional="true", class="InnovaSelfBundle:Institution\Year", options={"id" = "yearId"})
 */
class YearController
{
    protected $entityManager;
    protected $voter;
    protected $router;
    protected $formFactory;
    protected $session;

    public function __construct($entityManager, $voter, $router, $formFactory, $session)
    {
        $this->entityManager            = $entityManager;
        $this->voter                    = $voter;
        $this->router                   = $router;
        $this->formFactory              = $formFactory;
        $this->session                  = $session;
    }


    /**
     * List institutions
     *
     * @Route("/admin/years", name="years")
     * @Method({"GET"})
     * @Template("InnovaSelfBundle:Year:list.html.twig")
     */
    public function listYearAction()
    {
        $this->voter->isAllowed("right.institution");

        $years = $this->entityManager->getRepository('InnovaSelfBundle:Institution\Year')->findBy(array(), array('name'=>'asc'));
          
        return array('years' => $years);
    }

    /**
     * List institutions
     *
     * @Route("/admin/year/new", name="year_create")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Year:create.html.twig")
     */
    public function createYearAction(Request $request)
    {
        $this->voter->isAllowed("right.institution");

        $year = new Year();
        $form = $this->handleForm($year, $request);
        if (!$form) {
            $this->session->getFlashBag()->set('info', "L'année a bien été créée");

            return new RedirectResponse($this->router->generate('years'));
        }

        return array('form' => $form->createView(), 'year' => $year);
    }

    /**
     * List years
     *
     * @Route("/admin/year/{yearId}", name="year_view")
     * @Method({"GET"})
     * @Template("InnovaSelfBundle:Year:view.html.twig")
     */
    public function viewYearAction(Year $year)
    {
        $this->voter->isAllowed("right.institution");
 
        return array('year' => $year);
    }

    /**
     * Delete year
     *
     * @Route("/admin/year/{yearId}/delete", name="year_delete")
     * @Method("DELETE")
     */
    public function deleteYearAction(year $year)
    {
        $this->voter->isAllowed("right.institution");

        $em = $this->entityManager;
        $em->remove($year);
        $em->flush();
        $this->session->getFlashBag()->set('info', "L'année a bien été supprimée");

        return new RedirectResponse($this->router->generate('years'));
    }


    /**
     * List institutions
     *
     * @Route("/admin/year/{yearId}/edit", name="year_edit")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Year:create.html.twig")
     */
    public function editYearAction(Year $year, Request $request)
    {
        $this->voter->isAllowed("right.institution");

        $form = $this->handleForm($year, $request);
        if (!$form) {
            $this->session->getFlashBag()->set('info', "L'année a bien été modifiée");

            return new RedirectResponse($this->router->generate('years'));
        }

        return array('form' => $form->createView(), 'year' => $year);
    }


    /**
     * Handles year form
     * @param Request $request
     */
    private function handleForm(Year $year, Request $request)
    {
        $form = $this->formFactory->createBuilder(new YearType(), $year)->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->entityManager;
                $em->persist($year);
                $em->flush();

                return;
            }
        }

        return $form;
    }
}
