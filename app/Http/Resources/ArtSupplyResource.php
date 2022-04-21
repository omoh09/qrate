<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArtSupplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request) return
        return
        [
            'id' => $this->id,
            'title' => $this->title,
            'description' =>$this->description,
            'price' =>$this->price,
            'sold' => $this->sold ? true : false,
            'category' => $this->category,
            'file' => FileResource::collection($this->files),
            'user' => UserResource::make($this->user)
        ];
    }
}
