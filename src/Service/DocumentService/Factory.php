<?php

namespace App\Service\DocumentService;

use App\Entity\Document as DocumentEntity;
use App\Service\DocumentService\Document\Document;

interface Factory
{
    public function getDocument(string $documentClass, DocumentEntity $documentEntity): Document;
}