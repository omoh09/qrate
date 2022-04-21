<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HttpRepository\HttpInterface;

class CryptoController extends Controller
{
    //
     /**
     * @var HttpInterface
     */
     protected $repository;

    public function __construct(HttpInterface $repository){
        $this->repository = $repository;
    }

    public function cryptoPay()
    {

    }

    public function allAdress(Request $request){
        //return $this->repository->createCostomer(); 
        //return $this->repository->getCurrencies();
        return $this->repository->createCostomer();
        //return $this->repository->getAllAddress();
    }
}
