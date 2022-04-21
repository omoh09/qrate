<?php


namespace App\Repository\Exhibition;

use App\Checkouts;
use App\Events\LikeEvent;
use App\Exhibition;
use App\ExhibitionCheckout;
use App\Helpers\Helper;
use App\Http\Resources\ExhibitionCheckoutResource;
use App\Http\Resources\ExhibitionResource;
use App\Payment;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use KingFlamez\Rave\Facades\Rave;
use Paystack;

class ExhibitionRepository implements ExhibitionRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        $upcoming = Exhibition::where('event_date','>=',Now()->format('Y-m-d'))->where('time','>', Now()->format('H:i'))->orderBy('event_date','asc')->take(4)->get();
        $past = Exhibition::where('event_date','<' ,Now()->format('Y-m-d'))->orderBy('event_date','desc')->take(1)->get();
        $ongoing = Exhibition::where('event_date',Now()->format('Y-m-d'))->where('time','<',Now()->format('H:i:s'))->take(4)->get();

//        TODO return back to normal
        $upcoming = $this->all();
        $past = $this->all();
        $ongoing = $this->all();
        return Helper::response(
            'success',
            'exhibition index',
            200 ,
            [
                'ongoing' => ExhibitionResource::collection($ongoing),
                'upcoming' => ExhibitionResource::collection($upcoming),
                'past' => ExhibitionResource::collection($past)
            ]
        );
    }

    public  function all(){
        return Exhibition::paginate(20);
    }
    public function ongoing()
    {
        return $this->all();
//        TODO return back to normal
        return Exhibition::where('event_date' , Now()->format('Y-m-d'))->where('time','<', Now()->format('H:i'))->paginate(20);
    }
    public function upcoming()
    {
        return $this->all();
//        TODO return back to normal
        return Exhibition::where('event_date','>=',Now()->format('Y-m-d'))->where('time','>', Now()->format('H:i'))->orderBy('event_date')->paginate(20);
    }
    public function past()
    {
        return $this->all();
//        TODO return back to normal
        return Exhibition::where('event_date','<' ,Now()->format('Y-m-d'))->orderBy('event_date')->paginate(20);
    }
    public function show($id)
    {
        $exhibition = Exhibition::where(['id'=> $id])->first();
        if($exhibition){
            return Helper::response('success','exhibition found',200,ExhibitionResource::make($exhibition));
        }else{
            return Helper::response('error','Exhibition not found',404);
        }
    }
    public function toggleLike($id)
    {
        $exhibition = Exhibition::whereId($id)->first();
        if ($exhibition) {
            $likedPreviosly = $exhibition->likes()->onlyTrashed()->where(['user_id' => auth()->user()->id])->first();
            if ($likedPreviosly) {
                $likedPreviosly->restore();
                Helper::updateLikeCount($exhibition);
                return Helper::response('success', 'exhibition liked', 200);
            } else {
                $liked = $exhibition->likes()->where(['user_id' => auth()->user()->id])->first();
                if ($liked) {
                    $liked->delete();
                    Helper::updateLikeCount($exhibition);
                    return Helper::response('success', 'exhibition un-liked', 200);
                }
                $like = $exhibition->likes()->create(['user_id' => auth()->user()->id]);
                Helper::updateLikeCount($exhibition);
                event(new LikeEvent($like));
                return Helper::response('success', 'exhibition liked', 200);
            }
        }
        return Helper::response('error', 'exhibition not found', 404);
    }

    public function register($id)
    {
        $exhibition = Exhibition::whereId($id)->first();
        if ($exhibition ) {
            if(($exhibition->initial_ticket_no == 0 ) || ($exhibition->available_ticket_no > 0))
            {
                $checkout = auth()->user()->exhibitionsCheckout()->create([
                    'exhibition_id' => $exhibition->id,
                    'amount' => $exhibition->ticket_price ?? 0,
                    'firstname' => \request()->firstname,
                    'lastname' => \request()->lastname,
                    'email' => \request()->email,
                    'quantity' => \request()->quantity,
                ]);

                if($checkout)
                {
                    return Helper::response('success','exhibition checkout created ',200, ExhibitionCheckoutResource::make($checkout));
                }else{
                    return Helper::response('error', 'checkout was not possible', 404);
                }
            }
            return Helper::response('error', 'exhibition Ticket Finished', 404);
        }
        return Helper::response('error', 'exhibition not found', 404);
    }

    public function payTicket($request)
    {
        $user = User::whereId($request->user_id)->first();
        $checkout = $user->exhibitionsCheckout()->whereId($request->checkout_id)->where('paid',false)->first();
        if($checkout) {
            if(( (int) $checkout->amount > 0)) {
                // $request->email = $user->email;
                // $request->currency = 'NGN'; //to be changed
                // $request->orderId = $checkout->id;
                // $request->reference = Paystack::genTranxRef();;
                // $request->country = 'NG';
                // $request->metadata =  [
                //     'checkout_id' => $request->checkout_id,
                //     'payment_type' => 'exhibition'
                // ];
                $reference = Rave::generateReference();
                $data = [ 
                    'payment_options' => 'card,banktransfer',
                    'amount' => Helper::inKobo($checkout->amount),
                    'email' => $user->email,
                    'tx_ref' => $reference,
                    'currency' => "NGN",
                    'redirect_url' => route('rave.callback'),
                    'meta' =>  [
                        'checkout_id' => $request->checkout_id,
                        'payment_type' => 'exhibition'
                    ],
                    'customer' => [
                        'email' => $user->email,
                        //"phone_number" => request()->phone,
                        "name" => $user->name,
                        "country" => 'NG'
                    ],
                    "customizations" => [
                        "title" => 'Qrate Art Exhibition',
                        "description" => "Qrate Art Exhibition Payment"
                    ],
                ];

                $payment = Rave::initializePayment($data);
                if ($payment['status'] !== 'success') {
                    return Helper::response('error','something went wrong! Failed to initialized',500);
                }

                return Helper::response('success','Payment initialized!',200, ['link' => $payment['data']['link']]);
            }else{
                return $this->paid($request->checkout_id, $user);
            }
        }
        return Helper::response('error', 'checkout not found', 404);
    }

    private function paid($id, $user)
    {
        $checkout = $user->exhibitionsCheckout()->whereId($id)->where('paid',false)->first();
        if($checkout)
        {
            $checkout->update(
                [
                    'paid' => true
                ]
            );
            Helper::exhibitionPaid($checkout);
            return Helper::response('success','exhibition registered for',200);
        }
        return Helper::response('error', 'checkout not found', 404);
    }
    public function paymentCallback($checkout)
    {
        $response = Rave::verifyTransaction($checkout);
        $data = $response->data;
        if( strtolower($data->status) == 'successful')
        {
            $checkoutModel = ExhibitionCheckout::whereId($checkout)->first();
            if($checkoutModel)
            {
                $checkoutModel->update(
                    [
                        'payment_id' => $data->flwref,
                        'paid' => true
                    ]
                );
                Helper::exhibitionPaid($checkoutModel);
                return Helper::response('success','payment for ticket made successfully');
            }
            return Helper::response('success','payment made successfully');
        }

    }


}
