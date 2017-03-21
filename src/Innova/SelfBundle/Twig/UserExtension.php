<?php

namespace Innova\SelfBundle\Twig;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("", name = "", service = "innova.twig.user"
 * )
 */
class UserExtension extends \Twig_Extension
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function hasAnyGlobalRight($user)
    {
        $em = $this->entityManager;

        $hasAnyGlobalRight = $em->getRepository('InnovaSelfBundle:User')->hasAnyGlobalRight($user);

        return $hasAnyGlobalRight;
    }

    public function getTestsWithRights($user)
    {
        $em = $this->entityManager;

        $testsWithRights = $em->getRepository('InnovaSelfBundle:User')->getTestWithRights($user);

        return $testsWithRights;
    }

    public function getSessionsWithRights($user)
    {
        $em = $this->entityManager;

        $sessionsWithRights = $em->getRepository('InnovaSelfBundle:User')->getSessionsWithRights($user);

        return $sessionsWithRights;
    }

    public function getFunctions()
    {
        return array(
            'hasAnyGlobalRight' => new \Twig_Function_Method($this, 'hasAnyGlobalRight'),
            'getTestsWithRights' => new \Twig_Function_Method($this, 'getTestsWithRights'),
            'getSessionsWithRights' => new \Twig_Function_Method($this, 'getSessionsWithRights'),
        );
    }

    public function getName()
    {
        return 'userExtension';
    }
}
