<?php


namespace App\Repository\ArtistProfile;


use App\Profile;
use App\Helpers\Helper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileRepository implements ProfileInterface
{

    /**
     * @inheritDoc
     */
    public function index()
    {
        $user = auth()->user();
        $profile = Profile::where(['user_id'=> $user->id])->first();
        if($profile)
        {
            return User::whereId($user->id)->first();
        }
        $profile = Profile::create(
            [
                'user_id' => $user->id,
                'username' => $user->name,
            ]
        );
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function edit(Request $request)
    {
        $user = auth()->user();
            $profile = Profile::where(['user_id'=> $user->id])->first();
            $profile->update(
                [
                    'bio' => $request->bio ?? $profile->bio,
                    'username' => $request->username ?? $profile->username,
                    'address' => $request->address ?? $profile->address,
                    'bank_name' => $request->bank_name ?? $profile->bank_name,
                    'account_no' => $request->account_no ?? $profile->account_no
                ]
            );
            $user = User::whereId($user->id)->first();
            $user->update(
                [
                    'name'  => $request->username ?? $user->name,
                ]
            );
            if($request->hasFile('profile_picture'))
            {
                Helper::uploadProfilePicture($request->file('profile_picture'),$user);
            }
            if($request->categories){
                $user->preferredCategories()->sync($request->categories);
            }
            return  Helper::response('success','profile updated successfully');
        }
}
