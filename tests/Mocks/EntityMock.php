<?php

namespace App\Tests\Mocks;

use App\Entity\User;

class EntityMock
{
    public static function getUser(): User
    {
        $hashPassword = '$2y$13$/7n7WmHAJOLjZTit/6whA.v/6meSJSjEB6452Uz.uBD2uTo67NBR6';

        $user = new User();
        $user->setFirstname('Konrad');
        $user->setLastname('Sądel');
        $user->setEmail('sadelkonrad@gmail.com');
        $user->setPassword($hashPassword);
        $user->setIsActive(true);
        $user->setLogoUrl('');

        return $user;
    }
}