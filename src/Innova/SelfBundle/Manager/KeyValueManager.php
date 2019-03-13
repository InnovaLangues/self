<?php

namespace Innova\SelfBundle\Manager;

use Doctrine\ORM\EntityManager;
use Innova\SelfBundle\Entity\KeyValue;

class KeyValueManager
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(KeyValue::class);
    }

    public function get(string $key, $defaultValue = null)
    {
        $keyValue = $this->repository->findOneByKey($key);

        if ($keyValue === null) {
            return new KeyValue($key, $defaultValue);
        }

        return $keyValue;
    }

    public function save(string $key, string $value)
    {
        $keyValue = $this->repository->findOneByKey($key);

        if ($keyValue === null) {
            $keyValue = new KeyValue($key, $value);
            $this->entityManager->persist($keyValue);
        } else {
            $keyValue->setValue($value);
        }

        $this->entityManager->flush();
    }
}
