<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArtworksResource;
use App\Http\Resources\PostResource;
use App\Repository\Timeline\TimelineInterface;

class TimelineController extends Controller
{
    //
    /**
     * @var TimelineInterface
     */
    private $repository;

    public function __construct(TimelineInterface $repository)
    {
        $this->repository = $repository;
    }

    public function timeline()
    {
        return Helper::timelineResponse('success','user timeline',200,PostResource::collection($this->repository->timeline())->resource);
    }
    public function topPicks()
    {
        return Helper::response('success','top picks',200,ArtworksResource::collection($this->repository->topPicks())->resource);
    }
}
