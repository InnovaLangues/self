<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Typology.
 *
 * @ORM\Table("user_result")
 * @ORM\Entity(repositoryClass="Innova\SelfBundle\Repository\TypologyRepository")
 */
class UserResult
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
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Innova\SelfBundle\Entity\Session")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $session;

    /**
     * @var int
     *
     * @ORM\Column(name="general_score", type="string", nullable=true)
     */
    private $generalScore;

    /**
     * @var int
     *
     * @ORM\Column(name="eec_score", type="string", nullable=true)
     */
    private $eecScore;

    /**
     * @var int
     *
     * @ORM\Column(name="ce_score", type="string", nullable=true)
     */
    private $ceScore;

    /**
     * @var int
     *
     * @ORM\Column(name="co_score", type="string", nullable=true)
     */
    private $coScore;

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
     * Set generalScore.
     *
     * @param string $generalScore
     *
     * @return UserResult
     */
    public function setGeneralScore($generalScore)
    {
        $this->generalScore = $generalScore;

        return $this;
    }

    /**
     * Get generalScore.
     *
     * @return string
     */
    public function getGeneralScore()
    {
        return $this->generalScore;
    }

    /**
     * Set eecScore.
     *
     * @param string $eecScore
     *
     * @return UserResult
     */
    public function setEecScore($eecScore)
    {
        $this->eecScore = $eecScore;

        return $this;
    }

    /**
     * Get eecScore.
     *
     * @return string
     */
    public function getEecScore()
    {
        return $this->eecScore;
    }

    /**
     * Set ceScore.
     *
     * @param string $ceScore
     *
     * @return UserResult
     */
    public function setCeScore($ceScore)
    {
        $this->ceScore = $ceScore;

        return $this;
    }

    /**
     * Get ceScore.
     *
     * @return string
     */
    public function getCeScore()
    {
        return $this->ceScore;
    }

    /**
     * Set coScore.
     *
     * @param string $coScore
     *
     * @return UserResult
     */
    public function setCoScore($coScore)
    {
        $this->coScore = $coScore;

        return $this;
    }

    /**
     * Get coScore.
     *
     * @return string
     */
    public function getCoScore()
    {
        return $this->coScore;
    }

    /**
     * Set user.
     *
     * @param \Innova\SelfBundle\Entity\User $user
     *
     * @return UserResult
     */
    public function setUser(\Innova\SelfBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \Innova\SelfBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set session.
     *
     * @param \Innova\SelfBundle\Entity\Session $session
     *
     * @return UserResult
     */
    public function setSession(\Innova\SelfBundle\Entity\Session $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session.
     *
     * @return \Innova\SelfBundle\Entity\Session
     */
    public function getSession()
    {
        return $this->session;
    }
}
