<?php

namespace App\Providers;

use App\User;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
//        VerifyEmail::toMailUsing(function (User $user, string $verificationUrl) {
//            return (new MailMessage)
//                ->subject(Lang::get('Verify Email Address'))
//                ->view('mail.verification', ['url' => $verificationUrl,'username' => $user->name]);
//        });

        VerifyEmail::toMailUsing(function ($notifiable){
            if(!$notifiable->verifyTable){
               $verifyModel = $notifiable->verifyTable()->create(
                    [
                        'token' => sha1($notifiable->getEmailForVerification()),
                        'expires' => Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                    ]
                );
            }else{
                $notifiable->verifyTable->update(
                    [
                        'token' => sha1($notifiable->getEmailForVerification()),
                        'expires' => Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                    ]
                );
                $verifyModel = $notifiable->verifyTable;
            };
            $verifyUrl = \config('app.verification_page').$notifiable->getKey()."&token=" .$verifyModel->token."&expires=".Carbon::parse($verifyModel->expires)->timestamp;
            $user = User::whereEmail($notifiable->getEmailForVerification())->first();
            return (new MailMessage)
                ->subject(Lang::get('Verify Email Address'))
                ->view('mail.verification', ['url' => $verifyUrl,'username' => $user->name]);
        });
        Passport::tokensCan([
            'admin' => 'Access Admin Backend',
            'customer' => 'Access Customer App',
            'SalesRep' => 'access sales record',
        ]);
        Passport::setDefaultScope([
            'customer',
        ]);
        Passport::personalAccessTokensExpireIn(Carbon::now()->addMonths(1));
        //
    }
}
