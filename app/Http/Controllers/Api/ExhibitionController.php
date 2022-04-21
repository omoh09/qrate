<?php

namespace App\Http\Controllers\Api;

use App\Exhibition;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Repository\Exhibition\ExhibitionRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Resources\ExhibitionResource;

class ExhibitionController extends Controller
{

    /**
     * @var ExhibitionRepositoryInterface
     */
    private $repository;

    public function __construct(ExhibitionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all(){
        return Helper::response('success','all exhibitions',200, ExhibitionResource::collection($this->repository->all())->resource);
    }
    public function index()
    {
        //return Helper::response('success','Exhibition',200);
        return $this->repository->index();
    }

    public function ongoing()
    {
        return Helper::response('success','ongoing exhibition',200, ExhibitionResource::collection($this->repository->ongoing())->resource);
    }
    public function past()
    {
        return Helper::response('success','past exhibition',200, ExhibitionResource::collection($this->repository->past())->resource);
    }
    public function upcoming()
    {
        return Helper::response('success','upcoming exhibition',200, ExhibitionResource::collection($this->repository->upcoming())->resource);
    }
    public function show($id)
    {
        $response = $this->repository->show($id);
        if($response instanceof Exhibition)
        {
            return Helper::response('success','Auction found',200,ExhibitionResource::make($response));
        }
        return $response;
    }

    public function toggleLike($id)
    {
        return $this->repository->toggleLike($id);
    }

    public function register($id)
    {
        request()->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string',
            'quantity' => 'required',
        ]);
        return $this->repository->register($id);
        //TO DO: send the user an email
    }

    public function pay(Request  $request)
    {
        $request->validate(
            [
                'user_id' => 'required',
                'checkout_id' => 'required'
            ]
        );
        return $this->repository->payTicket($request);
    }

    public function  paymentCallback($checkout)
    {
        return $this->repository->paymentCallback($checkout);
    }
}

