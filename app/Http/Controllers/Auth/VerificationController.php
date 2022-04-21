<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserVerified;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Providers\RouteServiceProvider;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    use VerifiesEmails;
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */


    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }


    public function verify2(Request $request)
    {
        $request->validate(
            [
                'token' => 'required',
                'expires' => 'required'
            ]
        );
//        dd($request->route('id'));
        $user = User::find($request->route('id'));
//        dd($user);
        if($user){
            if ($user->hasVerifiedEmail()) {
                return Helper::response('error','account verified already',400);
            }
            if( ! (Now() <= Carbon::parse((int)$request->expires)))
            {
                return Helper::response('error','token expired',400);
            }
            $check = $user->verifyTable()->where('token',$request->token)->where('expires' , Carbon::parse((int)$request->expires))->first();
            if(!$check){
                return Helper::response('error','verification link is broken request new one',400);
            }
            if ($user->markEmailAsVerified()) {
                event(new Verified($user));
//                $check->update(['expires' => Now()]);
            }
            event( new UserVerified($user));
            $accessToken = $user->createToken('authToken',['customer'])->accessToken;
            return response([
                'StatusCode' => 200,
                'success' => true,
                'message' => 'Account verified',
                'user' => UserResource::make($user),
                'access_token' => $accessToken
            ]);

        }
        return Helper::response('error','user not found');
    }
    public function resend2(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|string'
            ]
        );
        $request->email = strtolower($request->email);
        $user = User::where('email',$request->email)->first();
        if($user )
        {
            if($user->hasVerifiedEmail())
            {
                return Helper::response('error','account has been verified already',400);
            }
            $user->sendEmailVerificationNotification();
            return Helper::response('success','email sent',200);
        }
        return Helper::response('error','account not registered',404);

    }

}
