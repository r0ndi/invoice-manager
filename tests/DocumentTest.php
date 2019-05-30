<?php

namespace App\Tests;

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
        $invoice = $this->getDocumentFactory()->getDocument(Invoice::class);
        $this->assertEquals('invoice_01-05-2019.pdf', $invoice->getFileName());
        $this->assertEquals(true, $invoice->save());
        $this->assertEquals(true, $invoice->remove());
    }

}