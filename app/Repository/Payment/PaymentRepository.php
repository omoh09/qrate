<?php


namespace App\Repository\Payment;

use App\Checkouts;
use App\ExhibitionCheckout;
use App\Helpers\Helper;
use App\Payment;
use App\User;
use Illuminate\Http\Request;
use Rave;
use Paystack;

class PaymentRepository implements PaymentInterface
{

    /**
     *what is required for payment
     * email --> user email
     * orderId --> checkout id
     * amount
     * quantity --> this would be depending on the other factors in future
     * currency
     * metadata // details to be added to the payment (optional)
     * reference
     */
    public function pay(Request $request)
    {
        try{
            $user = User::whereId($request->user_id)->first();
            $check = $user->checkouts()->whereId($request->checkout_id)->wherePaid(false);
            if($check->first())
            {
                $CheckUpdate = Helper::UpdateTotalAmount($check->first());
                if($CheckUpdate['empty']){
                    return Helper::response('error','checkout empty',404);
                }
                $reference = Rave::generateReference();
                $data = [ 
                    'payment_options' => 'card,banktransfer',
                    'amount' => Helper::inKobo($CheckUpdate['amount']),
                    'email' => $user->email,
                    'tx_ref' => $reference,
                    'currency' => "NGN",
                    //'redirect_url' => route('rave.callback',['checkout' => $check->first()->id]),rave.callback
                    'redirect_url' => route('rave.callback'),
                    'meta' =>  [
                        'checkout_id' => $request->checkout_id,
                        'payment_type' => 'default'
                    ],
                    'customer' => [
                        'email' => $user->email,
                        //"phone_number" => request()->phone,
                        "name" => $user->name
                    ],
                    "customizations" => [
                        "title" => 'Qrate Art',
                        "description" => "Qrate Art Payment"
                    ],
                ];
                
                $payment = Rave::initializePayment($data);
                if ($payment['status'] !== 'success') {
                    return Helper::response('error','something went wrong! Failed to initialized',500);
                }

                return Helper::response('success','Payment initialized!',200, ['link' => $payment['data']['link']]);
                               
            }else{
                return Helper::response('error','checkout not found',404);
            }
        }catch (\Exception $exception){
            return Helper::response('error',$exception->getMessage(),404);
        }
    }

    public function callback()
    {
        // paystack
        $paymentDetails = Paystack::getPaymentData();
        if(!$paymentDetails['status']){
            return ;
        }
        [
//            'status' => $status,
//            'message' => $message,
            'data' => $data
        ] = $paymentDetails;
        [
            'status' => $payment_status,
            'checkout' => $checkout_id,
//            'domain'   => $domain,
            'type' => $payment_type
        ] = Helper::processPaymentResponse($data);
        if($payment_status)
        {
            if($payment_type == 'default'){
                $checkout = Checkouts::whereId($checkout_id)->first();
                Helper::paid($checkout);
                return view('paymentsuccess',['checkout' => $checkout_id, 'type' => $payment_type]);
            }else {
                $checkout = ExhibitionCheckout::whereId($checkout_id)->first();
                $checkout->update(
                    [
                        'payment_id' => $data['id'],
                        'paid' => true
                    ]
                );
                if(Helper::exhibitionPaid($checkout)){
                    return view('paymentsuccess',['checkout' => $checkout_id, 'type' => $payment_type]);
                }else{
                    //TODO update to a script
                    return false;
                }
            }
        }
        //TODO return a view for un successful transaction
        return  view('paymenterror');
    }

    public function callbackRave()
    {
        $transactionID = Rave::getTransactionIDFromCallback();
        $response = Rave::verifyTransaction($transactionID); //For FLUTTERWAVE
        
        $data = $response->data;
        if (strtolower($data->status) ==  'cancelled')
        {
            return  Helper::response('error','transactio cancelled',404);
        }

        if(strtolower($data->status) == 'successful')
        {
            Payment::create(
                [
                    //'checkout_id' => $checkout,
                    'checkout_id' => $data->meta['checkout_id'],
                    'amount' => $data->amount,
                    'status' => true,
                    'transaction_ref' => $data->flwref
                ]
             );
            //$checkout = Checkouts::whereId($checkout)->first();
            $checkout = Checkouts::whereId($data->meta['checkout_id'])->first();
            Helper::paid($checkout);
            return Helper::response('success','payment made successfully');
        }
        return  Helper::response('error','payment not completed',422);
    }

    public function webhook(Request $request)
    {
        $ip = $request->ip();
        $signature = $request->header('X-Paystack-Signature');
        $input =  $request->post();
        $hash =  hash_hmac('sha512', json_encode($input), getenv('PAYSTACK_SECRET_KEY'));
        if(array_search((string) $ip, ['52.31.139.75','52.49.173.169','52.214.14.220'])){
            $valid = $signature == $hash;
            if($valid){
                $event = strtolower($input['event']);
                switch ($event){
                    case 'charge.success':
                        return $this->processCharges($input);
                    default:
                        return  Helper::response('error','unknown event',404);
                }
            }
            return Helper::response('error','invalid hash',401);
        }
        return Helper::response('error','UnAuthorized',401);
    }

    private function  processCharges($input){
        $process = Helper::processPaymentResponse($input['data']);
        if($process['type'] == 'normal') {
            if (!$process['paid_before']) {
                $checkout = Checkouts::whereId($process['checkout'])->first();
                if ($process['payment_status']) {
                    Helper::paid($checkout);
                }
            }
            return Helper::response('success', 'received', 200);
        }else{
            if (!$process['paid_before']) {
                $checkout = ExhibitionCheckout::whereId($process['checkout'])->first();
                if ($process['payment_status']) {
                    $checkout->update(
                        [
                            'payment_id' => $input['data']['id'],
                            'paid' => true
                        ]
                    );
                    Helper::exhibitionPaid($checkout);
                }
            }
            return Helper::response('success', 'received', 200);
        }
        return Helper::response('success', 'unknown', 400);
    }
}
