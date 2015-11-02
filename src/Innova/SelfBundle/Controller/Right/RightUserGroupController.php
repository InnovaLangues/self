<?php

namespace Innova\SelfBundle\Controller\Right;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\Group;
use Innova\SelfBundle\Entity\Right\RightUserGroup;
use Innova\SelfBundle\Form\Type\Right\RightUserGroupType;
use Symfony\Component\HttpFoundation\Request;

/**
 * RightUserGroup controller.
 *
 * @Route("/admin")
 * @ParamConverter("group", isOptional="true", class="InnovaSelfBundle:Group", options={"id" = "groupId"})
 * @ParamConverter("rightUserGroup", isOptional="true", class="InnovaSelfBundle:Right\RightUserGroup", options={"id" = "rightId"})
 */
class RightUserGroupController extends Controller
{
    /**
     *
     * @Route("/group/{groupId}/rights", name="editor_group_rights")
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Group:rights.html.twig")
     */
    public function handleRightsAction(Group $group)
    {
        $this->get("innova_voter")->isAllowed("right.editrightsgroup");

        $em = $this->getDoctrine()->getManager();
        $rights = $em->getRepository("InnovaSelfBundle:Right\RightUserGroup")->findByTarget($group);

        return array("group" => $group, "rights" => $rights);
    }

    /**
     *
     * @Route("/group/{groupId}/rights/add", name="editor_group_rights_add")
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:Group:rights_form.html.twig")
     */
    public function createRightsAction(Group $group, Request $request)
    {
        $this->get("innova_voter")->isAllowed("right.editrightsgroup");

        $right = new RightUserGroup();

        $form = $this->handleRightsForm($right, $group, $request);
        if (!$form) {
            $this->get("session")->getFlashBag()->set('info', "Les droits ont bien été créés");

            return $this->redirect($this->generateUrl('editor_group_rights', array('groupId' => $group->getId())));
        }

        return array('form' => $form->createView(), 'group' => $group, 'right' => $right);
    }

    /**
     *
     * @Route("/group/{groupId}/rights/{rightId}/edit", name="editor_group_rights_edit")
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:Group:rights_form.html.twig")
     */
    public function editRightsAction(Group $group, RightUserGroup $rightUserGroup, Request $request)
    {
        $this->get("innova_voter")->isAllowed("right.editrightsgroup");

        $form = $this->handleRightsForm($rightUserGroup, $group, $request);
        if (!$form) {
            $this->get("session")->getFlashBag()->set('info', "Les droits ont bien été modifiés");

            return $this->redirect($this->generateUrl('editor_group_rights', array('groupId' => $group->getId())));
        }

        return array('form' => $form->createView(), 'group' => $group, 'rightUserGroup' => $rightUserGroup );
    }

    /**
     *
     * @Route("/group/{groupId}/right/{rightId}/delete", name="editor_group_rights_delete", options = {"expose"=true})
     * @Method("DELETE")
     *
     * @Template("InnovaSelfBundle:Group:list.html.twig")
     */
    public function deleteRightAction(Group $group, RightUserGroup $rightUserGroup)
    {
        $this->get("innova_voter")->isAllowed("right.editrightsgroup");
        
        $user = $rightUserGroup->getUser();
        $em = $this->getDoctrine()->getManager();
        $em->remove($rightUserGroup);
        $em->flush();

        $this->get("self.right.manager")->adminToggle($user);

        $this->get("session")->getFlashBag()->set('info', "Les droits ont bien été supprimés");

        return $this->redirect($this->generateUrl('editor_group_rights', array('groupId' => $group->getId())));
    }

    /**
     * Handles group form
     */
    private function handleRightsForm(RightUserGroup $rightUserGroup, Group $group, $request)
    {
        $form = $this->get('form.factory')->createBuilder(new RightUserGroupType(), $rightUserGroup)->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $rightUserGroup->setTarget($group);
                $em->persist($rightUserGroup);
                $em->flush();

                $this->get("self.right.manager")->adminToggle($rightUserGroup->getUser());

                return;
            }
        }

        return $form;
    }
}
