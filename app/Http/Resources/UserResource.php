<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $following = false;
        if(auth()->check() && auth()->user()->id != $this->id)
        {
                if(auth()->user()->following()->find($this->id))
                {
                    $following = true;
                }
        }
        if(auth()->check())
        {
            if(auth()->user()->id == $this->id)
            {
                $following = true;
            }
        }
        $file = $this->profilePicture()->orderBy('updated_at','desc')->first();
        return [
            'id' => $this->id,
            'username' => $this->name,
            'profile_picture' => $file ? FileResource::make($file) : [],
            'email' => $this->email,
            'country' => $this->country,
            'role_id' => $this->role,
            'active' => $this->active,
            'role' => RoleResource::make($this->role()->first()),
            'following' =>  $following
        ];
    }
}
