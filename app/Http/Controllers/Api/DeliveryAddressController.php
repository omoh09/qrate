<?php

namespace App\Http\Controllers\Api;

use App\DeliveryAddress;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeliveryAddressController extends Controller
{

    public function index()
    {    
        return Helper::response('success',' saved addresses', 200 , auth()->user()->deliveryAddress);
    }

    public function show($id)
    {
       if( $deliveryAddress = auth()->user()->deliveryAddress()->whereId($id)->first() )
       {
            return Helper::response('success',' saved addresses', 200 , $deliveryAddress); 
       }
       return Helper::response('success',' saved addresses found', 404);
    }
    
    public function destroy($id)
    {
       if( $deliveryAddress = auth()->user()->deliveryAddress()->whereId($id)->first() )
       {
           $deliveryAddress->delete();
            return Helper::response('success',' deleted'); 
       }
       return Helper::response('success',' saved addresses not found', 404);
    }
}
