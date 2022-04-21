<?php
namespace App\Repository\Exhibition;

use Illuminate\Http\Request;

interface ExhibitionRepositoryInterface
{
    /**
     * @return mixed
     */
    public function index();

    public function show($id);

    public function toggleLike($id);

    public function ongoing();

    public function all();

    public function upcoming();

    public function past();

    public function register($id);

    public function payTicket(Request $request);

}
