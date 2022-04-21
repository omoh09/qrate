<?php


namespace App\Repository\Auction;

use App\Auction;
use App\Artworks;
use App\Bid;
use App\Checkouts;
use App\Helpers\Helper;
use App\Http\Resources\AuctionResource;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\PseudoTypes\True_;
use App\Events\BroadCastBidForAuction;

class AuctionRepository implements AuctionRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        $time = Now()->subHours(3)->toDateTime();
//        $live = Auction::where('bid_start','>=',$time)->where('bid_start' ,'<=',Now())->where("approved",true)->where('bid_end','>',Now()->toDateTime())->orderBy('bid_start')->take(10)->get();
        $live = Auction::artworkAuctionLive($time)->get();//Auction::where("approved",1)->orderBy('bid_start')->take(10)->get();
//        $upcoming = Auction::where("approved",true)->where('bid_start','>',Now())->orderBy('bid_start')->take(10)->get();
        $upcoming = Auction::artworkAuctionUpcoming()->get();//Auction::where("approved",1)->orderBy('bid_start')->take(10)->get();
//        TODO chnage back to the previous one;
        $past = Auction::artworkAuctionPast()->get();//Auction::where("approved",1)->where('bid_end','<=',Now())->orderBy('bid_end','desc')->take(1)->get();
        return Helper::response('success','auction found',200, ['live'=> AuctionResource::collection($live),'upcoming'=> AuctionResource::collection($upcoming),'past'=> $past ? AuctionResource::collection($past) : []]);

    }
    /**
     * @inheritDoc
     */
    public function live()
    {
        $time = Now()->subHours(3)->toDateTime();
        $result = Auction::where('bid_start','>=',$time)->where('bid_start' ,'<=',Now())->where("approved",true)->where('bid_end','>',Now()->toDateTime())->orderBy('bid_start')->get();
        return Helper::response('success','auctions found',200, AuctionResource::collection($result));
    }

    /**
     * @inheritDoc
     */
    public function upcoming()
    {
        $time = Now()->toDateTime();
        $result = Auction::where("approved",true)->where('bid_start','>',Now())->take(10)->orderBy('bid_start')->get();
        return Helper::response('success','auctions found',200, AuctionResource::collection($result));
    }
    /**
     * @inheritDoc
     */
    public function past_auction()
    {
        $time = Now()->subHours(3)->toDateTime();
        $result = Auction::where("approved",true)->where('bid_end','<=',Now())->orderBy('bid_end','desc')->get();
        return Helper::response('success','auctions found',200, AuctionResource::collection($result));
    }

    /**
     * @inheritDoc
     */
    public function show($id)
    {
        $auction = Auction::where(['id'=> $id])->first();
        if($auction){
            return Helper::response('success','auction found',200, AuctionResource::make($auction));
        }else{
            return Helper::response('error','Auction not found',404);
        }
    }

    /**
     * @inheritDoc
     */
    public function search(Request $request)
    {
        $input = $request->text;
        $auction = Auction::where('name','Like','%'.$input.'%')->get();
        if($auction->toArray())
        {
            return Helper::response('success','Auction found', 200,
                [
                    'auction'=> $auction
                ]);
        }else{
            return Helper::response('error','Auction not found',404);
        }
    }

   /**
     * @inheritDoc
     */
    public function create_bid(Request $request, $id)
    {
        $currentTime = now();
        $time = $currentTime->subHours(3)->toDateTime();
        //$auction = Auction::where(['id'=> $id])->where('bid_start','>=',$time)->where('bid_start' ,'<=',Now())->where("approved",true)->where('bid_end','>',Now()->toDateTime())->first();
        $auction = Auction::where(['id'=> $id])->first();
        if(!$auction){
            return Helper::response('error','Auction not found or the auction has not stated',404);
        }

        if((int) $auction->artwork->price > (int) $request->amount )
        {
            return Helper::response('error','bid not acceptable',400);
        }
        if($auction->artwork->bid->first())
        {
            if((int) $auction->artwork->bid->first()->amount >= (int) $request->amount )
            {
                return Helper::response('error','bid not acceptable',400);
            }
        }

        //broadcast event and data
        $data = [
            'amount' => $request->amount,
            'bid_elapse_time' => $currentTime->addSeconds(20)
        ];
        
        BroadCastBidForAuction::dispatch($data);

        $response = auth()->user()->bid()->create(
            [
                'amount' => $request->amount,
                'artwork_id' => $auction->artwork->id,
            ]
        );
        return $response;
    }

    /**
     * @inheritDoc
     */
//    public function checkout_bid($id)
//    {
//        $user = auth()->user()->id;
//    }
}
