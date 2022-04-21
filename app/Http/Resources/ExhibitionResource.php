<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExhibitionResource extends JsonResource
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
        return  [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->desc,
            'date' => $this->event_date,
            'address' => $this->address,
            'country' => $this->country,
            'time' => $this->time,
            'video' => VideoResource::collection($this->video),
            'liked_by' => $liked_by,
            'ticket_price' => $this->ticket_price,
            'likes_count' => $this->likes_count,
            'files' => FileResource::collection($this->files)
        ];
    }
}
