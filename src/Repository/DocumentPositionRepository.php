<?php

namespace App\Repository;

use App\Util\ServiceLocator;
use App\Entity\DocumentPosition;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DocumentPosition|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentPosition|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentPosition[]    findAll()
 * @method DocumentPosition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentPositionRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry, ServiceLocator $serviceLocator)
    {
        parent::__construct($registry, DocumentPosition::class, $serviceLocator);
    }
}
