<?php

namespace Innova\SelfBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table("question")
 * @ORM\Entity
 */
class Question
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
    * @ORM\ManyToOne(targetEntity="Questionnaire", inversedBy="questions", cascade={"remove"})
    */
    protected $questionnaire;


    /**
    * @ORM\ManyToOne(targetEntity="Typology", inversedBy="questions")
    */
    protected $typology;

    /**
    * @ORM\OneToMany(targetEntity="Subquestion", mappedBy="question", cascade={"remove", "persist"})
    */
    protected $subquestions;

    /**
    * @ORM\ManyToOne(targetEntity="Instruction", inversedBy="questions")
    */
    protected $instruction;

    /**
    * @ORM\ManyToOne(targetEntity="Media")
    */
    protected $media;

}