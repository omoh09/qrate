<?php

namespace App\Http\Resources;

use App\Artworks;
use App\Comments;
use App\Post;
use Illuminate\Http\Resources\Json\JsonResource;

class LikedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $post = '';
        $index = '';
        if($this->owner instanceof Post)
        {
            $post = MiniPostResource::make($this->owner()->first());
            $index = 'post';
        }
        if($this->owner instanceof Artworks)
        {
            $post = MiniArtworkResource::make($this->owner()->first());
            $index = 'artwork';
        }
        if($this->owner instanceof Comments)
        {
            $post = CommentResource::make($this->owner()->first());
            $index = 'comment';
        }
        return
            [$index => $post];
    }
}
