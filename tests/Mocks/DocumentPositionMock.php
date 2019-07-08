<?php

namespace App\Tests\Mocks;

use App\Entity\DocumentPosition;

class DocumentPositionMock
{
    public static function getDocumentPosition(): DocumentPosition
    {
        $documentPosition = new DocumentPosition();
        $documentPosition->setTax(TaxMock::getTax());
        $documentPosition->setPrice(self::getPrice());
        $documentPosition->setUtil(UtilMock::getUtil());
        $documentPosition->setQuantity(self::getQuantity());
        $documentPosition->setName('Usługi programistyczne');

        return $documentPosition;
    }

    private static function getQuantity(): int
    {
        return rand(1, 5);
    }

    private static function getPrice(): int
    {
        return rand(100, 5000);
    }
}