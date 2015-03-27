<?php

namespace Innova\SelfBundle\Manager;


class GroupManager
{
    protected $entityManager;

    public function __construct($entityManager, $formFactory)
    {
        $this->entityManager = $entityManager;
    }
}
