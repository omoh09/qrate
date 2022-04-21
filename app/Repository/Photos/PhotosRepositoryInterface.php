<?php
namespace  App\Repository\Photos;



use Illuminate\Http\Request;

interface PhotosRepositoryInterface
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
     * @param $photo
     * @return mixed
     */
public function destroy($photo);
}
