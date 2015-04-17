<?php

namespace Innova\SelfBundle\Twig;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("", name = "", service = "innova.twig.check_right"
 * )
 */
class RightExtension extends \Twig_Extension
{
    protected $entityManager;
    protected $securityContext;
    protected $rightManager;
    protected $user;

    public function __construct($entityManager, $securityContext, $rightManager)
    {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
        $this->rightManager = $rightManager;
    }

    public function checkRight($rightName, $entity = null)
    {
        $user = $this->securityContext->getToken()->getUser();

        return $this->rightManager->checkRight($rightName, $user, $entity);
    }

    public function hasRightsOnGroup($groupClass)
    {
        $user = $this->securityContext->getToken()->getUser();
        $hasRights = $this->rightManager->hasRightsOnGroup($groupClass, $user);

        return $hasRights;
    }

    public function getFunctions()
    {
        return array(
            'checkRight' => new \Twig_Function_Method($this, 'checkRight'),
            'hasRightsOnGroup' => new \Twig_Function_Method($this, 'hasRightsOnGroup'),
        );
    }

    public function getName()
    {
        return 'check_right';
    }
}
