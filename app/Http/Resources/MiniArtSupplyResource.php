<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MiniArtSupplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return
            [
                'id' => $this->id,
                'title' => $this->title,
                'description' =>$this->description,
                'price' => (float) $this->price,
                'sold' => $this->sold ? true : false,
                'category' => $this->category,
                'file' => FileResource::collection($this->files),
            ];
    }
}
