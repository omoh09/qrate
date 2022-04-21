<?php
namespace App\Repository\Auction;

use Illuminate\Http\Request;

interface AuctionRepositoryInterface
{
    /**
     * @return mixed
     */
    public function index();

    /**
     * @return mixed
     */
    public function live();

    /**
     * @return mixed
     */
    public function past_auction();

    /**
     * @return mixed
     */
    public function upcoming();

    /**
     * @param $id
     * @return mixed
     */
    public function show($id);

    /**
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function create_bid(Request $request,$id);


//
//    /**
//     * @param Request $request
//     * @return mixed
//     */
//    public function checkout_bid($id);
}
