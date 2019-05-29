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
            'template/invoice.html.twig',
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
            'invoiceTitle' => 'Faktura VAT nr 01/04/2019',
            'paid' => true,
            'paymentMethod' => 'przelew',
            'paymentDeadline' => date('Y-m-d'),
            'bankNo' => '34 1050 1445 1000 0092 5036 1947',
            'toPay' => '12 238,50 PLN',
            'toPayInWords' => 'dwanaście tysiecy dwieście trzydziesci osiem 50/100 PLN',
            'seller' => [
                'name' => 'Dream Apps Konrad Sądel',
                'address' => 'Laskowa 645, 34-602 Laskowa',
                'nip' => '7732211996',
                'regon' => '102382424',
            ],
            'buyer' => [
                'name' => 'Printbox',
                'address' => 'Rynek Głowny 17, 30-008 Kraków',
                'nip' => '7372210993',
                'regon' => '2842882',
            ],
            'positions' => [
                [
                    'name' => 'Usługi programistyczne',
                    'unit' => 'usł.',
                    'quantity' => 1,
                    'netPrice' => '9 950,00',
                    'netValue' => '9 950,00',
                    'grossValue' => '12 238,50',
                    'tax' => '23%',
                    'taxValue' => '2 288,50'
                ]
            ],
            'taxSummary' => [
                [
                    'name' => '23%',
                    'netValue' => '9 950,00',
                    'grossValue' => '12 238,50',
                    'taxValue' => '2 288,50'
                ],
            ],
            'summary' => [
                'netValue' => '9 950,00',
                'grossValue' => '12 238,50',
                'taxValue' => '2 288,50'
            ]
        ];
    }
}