<?php

namespace App\Tests\UnitTests;

use App\Tests\Mocks\DocumentMock;
use App\Service\DocumentService\DocumentFactory;
use App\Service\DocumentService\Document\Invoice;

class DocumentTest extends BaseTest
{
    private $documentFactory;

    public function setUp()
    {
        parent::setUp();

        $this->documentFactory = new DocumentFactory($this->getClient()->getContainer());
    }

    private function getDocumentFactory(): DocumentFactory
    {
        return $this->documentFactory;
    }

    public function testGenerateInvoice()
    {
        $document = DocumentMock::getDocument();
dump($document);exit;
        $invoice = $this->getDocumentFactory()->getDocument(Invoice::class, $document);
        $this->assertEquals(true, $invoice->save(), 'Save Invoice');
        $this->assertEquals('invoice_01-05-2019.pdf', $invoice->getFileName(), 'Invoice file name');
        $this->assertEquals(true, $invoice->remove(), 'Remove Invoice');
    }

}