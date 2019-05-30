<?php

namespace App\Service\DocumentService;

use App\Service\DocumentService\Document\Document;

interface Factory
{
    public function getDocument(string $documentClass): Document;
}