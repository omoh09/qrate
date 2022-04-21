<?php


namespace App\Repository\TwoFactorAuth;


use App\Helpers\Helper;

class TwoFactorRepository implements TwoFactorAuthInterface
{

    public function on()
    {
        return $this->generateNewSecret();
    }

    public function off()
    {
        auth()->user()->disableTwoFactorAuth();
        return Helper::response('success','two factor authentication disabled' );
    }

    public function generateNewSecret()
    {
        $secret = auth()->user()->createTwoFactorAuth();
        // add event Here
        return Helper::response(
            'success',
            'two factor Authentication generated successfully',
            200,
            [
                'secret_qr_Code' => $secret->toQr(),
                'secret_uri'     => $secret->toUri(),
                'secret_string'  => $secret->toString(),
            ]
        );
    }
}
