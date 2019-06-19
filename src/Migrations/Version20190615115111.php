<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Tax;
use App\Entity\Util;
use App\Entity\DocumentType;
use App\Entity\PaymentMethod;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class Version20190615115111 extends AbstractMigration implements ContainerAwareInterface
{
    private $entityManager;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
    }

    public function up(Schema $schema) : void
    {
        $documentTypes = ['invoice'];
        $this->addItems(DocumentType::class, $documentTypes);

        $paymentMethods = ['przelew', 'gotówka'];
        $this->addItems(PaymentMethod::class, $paymentMethods);

        $taxes = [23,8,5,0];
        $this->addItems(Tax::class, $taxes);

        $utils = ['usł.', 'szt.', 'godz.', 'dni'];
        $this->addItems(Util::class, $utils);
    }

    public function down(Schema $schema) : void
    {
        $this->deleteItems(Tax::class);
        $this->deleteItems(Util::class);
        $this->deleteItems(DocumentType::class);
        $this->deleteItems(PaymentMethod::class);
    }

    private function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    private function addItems(string $entityName, array $items): void
    {
        foreach ($items as $item) {
            $object = new $entityName();
            $object->setName($item);

            $this->getEntityManager()->persist($object);
        }

        $this->getEntityManager()->flush();
    }

    private function deleteItems(string $entityName): void
    {
        $items = $this->getEntityManager()
            ->getRepository($entityName)
            ->findAll();

        foreach ($items as $item) {
            $this->getEntityManager()->remove($item);
        }

        $this->getEntityManager()->flush();
    }
}