<?php

namespace Innova\SelfBundle\Controller\Right;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Test;
use Innova\SelfBundle\Entity\Right\RightUserTest;
use Symfony\Component\HttpFoundation\Request;
use Innova\SelfBundle\Form\Type\Right\RightUserTestType;

/**
 * RightUserTest controller.
 *
 * @Route("/admin")
 * @ParamConverter("test", isOptional="true", class="InnovaSelfBundle:Test", options={"id" = "testId"})
 * @ParamConverter("rightUserTest", isOptional="true", class="InnovaSelfBundle:Right\RightUserTest", options={"id" = "rightId"})
 */
class RightUserTestController extends Controller
{
    /**
     * @Route("/test/{testId}/rights", name="editor_test_rights")
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Test:rights.html.twig")
     */
    public function handleRightsAction(Test $test)
    {
        $this->get('innova_voter')->isAllowed('right.editrightstest');

        $rights = $this->getDoctrine()->getManager()->getRepository("InnovaSelfBundle:Right\RightUserTest")->findByTarget($test);

        return array('test' => $test, 'rights' => $rights);
    }

    /**
     * @Route("/test/{testId}/rights/add", name="editor_test_rights_add")
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:Test:rights_form.html.twig")
     */
    public function createRightsAction(Test $test, Request $request)
    {
        $this->get('innova_voter')->isAllowed('right.editrightstest');

        $right = new RightUserTest();
        $form = $this->handleRightsForm($right, $test, $request);
        if (!$form) {
            $this->get('session')->getFlashBag()->set('info', 'Les droits ont bien été créés');

            return $this->redirect($this->generateUrl('editor_test_rights', array('testId' => $test->getId())));
        }

        return array('form' => $form->createView(), 'test' => $test, 'right' => $right);
    }

    /**
     * @Route("/test/{testId}/rights/{rightId}/edit", name="editor_test_rights_edit")
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:Test:rights_form.html.twig")
     */
    public function editRightsAction(Test $test, RightUserTest $rightUserTest, Request $request)
    {
        $this->get('innova_voter')->isAllowed('right.editrightstest');

        $form = $this->handleRightsForm($rightUserTest, $test, $request);
        if (!$form) {
            $this->get('session')->getFlashBag()->set('info', 'Les droits ont bien été modifiés');

            return $this->redirect($this->generateUrl('editor_test_rights', array('testId' => $test->getId())));
        }

        return array('form' => $form->createView(), 'test' => $test, 'rightUserTest' => $rightUserTest);
    }

    /**
     * @Route("/test/{testId}/right/{rightId}/delete", name="editor_test_rights_delete", options = {"expose"=true})
     * @Method("DELETE")
     *
     * @Template("InnovaSelfBundle:Test:list.html.twig")
     */
    public function deleteRightAction(Test $test, RightUsertest $rightUserTest)
    {
        $this->get('innova_voter')->isAllowed('right.editrightstest');

        $user = $rightUserTest->getUser();
        $em = $this->getDoctrine()->getManager();
        $em->remove($rightUserTest);
        $em->flush();

        $this->get('self.right.manager')->adminToggle($user);

        $this->get('session')->getFlashBag()->set('info', 'Les droits ont bien été supprimés');

        return $this->redirect($this->generateUrl('editor_test_rights', array('testId' => $test->getId())));
    }

    private function handleRightsForm(RightUserTest $rightUserTest, Test $test, $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->get('form.factory')->createBuilder(new RightUserTestType($em, $rightUserTest), $rightUserTest)->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $rightUserTest->setTarget($test);
                $em->persist($rightUserTest);
                $em->flush();

                $this->get('self.right.manager')->adminToggle($rightUserTest->getUser());

                return;
            }
        }

        return $form;
    }
}
