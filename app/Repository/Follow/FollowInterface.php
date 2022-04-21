<?php
namespace App\Repository\Follow;

interface FollowInterface
{
    /**
     * @return mixed
     */
    public function followers();

    public function following();

    public function showFollowing($id);

    public function showFollower($id);
    public function toggleFollow($id);
}
