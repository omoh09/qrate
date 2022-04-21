<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MiniArtworkResourceForCart extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => (float) $this->price,
            'sold' => $this->sold ? true : false,
            'category' => ArtworkCatgories::make($this->category),
            'files' => FileResource::collection($this->files),
            'dimension' =>  $this->dimension,
            'on_shelf' => $this['on-shelf'],
            'sale_type' => $this->sale_type == 2 ? "auction" : "normal",
        ];}
}
