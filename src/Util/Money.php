<?php

namespace App\Util;

class Money
{
    private const DEFAULT_CURRENCY = 'zł';

    public static function format(float $value, bool $showCurrency = false, string $currency = self::DEFAULT_CURRENCY): string
    {
        return sprintf(
            '%s%s',
            number_format($value, 2, ',', ' '),
            $showCurrency ? ' ' . $currency : ''
        );
    }

    public static function formatToText(float $value): string
    {
        return $value;
    }
}