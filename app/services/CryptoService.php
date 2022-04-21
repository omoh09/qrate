<?php

namespace App\services;

use App\HttpRepository\HttpRepository;
use App\HttpRepository\HttpInterface;

class CryptoService extends \App\Providers\AppServiceProvider
{
    
    protected $HtpRepository;

    public function __construct(HtpRepository $HtpRepository)
    {
        $this->HtpRepository = $htpRepository;
    }

    /**
     * @param string default ='USDT'
     * @param string default ='POLYGON'
     * @return mixed
     */
    public function createNewAddress($code, $network)
    {
        return $this->$htpRepository->createNewAddress($code, $network);
    }

     /**
     * @param array $paymentData
     * @return mixed
     */
    public function createNewPaymentLink($amount, $description, $title)
    {
        $paymentData = array(
            'amount' => $amount,
            'description'=> $description,
            'title' => $description,
        );
        return $this->HtpRepository->createNewPaymentLink($paymentData);
    }

    /**
     * @return mixed
     */
    public function getCurrencies()
    {
        $result = $this->$HtpRepository->getCurrencies();
        $data = [];
        foreach($result['currencies'] as $currency)
        {
            if(isset($currency['code'])){
                array_push($data, $currency['code']);
            }
        }
        return $data;
    }

}