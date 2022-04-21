<?php


namespace App\Repository\Admin;

use App\Artworks;
use App\Categories;
use App\Checkouts;
use App\Helpers\Helper;
use App\Http\Resources\AdminCheckoutResource;
use App\Http\Resources\AuctionResource;
use App\Http\Resources\ExhibitionResource;
use App\Http\Resources\CheckoutResource;
use App\Http\Resources\UserResource;
use App\User;
use App\Advert;
use App\Auction;
use App\Exhibition;
use App\Http\Resources\ArtworksResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminRepository implements AdminRepositoryInterface
{

    public function index()
    {
        // Users
        $users_count = User::where('role','!=',5)->count();
        $qraters_count = User::whereRole(1)->count();
        $artists_count = User::whereRole(2)->count();
        $galleries_count = User::whereRole(3)->count();
        $art_suppliers_count = User::whereRole(4)->count();
        //Artworks
        $artworks_count = Artworks::all()->count();
        $artworks_percentage = [];
        if($artworks_count > 0 )
        {
            $Artwork_groups = Artworks::all()->groupBy('category_id');
            $artworks_array = array();
            foreach($Artwork_groups as $group => $value)
            {
                $artworks_array[$group] = $value->count();
            };
            $artworks_percentage = array();
            foreach($artworks_array as $key => $value){
                $category = Categories::whereId($key)->first();
               $artworks_percentage[] =[
                   'name' => $category ? $category->name: ''.$key,
                   'color' => $category ? $category->color : null,
                    'percentage' => $value/$artworks_count * 100];
            }
        }
        //TODO add transaction details
        $result = [
            'users' => [
                'total' => $users_count,
                'qraters' => $qraters_count,
                'artists' => $artists_count,
                'galleries' => $galleries_count,
                'supplies' => $art_suppliers_count
                ],
            'artworks' => [
                'total' => $artworks_count,
                'percentage_per_category' => $artworks_percentage
                ]
            ];

        return Helper::response('success','dashboard details',200,$result);
    }

    public function artworks()
    {
        // TODO: Implement artworks() method.
    }

    public function transactions()
    {
        // TODO: Implement transactions() method.
    }

    public function artSupplies()
    {
        // TODO: Implement artSupplies() method.
    }

    public function users()
    {
        $users = User::all()->paginate(20);
        return Helper::response('success','users',200,UserResource::collection($users)->resource);
    }

    public function qraters()
    {
        $users = User::whereRole(1)->paginate(20);
        return Helper::response('success','users',200,UserResource::collection($users)->resource);
    }

    public function artists()
    {
        $users = User::whereRole(2)->paginate(20);
        return Helper::response('success','users',200,UserResource::collection($users)->resource);
    }

    public function artGallery()
    {
        $users = User::whereRole(3)->paginate(20);
        return Helper::response('success','users',200,UserResource::collection($users)->resource);
    }

    public function ArtSuppliers()
    {
        $users = User::whereRole(4)->paginate(20);
        return Helper::response('success','users',200,UserResource::collection($users)->resource);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function deactivate(User $user)
    {
        if(!$user->active)
        {
            return Helper::response('success','user deactivated');
        }
        $user->update(
            [
                'active' => false
            ]
        );
        // TODO create event to send notification to user
        return Helper::response('success','user deactivated');
    }

    /**
     * @inheritDoc
     */
    public function activate(User $user)
    {
        if($user->active)
        {
            return Helper::response('success','user activated');
        }
        $user->update(
            [
                'active' => false
            ]
        );
        //TODO create event to send notification to the user
        return Helper::response('success','user activated');
    }

    public function transaction()
    {
    }

    public function checkouts()
    {
        $checkouts = Checkouts::orderBy('updated_at','DESC')->paginate(30);
        return Helper::response('success','checkouts' , 200, AdminCheckoutResource::collection($checkouts)->resource);
    }

    public function paid_checkouts()
    {
        $checkouts = Checkouts::wherePaid(true)->orderBy('updated_at','DESC')->paginate(30);
        return Helper::response('success','checkouts' , 200, AdminCheckoutResource::collection($checkouts)->resource);
    }

    public function pending_checkouts()
    {
        $checkouts = Checkouts::wherePaid(false)->orderBy('updated_at','DESC')->paginate(30);
        return Helper::response('success','checkouts' , 200, AdminCheckoutResource::collection($checkouts)->resource);
    }

    /**
     * @param $id
     * @return mixed|void
     */
    public function singleCheckout($id)
    {
        if($checkout  = Checkouts::whereId($id)->first())
        {
            return Helper::response('success','checkouts' , 200, AdminCheckoutResource::make($checkout));
        }
        return Helper::response('error','Checkout Not found');
    }

/*------AUCTION------*/
    /**
     * @param
     * @return mixed|void
     */
    public function auctionRequest()
    {
        $result = Auction::where("approved",false)->orderBy('bid_start')->take(5)->get();
        return Helper::response('success','auctions found',200, AuctionResource::collection($result));
    }

    public function auctionApproved($id){
        if($result = Auction::whereId($id)->first()){
            $result->update(['approved' => true]);
            //TO DO alert the artist or art gallery
            return Helper::response('success', 'Auction Approved successfully', 200);
        }
        return Helper::response('error','oops something went wrong, cannot approve this auction',404);
    }

    /**
    * @param
    * @return mixed|void
    */
   public function auctionLive()
   {
        $time = Now()->subHours(3)->toDateTime();
        $result = Auction::where('bid_start','>=',$time)->where('bid_start' ,'<=',Now())->where("approved",true)->where('bid_end','>',Now()->toDateTime())->orderBy('bid_start')->take(5)->get();
        return Helper::response('success','auctions found',200, AuctionResource::collection($result));
   }

    /**
    * @param
    * @return mixed|void
    */
    public function auctionUpcoming()
    {
         $result = Auction::where('bid_start' ,'<',Now())->where("approved",true)->orderBy('bid_start')->take(5)->get();
         return Helper::response('success','auctions found',200, AuctionResource::collection($result));
    }

     /**
     * @param
     * @return mixed|void
     */
    public function auctionPast()
    {
         $result = Auction::where('bid_end' ,'<=',Now())->where("approved",true)->orderBy('bid_end','desc')->take(5)->get();
         return Helper::response('success','auctions found',200, AuctionResource::collection($result));
    }

    public function allAuction()
    {
        $result =  Auction::get();
        return Helper::response('success','all auctions',200, AuctionResource::collection($result));
    }

     public function auctionDestroy($auctionRequestId)
     {
         if($result = Auction::whereId($auctionRequestId)->first())
         {
            $result->delete();
             return Helper::response('success','Auction deleted successfully');
         }
         return Helper::response('error','Auction not found',404);
     }

     public function endAuction()
     {
        $time = Now()->AddHours(5)->toDateTime();
        $result = Auction::where('bid_end' ,'<=',$time)->where("approved",true);
        return Helper::response('success','Auction End successfully',200);
     }

     public function createAuction(Request $request, $artworkId)
     {
         $auction = Auction::create(
             [
                 'artwork_id' => $artworkId,
                 'bid_start' => Carbon::parse($request->date),
                 'bid_end' => Carbon::parse($request->time),
             ]
         );
         if ($request->hasFile('pictures.*')) {
             $files = $request->file('pictures');
             Helper::uploadPictures($files, $auction);
         }
         if($request->hasFile('video'))
         {
             $files = $request->file('video');
             Helper::uploadVideo($files,$auction);
         }
         return Helper::response('success','Auction created',200 , AuctionResource::make($auction));
     }

     public function suggestAuction(){
         $suggestArtwork = Artworks::where('sale_type','2')->get();
         return Helper::response('success', 'suggested artwork found', 200, ArtworksResource::collection($suggestArtwork));
     }
/*------AUCTION------*/

/*------EXHIBITION------*/
    /**
     * @param
     * @return mixed|void
     */
    public function exhibitionRequest()
    {
        return Exhibition::get();
    }

    public function exhibitionOngoing()
    {
        return Exhibition::where('event_date' , Now()->format('Y-m-d'))->where('time','<', Now()->format('H:i'))->paginate(20);
    }
    
    public function exhibitionUpcoming()
    {
        return Exhibition::where('event_date','>=',Now()->format('Y-m-d'))->where('time','>', Now()->format('H:i'))->orderBy('event_date')->get();
    }

    public function exhibitionPast()
    {
        return Exhibition::where('event_date','<' ,Now()->format('Y-m-d'))->orderBy('event_date')->get();
    }

    public function showExhibition($id)
    {
        $exhibition = Exhibition::where(['id'=> $id])->first();
        if($exhibition){
            return Helper::response('success','exhibition found',200,ExhibitionResource::make($exhibition));
        }else{
            return Helper::response('error','Exhibition not found',404);
        }
    }

    public function createExhibition(Request $request)
    {
        $exhibition = auth()->user()->exhibitions()->create(
            [
                'name' => $request->name,
                'desc' => $request->description,
                'event_date' => Carbon::parse($request->date)->format('Y-m-d'),
                'time' => Carbon::parse($request->time)->format('H:i'),
                'country' => $request->country,
                'address' => $request->address,
                'ticket_price' => $request->ticket_price,
            ]
        );
        if ($request->hasFile('pictures.*')) {
            $files = $request->file('pictures');
            Helper::uploadPictures($files, $exhibition);
        }
        if($request->hasFile('video'))
        {
            $files = $request->file('video');
            Helper::uploadVideo($files,$exhibition);
        }
        return Helper::response('success','exhibition created',200 , ExhibitionResource::make($exhibition));
    }

    public function createArtwork(Request $request)
    {
        if($request->hasFile('pictures')){
            $count = count($request->file('pictures'));
            if($count > 5){
                return Helper::response('error' , 'you can\'t upload more that file pictures',404);
            }
        }
        $artwork = Artworks::create(
            [
                'user_id' => auth()->user()->id,
                'title' => $request->title,
                'description' => $request->description,
                'dimension' => (string) $request->dimension,
                //'sale_type' => $request->sale_type,
                'category_id' => $request->category,
                'price' => $request->price
            ]
        );
        if ($request->hasFile('pictures')) {
            $files = $request->file('pictures');
            Helper::uploadPictures($files, $artwork);
        };

        if($request->hasFile('video'))
        {
            $files = $request->file('video');
            Helper::uploadVideo($files,$artwork);
        }
        return $artwork;
    }

    public function createAdvert(Request $request){
        if($request->hasFile('pictures')){
            $count = count($request->file('pictures'));
            if($count > 5){
                return Helper::response('error' , 'you can\'t upload more that file pictures',404);
            }
        }

        $advert = Advert::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        if ($request->hasFile('pictures')) {
            $file = $request->file('pictures');
            Helper::uploadPictures($file, $advert);
        };
        return $advert;
    }

    public function showAdverts() {
        $advert = Advert::all()->paginate(5);
        return Helper::response('success','Adverts',200, $advert);
    }

    public function showSingleAdvert($advert) {
        $advert = Advert::whereId($advert)->first();
        return Helper::response('success','Adverts',200, $advert);
    }
}
