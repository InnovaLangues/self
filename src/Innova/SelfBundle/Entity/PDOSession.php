<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Group
 * @ORM\Table(name="session_pdo")
 * @ORM\Entity
 */
class PDOSession
{
    /**
     *
     * @ORM\Column(name="session_id", type="string", length=255)
     * @ORM\Id
     */
    private $session_id;

    /**
     *
     * @ORM\Column(name="session_value", type="text")
     */
    private $session_value;

    /**
     *
     * @ORM\Column(name="session_time", type="integer")
     */
    private $session_time;

    /**
     * Set sessionId
     *
     * @param string $sessionId
     *
     * @return PDOSession
     */
    public function setSessionId($sessionId)
    {
        $this->session_id = $sessionId;

        return $this;
    }

    /**
     * Get sessionId
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->session_id;
    }

    /**
     * Set sessionValue
     *
     * @param string $sessionValue
     *
     * @return PDOSession
     */
    public function setSessionValue($sessionValue)
    {
        $this->session_value = $sessionValue;

        return $this;
    }

    /**
     * Get sessionValue
     *
     * @return string
     */
    public function getSessionValue()
    {
        return $this->session_value;
    }

    /**
     * Set sessionTime
     *
     * @param integer $sessionTime
     *
     * @return PDOSession
     */
    public function setSessionTime($sessionTime)
    {
        $this->session_time = $sessionTime;

        return $this;
    }

    /**
     * Get sessionTime
     *
     * @return integer
     */
    public function getSessionTime()
    {
        return $this->session_time;
    }
}
