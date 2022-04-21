<?php

namespace App\Http\Controllers\Api;

use App\ArtGallery;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Resources\ArtGalleryResource;
use App\Http\Resources\MiniArtGalleryResource;
use App\Repository\ArtGallery\ArtGalleryInterface;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\EloquentUserProvider;

class ArtGalleryController extends Controller
{

    /**
     * @var ArtGalleryInterface
     */
    private $repository;

    public function __construct(ArtGalleryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return Helper::response('success','art galleries',200,MiniArtGalleryResource::collection($this->repository->index())->resource);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse|Response
     */
    public function show($id)
    {
        $response = $this->repository->show($id);
        if($response instanceof User)
        {
            return  Helper::response('success','art gallery found',200,ArtGalleryResource::make($response));
        }
        return  $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        $request->validate(
            [
                'text' => 'required|string'
            ]
        );
        $response = $this->repository->search($request);
        if($response instanceof User)
        {
            return  Helper::response('success','art gallery found',200,MiniArtGalleryResource::collection($response)->resource);
        }
        return  $response;
    }

    public function addArtistToGallery(Request $request)
    {
        $request->validate(
            [
                'artists' => 'required|array',
                'artists.*' => 'int'
            ]
        );
        $user = User::whereId(auth()->user()->id)->first();
        $existing = $user->artists()->allRelatedIds()->toArray();
        $artists = User::whereIn('id',$request->artists)->where('role' , 2)->pluck('id')->toArray();
        foreach ($artists as $key => $artist)
        {
            if(array_search((int)$artist,$existing) !== false){
                unset($artists[$key]);
            };
        };
        $user->artists()->attach($artists);
        return Helper::response('success','artist added to this gallery');

    }

    public function removeArtistFromGallery(Request $request)
    {
        $request->validate(
            [
                'artists' => 'required|array',
                'artists.*' => 'int'
            ]
        );
        $user = User::whereId(auth()->user()->id)->first();
        $existing = $user->artists()->allRelatedIds()->toArray();
        $artists = $request->artists;
        foreach ($artists as $key => $artist)
        {
            if(array_search((int)$artist,$existing) === false){
                unset($artists[$key]);
            };
        };
        $user->artists()->detach($artists);
        return Helper::response('success','artist removed from this gallery');
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

    public function editExhibition(Request $request , $id)
    {
        $request->validate(
            [
                'name' => 'required|string',
                'description' => 'required|string',
                'event_date' => 'required|date|date_format:d-m-Y',
                'address' => 'required|string',
                'time' => 'required|date_format:H:i',
                'country' => 'required',
                'pictures.*' => 'image|mimes:jpeg,png,bmp,gif,svg',
                'ticket_price' => 'required',
                'video' => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|max:20000',
            ]
        );
        return $this->repository->editExhibition($request, $id);
    }

}
