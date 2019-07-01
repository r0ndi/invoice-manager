<?php

namespace App\Repository;

use App\Entity\Tax;
use App\Util\ServiceLocator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tax|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tax|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tax[]    findAll()
 * @method Tax[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry, ServiceLocator $serviceLocator)
    {
        parent::__construct($registry, Tax::class, $serviceLocator);
    }
}
