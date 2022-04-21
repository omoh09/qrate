<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public static $wrap = 'posts';
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
            'body' => $this->body,
            'files' => FileResource::collection($this->files),
            'category' => ArtworkCatgories::collection($this->categories),
            'liked' => $liked_by,
            'likes_count' => $this->likes_count,
            'comments_count' => $this->comments_count,
            'user' => PostUserResource::make($this->user),
            'comments' => CommentResource::collection($this->comments),
            'created_at' => Carbon::parse($this->created_at)->toDateTime()
        ];
    }
}
