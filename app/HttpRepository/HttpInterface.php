<?php

namespace App\HttpRepository;

interface HttpInterface 
{
    public function createAddress();

    public function createCostomer();

    public function getcostomer();

    public function getCurrencies();
}