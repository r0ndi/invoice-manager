<?php

namespace App\Service\DocumentService\Document;

use App\Util\Money;
use App\Util\PriceCalculator;
use Doctrine\Common\Collections\Collection;

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
        $toPay = $this->getToPay($document->getPositions());

        return [
            'placeIssue' => $document->getPlaceIssue(),
            'dateIssue' => $document->getDateIssue()->format('Y-m-d'),
            'dateSell' => $document->getDateSell()->format('Y-m-d'),
            'logo' => '../storage/logos/logo-1.png',
            'invoiceTitle' => $document->getTitle(),
            'paid' => $document->getPaid(),
            'paymentMethod' => $document->getPaymentMethod()->getName(),
            'paymentDeadline' => $document->getPaymentDateLimit()->format('Y-m-d'),
            'bankNo' => $document->getBankNo(),
            'toPay' => Money::format($toPay, true),
            'toPayInWords' => Money::formatToText($toPay),
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
            'positions' => $this->getPositions($document->getPositions()),
            'taxSummary' => $this->getTaxSummary($document->getPositions()),
            'summary' => $this->getSummary($document->getPositions())
        ];
    }

    private function getTaxSummary(Collection $positions): array
    {
        if ($positions->count() <= 0) {
            return [];
        }

        $taxSummary = [];
        foreach ($positions as $position) {
            $index = $position->getTax()->getValue();

            if (!isset($taxSummary[$index])) {
                $taxSummary[$index] = [
                    'name' => $position->getTax()->getName(),
                    'tax' => $position->getTax(),
                    'netValue' => 0
                ];
            }

            $taxSummary[$index]['netValue'] += $position->getPrice() * $position->getQuantity();
        }

        foreach ($taxSummary as &$tax) {
            $priceCalculator = new PriceCalculator($tax['netValue'], $tax['tax']);

            $tax['taxValue'] = Money::format($priceCalculator->getTaxValue());
            $tax['netValue'] = Money::format($priceCalculator->getNetValue());
            $tax['grossValue'] = Money::format($priceCalculator->getGrossValue());

            unset($tax['tax']);
        }

        return $taxSummary;
    }

    private function getSummary(Collection $positions): array
    {
        if ($positions->count() <= 0) {
            return [];
        }

        $summary = [];
        foreach ($positions as $position) {
            if (!$summary) {
                $summary = [
                    'taxValue' => 0,
                    'netValue' => 0,
                    'grossValue' => 0
                ];
            }

            $priceCalculator = new PriceCalculator($position->getPrice(), $position->getTax(), $position->getQuantity());

            $summary['taxValue'] += $priceCalculator->getTaxValue();
            $summary['netValue'] += $priceCalculator->getNetValue();
            $summary['grossValue'] += $priceCalculator->getGrossValue();
        }

        $summary['taxValue'] = Money::format($summary['taxValue']);
        $summary['netValue'] = Money::format($summary['netValue']);
        $summary['grossValue'] = Money::format($summary['grossValue']);

        return $summary;
    }

    private function getToPay(Collection $positions): float
    {
        if ($positions->count() <= 0) {
            return 0;
        }

        $toPay = 0;
        foreach ($positions as $position) {
            $priceCalculator = new PriceCalculator($position->getPrice(), $position->getTax(), $position->getQuantity());
            $toPay += $priceCalculator->getGrossValue();
        }

        return $toPay;
    }

    private function getPositions(Collection $positions): array
    {
        if ($positions->count() <= 0) {
            return [];
        }

        $positionsData = [];
        foreach ($positions as $position) {
            $priceCalculator = new PriceCalculator($position->getPrice(), $position->getTax(), $position->getQuantity());

            $positionsData[] = [
                'name' => $position->getName(),
                'quantity' => $position->getQuantity(),
                'tax' => $position->getTax()->getName(),
                'unit' => $position->getUtil()->getName(),
                'netPrice' => Money::format($priceCalculator->getNet()),
                'taxValue' => Money::format($priceCalculator->getTaxValue()),
                'netValue' => Money::format($priceCalculator->getNetValue()),
                'grossValue' => Money::format($priceCalculator->getGrossValue()),
            ];
        }

        return $positionsData;
    }
}