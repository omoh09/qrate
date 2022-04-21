<?php

namespace App\Repository\Crypto;

use Illuminate\Http\Request;

class CryptoRepository implements CryptoRepositoryINterface
{
    /**
     * @var httpInterface
     */
    protected $repository;

    public function __construct(httpInterface $repository){
        $this->repository = $repository;
    }

    public function getAllAddress(){
        return $this->repository->getAllAddress();
    }
}
