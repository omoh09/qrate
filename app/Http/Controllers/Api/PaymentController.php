<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\Payment\PaymentInterface;
use Illuminate\Http\Request;
use Rave;
class PaymentController extends Controller
{
    //
    private $repository;

    public function __construct(PaymentInterface $repository)
    {
        $this->repository = $repository;
    }

    public function pay(Request  $request)
    {
        $request->validate(
            [
                'user_id' => 'required',
                'checkout_id' => 'required'
            ]
        );

        return $this->repository->pay($request);

    }
    public function callback()
    {
        return $this->repository->callbackRave();
    }

    public function webhook(Request  $request){
        return $this->repository->webhook($request);
    }
}
