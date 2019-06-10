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
            'dateIssue' => '2019-05-31',//date('Y-m-d'),
            'dateSell' => '2019-05-31',//date('Y-m-d'),
            'logo' => '../storage/logos/logo-1.png',
            'invoiceTitle' => 'Faktura VAT nr 02/05/2019',
            'paid' => false,
            'paymentMethod' => 'przelew',
            'paymentDeadline' => '2019-06-10',//date('Y-m-d', strtotime('+ 10 DAY')),
            'bankNo' => '34 1050 1445 1000 0092 5036 1947',
            'toPay' => '10 455,00 PLN',
            'toPayInWords' => 'dziesięć tysięcy cztersyta piędziesiąt pięć PLN',
            'seller' => [
                'name' => 'Dream Apps Konrad Sądel',
                'address' => 'Laskowa 645, 34-602 Laskowa',
                'nip' => '7372210996',
                'regon' => '',
            ],
            'buyer' => [
                'name' => 'PRINTBOX SPÓŁKA Z OGRANICZONĄ ODPOWIEDZIALNOŚCIĄ',
                'address' => 'Rynek Główny 17, 31-008 Kraków',
                'nip' => '6762470210',
                'regon' => '',
            ],
            'positions' => [
                [
                    'name' => 'Usługi programistyczne',
                    'unit' => 'usł.',
                    'quantity' => 1,
                    'netPrice' => '8 500,00',
                    'netValue' => '8 500,00',
                    'grossValue' => '10 455,00',
                    'tax' => '23%',
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