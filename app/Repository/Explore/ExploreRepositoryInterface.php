<?php

namespace App\Repository\Explore;

interface ExploreRepositoryInterface
{
    /**
     * @return mixed
     */
    public function index();

    /**
     * @param Request $request
     * @return mixed
     */
    public function show($id);

    /**
     * @return mixed
     */
    public function trending();
}
