<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArtGalleryResource extends JsonResource
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
        return
            [
                'id' => $this->id,
                'username' => $this->name,
                'profile_picture' => FileResource::make($this->profilePicture()->orderBy('updated_at','desc')->first()),
                'bio' => $this->profile ? $this->profile->bio : '',
                'address' => $this->profile ? $this->profile->address : '',
                'artworks' => MiniArtworkResource::collection($this->artworks()->orderBy('updated_at','desc')->take(20)->get()),
                'collection' => CollectionResource::collection($this->artworksCollection()->orderBy('updated_at','desc')->take(20)->get()),
                'artist' => UserResource::collection($this->artists()->take(20)->get()),
                'photos' => $this->photos ? FileResource::collection($this->photos->files()->orderBy('updated_at','desc')->take(20)->get()) : [],
                'exhibtions' => ExhibitionResource::collection($this->exhibitions),
                'following' => $following
            ];
    }
}
