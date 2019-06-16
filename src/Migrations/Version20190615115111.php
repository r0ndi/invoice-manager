<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\DocumentType;
use App\Entity\PaymentMethod;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManager;
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
        $documentType = new DocumentType();
        $documentType->setName('invoice');
        $this->getEntityManager()->persist($documentType);

        $paymentMethod = new PaymentMethod();
        $paymentMethod->setName('gotówka');
        $this->getEntityManager()->persist($paymentMethod);

        $paymentMethod = new PaymentMethod();
        $paymentMethod->setName('przelew');
        $this->getEntityManager()->persist($paymentMethod);

        $this->getEntityManager()->flush();
    }

    public function down(Schema $schema) : void
    {
        $documentType = $this->getEntityManager()
            ->getRepository(DocumentType::class)
            ->findOneBy(['name' => 'invoice']);

        $this->getEntityManager()->remove($documentType);

        $paymentMethods = $this->getEntityManager()
            ->getRepository(PaymentMethod::class)
            ->findAll();

        foreach ($paymentMethods as $paymentMethod) {
            $this->getEntityManager()->remove($paymentMethod);
        }

        $this->getEntityManager()->flush();
    }

    private function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }
}