<?php

namespace App\Http\Controllers\Api;

use App\Categories;
use App\Explore;
use App\Http\Controllers\Controller;
use App\Repository\Explore\ExploreRepositoryInterface;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Http\Resources\ExploreResource;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ExploreController extends Controller
{
        /**
     * @var ExploreRepositoryInterface
     */
    private $repository;

    public function __construct(ExploreRepositoryInterface $repository)
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
        return $this->repository->index();
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
     * @param $art_supply
     * @return JsonResponse
     */
    public function show($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Categories $categories
     * @return Response
     */
    public function update(Request $request, Categories $categories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Categories $categories
     * @return Response
     */
    public function destroy(Categories $categories)
    {
        //
    }

    /**
     * Explore single category.
     *
     * @param Explore  $explore
     * @return Response
     */

    public function trend()
    {
        return  $this->repository->trending();
    }

}
