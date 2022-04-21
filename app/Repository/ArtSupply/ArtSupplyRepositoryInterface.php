<?php

namespace App\Repository\ArtSupply;



use Illuminate\Http\Request;

interface ArtSupplyRepositoryInterface
{
    /**
     * @return mixed
     */
    public function index();

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request);

    /**
     * @param $artSupply
     * @return mixed
     */
    public function show($artSupply);

    /**
     * @param Request $request
     * @param $artSupply
     * @return mixed
     */
    public function update(Request $request, $artSupply);

    /**
     * @param $artSupply
     * @return mixed
     */
    public function destroy($artSupply);

    /**
     * @return mixed
     */
    public function userArtSupplies();

    /**
     * @param Request $request
     * @return mixed
     */
    public function categorizeArtSupplies(Request $request);

    /**
     * @param $id
     * @return mixed
     */
    public function addToCart($id);
}
