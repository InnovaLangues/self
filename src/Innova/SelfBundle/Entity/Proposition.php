<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proposition
 *
 * @ORM\Table("proposition")
 * @ORM\Entity
 */
class Proposition
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
    * @ORM\ManyToOne(targetEntity="Subquestion", inversedBy="propositions")
    */
    protected $subquestion;

    /**
    * @ORM\OneToMany(targetEntity="Answer", mappedBy="proposition")
    */
    protected $answers;

    /**
    * @ORM\ManyToOne(targetEntity="Media")
    */
    protected $media;


    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rightAnswer", type="boolean")
     */
    private $rightAnswer;

}