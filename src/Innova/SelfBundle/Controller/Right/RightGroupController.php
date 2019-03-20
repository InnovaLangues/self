<?php

namespace Innova\SelfBundle\Controller\Right;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Right\RightGroup;
use Innova\SelfBundle\Entity\User;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * RightGroup controller.
 *
 * @Route("/admin")
 * @ParamConverter("rightGroup", isOptional="true", class="InnovaSelfBundle:Right\RightGroup", options={"id" = "rightGroupId"})
 * @ParamConverter("user", isOptional="true", class="InnovaSelfBundle:User", options={"id" = "userId"})
 */
class RightGroupController extends Controller
{
    /**
     *
     * @Route("admin/user/{userId}/group/{rightGroupId}/toggle", name="editor_group_rights_toggle")
     * @Method("GET")
     *
     * @Template("InnovaSelfBundle:Features:Group/rights.html.twig")
     */
    public function toggleAllForGroupAction(User $user, RightGroup $rightGroup)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $this->get("self.rightgroup.manager")->toggleAll($user, $rightGroup);
        $this->get("session")->getFlashBag()->set('info', "Les permissions ont bien été modifiées");

        return $this->redirect($this->generateUrl('admin_user_rights', array('userId' => $user->getId())));
    }
}
