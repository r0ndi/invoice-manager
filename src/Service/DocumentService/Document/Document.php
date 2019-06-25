<?php

namespace App\Service\DocumentService\Document;

use App\Util\File;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Service\Service;
use App\Util\ConfigReader;
use App\Entity\Document as DocumentEntity;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class Document extends Service
{
    private $domPdf;
    private $pdfFile;
    private $pdfOptions;

    protected $template;
    protected $documentEntity;
    protected $path = 'template/document/';

    public function __construct(ContainerInterface $container, DocumentEntity $documentEntity)
    {
        parent::__construct($container);

        $this->setUp($documentEntity);
    }

    abstract public function save(): bool;
    abstract public function remove(): bool;
    abstract public function preview(): void;
    abstract public function download(): void;
    abstract public function getFileName(): string;

    protected function getPdfContent(): string
    {
        return $this->getTwig()->render($this->path . $this->template, $this->getTemplateData());
    }

    protected function setDomPdf(): void
    {
        $this->domPdf = new Dompdf($this->pdfOptions);
        $this->domPdf->loadHtml($this->getPdfContent(), 'UTF-8');
        $this->domPdf->setPaper('A4', 'portrait');
        $this->domPdf->render();
    }

    protected function getDomPdf(): Dompdf
    {
        return $this->domPdf;
    }

    protected function getTemplateData(): array
    {
        return [];
    }

    protected function getPdfFile(): File
    {
        return $this->pdfFile;
    }

    protected function getDocumentEntity(): DocumentEntity
    {
        return $this->documentEntity;
    }

    protected function setPdfOptions(array $customOptions = []): void
    {
        $options = array_merge(
            ['defaultFont', 'DejaVu Sans'],
            $customOptions
        );

        $this->pdfOptions = new Options();
        $this->pdfOptions->setIsHtml5ParserEnabled(true);
        $this->pdfOptions->setIsRemoteEnabled(true);
        $this->pdfOptions->set($options);
    }

    protected function setPdfFile(): void
    {
        $configReader = new ConfigReader();
        $this->pdfFile = new File($configReader->get('documents.path'), $this->getFileName(), true);
    }

    private function setDocumentEntity(DocumentEntity $documentEntity): void
    {
        $this->documentEntity = $documentEntity;
    }

    private function setUp(DocumentEntity $documentEntity): void
    {
        $this->setDocumentEntity($documentEntity);
        $this->setPdfFile();

        if (!$this->getPdfFile()->getWeight()) {

            $this->setPdfOptions();
            $this->setDomPdf();
        }
    }

}