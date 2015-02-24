<?php

namespace Innova\SelfBundle\Entity\PhasedTest;

use Doctrine\ORM\Mapping as ORM;

/**
 * ComponentAlternative
 *
 * @ORM\Table("componentAlternative")
 * @ORM\Entity
 */
class ComponentAlternative
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
     * @var integer
     *
     * @ORM\Column(name="alternativeNumber", type="integer")
     */
    private $alternativeNumber;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set alternativeNumber
     *
     * @param integer $alternativeNumber
     * @return ComponentAlternative
     */
    public function setAlternativeNumber($alternativeNumber)
    {
        $this->alternativeNumber = $alternativeNumber;
    
        return $this;
    }

    /**
     * Get alternativeNumber
     *
     * @return integer 
     */
    public function getAlternativeNumber()
    {
        return $this->alternativeNumber;
    }
}