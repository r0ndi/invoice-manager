<?php

namespace App\Util;

class NotifyMessageType
{
    public const INFO = 1;
    public const ERROR = 2;
    public const SUCCESS = 3;
    public const WARNING = 4;

    public static function getTypeName(int $type): string
    {
        switch ($type) {
            case self::ERROR:
                return 'error';
            case self::SUCCESS:
                return 'success';
            case self::WARNING:
                return 'warning';
            case self::INFO:
            default:
                return 'info';
        }
    }
}