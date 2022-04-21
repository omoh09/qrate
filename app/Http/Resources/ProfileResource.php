<?php

namespace App\Http\Resources;

use App\Role;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $file = $this->profilePicture()->orderBy('updated_at','desc')->first();
        return [
            'id' => $this->id,
            'username' => $this->name,
            'profile_picture' => $file ? FileResource::make($file) : [],
            'bio' => $this->profile ? $this->profile->bio : '',
            'categories' => CategoryResource::collection($this->preferredCategories),
            'email' => $this->email,
            'country' => $this->country,
            'bank_name' => $this->bank_name,
            'account_no' => $this->account_no,
            'role' => RoleResource::make($this->role()->first()),
            'address' => $this->profile->address ? $this->profile->address : '',
            $this->mergeWhen( $this->role == 2 || $this->role == 3 ,[
            'collection' => MiniArtworkResource::collection($this->artworks()->orderBy('updated_at','desc')->paginate(20))->resource]),
            $this->mergeWhen( $this->role == 1,[
                'collection' => MiniPostResource::collection($this->posts()->orderBy('updated_at','desc')->paginate(20))->resource]),
            $this->mergeWhen( $this->role == 4,[
                'collection' => ArtSupplyResource::collection($this->artSupplies()->orderBy('updated_at','desc')->paginate(20))->resource]),
            $this->mergeWhen( $this->role == 3,[
                'photos' => $this->photos ? FileResource::collection($this->photos->files()->orderBy('updated_at','desc')->paginate(20))->resource : null]) ,
                'liked_post' => LikedResource::collection($this->liked()->orderBy('updated_at','desc')->paginate(20))->resource
        ];
    }
}
