<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class InvoiceService extends Service
{
    public function generateInvoice()
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'DejaVu Sans');
        $pdfOptions->setIsHtml5ParserEnabled(true);
        $pdfOptions->setIsRemoteEnabled(true);

        $html = $this->getTwig()->render(
            'template/document/invoice.html.twig',
            $this->getInvoiceData()
        );

        $domPdf = new Dompdf($pdfOptions);
        $domPdf->loadHtml($html, 'UTF-8');
        $domPdf->setPaper('A4', 'portrait');
        $domPdf->render();

        $domPdf->stream('test.pdf', [
            'Attachment' => false
        ]);
    }

    private function getInvoiceData(): array
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