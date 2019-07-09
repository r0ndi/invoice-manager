<?php

namespace App\Repository;

use App\Util\ServiceLocator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Exception;
use Symfony\Bridge\Doctrine\RegistryInterface;

abstract class BaseRepository extends ServiceEntityRepository
{
    private $serviceLocator;

    public function __construct(RegistryInterface $registry, string $className, ServiceLocator $serviceLocator)
    {
        parent::__construct($registry, $className);

        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator(): ServiceLocator
    {
        return $this->serviceLocator;
    }

    public function getAllToForm(): array
    {
        return array_map(function ($object) {
            return [$object->getName() => $object->getId()];
        }, $this->findAll());
    }

    public function persist($object, bool $flush = true): bool
    {
        try {
            $this->getEntityManager()->persist($object);

            if ($flush) {
                $this->getEntityManager()->flush();
            }
        } catch (Exception $exception) {
            $this->getServiceLocator()->getNotifyService()->addError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function merge($object, bool $flush = true): bool
    {
        try {
            $this->getEntityManager()->merge($object);

            if ($flush) {
                $this->getEntityManager()->flush();
            }
        } catch (Exception $exception) {
            $this->getServiceLocator()->getNotifyService()->addError($exception->getMessage());
            return false;
        }

        return true;
    }
}