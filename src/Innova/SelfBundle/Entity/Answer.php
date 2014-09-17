<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table("answer")
 * @ORM\Entity
 */
class Answer
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
    * @ORM\ManyToOne(targetEntity="Trace", inversedBy="answers", cascade={"remove"})
    */
    protected $trace;

    /**
    * @ORM\ManyToOne(targetEntity="Proposition", inversedBy="answers")
    */
    protected $proposition;

    /**
    * @ORM\ManyToOne(targetEntity="Subquestion", inversedBy="answers")
    */
    protected $subquestion;

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
     * Set trace
     *
     * @param  \Innova\SelfBundle\Entity\Trace $trace
     * @return Answer
     */
    public function setTrace(\Innova\SelfBundle\Entity\Trace $trace = null)
    {
        $this->trace = $trace;

        return $this;
    }

    /**
     * Get trace
     *
     * @return \Innova\SelfBundle\Entity\Trace
     */
    public function getTrace()
    {
        return $this->trace;
    }

    /**
     * Set proposition
     *
     * @param  \Innova\SelfBundle\Entity\Proposition $proposition
     * @return Answer
     */
    public function setProposition(\Innova\SelfBundle\Entity\Proposition $proposition = null)
    {
        $this->proposition = $proposition;

        return $this;
    }

    /**
     * Get proposition
     *
     * @return \Innova\SelfBundle\Entity\Proposition
     */
    public function getProposition()
    {
        return $this->proposition;
    }

    /**
     * Set subquestion
     *
     * @param  \Innova\SelfBundle\Entity\Subquestion $subquestion
     * @return Answer
     */
    public function setSubquestion(\Innova\SelfBundle\Entity\Subquestion $subquestion = null)
    {
        $this->subquestion = $subquestion;

        return $this;
    }

    /**
     * Get subquestion
     *
     * @return \Innova\SelfBundle\Entity\Subquestion
     */
    public function getSubquestion()
    {
        return $this->subquestion;
    }
}