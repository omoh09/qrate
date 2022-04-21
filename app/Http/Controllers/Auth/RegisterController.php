<?php /** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Mail;
use App\User;
//use Validator;
use App\Profile;
use App\Catalogue;
use App\Subscription;
use App\Helpers\Helper;
use App\Events\NewUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Mail\TestEmail;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;


class RegisterController extends Controller
{
    // Register Controller Start

    /** @noinspection PhpUndefinedMethodInspection */
    public function register (Request $request) {
        // Using Validator to check the input data{$request}
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'username' => ['required', 'string', 'unique:users', 'alpha_dash', 'min:3', 'max:30'],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8|max:32|regex:"^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$"',
            'country' => 'required|string',
            'role' => 'required|integer|between:1,4',
            'categories' => 'array'
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
        $request->email = strtolower($request->email);
        //Hashing the password
        $request['password']=Hash::make($request['password']);
        //Remember Token generating
        $request['remember_token'] = Str::random(10);

        if ($request->has('ref')) {
            $ref = $request->query('ref');
            $referral = User::whereUsername($ref)->first();
            if(!$referral == null){
                $referral->fill(['ref_count' => $referral['ref_count'] += 1]);
                $referral->save();
            }            
            //TODO
            //Notify the user that he has a referral
        }
        //Creating the User
        $user = User::create($request->toArray());
        //send a verification mail
        event(new NewUser($user));
      
        return Helper::response('success','user account registered check mail for verification link');

    }

    //Testing mail service
    public function subscribe(Request $request) 
    {
        Validator::make($request->all(), [
             'email' => 'required|email|unique:subscribers'
        ]);

        Mail::to($request->email)->send(new TestEmail());
        return new JsonResponse(
            [
                'success' => true, 
                'message' => "Thank you for subscribing to our email, please check your inbox"
            ], 
            200
        );
    }

    public function test(){
        echo "SERVER IS LVE"; 
    }

}
