<?php

namespace App\Tests\Mocks;

use App\Entity\Document;

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
        $document->setDateAdded(new \DateTime());
        $document->setSeller($seller);
        $document->setStatus(true);

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