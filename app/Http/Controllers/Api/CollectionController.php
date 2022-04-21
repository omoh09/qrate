<?php

namespace App\Http\Controllers\Api;

use App\Collection;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\MinicollectionResource;
use App\Repository\Collection\CollectionRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CollectionController extends Controller
{

    /**
     * @var CollectionRepositoryInterface
     */
    private $repository;

    public function __construct(CollectionRepositoryInterface $collectionRepository)
    {
        $this->repository = $collectionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response
     */
    public function index()
    {
        return  Helper::response('success','user collection',200, MinicollectionResource::collection($this->repository->index()));
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
                'name' => 'required|string',
                'details' => 'required|string'
            ]
        );
        $response = $this->repository->store($request);
        if($response instanceof Collection)
        {
            return  Helper::response('success','collection created',200, MinicollectionResource::make($response));
        }
        return  $response;
    }

    /**
     * Display the specified resource.
     *
     * @param $collection
     * @return JsonResponse|Response
     */
    public function show($collection)
    {
        $response = $this->repository->show($collection);
        if($response instanceof Collection)
        {
            return  Helper::response('success','collection created',200, CollectionResource::make($response));
        }
        return  $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $collection
     * @return Response
     */
    public function update(Request $request, $collection)
    {  $request->validate(
        [
            'name' => 'required|string',
            'details' => 'require|string'
        ]
    );
        return $this->repository->update($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $collection
     * @return Response
     */
    public function destroy($collection)
    {
        return $this->repository->destroy($collection);
    }

    public function addToCollection(Request $request, $collection)
    {
        $request->validate(
            [
                'artworks.*' => 'required'
            ]
        );
        return $this->repository->addArtworkToCollection($request, $collection);
    }
    public function removeFromCollection(Request $request,$collection)
    {
        $request->validate(
            [
                'artworks.*' => 'required|array'
            ]
        );
        return $this->repository->removeArtworkFromCollection($request,$collection);
    }
}
