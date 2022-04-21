<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MiniArtworkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $liked_by = false;
        if(auth()->check())
        {
            $liked = $this->likes()->where('user_id',auth()->user()->id)->first();
            if($liked)
            {
                $liked_by = true;
            }
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'files' => FileResource::collection($this->files),
            'dimension' =>  $this->dimension,
            'price' => (float) $this->price,
            'sold' => $this->sold ? true : false,
            'liked' => $liked_by,
            'category' => ArtworkCatgories::make($this->category),
            'likes_count' => $this->likes_count,
            'comments_count' => $this->comments_count,
            'on_shelf' => $this['on-shelf'],
            'sale_type' => $this->sale_type == 2 ? "auction" : "normal",
        ];
    }
}
