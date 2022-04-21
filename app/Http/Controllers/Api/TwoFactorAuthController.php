<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\TwoFactorAuth\TwoFactorAuthInterface;
use Illuminate\Http\Request;

class TwoFactorAuthController extends Controller
{
    /**
     * @var
     */
    private $repository;

    /**
     * TwoFactorAuthController constructor.
     * @param TwoFactorAuthInterface $repository
     */
    public function __construct(TwoFactorAuthInterface $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @return mixed
     */
    public function on()
    {
        return $this->repository->on();
    }

    /**
     * @return mixed
     */
    public function off()
    {
        return $this->repository->off();
    }
}
