<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\DocumentType;
use App\Entity\PaymentMethod;
use App\Entity\Tax;
use App\Entity\Util;
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

        $paymentMethods = ['przelew', 'gotówka'];
        foreach ($paymentMethods as $paymentMethodName) {
            $paymentMethod = new PaymentMethod();
            $paymentMethod->setName($paymentMethodName);

            $this->getEntityManager()->persist($paymentMethod);
        }

        $taxes = [23,8,5,0];
        foreach ($taxes as $tax) {
            $taxObj = new Tax();
            $taxObj->setName($tax . '%');
            $taxObj->setValue($tax);

            $this->getEntityManager()->persist($taxObj);
        }

        $utils = ['usł.', 'szt.', 'godz.', 'dni'];
        foreach ($utils as $util) {
            $utilObj = new Util();
            $utilObj->setName($util);

            $this->getEntityManager()->persist($utilObj);
        }

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