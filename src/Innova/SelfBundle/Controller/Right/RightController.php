<?php

namespace Innova\SelfBundle\Controller\Right;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Right\Right;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
        $this->get("innova_voter")->isAllowed("right.editrightsuser");

        $groups = $this->getDoctrine()->getManager()->getRepository('InnovaSelfBundle:Right\RightGroup')->findAll();

        return [
            'groups' => $groups,
            'user' => $user,
            'canEditRight' => $this->canEditRight($user),
            'token' => (string) $this->createCsrfToken()
        ];
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
        if (!$this->canEditRight($user)) {
            throw new AccessDeniedHttpException("You are not allowed to edit right for this user.");
        }

        $this->get("self.right.manager")->toggleRight($right, $user);
        $this->get("session")->getFlashBag()->set('info', "Les permissions ont bien été modifiées");

        return $this->redirect($this->generateUrl('admin_user_rights', array('userId' => $user->getId())));
    }

    // TODO : move to a voter
    private function canEditRight(User $user)
    {
        $requiredRole = 'ROLE_SUPER_ADMIN';

        foreach (['ROLE_ADMIN', 'ROLE_SUPER_ADMIN'] as $role) {
            if ($user->hasRole($role) &&
                !$this->isGranted($requiredRole)
            ) {
                return false;
            }
        }

        return $this->get("innova_voter")->checkRight("right.editrightsuser");
    }

    /**
     * @Route("/user/{userId}/grant-role/{role}", name="self_user_grant_role")
     * @Method("GET")
     */
    public function grantRoleAction(Request $request, User $user, $role)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $this->assertValidCsrfToken($request->get('token'));

        $roles = ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN'];

        if (!\in_array($role, $roles, true)) {
            throw new BadRequestHttpException();
        }

        foreach ($roles as $r) {
            $this->get('fos_user.util.user_manipulator')->removeRole($user->getUsername(), $r);
        }

        $this->get('fos_user.util.user_manipulator')->addRole($user->getUsername(), $role);

        $this->addFlash('success', 'Opération effectuée.');

        return $this->redirect($request->headers->get('Referer'));
    }

    /**
     * @Route("/user/{userId}/ungrant-role/{role}", name="self_user_ungrant_role")
     * @Method("GET")
     */
    public function ungrantRoleAction(Request $request, User $user, $role)
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $this->assertValidCsrfToken($request->get('token'));

        if (!in_array($role, ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN'])) {
            throw new BadRequestHttpException();
        }

        $this->get('fos_user.util.user_manipulator')->removeRole($user->getUsername(), $role);

        $this->addFlash('success', 'Opération effectuée.');

        return $this->redirect($request->headers->get('Referer'));
    }

    private function createCsrfToken()
    {
        return $this->get('security.csrf.token_manager')->getToken('self_user');
    }

    private function assertValidCsrfToken($token)
    {
        if (!$this->isCsrfTokenValid('self_user', $token)) {
            throw new UnauthorizedHttpException('Invalid CSRF Token');
        }
    }
}
