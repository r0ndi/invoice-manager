<?php

namespace App\Tests\Mocks;

use App\Entity\Util;

class UtilMock
{
    public static function getUtil(): Util
    {
        $util = new Util();
        $util->setName(self::getName());

        return $util;
    }

    private static function getName(): string
    {
        switch (rand(1, 4)) {
            case 1:
                return 'usł';
            case 2:
                return 'szt.';
            case 3:
                return 'godz.';
            case 4:
            default:
                return 'dni';
        }
    }
}