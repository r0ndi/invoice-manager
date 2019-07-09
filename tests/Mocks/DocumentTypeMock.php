<?php

namespace App\Tests\Mocks;

use App\Entity\DocumentType;

class DocumentTypeMock
{
    public static function getDocumentType(): DocumentType
    {
        $documentType = new DocumentType();
        $documentType->setName('invoice');

        return $documentType;
    }
}