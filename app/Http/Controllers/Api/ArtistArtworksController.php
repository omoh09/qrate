<?php

namespace App\Http\Controllers\Api;

use App\Artworks;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArtworksResource;
use App\Repository\Artworks\ArtworksRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArtistArtworksController extends Controller
{


    /**
     * @var ArtworksRepositoryInterface
     */
    private $repository;

    public function __construct(ArtworksRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Helper::response('success','artworks',200,ArtworksResource::collection($this->repository->artworks())->resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string',
                'description' => 'required|string',
                'dimension' => 'required|string',
                'sale_type' => 'required|in:1,2',
                'price' => 'required',
                'pictures.*' => 'required|image|mimes:jpeg,png,bmp,gif,svg',
                'video' => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|max:20000',
                'category' => 'required|int'
            ]
        );
        $response = $this->repository->store($request);
        return Helper::response('success','artwork sent',200,ArtworksResource::make($response));
    }

    /**
     * Display the specified resource.
     *
     * @param int $artwork
     * @return JsonResponse|Response
     */
    public function show(int $artwork)
    {
        $response = $this->repository->show($artwork);
        if($response instanceof Artworks)
        {
            return Helper::response('success','artwork found',200,ArtworksResource::make($response));
        }
        return  $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $artwork
     * @return JsonResponse|Response
     */
    public function update(Request $request, int $artwork)
    {
        $request->validate(
            [
                'title' => 'string',
                'description' => 'string',
                'dimension' => 'string',
                'sale_type' => 'in:1,2',
                'price' => 'required',
                'pictures.*' => 'image|mimes:jpeg,png,bmp,gif,svg',
                'video' => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|max:20000',
                'category' => 'int'
            ]
        );
        $response = $this->repository->update($request,$artwork);
        if($response instanceof Artworks)
        {
            return Helper::response('success','artwork updated',200,ArtworksResource::make($response));
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $artwork
     * @return JsonResponse|Response
     */
    public function destroy(int $artwork)
    {
        return $this->repository->destroy($artwork);
    }
}
