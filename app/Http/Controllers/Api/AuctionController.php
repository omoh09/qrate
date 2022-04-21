<?php

namespace App\Http\Controllers\Api;

use App\Artworks;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuctionResource;
use App\Repository\Auction\AuctionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Auction;
use Carbon\Carbon;
use App\Bid;
use App\Checkouts;
use App\Http\Resources\ArtworksResource;
use App\Http\Resources\CheckoutResource;

class AuctionController extends Controller
{

    /**
     * @var AuctionRepositoryInterface
     */
    private $repository;

    public function __construct(AuctionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->index();
    }

    public function live()
    {
        return $this->repository->live();
    }

    public function upcoming()
    {
        return $this->repository->upcoming();
    }

    public function past_auction()
    {
//        Helper::response()
        return $this->repository->past_auction();
    }

    public function show($id)
    {
        return $this->repository->show($id);
    }

    public function search(Request $request)
    {
        $request->validate(
            [
                'text'=> 'required'
            ]
        );
        return $this->repository->search($request);
    }

    public function bid(Request $request, $id)
    {
        $request->validate(
            [
                'amount'=> 'required'
            ]
        );
        $response = $this->repository->create_bid($request,$id);
        if($response instanceof Bid)
        {
            return Helper::response('success','Bid sent',200,$response);
        }
        return  $response;
    }
}

