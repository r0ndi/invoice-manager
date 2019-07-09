<?php

namespace App\Tests\UnitTests;

use App\Tests\Mocks\DocumentMock;
use App\Service\DocumentService\DocumentFactory;
use App\Service\DocumentService\Document\Invoice;

class DocumentTest extends Base
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

    public function testFileName()
    {
        $document = DocumentMock::getDocument();
        $invoice = $this->getDocumentFactory()->getDocument(Invoice::class, $document);

        $this->assertEquals(DocumentMock::getFileName($document->getTitle()), $invoice->getFileName());
    }

    public function testSave(): void
    {
        $document = DocumentMock::getDocument();
        $invoice = $this->getDocumentFactory()->getDocument(Invoice::class, $document);

        $this->assertTrue($invoice->save());
    }

    public function testRemove(): void
    {
        $document = DocumentMock::getDocument();
        $invoice = $this->getDocumentFactory()->getDocument(Invoice::class, $document);

        $this->assertTrue($invoice->remove());
    }

}