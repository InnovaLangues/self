<?php

namespace Innova\SelfBundle\Entity;

class Message
{
    /**
     * @var string
     *
     */
    private $channel;

    /**
     * @var string
     *
     */
    private $message;

    /**
     * @var string
     *
     */
    private $user;

    /**
     * Set channel
     *
     * @param  string  $channel
     * @return Message
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Get channel
     *
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Set message
     *
     * @param  string  $message
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set user
     *
     * @param  string $user
     * @return user
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }
}
