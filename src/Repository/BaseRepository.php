<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

abstract class BaseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry, string $className)
    {
        parent::__construct($registry, $className);
    }

    public function getAllToForm(): array
    {
        return array_map(function ($object) {
            return [$object->getName() => $object->getId()];
        }, $this->findAll());
    }
}