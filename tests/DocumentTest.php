<?php

namespace App\Tests;

use App\Entity\Document;
use App\Entity\User;
use App\Tests\Mocks\EntityMock;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Client;
use App\Service\DocumentService\DocumentFactory;
use App\Service\DocumentService\Document\Invoice;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DocumentTest extends WebTestCase
{
    private $client;
    private $documentFactory;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->documentFactory = new DocumentFactory($this->getClient()->getContainer());
    }

    private function getClient(): Client
    {
        return $this->client;
    }

    private function getDocumentFactory(): DocumentFactory
    {
        return $this->documentFactory;
    }

    public function testGenerateInvoice()
    {
        $document = new Document();
        $document->setTitle('Faktura VAT nr 01/05/2019');
        $document->setUser(EntityMock::getUser());
        $document->setPaid(false);

        dump($document);exit;

        $documentRepository = $this->createMock(ObjectRepository::class);
        $documentRepository->expects($this->any())
            ->method('find')
            ->willReturn($document);

        $invoice = $this->getDocumentFactory()->getDocument(Invoice::class, $document);
        $this->assertEquals(true, $invoice->save(), 'Save Invoice');
        $this->assertEquals('invoice_01-05-2019.pdf', $invoice->getFileName(), 'Invoice file name');
        $this->assertEquals(true, $invoice->remove(), 'Remove Invoice');
    }

}