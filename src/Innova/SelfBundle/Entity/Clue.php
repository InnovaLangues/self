<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clue.
 *
 * @ORM\Table("clue")
 * @ORM\Entity
 */
class Clue
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="ClueType", fetch = "EAGER")
     */
    protected $clueType;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Media\Media", fetch = "EAGER")
     */
    protected $media;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set clueType.
     *
     * @param \Innova\SelfBundle\Entity\ClueType $clueType
     *
     * @return Clue
     */
    public function setClueType(\Innova\SelfBundle\Entity\ClueType $clueType = null)
    {
        $this->clueType = $clueType;

        return $this;
    }

    /**
     * Get clueType.
     *
     * @return \Innova\SelfBundle\Entity\ClueType
     */
    public function getClueType()
    {
        return $this->clueType;
    }

    /**
     * Set media.
     *
     * @param \Innova\SelfBundle\Entity\Media\Media $media
     *
     * @return Clue
     */
    public function setMedia(\Innova\SelfBundle\Entity\Media\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media.
     *
     * @return \Innova\SelfBundle\Entity\Media\Media
     */
    public function getMedia()
    {
        return $this->media;
    }
}
