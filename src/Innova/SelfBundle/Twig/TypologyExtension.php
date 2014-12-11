<?php

namespace Innova\SelfBundle\Twig;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class TaskController
 * @Route("", name = "", service = "innova.twig.get_typologies"
 * )
 */
class TypologyExtension extends \Twig_Extension
{
    protected $entityManager;

    public function __construct(
            $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function getTypologies()
    {
        $em = $this->entityManager;

        $typologies = $em->getRepository('InnovaSelfBundle:Typology')->findAll();

        return $typologies;
    }

    public function getTypologiesForSkill($skill)
    {
        $em = $this->entityManager;

        if ($skill) {
            $typologies = $skill->getTypologys();
        } else {
            $typologies = $em->getRepository('InnovaSelfBundle:Typology')->findAll();
        }

        return $typologies;
    }

    public function getFunctions()
    {
        return array(
            'get_typologies' => new \Twig_Function_Method($this, 'getTypologies'),
            'get_typologies_for_skill' => new \Twig_Function_Method($this, 'getTypologiesForSkill'),
        );
    }

    public function getName()
    {
        return 'get_typologies';
    }
}
