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

        return $document;
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