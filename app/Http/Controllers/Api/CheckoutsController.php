<?php

namespace App\Http\Controllers\Api;

use App\Checkouts;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CheckoutResource;
use Illuminate\Support\Facades\Validator;
use App\Repository\Checkout\CheckoutRepositoryInterface;

class CheckoutsController extends Controller
{



    private $repository;

    public function __construct(CheckoutRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response
     */
    public function index()
    {
        return Helper::response('success','user checkouts',200,CheckoutResource::collection($this->repository->index()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'delivery_address_id' => 'required|int',
          ]);
        if($validator->fails())
        {
            $request->validate(
                [
                    'name' => 'required|string',
                    'phone' => 'required|string',
                    'str_address' => 'required|string',
                    'city_state' => 'required|string',
                    'postal_code' => 'required|string',
                    'country' => 'required|string'
                ]
            );
        }
        $response = $this->repository->store($request);
        if($response instanceof  Checkouts)
        {
            return Helper::response('success','checkout done', 200,CheckoutResource::make($response));
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param $checkouts
     * @return Response
     */
    public function show($checkouts)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $checkouts
     * @return Response
     */
    public function update(Request $request, $checkouts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $checkouts
     * @return Response
     */
    public function destroy($checkouts)
    {
        //
    }


}
