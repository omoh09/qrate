<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Support\Facades\Hash;

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

        $pattern = "/qrateart.com/i";
        if (!preg_match($pattern, $request->email))
        {
            return response([
                'message' => 'Invalid Admin email',
                'StatusCode' => 400 
            ]);
        }
        
        //dd($password);
        $adminData = Admin::where(['email' => $request->email])->first();
        $password = Hash::check($request->password, $adminData['password']);
        if (!$adminData['email'] == $request->email && $password == true){
            return response([
                'message' => 'Invalid Credentials',
                'StatusCode' => 400 
            ]);
        }

        $accessToken = $adminData->createToken('authToken',['admin'])->accessToken;

        return response([
            'StatusCode' => 200,
            'success' => true,
            'message' => 'admin Successfully Logged-in',
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
