<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class LoginController extends Controller
{
    //
    public function login(Request $request)
    {
        //Validate login input data
        $request->validate([
            'email' => 'email|required',
            'password' => 'required|min:6'
        ]);
        $request->email = strtolower($request->email);
        if (!Auth::attempt(['email' => $request->email,'password' => $request->password]))
        {
            return response([
                'message' => 'Invalid Credentials'
            ]);
        }

        if(!auth()->user()->active)
        {
           return Helper::response('error','account deactivated',401);
        }

        if(auth()->user()->email_verified_at  == NULL)
        {
            return Helper::response('error','unverified account',403);
        }

        $accessToken = auth()->user()->createToken('authToken',['customer'])->accessToken;

        return response([
            'StatusCode' => 200,
            'success' => true,
            'message' => 'User Successfully Logged-in',
            'user' => UserResource::make(auth()->user()),
            'access_token' => $accessToken
        ]);

    }
    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
