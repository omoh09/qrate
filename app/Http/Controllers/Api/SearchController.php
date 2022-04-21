<?php

namespace App\Http\Controllers\Api;

use App\ArtSupply;
use App\Artworks;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArtSupplyResource;
use App\Http\Resources\MiniArtworkResource;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public  function index(Request $request)
    {
        $request->validate(
            [
                'text' => 'required|string'
            ]
        );
        $text = $request->text;
        $users = User::where('name','like', '%'.$text.'%')->orWhere('email','like', '%'.$text.'%')->get();
        $artworks = Artworks::where('title','like', '%'.$text.'%')->get();
        //TODO add exhibiton
        $artSupplies = ArtSupply::where('title','like', '%'.$text.'%')->get();
        return Helper::response(
            'success',
            'query found',
            200,
            [
                'users'=> UserResource::collection($users),
                'artworks' => MiniArtworkResource::collection($artworks),
                'artSupply' => ArtSupplyResource::collection($artSupplies)
            ]
        );
    }
}
