<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subquestion
 *
 * @ORM\Table("subquestion")
 * @ORM\Entity
 */
class Subquestion
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
    * @ORM\ManyToOne(targetEntity="Typology", inversedBy="subquestions")
    */
    protected $typology;


    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
    * @ORM\ManyToOne(targetEntity="Media")
    */
    protected $media;

    /**
    * @ORM\ManyToOne(targetEntity="Question", inversedBy="subquestions")
    */
    protected $question;

    /**
    * @ORM\OneToMany(targetEntity="Proposition", mappedBy="subquestion", cascade={"remove", "persist"})
    */
    protected $propositions;

}