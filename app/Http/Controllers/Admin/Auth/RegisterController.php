<?php /** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Support\Facades\Mail;
use App\Helpers\Helper;
use App\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class RegisterController extends Controller
{
    // Register Controller Start

    /** @noinspection PhpUndefinedMethodInspection */
    public function register (Request $request) {
        // Using Validator to check the input data{$request}
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:32|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[$#~`\=\+\.\^\@_%\*\)\(&%]).*$/',
        ]);

        //Check for Validation
        if ($validator->fails())
        {
            //Error Messages
            $response = ['success' => false,
                     'message' => 'Error while Registering',
                     'StatusCode' => 422,
                     'errors'=>$validator->errors()->all(),
            ];
            return response($response, 422);
        }

        $pattern = "/qrateart.com/i";
        if (!preg_match($pattern, $request->email))
        {
            return response([
                'message' => 'Invalid Admin email',
                'StatusCode' => 400 
            ]);
        }

        $request->email = strtolower($request->email);
        //Hashing the password
        $request['password']=Hash::make($request['password']);
        
        //Creating the User
        $user = Admin::create($request->toArray());
      
        return Helper::response('success','Admin account registered');
    }
}
