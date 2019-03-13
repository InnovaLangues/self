<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="key_value")
 */
class KeyValue
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="k", type="string", length=255, unique=true)
     */
    private $key;

    /**
     * @var string
     *
     * @ORM\Column(name="v", type="string", length=255)
     */
    private $value;


    public function __construct(string $key, string $value = null)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue(string $value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->getValue();
    }
}
