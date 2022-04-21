<?php

namespace App\Http\Controllers\Api;

use App\Admin;
use App\Auction;
use App\Http\Controllers\Controller;
use App\User;
use App\Helpers\Helper;
use App\Http\Resources\ExhibitionResource;
use App\Http\Resources\ArtworksResource;
use Illuminate\Http\Request;
use App\Repository\Admin\AdminRepositoryInterface;
class AdminController extends Controller
{

    private $repository;
    public function __construct(AdminRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->repository->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }

    public function users()
    {
        return $this->repository->users();
    }
    public function qraters()
    {
        return $this->repository->qraters();
    }
    public function artists()
    {
        return $this->repository->artists();
    }
    public function artGallery()
    {
        return $this->repository->artGallery();
    }
    public function artSuppliers()
    {
        return $this->repository->ArtSuppliers();
    }
    public function deactivateUser(User $user)
    {
        return $this->repository->deactivate($user);
    }

    public function activateUser(User $user)
    {
        return $this->repository->activate($user);
    }

    public function checkouts(){
        return $this->repository->checkouts();
    }

    public function paidCheckouts()
    {
        return $this->repository->paid_checkouts();
    }

    public function pendingCheckouts()
    {
        return $this->repository->pending_checkouts();
    }

    public function singleCheckout($id)
    {
        return $this->repository->singleCheckout($id);
    }

    public function auctionRequest(){
        return $this->repository->auctionRequest();
    }

    public function auctionApproved($id){
        return $this->repository->auctionApproved($id);
    }

    public function auctionLive(){
        return $this->repository->auctionLive();
    }
    
    public function auctionUpcoming(){
        return $this->repository->auctionUpcoming();
    }
    
    public function auctionPast(){
        return $this->repository->auctionPast();
    }

    public function allAuction(){
        return $this->repository->allAuction();
    }
    
    public function auctionDestroy($auctionId){
        return $this->repository->auctionDestroy($auctionId);
    }
    
    public function endAuction(){
        return $this->repository->endAuction();
    }

    public function createAuction(Request $request, $artworkId){
        $request->validate(
            [
                'bid_start'=> 'required|date',
                'bid_end' => 'required|date',
            ]
        );
        return $this->repository->createAuction($request, $artworkId);
    }

    public function suggestAuction(){
        return $this->repository->suggestAuction();
    }

    public function exhibitionRequest(){
        return $this->repository->exhibitionRequest();
    }
    
    public function exhibitionOngoing(){
        return Helper::response('success','ongoing exhibition',200, ExhibitionResource::collection($this->repository->exhibitionOngoing())->resource);
    }

    public function exhibitionUpcoming(){
        return Helper::response('success','upcoming exhibition',200, ExhibitionResource::collection($this->repository->exhibitionUpcoming())->resource);
    }

    public function exhibitionPast(){
        return Helper::response('success','past exhibition',200, ExhibitionResource::collection($this->repository->exhibitionPast())->resource);
    }

    public function showExhibition($id){
        return $this->repository->showExhibition($id);
    }

    public function createExhibition(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string',
                'description' => 'required|string',
                'event_date' => 'required|date|date_format:d-m-Y',
                'address' => 'required|string',
                'time' => 'required|date_format:H:i',
                'country' => 'required',
                'pictures.*' => 'required|image|mimes:jpeg,png,bmp,gif,svg',
                'ticket_price' => 'required',
                'video' => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|max:20000',
            ]
        );
        return $this->repository->createExhibition($request);
    }

    public function createArtwork(Request $request){
        $request->validate(
            [
                'title' => 'required|string',
                'description' => 'required|string',
                'dimension' => 'required|string',
                //'sale_type' => 'required|in:1,2',
                'price' => 'required',
                'pictures.*' => 'required|image|mimes:jpeg,png,bmp,gif,svg',
                'video' => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|max:20000',
                'category' => 'required|int'
            ]
        );
        $response = $this->repository->createArtwork($request);
        return Helper::response('success','artwork sent',200,ArtworksResource::make($response));
    }

    public function createAdvert (Request $request) {
        $request->validate([
            'title' => 'required|string',
            'description' => 'string'
        ]);
        $response = $this->repository->createAdvert($request);
        return Helper::response('success','Advert Created',200);
    }

    public function showAdverts() {
        return $this->repository->showAdverts();
    }

    public function showSingleAdvert($advert) {
        return $this->repository->showSingleAdvert($advert);
    }

}
