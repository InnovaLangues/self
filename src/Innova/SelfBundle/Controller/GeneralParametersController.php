<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Innova\SelfBundle\Entity\GeneralParameters;
use Innova\SelfBundle\Form\Type\GeneralParametersType;

/**
 * Test controller.
 *
 * @Route("/admin")
 */
class GeneralParametersController extends Controller
{
    /**
     *
     * @Route("/parameters", name="parameters")
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:Parameters:new.html.twig")
     */
    public function editAction(Request $request)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        if ($this->get("self.right.manager")->checkRight("right.generalParameters", $currentUser)) {
            $parameters = $em->getRepository('InnovaSelfBundle:GeneralParameters')->get();

            $form = $this->handleForm($parameters, $request);
            if (!$form) {
                $this->get("session")->getFlashBag()->set('info', "Les paramètres ont bien été modifiés");

                return $this->redirect($this->generateUrl('parameters', array()));
            }

            return array('form' => $form->createView(), 'parameters' => $parameters);
        }

        return;
    }

    /**
     * Handles parameters form
     */
    private function handleForm(GeneralParameters $parameters, $request)
    {
        $form = $this->get('form.factory')->createBuilder(new GeneralParametersType(), $parameters)->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($parameters);
                $em->flush();

                return;
            }
        }

        return $form;
    }
}
