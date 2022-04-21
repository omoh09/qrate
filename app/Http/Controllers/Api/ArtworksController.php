<?php

namespace App\Http\Controllers\Api;

use App\Artworks;
use App\Comments;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArtworksResource;
use App\Http\Resources\CommentResource;
use App\Repository\Artworks\ArtworksRepositoryInterface;
use Illuminate\Http\Request;

class ArtworksController extends Controller
{
    //
    /**
     * @var ArtworksRepositoryInterface
     */
    private $repository;

    public function __construct(ArtworksRepositoryInterface $artworksRepository)
    {
        $this->repository = $artworksRepository;
    }

    public function index()
    {
        return Helper::response('success' ,'artworks',200,ArtworksResource::collection($this->repository->index())->resource);
    }

    public function  artistArtworks($artist)
    {
        $response = $this->repository->artistArtworks($artist);

        if($response instanceof  Artworks)
        {
            return Helper::response('success' ,'artworks',200,ArtworksResource::collection($response)->resource);
        }
        return $response;
    }

    public function show($artwork)
    {
        $response = $this->repository->show($artwork);
        if($response instanceof Artworks)
        {
            return Helper::response('success','artwork found',200,ArtworksResource::make($response));
        }
        return  $response;
    }
    public function toggleLike($artwork)
    {
        return $this->repository->toggleLike($artwork);

    }
    public function comment(Request $request,$artwork)
    {
        $request->validate(
            [
                'body' => 'required'
            ]
        );
        $response = $this->repository->comment($request,$artwork);
        if($response instanceof  Comments)
        {
            return Helper::response('success','comment sent',200,CommentResource::make($response));
        }
        return $response;
    }

    public function addToCart($id)
    {
        return $this->repository->addtoCart($id);
    }
}
