<?php

namespace App\Http\Controllers\Api;

use App\Comments;
use App\File;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Post;
use App\Repository\Post\PostRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{

    /**
     * @var PostRepositoryInterface
     */
    private $repository;

    ///
    public function __construct(PostRepositoryInterface $repository)
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
        $response = $this->repository->index();
        if($response->toArray()) {
            return Helper::response('success', 'posts found', '200', PostResource::collection($response)->resource);
        }
        return Helper::response('success', 'user has no post', '202', []);
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
                'body' => 'required|string',
                'pictures.*' => 'image|mimes:jpeg,png,bmp,gif,svg',
                'categories' => 'int'
            ]);
        $response = $this->repository->store($request);
        if($response instanceof Post)
        {
            return  Helper::response('success','post created','200',PostResource::make($response));
        }
        return  $response;
    }

    /**
     * Display the specified resource.
     *
     * @param $post
     * @return JsonResponse|void
     */
    public function show($post)
    {
        $response = $this->repository->show($post);
        if($response instanceof Post)
        {
            return  Helper::response('success','post found','200',PostResource::make($response));
        }
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $post
     * @return JsonResponse|void
     */
    public function update(Request $request, $post)
    {
        $request->validate(
            [
                'body' => 'required|string',
                'category' => 'required|int'
            ]
        );
        $response = $this->repository->edit($post,$request);
        if($response instanceof Post)
        {
            return  Helper::response('success','post edited','200',PostResource::make($response));
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $post
     * @return void
     */
    public function destroy($post)
    {
        return $this->repository->destroy($post);
    }

    public function toggleLike($post)
    {
        return $this->repository->toggleLike($post);

    }
    public function comment(Request $request,$post)
    {
        $request->validate(
            [
                'body' => 'required'
            ]
        );
        $response = $this->repository->comment($request,$post);
        if($response instanceof  Comments)
        {
            return Helper::response('success','comment sent',200,CommentResource::make($response));
        }
        return $response;
    }


}
