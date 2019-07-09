<?php

namespace App\Tests\Mocks;

use App\Entity\Tax;

class TaxMock
{
    public static function getTax(): Tax
    {
        $taxValue = self::getTaxValue();

        $tax = new Tax();
        $tax->setValue($taxValue);
        $tax->setName(self::getName($taxValue));

        return $tax;
    }

    private static function getTaxValue(): int
    {
        return (int)array_rand([0, 5, 8, 23]);
    }

    private static function getName(int $taxValue): string
    {
        switch ($taxValue) {
            case 0:
                return '0%';
            case 5:
                return '5%';
            case 8:
                return '8%';
            case 23:
            default:
                return '23%';
        }
    }
}