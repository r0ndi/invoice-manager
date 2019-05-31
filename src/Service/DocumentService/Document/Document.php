<?php

namespace App\Service\DocumentService\Document;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Service\Service;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class Document extends Service
{
    private $domPdf;
    private $pdfOptions;

    protected $template;
    protected $path = 'template/document/';

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->setPdfOptions();
        $this->setDomPdf();
    }

    abstract public function save(): bool;
    abstract public function remove(): bool;
    abstract public function show(): bool;
    abstract public function download(): bool;
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

}