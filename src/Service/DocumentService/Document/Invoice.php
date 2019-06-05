<?php

namespace App\Service\DocumentService\Document;

use App\Util\ConfigReader;
use App\Util\File;

class Invoice extends Document
{
    protected $template = 'invoice.html.twig';

    public function getFileName(): string
    {
        return sprintf(
            '%s_%s.pdf',
            'invoice',
            '01-05-2019'
        );
    }

    public function save(): bool
    {
        $configReader = new ConfigReader();
        $file = new File($configReader->get('documents.path'), $this->getFileName());

        return $file->clear() && $file->append($this->getDomPdf()->output());
    }

    public function remove(): bool
    {
        $configReader = new ConfigReader();
        $file = new File($configReader->get('documents.path'), $this->getFileName());

        return $file->delete();
    }

    public function show(): bool
    {
        return true;
    }

    public function download(): bool
    {
        $this->getDomPdf()->stream(
            $this->getFileName(), [
            'Attachment' => false
        ]);

        return true;
    }

    protected function getTemplateData(): array
    {
        return [
            'placeIssue' => 'Laskowa',
            'dateIssue' => date('Y-m-d'),
            'dateSell' => date('Y-m-d'),
            'logo' => '../storage/logos/logo-1.png',
            'invoiceTitle' => 'Faktura VAT nr 01/05/2019',
            'paid' => false,
            'paymentMethod' => 'przelew',
            'paymentDeadline' => date('Y-m-d', strtotime('+ 10 DAY')),
            'bankNo' => '34 1050 1445 1000 0092 5036 1947',
            'toPay' => '307,50 PLN',
            'toPayInWords' => 'trzysta siedem 50/100 PLN',
            'seller' => [
                'name' => 'Dream Apps Konrad Sądel',
                'address' => 'Laskowa 645, 34-602 Laskowa',
                'nip' => '7372210996',
                'regon' => '',
            ],
            'buyer' => [
                'name' => 'Art-Be Marta Mitan',
                'address' => 'Laskowa 421, 34-602 Laskowa',
                'nip' => '7371024027',
                'regon' => '',
            ],
            'positions' => [
                [
                    'name' => 'Usługi hostingowe',
                    'unit' => 'usł.',
                    'quantity' => 1,
                    'netPrice' => '250,00',
                    'netValue' => '250,00',
                    'grossValue' => '307,50',
                    'tax' => '23%',
                    'taxValue' => '57,50'
                ]
            ],
            'taxSummary' => [
                [
                    'name' => '23%',
                    'netValue' => '250,00',
                    'grossValue' => '307,50',
                    'taxValue' => '57,50'
                ],
            ],
            'summary' => [
                'netValue' => '250,00',
                'grossValue' => '307,50',
                'taxValue' => '57,50'
            ]
        ];
    }
}