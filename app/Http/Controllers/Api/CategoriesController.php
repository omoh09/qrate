<?php

namespace App\Http\Controllers\Api;

use App\Categories;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Http\Resources\MiniCategoriesResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Http\Response;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response
     */
    public function index()
    {
        return Helper::response('success' ,'All Categories',200, MiniCategoriesResource::collection(Categories::all())->resource);
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
     * @param Categories $categories
     * @return Response
     */
    public function show(Categories $categories)
    {
        //
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

    public function singleCategory($category)
    {
        return Helper::response('success' ,'All Categories',200, CategoriesResource::make(Categories::where('id', $category)->first()));
    }

    public function addUserCategory(Request $request)
    {
        $request->validate(
            [
                'categories' => 'required|array',
                'categories.*' => 'int'
            ]
        );
        auth()->user()->preferredCategories()->sync($request->categories);
        return Helper::response('success','categories updated');
    }
}
