<?php

namespace App\Repository\Collection;

use Illuminate\Http\Request;

interface CollectionRepositoryInterface
{
    public function index();

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request);

    /**
     * @param $collection
     * @return mixed
     */
    public function show($collection);

    /**
     * @param Request $request
     * @param $collection
     * @return mixed
     */
    public function update(Request $request, $collection);

    /**
     * @param $collection
     * @return mixed
     */
    public function destroy($collection);

    /**
     * @param Request $request
     * @param $collection
     * @return mixed
     */
    public function addArtworkToCollection(Request $request, $collection);

    /**
     * @param Request $request
     * @param $collection
     * @return mixed
     */
    public function removeArtworkFromCollection(Request $request, $collection);


}
