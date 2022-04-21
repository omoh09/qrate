<?php
namespace App\Repository\Admin;

use App\User;
use Illuminate\Http\Request;

interface AdminRepositoryInterface
{
    public function index();

    public function artworks();

    public function transactions();

    public function artSupplies();

    public function users();

    public function qraters();

    public function artists();

    public function artGallery();

    public function ArtSuppliers();

    /**
     * @param User $user
     * @return mixed
     */
    public function deactivate(User $user);

    /**
     * @param User $user
     * @return mixed
     */
    public function activate(User $user);

    public function transaction();

    public function  checkouts();

    public  function paid_checkouts();

    public function pending_checkouts();

    /**
     * @param $id
     * @return mixed
     */
    public function singleCheckout($id);

    public function auctionRequest();

    public function auctionApproved($id);

    public function auctionLive();
    
    public function auctionUpcoming();
    
    public function auctionPast();

    public function allAuction();
    
    public function auctionDestroy($auctionId);
    
    public function endAuction();

    public function createAuction(Request $request, $artworkId);

    public function suggestAuction();

    public function exhibitionRequest();
    
    public function exhibitionOngoing();

    public function exhibitionUpcoming();

    public function exhibitionPast();

    public function showExhibition($id);

    public function createExhibition(Request $request);

    public function createArtwork(Request $request);   
    
    public function createAdvert(Request $request);

    public function showAdverts();

    public function showSingleAdvert($advert);
}
