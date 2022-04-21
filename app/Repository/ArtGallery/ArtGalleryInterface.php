<?php

namespace  App\Repository\ArtGallery;
use Illuminate\Http\Request;

interface ArtGalleryInterface
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

    public function createExhibition(Request $request);

    public function editExhibition(Request $request, $id);
}
