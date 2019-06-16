<?php

namespace App\Repository;

use App\Entity\DocumentPosition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DocumentPosition|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentPosition|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentPosition[]    findAll()
 * @method DocumentPosition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentPositionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DocumentPosition::class);
    }
}
