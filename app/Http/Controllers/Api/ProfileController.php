<?php

namespace App\Http\Controllers\Api;

use App\Profile;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Repository\ArtistProfile\ProfileInterface;
use App\Rules\NoNumeric;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfileController extends Controller
{

    /**
     * @var ProfileInterface
     */
    private $repository;

    public function __construct(ProfileInterface $repository)
    {
        $this->repository = $repository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response
     */
    public function index()
    {
       $response =  $this->repository->index();
       if($response instanceof User)
       {
           return  Helper::response('success','profile found',200 ,ProfileResource::make($response));
       }
       return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Profile $artistProfile
     * @return Response
     */
    public function show(Profile $artistProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $request->validate(
            [
                'categories' => 'array',
                'bio' => ['string','max:255',new NoNumeric()],
                'username' => 'string',
                'address' => 'string',
                'bank_name' => 'string',
                'account_no' => 'string',
                'profile_picture' => 'image|mimes:jpeg,png,bmp,gif,svg'
            ]
        );
        return $this->repository->edit($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Profile $artistProfile
     * @return Response
     */
    public function destroy(Profile $artistProfile)
    {
        //
    }
}
