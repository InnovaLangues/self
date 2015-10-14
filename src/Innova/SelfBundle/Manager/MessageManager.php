<?php

namespace Innova\SelfBundle\Manager;

class MessageManager
{
    protected $fayeClient;
    protected $entityManager;

    public function __construct($fayeClient, $entityManager)
    {
        $this->fayeClient = $fayeClient;
        $this->entityManager = $entityManager;
    }

    public function sendMessage($message, $channel, $username = null)
    {
        $em = $this->entityManager;

        if ($channel == "user") {
            if ($user = $em->getRepository('InnovaSelfBundle:User')->findOneByUsername($username)) {
                $channel .= $user->getId();
            } else {
                return false;
            }
        }

        $faye = $this->fayeClient;

        $channel = '/'.$channel;
        $data    = array('text' => $message);
        $faye->send($channel, $data);

        return true;
    }
}
