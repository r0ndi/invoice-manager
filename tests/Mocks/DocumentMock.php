<?php

namespace App\Tests\Mocks;

use App\Entity\Document;
use DateTime;

class DocumentMock
{
    public static function getDocument(): Document
    {
        $seller = ContractorMock::getContractor();

        $document = new Document();
        $document->setTitle(self::getTitle());
        $document->setUser(UserMock::getUser());
        $document->setBankNo($seller->getBankNo());
        $document->setPaid(self::getPaid());
        $document->setBuyer(ContractorMock::getContractor());
        $document->setPlaceIssue($seller->getCity());
        $document->setPaymentDateLimit(new DateTime('+10'));
        $document->setDateAdded(new DateTime());
        $document->setDateSell(new DateTime());
        $document->setDateIssue(new DateTime());
        $document->setSeller($seller);
        $document->setStatus(true);
        $document->setDocumentType(DocumentTypeMock::getDocumentType());
        $document->setPaymentMethod(PaymentMethodMock::getPaymentMethod());

        $quantity = rand(1, 3);
        for ($i = 0; $i < $quantity; $i++) {
            $document->getPositions()->add(DocumentPositionMock::getDocumentPosition());
        }

        return $document;
    }

    public static function getFileName(string $title): string
    {
        $title = trim(preg_replace('/[a-zA-Z]/', '', $title));
        $title = str_replace(['/', '\\', '_', ' '], '-', $title);

        return sprintf(
            '%s_%s.pdf',
            'invoice',
            $title
        );
    }

    private static function getTitle(): string
    {
        return sprintf(
            "Faktura VAT nr %s",
            date('d/m/Y')
        );
    }

    private static function getPaid(): bool
    {
        return (bool)rand(0, 1);
    }
}