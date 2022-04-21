<?php
namespace App\Repository\Artist;

use Illuminate\Http\Request;

interface ArtistRepositoryInterface
{
    /**
     * @return mixed
     */
    public function index();

    /**
     * @param $id
     * @return mixed
     */
    public function show($id);

    /**
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request);

}
