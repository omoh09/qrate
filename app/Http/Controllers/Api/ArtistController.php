<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArtistResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use App\Repository\Artist\ArtistRepositoryInterface;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    //

    public function __construct(ArtistRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return Helper::response('success','artists',200,UserResource::collection($this->repository->index())->resource);
    }
    public function show($id)
    {
        $response = $this->repository->show($id);
        if($response instanceof User)
        {
            return Helper::response('success','artist found',200,ArtistResource::make($response));
        }
        return $response;
    }

    public function search(Request $request)
    {
        $request->validate(
            [
                'text'=> 'required'
            ]
        );
        $response = $this->repository->search($request);
        if($response instanceof Collection)
        {
            return Helper::response('success','artists found',200,UserResource::collection($response)->resource);
        }
        return  $response;
    }
}
