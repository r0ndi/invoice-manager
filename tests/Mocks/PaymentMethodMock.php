<?php

namespace App\Tests\Mocks;

use App\Entity\PaymentMethod;

class PaymentMethodMock
{
    public static function getPaymentMethod(): PaymentMethod
    {
        $paymentMethod = new PaymentMethod();
        $paymentMethod->setName(self::getMethodName());

        return $paymentMethod;
    }

    private static function getMethodName(): string
    {
        if (rand(0, 1)) {
            return 'gotówka';
        }

        return 'przelew';
    }
}