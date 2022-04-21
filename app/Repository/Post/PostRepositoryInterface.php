<?php
namespace App\Repository\Post;

use Illuminate\Http\Request;

interface PostRepositoryInterface
{
    /**
     * @return mixed
     */
    public function  index();

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request);

    public function show($id);

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function edit($id , Request $request);

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);

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
}
