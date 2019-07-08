<?php

namespace App\Tests\Mocks;

use DateTime;
use App\Entity\Contractor;

class ContractorMock
{
    public static function getContractor(): Contractor
    {
        $contractor = new Contractor();
        $contractor->setUser(UserMock::getUser());
        $contractor->setBankNo(self::getBankNo());
        $contractor->setDateAdded(new DateTime());
        $contractor->setRegon(self::getRegon());
        $contractor->setNip(self::getNip());
        $contractor->setName('Contractor test name');
        $contractor->setCity('Laskowa');
        $contractor->setPostcode('34-602');
        $contractor->setAddress('Laskowa 645');
        $contractor->setStatus(true);

        return $contractor;
    }

    private static function getNip(): string
    {
        return rand(1000000000, 9999999999);
    }

    private static function getRegon(): string
    {
        if ((bool)rand(0,1)) {
            return '';
        }

        return rand(1000000000, 9999999999);
    }

    private static function getBankNo(): string
    {
        return sprintf(
            "%s %s %s %s %s",
            rand(1000, 9999),
            rand(1000, 9999),
            rand(1000, 9999),
            rand(1000, 9999),
            rand(1000, 9999)
        );
    }
}