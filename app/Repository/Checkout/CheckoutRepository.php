<?php
namespace App\Repository\Checkout;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CheckoutRepository implements CheckoutRepositoryInterface
{

    public function index()
    {
       return auth()->user()->checkouts;
    }

    public function show($checkout)
    {
        return auth()->user()->checkouts()->where('id',$checkout)->get();
    }

    public function paid($checkout)
    {
        $checkout = auth()->user()->checkouts()->where('id','$checkout');
        // Todo add payment logic
    }

    public function delete($checkout)
    {
        //Todo Admin Feature
    }
    public function store(Request $request)
    {
        $cart_filled = auth()->user()->cart;
        if($cart_filled)
        {
            $available_product = $this->filterCart($cart_filled);
            if($available_product->toArray())
            {
               
                if(!($check = auth()->user()->deliveryAddress()->whereId($request->delivery_address_id)->first()))
                {
                    if( $request->delivery_address_id && !$check)
                    {
                         return Helper::response('error','address not found for this user',404);  
                    }
                    $check = auth()->user()->deliveryAddress()->create(
                        [
                            'name' => $request->name ,
                            'str_address'=>$request->str_address,
                            'city_state' => $request->city_state,
                            'country' => $request->country,
                            'postal_code' => $request->postal_code,
                            'phone' => $request->phone
                        ]
                    );
                }
                $name = $check->name;
                $str_address = $check->str_address;
                $country = $check->country;
                $postal_code = $check->postal_code;
                $phone = $check->phone;
                $city_state = $check->city_state;
                $checkout = auth()->user()->checkouts()->create(
                    [
                        'name' => $name ,
                        'str_address'=>$str_address,
                        'city_state' => $city_state,
                        'country' => $country,
                        'postal_code' => $postal_code,
                        'phone' => $phone
                    ]
                );
                foreach($available_product as $item)
                {
                    $checkout->cart()->attach($item);
                }
                return $checkout;
            }
            return Helper::response('error','cart is empty',404);
        }
        return Helper::response('error','cart is empty',404);
    }

    private function filterCart($cart)
    {
        $collection_filtered = $cart->filter(
            function ($item){
                return (bool) !$item->product->sold;
            }
        );
        return $collection_filtered;
    }

}
