<?php

namespace Innova\SelfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Innova\SelfBundle\Entity\Message;
use Innova\SelfBundle\Form\Type\MessageType;

/**
 * Message controller.
 *
 * @Route("/admin")
 */
class MessageController extends Controller
{
    /**
     *
     * @Route("/message", name="send_message")
     * @Method({"GET", "POST"})
     *
     * @Template("InnovaSelfBundle:Message:new.html.twig")
     */
    public function newMessageAction(Request $request)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        if ($this->get("self.right.manager")->checkRight("right.message", $currentUser)) {
            $message = new Message();
            $form = $this->handleMessageForm($message, $request);
            if (!$form) {
                $this->get("session")->getFlashBag()->set('info', "Le message a bien été envoyé");

                return $this->redirect($this->generateUrl('send_message', array()));
            }

            return array('form' => $form->createView(), 'message' => $message);
        }

        return;
    }

    /**
     * Handles message form
     */
    private function handleMessageForm(Message $msg, $request)
    {
        $form = $this->get('form.factory')->createBuilder(new MessageType(), $msg)->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $message    = htmlentities($msg->getMessage());
                $channel    = $msg->getChannel();
                $user       = $msg->getUser();

                $this->get("self.message.manager")->sendMessage($message, $channel, $user);

                return;
            }
        }

        return $form;
    }
}
