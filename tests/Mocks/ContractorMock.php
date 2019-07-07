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
        $contractor->setName('Contractor test name');
        $contractor->setCity('Laskowa');
        $contractor->setStatus(true);

        return $contractor;
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