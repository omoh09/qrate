<?php

namespace App\Repository\TwoFactorAuth;

interface TwoFactorAuthInterface
{
    public function on();

    public function off();
}
