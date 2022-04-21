<?php 
namespace App\Repository\Checkout;

use Illuminate\Http\Request;

interface CheckoutRepositoryInterface
{
    public function index();

    public function show($checkout);

    public function store(Request $request);
    public function delete($checkout);

    public function paid($checkout);

}