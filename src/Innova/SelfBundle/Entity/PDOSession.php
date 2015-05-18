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
}
