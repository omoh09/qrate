<?php

namespace App\HttpRepository;

use Illuminate\Support\Facades\Http;
use App\HttpRepository\HttpInterface;

class HttpRepository implements HttpInterface
{
    //public $url = 'https://api.fluidcoins.com/v1/address';

    // public function __construct(){
    //     //$this->client = new \GuzzleHttp\Client();
    // }

    public function createAddress($code = 'USDT', $network = 'POLYGON'){
        $url = 'https://api.fluidcoins.com/v1/address';
        $client = new \GuzzleHttp\Client();
       
        $headers = array(
            'key' => 'pk_test_81d56946ded9479e941e258d8f4da824',
            'Content-Type' => 'application/json',
            'Accept'=> 'application/json',
            'Authorization'=> 'Bearer sk_test_7363d20b23bf4af99882cd8df11f177e',
         );
         $form_param = array(
            'code' => $code,
            'network' => $network
         );
        $response = $client->request('POST', $url, ['form_param' => $form_param], ['headers' => $headers]);
        return json_decode($response->getBody());
    }

    public function createCostomer()
    {
        $url = 'https://api.fluidcoins.com/v1/customers';
        $client = new \GuzzleHttp\Client();
        $data = [
            'email' => 'omoh@email.com',
            'full_name' => 'omoh',
            'phone' => [
                'code' => '+234',
                'phone' => '9123456789'
            ]
        ];
        $headers = array(
            'key' => 'pk_test_81d56946ded9479e941e258d8f4da824',
            'Content-Type' => 'application/json',
            'Accept'=> 'application/json',
            'Authorization' => 'Bearer sk_test_7363d20b23bf4af99882cd8df11f177e',
            'debug' => true,
         );
        $response = $client->request('POST', $url, 
        ['form_params' => $data],
        ['headers' => $headers]);
        return $response->getBody();
    }

    public function getCostomer(){
        $url = 'https://api.fluidcoins.com/v1/customers/reference';
        $client = new \GuzzleHttp\Client();
        $headers = array(
            'key' => 'pk_test_81d56946ded9479e941e258d8f4da824',
            'Content-Type' => 'application/json',
            'Accept'=> 'application/json',
            'Authorization'=> 'Bearer sk_test_7363d20b23bf4af99882cd8df11f177e',
         );
        $response = $client->request('GET', $url, ['headers' => $headers]);
        dd($response);
        if ($response->status != true)
        {
            return "Costomer does not exist!";        
        }
        return $response->getBody();
    }

    public function getCurrencies()
    {
        $data = [];
        $url = 'https://api.fluidcoins.com/v1/currencies';
        $client = new \GuzzleHttp\Client();
        $headers = array(
            'key' => 'pk_test_81d56946ded9479e941e258d8f4da824',
            'Content-Type' => 'application/json',
            'Accept'=> 'application/json',
            'Authorization'=> 'Bearer sk_test_7363d20b23bf4af99882cd8df11f177e',
         );
        $response = $client->request('GET', $url, ['headers' => $headers]);
        $result = json_decode($response->getBody(), true);
        //return $result;
        foreach($result['currencies'] as $currency)
        {
            if(isset($currency['code'])){
                array_push($data, $currency['code']);
            }
        }
        return $data;
    }
    /* Check if the user exsit with fluidcoin else register 
       *  create the currecy link which is the payment link for all cypto 
       *  Show the address of the currency selected above 
       *  if payment is successful
       *  a webhook will be sent to me to track the payment details
       */

    
}

