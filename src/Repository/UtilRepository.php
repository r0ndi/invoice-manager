<?php

namespace App\Repository;

use App\Entity\Util;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Util|null find($id, $lockMode = null, $lockVersion = null)
 * @method Util|null findOneBy(array $criteria, array $orderBy = null)
 * @method Util[]    findAll()
 * @method Util[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Util::class);
    }

    public function getAllToForm(): array
    {
        return array_map(function (Util $util) {
            return [$util->getName() => $util->getId()];
        }, $this->findAll());
    }
}
