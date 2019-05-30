<?php

namespace App\Service\DocumentService;

use App\Exception\DocumentException;
use App\Exception\InvoiceManagerException;
use Symfony\Component\HttpFoundation\Response;
use App\Service\DocumentService\Document\Document;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DocumentFactory implements Factory
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getDocument(string $documentClass): Document
    {
        if (class_exists($documentClass)) {
            return new $documentClass($this->container);
        }

        throw new DocumentException(
            "Document type not found [$documentClass]",
            InvoiceManagerException::INVALID_ARGUMENTS,
            Response::HTTP_BAD_REQUEST
        );
    }

}