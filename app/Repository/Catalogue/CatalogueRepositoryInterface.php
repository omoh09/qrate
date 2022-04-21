<?php

namespace App\Repository\Catalogue;

use Illuminate\Http\Request;

interface CatalogueRepositoryInterface
{
    /**
     * index
     *
     * @return mixed
     */
    public function index();

    /**
     * show
     *
     * @param int $id
     * @return mixed
     */
    public function show($id); // show a single folder

    /**
     * store
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request); //creat a new folder


    /**
     * edit
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function edit(Request $request,$id); // edit the folders details

    /**
     * destroy
     *
     * @param [int] $id
     * @return void
     */
    public function destroy($id); // delete a folder

    /**
     * @param int $folder
     * @param int $artwork
     * @return mixed
     */

    public function addToFolder( int $folder, int $artwork);

    /**
     * remove from folder
     *
     * @param int $folder
     * @param integer $artwork
     * @return mixed
     */
    public function removeFromFolder(int $folder , int $artwork);

}
