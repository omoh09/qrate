<?php
namespace App\Repository\Artworks;

use App\Artworks;
use Illuminate\Http\Request;

interface ArtworksRepositoryInterface
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
     * @param $artworks
     * @return mixed
     */
    public function show($artworks);

    /**
     * @param Request $request
     * @param int $artworks
     * @return mixed
     */
    public function update(Request $request, int $artworks);

    /**
     * @param Artworks $id
     * @return mixed
     */
    public function destroy($id);

    /**
     * @return mixed
     */
    public function artworks();

    public function artistArtworks($artist);

    /**
     * @param $id
     * @return mixed
     */
    public function toggleLike($id);

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function comment(Request $request, $id);

    /**
     * @param $id
     * @return mixed
     */
    public function addtoCart($id);
}
