<?php

namespace App\Util;

use App\Entity\Tax;

class PriceCalculator
{
    private $tax;
    private $quantity;
    private $netPrice;

    public function __construct(float $netPrice, Tax $tax, int $quantity = 1)
    {
        $this->tax = $tax;
        $this->quantity = $quantity;
        $this->netPrice = $netPrice;
    }

    public function getNet(): float
    {
        return $this->netPrice;
    }

    public function getGross(): float
    {
        return $this->netPrice * (100 + $this->tax->getValue()) / 100;
    }

    public function getTax(): float
    {
        return $this->getGross() - $this->getNet();
    }

    public function getNetValue(): float
    {
        return $this->getNet() * $this->quantity;
    }

    public function getGrossValue(): float
    {
        return $this->getGross() * $this->quantity;
    }

    public function getTaxValue(): float
    {
        return $this->getGrossValue() - $this->getNetValue();
    }

}