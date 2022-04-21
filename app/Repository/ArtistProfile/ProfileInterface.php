<?php
namespace App\Repository\ArtistProfile;


use Illuminate\Http\Request;

interface ProfileInterface
{
    /**
     * @return mixed
     */
    public function index();

    /**
     * @param Request $request
     * @return mixed
     */
    public function edit(Request $request);

}
