<?php

namespace App\Repository;

use App\Entity\Util;
use App\Util\ServiceLocator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Util|null find($id, $lockMode = null, $lockVersion = null)
 * @method Util|null findOneBy(array $criteria, array $orderBy = null)
 * @method Util[]    findAll()
 * @method Util[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry, ServiceLocator $serviceLocator)
    {
        parent::__construct($registry, Util::class, $serviceLocator);
    }
}
