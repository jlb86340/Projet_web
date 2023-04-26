<?php

namespace App\Services\PasswordService;

class PasswordService
{
    public function testPassword($password): bool
    {
    if (strlen($password) < 6 || $password=="azerty" || $password=="qwerty" || $password=="123456"){
        return false;
    }
    return true;
    }
}
