<?php


namespace App\Repository\Cart;


use App\Artworks;
use App\Helpers\Helper;
use App\User;
use Illuminate\Http\Request;

class CartRepository implements CartRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        return auth()->user()->cart;
    }

    /**
     * @inheritDoc
     */
    public function destroy($id)
    {
        $user = User::whereId(auth()->user()->id)->first();
        $cart = $user->cart()->whereId($id)->first();
        if($cart)
        {
            $cart->delete();
            return Helper::response('success','item deleted from cart');
        }
        return  Helper::response('error','item not in your cart',404);
    }

    /**
     * @inheritDoc
     */
    public function edit(Request $request, $id)
    {
        $user = User::whereId(auth()->user()->id)->first();
        $cart = $user->cart()->whereId($id)->first();
        if($cart->product instanceof Artworks)
        {
            return Helper::response('error','you can\'t increase quantity of an artwork',404);
        }
        if($cart)
        {
            $cart->update(['quantity' => $request->quantity]);
            return Helper::response('success','item details updated in cart');
        }
        return  Helper::response('error','item not in your cart',404);
    }
}
