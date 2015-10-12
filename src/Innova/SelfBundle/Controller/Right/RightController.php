<?php

namespace Innova\SelfBundle\Controller\Right;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Right\Right;

/**
 * RightController controller.
 *
 * @ParamConverter("user", isOptional="true", class="InnovaSelfBundle:User", options={"id" = "userId"})
 * @ParamConverter("right", isOptional="true", class="InnovaSelfBundle:Right\Right", options={"id" = "rightId"})
 */
class RightController extends Controller
{
    /**
     *
     * @Route("/admin/user/{userId}/edit-rights", name="admin_user_rights")
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:User:rights.html.twig")
     */
    public function displayRightsAction(User $user)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.editrightsuser", $currentUser)) {
            $em = $this->getDoctrine()->getManager();

            $groups = $em->getRepository('InnovaSelfBundle:Right\RightGroup')->findAll();

            return array('groups' => $groups, 'user' => $user);
        }

        return;
    }

    /**
     *
     * @Route("/admin/user/{userId}/right/{rightId}", name="admin_user_toggle_right")
     * @Method({"GET"})
     *
     * @Template("InnovaSelfBundle:User:rights.html.twig")
     */
    public function toggleRightAction(User $user, Right $right)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.editrightsuser", $currentUser)) {
            $this->get("self.right.manager")->toggleRight($right, $user);
            $this->get("session")->getFlashBag()->set('info', "Les permissions ont bien été modifiées");

            return $this->redirect($this->generateUrl('admin_user_rights', array('userId' => $user->getId())));
        }

        return;
    }
}
