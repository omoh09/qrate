<?php


namespace App\Repository\Follow;

use App\Events\FollowEvent;
use App\Helpers\Helper;
use App\User;

class FollowRepository implements FollowInterface
{
    private $userModel;


    /**
     * @inheritDoc
     */
    public function followers()
    {
        return  User::whereId(auth()->user()->id)->first()->followers;
    }

    public function following()
    {
        return  User::whereId(auth()->user()->id)->first()->following;
    }

    public function toggleFollow($id)
    {
        $user = User::whereId($id)->first();
        if (!$user || $user->role == 1 || $user->role == 4) {
            return Helper::response('error', 'user not found', 404);
        }
        if ($id == User::whereId(auth()->user()->id)->first()->id) return Helper::response('error', 'you can\'t follow your self', 404);
        $followingId = User::whereId(auth()->user()->id)->first()->following()->allRelatedIds();
        $toggle = User::whereId(auth()->user()->id)->first()->following()->toggle($id);
        if (array_search((int)$id, $followingId->toArray()) === false) {
            event(new FollowEvent($id,auth()->user()));
            return Helper::response('success', 'user followed', 200);
        }
        return Helper::response('success', 'user unFollowed', 200);

    }
    public function showFollowing($id)
    {
        $following = User::whereId(auth()->user()->id)->first()->following()->wherePivot('user_followed_id', '=', $id)->get();
        if ($following->toArray()) {
            return $following;
        }
        return Helper::response('error', 'you are not following this user', 400);
    }

    public function showFollower($id)
    {
        $follower = User::whereId(auth()->user()->id)->first()->followers()->wherePivot('user_id','=',$id)->get();
        if($follower->toArray())
        {
            return $follower;
        }
        return Helper::response('error','this user is not a follower',400);
    }
}

