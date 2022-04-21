<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Repository\Cart\CartRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{

    /**
     * @var CartRepositoryInterface
     */
    private $repository;

    public function __construct(CartRepositoryInterface $repository)
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
        return  Helper::response('succes' , 'user cart',200, CartResource::collection($this->repository->index())->resource);
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
     * @param $cart
     * @return Response
     */
    public function show($cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $cart
     * @return Response
     */
    public function update(Request $request, $cart)
    {
        $request->validate(
            [
                'quantity' => 'required|string'
            ]
        );

        return $this->repository->edit($request,$cart);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $cart
     * @return Response
     */
    public function destroy($cart)
    {
        return  $this->repository->destroy($cart);
    }
}
