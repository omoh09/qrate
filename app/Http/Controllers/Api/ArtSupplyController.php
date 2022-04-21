<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Repository\ArtSupply\ArtSupplyRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\ArtSupply;
use App\Http\Resources\ArtSupplyResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ArtSupplyController extends Controller
{

    /**
     * @var ArtSupplyRepositoryInterface
     */
    private $repository;

    public function __construct(ArtSupplyRepositoryInterface $repository)
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
        //
//        $art=ArtSupply::all();
//        return response([ 'Art Supply' => ArtSupplyResource::collection($art), 'message' => 'Retrieved successfully'], 200);

        return Helper::response('success' ,'all existing art supplied',200, ArtSupplyResource::collection($this->repository->index())->resource);

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
     * @return JsonResponse|Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price'=>'required|string',
            'pictures.*' => 'required|image|mimes:jpeg,png,bmp,gif,svg',
            'category' => 'required|int'
        ]);
        return  Helper::response('success','art supply created',200,ArtSupplyResource::make($this->repository->store($request)));
    }

    /**
     * Display the specified resource.
     *
     * @param $art_supply
     * @return JsonResponse
     */
    public function show($art_supply)
    {
        $response = $this->repository->show($art_supply);
        if ($response instanceof ArtSupply) {
            return Helper::response('success', 'art supply found', 200, ArtSupplyResource::make($response));
        }
        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $art_supply
     * @return Response
     */
    public function edit($art_supply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $art_supply
     * @return Response
     */
    public function update(Request $request, $art_supply)
    {

        $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'price'=>'string',
            'category' => 'int'
        ]);
        return $this->repository->update($request,$art_supply);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $art_supply
     * @return Response
     */
    public function destroy($art_supply)
    {
        return  $this->repository->destroy($art_supply);
    }

    public function categoryFilter(Request $request){
        $request->validate(
            [
                'categories' => 'array',
                'price' => 'string|in:desc,asc',
                'released' => 'int|in:1,2,3,4,5'
            ]
        );
        $response = $this->repository->categorizeArtSupplies($request);
        return Helper::response('success' ,'all existing art supplied',200, ArtSupplyResource::collection($response)->resource);

    }
    public function addToCart($art_supply)
    {
        return $this->repository->addtoCart($art_supply);
    }
}
