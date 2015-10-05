<?php

namespace Innova\SelfBundle\Manager;

class MessageManager
{
    protected $fayeClient;

    public function __construct($fayeClient)
    {
        $this->fayeClient = $fayeClient;
    }

    public function sendMessage($message, $channel)
    {
        $faye = $this->fayeClient;

        $channel = '/'.$channel;
        $data    = array('text' => $message);
        $faye->send($channel, $data);

        return true;
    }
}
