<?php

namespace App\Util;

use NumberToWords\NumberToWords;

class Money
{
    private const DEFAULT_FULL_CURRENCY = 'PLN';
    private const DEFAULT_CURRENCY = 'zł';
    private const DEFAULT_LANG = 'pl';

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
        $numberToWords = new NumberToWords();
        $currencyTransformer = $numberToWords->getCurrencyTransformer(self::DEFAULT_LANG);

        $thousands = 0;
        $decimals = $value;

        if (strpos($value, '.') !== false) {
            $decimals = substr($value, 0, strpos($value, '.'));
            $thousands = substr($value, strpos($value, '.') + 1, strlen($value));
            if (strlen($thousands) <= 1) {
                $thousands .= 0;
            }
        }

        $value = (int)$decimals * 100;
        if ($thousands > 0) {
            $value = (int)($decimals . $thousands);
        }

        return $currencyTransformer->toWords($value, self::DEFAULT_FULL_CURRENCY) . ' ' . self::DEFAULT_FULL_CURRENCY;
    }
}