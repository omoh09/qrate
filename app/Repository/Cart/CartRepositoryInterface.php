<?php

namespace App\Repository\Cart;

use Illuminate\Http\Request;

interface CartRepositoryInterface
{
    /**
     * @return mixed
     */
    public function index();

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function edit(Request $request, $id);
}
