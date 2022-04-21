<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArtistResource extends JsonResource
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
        if(auth()->user()->id == $this->id)
        {
            $following = true;
        }
        return [
            'id' => $this->id,
            'username' => $this->name,
            'following' => $following,
            'profile_picture' => FileResource::make($this->profilePicture()->orderBy('updated_at','desc')->first()),
            'bio' => $this->profile ? $this->profile->bio : '',
            'categories' => CategoryResource::collection($this->preferredCategories),
            'collection' => MiniArtworkResource::collection($this->artworks()->orderBy('updated_at','desc')->paginate(20)),
        ];
    }
}
