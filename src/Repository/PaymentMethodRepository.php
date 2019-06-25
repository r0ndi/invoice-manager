<?php

namespace App\Repository;

use App\Entity\PaymentMethod;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PaymentMethod|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentMethod|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentMethod[]    findAll()
 * @method PaymentMethod[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentMethodRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PaymentMethod::class);
    }
}
