<?php
namespace Innova\SelfBundle\Controller\Features;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * User controller.
 *
 * @Route("/user/")
 */
class UserController extends Controller
{
    /**
     * @Route("self_display", name="self_user_display")
     * @Method("GET")
     * @Template("InnovaSelfBundle:Features:AdminUser/show.html.twig")
     */
    public function selfDisplayAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        return array(
            'user'   => $user,
        );
    }

    /**
     * @Route("self_edit", name="self_user_edit")
     * @Method({"GET", "POST"})
     * @Template("InnovaSelfBundle:Features:AdminUser/new.html.twig")
     */
    public function selfEditAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $form = $this->get("self.user.manager")->handleForm($user, $request);

        if (!$form) {
            $this->get("session")->getFlashBag()->set('info', "Les informations ont bien été modifiées");

            return $this->redirect($this->generateUrl('self_user_display'));
        }

        return array('form' => $form->createView(), 'user' => $user);
    }
}
