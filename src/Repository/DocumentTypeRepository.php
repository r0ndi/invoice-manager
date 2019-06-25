<?php

namespace App\Repository;

use App\Entity\DocumentType;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DocumentType|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentType|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentType[]    findAll()
 * @method DocumentType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentTypeRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DocumentType::class);
    }
}
