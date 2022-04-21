<?php


namespace App\Helpers;




use App\ArtSupply;
use App\Artworks;
use App\Checkouts;
use App\ExhibitionCheckout;
use App\File;
use App\Payment;
use App\Photos;
use Illuminate\Database\Eloquent\Model;

class Helper
{
   public static function response(string $status, string $message, int $code = 200,$data = [])
   {
       if($data){
           return response()->json(['status' => $status,'message' => $message,'resource' => $data],$code);

       }
       return response()->json(['status' => $status,'message' => $message],$code);
   }

    public static function timelineResponse(string $status, string $message, int $code,$data = [])
    {
        if($data){
            return response()->json(['status' => $status,'message' => $message,'timeline' => $data],$code);

        }
        return response()->json(['status' => $status,'message' => $message],$code);
    }

    public static function updateLikeCount(Model $model)
    {
     return $model->update(['likes_count'=> $model->likes()->count()]);
    }
    public static function updateCommentCount(Model $model)
    {
        return $model->update(['comments_count'=> $model->comments()->count()]);
    }

    public static function uploadPictures($pictures ,$model)
    {
        $files = $pictures;
        $folder = null;
        if($model instanceof Artworks)
        {
            $folder = "Artworks";
        }
        if($model instanceof Photos)
        {
            $folder = "GalleryPhotos";
        }
        if($model instanceof ArtSupply)
        {
            $folder = "ArtSupply";
        }

        foreach ($files as  $file){
            $size = getimagesize($file);
            $url  = cloudinary()->upload($file->getRealPath(),['folder' => $folder ? $folder : "post"])->getSecurePath();
            $thumbnail = cloudinary()->upload($file->getRealPath(),
                [
                    'folder'=> 'thumbnail',
                    'resource_type' => 'image',
                    "transformation" => array(
                        array('width' => 254, 'height' => 252, 'crop' => 'limit',),
                    ),
                ])->getSecurePath();
            if($url){
                $file = $model->files()->create(
                    [
                        'url' => $url,
                        'thumbnail' => $thumbnail
                    ]
                );
            }
        }

    }
    public static function uploadProfilePicture($picture,$user)
    {
            $size = getimagesize($picture);
            $url = cloudinary()->upload($picture->getRealPath(),
                [
                    'folder'=> 'profilePicture',
                    'resource_type' => 'image',
                    "transformation" => array(
                        array('width' => 254, 'height' => 252, 'crop' => 'limit',),
                    ),
                ])->getSecurePath();
            if($url){
                $picture = $user->profilePicture()->create(
                    [
                        'url' => $url
                    ]
                );
            }
    }
    public static function uploadVideo($video ,$model)
    {
        $folder = null;
        if($model instanceof Artworks)
        {
            $folder = "Artworks";
        }
        $url = cloudinary()->uploadVideo($video->getRealPath(), ['folder' => $folder ? $folder : "exhibitions"])->getSecurePath();
        if ($url) {
            $model->video()->create(
                [
                    'url' => $url
                ]
            );
        }
    }

    public static function UpdateTotalAmount(Checkouts $checkout,int $delivery = 0)
    {
        $cart = $checkout->cart;
        $Sold = $cart->filter(
            function ($item){
                return (bool) $item->product->sold;
            }
        );
        foreach($Sold as $item)
        {
            $item->update(
                [
                    'checkout_id' => null
                ]
            );
        }
        $cart_new = $checkout->cart;
        if(empty($cart_new)){
            return  ['amount' => 0.00, 'empty' => true];
        }
        $amount = 0;
        foreach($cart_new as $item)
        {
            $amount += (float) $item->product->price;
        }
        $checkout->update(
            [
                'price' => ''.number_format($amount,2)
            ]
        );
        return ['amount' => number_format($amount,2), 'empty' => false];
    }

    public static function paid(Checkouts $checkout)
    {
        $checkout->update(
            [
                'paid' => true
            ]
        );
        $cart = $checkout->cart;
        foreach($cart as $item)
        {
            $item->update(
                [
                    'bought' => true
                ]
            );
            $item->product->update(
                [
                    'sold' => true
                ]
            );
        }
    }
    public static function picked(Model $model)
    {
        $model->update([
           'on-shelf' => false
        ]);
    }

    public static function exhibitionPaid(ExhibitionCheckout $checkout)
    {

        $paid = $checkout->isPaidFor();
        $exhibition = $checkout->exhibition;
        if((int)$exhibition->available_ticket_no > 0) {
            $exhibition->update(
                [
                    'sold_ticket_no' => $exhibition->sold_ticket_no + 1,
                    'available_ticket_no' => $exhibition->available_ticket_no - 1
                ]
            );
        };
        return $paid;
    }
    public  static function inKobo($amount){
        return  ((float) $amount) * 100;
    }
    public static function  processPaymentResponse($data){
        [
            'id' => $id,
            'domain' => $domain,
            'status' => $transaction_status,
            'reference' => $txt_ref,
            'amount' => $amount,
            'message' => $message,
            'metadata' => $metadata,
        ] = $data;
        $serialized_data = serialize($data);
        $payment_status = strtolower($transaction_status) == 'success';
        $checkout = $metadata['checkout_id'];
        $type = $metadata['payment_type'];
        $payment_data = [
            'checkout_id' => $checkout,
            'amount' => $amount,
            'status' => $payment_status,
            'transaction_ref' => $txt_ref,
            'transaction_data' => $serialized_data,
            'transaction_message' => $message,
            'payment_id' => $id
        ];
        $exist = Payment::where('payment_id',$id)->first();
        $check_paid_before = false;
        if(!$exist){
            Payment::create(
                $payment_data
            );
        }else{
            if($type == 'normal'){
                $checkoutOld = Checkouts::where('id',$checkout)->first();
            }else{
                $checkoutOld = ExhibitionCheckout::where('id',$checkout)->first();
            }
            if($checkoutOld){
                $check_paid_before = (boolean) $checkoutOld->paid;
            }
        }
        return ['status' => $payment_status,'checkout' => $checkout , 'domain' => $domain, 'paid_before' => $check_paid_before, 'type' => $type];
    }
}
