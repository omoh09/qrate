<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Photos;
use App\Repository\Photos\PhotosRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PhotosController extends Controller
{

    /**
     * @var PhotosRepositoryInterface
     */
    private $repository;

    public function __construct(PhotosRepositoryInterface $repository)
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
        return Helper::response('success','gallery pictures','200',FileResource::collection($this->repository->index())->resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'pictures.*' => 'required|image|mimes:jpeg,png,bmp,gif,svg',
            ]
        );

        return $this->repository->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param Photos $photos
     * @return Response
     */
    public function show(Photos $photos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Photos $photos
     * @return Response
     */
    public function update(Request $request, Photos $photos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $photos
     * @return Response
     */
    public function destroy($photos)
    {
        return $this->repository->destroy($photos);
    }
}
