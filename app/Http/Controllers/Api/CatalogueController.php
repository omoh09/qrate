<?php

namespace App\Http\Controllers\Api;

use App\Catalogue;
use App\Folder;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArtworksResource;
use App\Http\Resources\CatalogueResource;
use App\Http\Resources\FolderResource;
use App\Repository\Catalogue\CatalogueRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CatalogueController extends Controller
{


    /**
     * @var CatalogueRepositoryInterface
     */
    private $repository;

    public function __construct(CatalogueRepositoryInterface $repository)
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
        return Helper::response('success' ,'catalogue',200,CatalogueResource::make($this->repository->index()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string'
            ]
        );
        return Helper::response('success' ,'folder',200,FolderResource::make($this->repository->store($request)));
    }

    /**
     * Display the specified resource.
     *
     * @param $folder
     * @return JsonResponse|void
     */
    public function show($folder)
    {
        //
        $response = $this->repository->show($folder);
        if($response instanceof Folder)
        {
            return Helper::response('success' ,'folder',200,FolderResource::make($response));
        }
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $folder
     * @return void
     */
    public function update(Request $request, $folder)
    {
        $request->validate(
            [
                'name' => 'required|string'
            ]
        );
        return $this->repository->edit($request,$folder);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $folder
     * @return void
     */
    public function destroy($folder)
    {
        return $this->repository->destroy($folder);
    }

    public function addToFolder($folder, $artwork)
    {
        return $this->repository->addToFolder($folder,$artwork);
    }
    public function removeFromFolder($folder,$artwork)
    {
        return $this->repository->removeFromFolder($folder,$artwork);
    }

}
