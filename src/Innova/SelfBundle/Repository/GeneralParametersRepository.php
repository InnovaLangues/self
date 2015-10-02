<?php

namespace Innova\SelfBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GeneralParametersRepository extends EntityRepository
{
    public function get()
    {
        return $this->findAll()[0];
    }

    public function isMaintenanceEnabled()
    {
        return $this->get()->getMaintenance();
    }

    public function isSelfRegistrationEnabled()
    {
        return $this->get()->getSelfRegistration();
    }

    public function getMaintenanceText()
    {
        return $this->get()->getMaintenanceText();
    }
}
