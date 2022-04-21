<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repository\Follow\FollowInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class FollowingController extends Controller
{

    /**
     * @var FollowInterface
     */
    private $repository;

    public function __construct(FollowInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|AnonymousResourceCollection|Response
     */
    public function following()
    {
        $index = $this->repository->following();
        return Helper::response('success','resource found',200, UserResource::collection($index));
    }

    public function followers()
    {
        $index = $this->repository->followers();
        return Helper::response('success','resource found',200,UserResource::collection($index));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param $id
     * @return void
     */
    public function toggleFollow($id)
    {
        return $this->repository->toggleFollow($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse|AnonymousResourceCollection|Response
     */
    public function showFollower($id)
    {
        $result =  $this->repository->showFollower($id);
        if($result instanceof  JsonResponse){
            return $result;
        }
        return Helper::response('success','resource found',200,UserResource::Collection($result));
    }

    /**
     * @param $id
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function showFollowing($id)
    {
        $result =  $this->repository->showFollowing($id);
        if($result instanceof  JsonResponse){
          return $result;
        }
        return Helper::response('success','resource found',200,UserResource::Collection($result));
    }
}
