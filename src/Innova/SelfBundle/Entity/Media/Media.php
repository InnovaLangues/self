<?php

namespace Innova\SelfBundle\Entity\Media;

use Doctrine\ORM\Mapping as ORM;

/**
 * Media
 *
 * @ORM\Table("media")
 * @ORM\Entity
 */
class Media
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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
    * @ORM\ManyToOne(targetEntity="MediaType", inversedBy="medias")
    */
    protected $mediaType;

    /**
    * @ORM\OneToMany(targetEntity="MediaLimit", mappedBy="media")
    */
    private $mediaLimits;

    /**
    * @ORM\OneToMany(targetEntity="MediaClick", mappedBy="media")
    */
    private $mediaClicks;

    /**
    * @ORM\ManyToOne(targetEntity="MediaPurpose", inversedBy="medias")
    */
    protected $mediaPurpose;

    /**
     * To String
     */

    public function __toString()
    {
        return $this->getName();
    }

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
     * Set description
     *
     * @param  string $description
     * @return Media
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set mediaType
     *
     * @param  \Innova\SelfBundle\Entity\Media\MediaType $mediaType
     * @return Media
     */
    public function setMediaType(\Innova\SelfBundle\Entity\Media\MediaType $mediaType = null)
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    /**
     * Get mediaType
     *
     * @return \Innova\SelfBundle\Entity\Media\MediaType
     */
    public function getMediaType()
    {
        return $this->mediaType;
    }

    /**
     * Set name
     *
     * @param  string $name
     * @return Media
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set url
     *
     * @param  string $url
     * @return Media
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mediaLimits = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mediaClicks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add mediaLimits
     *
     * @param  \Innova\SelfBundle\Entity\Media\MediaLimit $mediaLimits
     * @return Media
     */
    public function addMediaLimit(\Innova\SelfBundle\Entity\Media\MediaLimit $mediaLimits)
    {
        $this->mediaLimits[] = $mediaLimits;

        return $this;
    }

    /**
     * Remove mediaLimits
     *
     * @param \Innova\SelfBundle\Entity\Media\MediaLimit $mediaLimits
     */
    public function removeMediaLimit(\Innova\SelfBundle\Entity\Media\MediaLimit $mediaLimits)
    {
        $this->mediaLimits->removeElement($mediaLimits);
    }

    /**
     * Get mediaLimits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMediaLimits()
    {
        return $this->mediaLimits;
    }

    /**
     * Add mediaClicks
     *
     * @param  \Innova\SelfBundle\Entity\Media\MediaClick $mediaClicks
     * @return Media
     */
    public function addMediaClick(\Innova\SelfBundle\Entity\Media\MediaClick $mediaClicks)
    {
        $this->mediaClicks[] = $mediaClicks;

        return $this;
    }

    /**
     * Remove mediaClicks
     *
     * @param \Innova\SelfBundle\Entity\Media\MediaClick $mediaClicks
     */
    public function removeMediaClick(\Innova\SelfBundle\Entity\Media\MediaClick $mediaClicks)
    {
        $this->mediaClicks->removeElement($mediaClicks);
    }

    /**
     * Get mediaClicks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMediaClicks()
    {
        return $this->mediaClicks;
    }

    /**
     * Set syllable
     *
     * @param string $syllable
     * @return Media
     */
    public function setSyllable($syllable)
    {
        $this->syllable = $syllable;

        return $this;
    }

    /**
     * Get syllable
     *
     * @return string
     */
    public function getSyllable()
    {
        return $this->syllable;
    }

    /**
     * Set clue
     *
     * @param string $clue
     * @return Media
     */
    public function setClue($clue)
    {
        $this->clue = $clue;

        return $this;
    }

    /**
     * Get clue
     *
     * @return string
     */
    public function getClue()
    {
        return $this->clue;
    }

    /**
     * Set mediaPurpose
     *
     * @param \Innova\SelfBundle\Entity\Media\MediaPurpose $mediaPurpose
     * @return Media
     */
    public function setMediaPurpose(\Innova\SelfBundle\Entity\Media\MediaPurpose $mediaPurpose = null)
    {
        $this->mediaPurpose = $mediaPurpose;
    
        return $this;
    }

    /**
     * Get mediaPurpose
     *
     * @return \Innova\SelfBundle\Entity\Media\MediaPurpose 
     */
    public function getMediaPurpose()
    {
        return $this->mediaPurpose;
    }
}