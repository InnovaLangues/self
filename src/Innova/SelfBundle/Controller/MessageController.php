<?php
namespace Innova\SelfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Innova\SelfBundle\Entity\User;
use Innova\SelfBundle\Entity\Right\Right;

/**
 * User controller.
 *
 * @ParamConverter("user", isOptional="true", class="InnovaSelfBundle:User", options={"id" = "userId"})
 * @ParamConverter("right", isOptional="true", class="InnovaSelfBundle:Right\Right", options={"id" = "rightId"})
 */
class MessageController extends Controller
{
    /**
     * Lists all users
     *
     * @Route("/admin/message/", name="message")
     * @Method("GET")
     *
     * @Template()
     */
    public function sendMessageAction()
    {
        $messageManager = $this->get('self.message.manager');

        $messageManager->sendMessage("zqdzq dzq dzq dzq dzq dzq dq", "all", "warning");

        return new Response();
    }
}
