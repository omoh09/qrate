<?php

namespace  App\Repository\Payment;

use Illuminate\Http\Request;

interface PaymentInterface
{
    public function pay(Request $request);

    public function callback();

    public function webhook(Request $request);
}
