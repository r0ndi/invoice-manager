<?php

namespace App\Service\DocumentService\Document;

use App\Entity\Document as DocumentEntity;

class Invoice extends Document
{
    protected $template = 'invoice.html.twig';

    public function getFileName(): string
    {
        $title = $this->getDocumentEntity()->getTitle();
        $title = trim(preg_replace('/[a-zA-Z]/', '', $title));
        $title = str_replace(['/', '\\', '_', ' '], '-', $title);

        return sprintf(
            '%s_%s.pdf',
            'invoice',
            $title
        );
    }

    public function save(): bool
    {
        $this->getPdfFile()->append($this->getDomPdf()->output());
        $this->setPdfFile();

        return true;
    }

    public function remove(): bool
    {
        return $this->getPdfFile()->delete();
    }

    public function preview(): void
    {
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename=' . $this->getFileName());
        header('Cache-Control: private, max-age=0, must-revalidate');
        echo $this->getPdfFile()->getContent();
        exit;
    }

    public function download(): void
    {
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename=' . $this->getFileName());
        echo $this->getPdfFile()->getContent();
        exit;
    }

    protected function getTemplateData(): array
    {
        $document = $this->getDocumentEntity();
        $position = $document->getPositions()->first();

        return [
            'placeIssue' => $document->getPlaceIssue(),
            'dateIssue' => date('Y-m-d', strtotime($document->getDateIssue())),
            'dateSell' => date('Y-m-d', strtotime($document->getDateSell())),
            'logo' => '../storage/logos/logo-1.png',
            'invoiceTitle' => $document->getTitle(),
            'paid' => $document->getPaid(),
            'paymentMethod' => $document->getPaymentMethod()->getName(),
            'paymentDeadline' => date('Y-m-d', strtotime($document->getPaymentDateLimit())),
            'bankNo' => $document->getBankNo(),
            'toPay' => '10 455,00 PLN',
            'toPayInWords' => 'dziesięć tysięcy cztersyta piędziesiąt pięć PLN',
            'seller' => [
                'name' => $document->getSeller()->getName(),
                'address' => $document->getSeller()->getFullAddress(),
                'nip' => $document->getSeller()->getNip(),
                'regon' => $document->getSeller()->getRegon(),
            ],
            'buyer' => [
                'name' => $document->getBuyer()->getName(),
                'address' => $document->getBuyer()->getFullAddress(),
                'nip' => $document->getBuyer()->getNip(),
                'regon' => $document->getBuyer()->getRegon(),
            ],
            'positions' => [
                [
                    'name' => $position->getName(),
                    'unit' => $position->getUtil()->getName(),
                    'quantity' => $position->getQauntity(),
                    'netPrice' => '8 500,00',
                    'netValue' => '8 500,00',
                    'grossValue' => '10 455,00',
                    'tax' => $position->getTax()->getName(),
                    'taxValue' => '1 955,00'
                ]
            ],
            'taxSummary' => [
                [
                    'name' => '23%',
                    'netValue' => '8 500,00',
                    'grossValue' => '10 455,00',
                    'taxValue' => '1 955,00'
                ],
            ],
            'summary' => [
                'netValue' => '8 500,00',
                'grossValue' => '10 455,00',
                'taxValue' => '1 955,00'
            ]
        ];
    }
}