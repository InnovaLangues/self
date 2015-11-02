<?php

namespace Innova\SelfBundle\Voter;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Innova\SelfBundle\Entity\User;

/**
 * Class Voter
 *
 * @Route(
 *      name = "innova_voter",
 *      service = "innova_voter"
 * )
 */
class Voter
{
    protected $securityContext;
    protected $rightManager;
    protected $currentUser;

    public function __construct($securityContext, $rightManager) 
    {
        $this->securityContext  = $securityContext;
        $this->rightManager     = $rightManager;
        $this->currentUser      = $this->securityContext->getToken()->getUser();

    }

    public function isAllowed($rightName, $entity = null)
    {
       if (true !== $this->rightManager->checkRight($rightName, $this->currentUser, $entity)) {
            throw new AccessDeniedException();   
       }

       return;
    }

}
