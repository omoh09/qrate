<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuctionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $your_bid = 0;
        if(auth()->check())
        {
            $check = $this->artwork->bid()->where('user_id',auth()->user()->id)->first();
            $your_bid =  $check ? $check->amount : 0;
        }
        return [
            'id' => $this->id,
            'artwork' =>ArtworksResource::make($this->artwork),
            'start_bid'=> $this->artwork->price,
            'your_bid' => $your_bid,
            'bid_count' => $this->artwork->bid->count(),
            'highest_bid' => $this->artwork->bid->first() ? $this->artwork->bid->first()->amount :  0,
            'starts' => $this->bid_start,
            'ends' => $this->bid_end
        ];
    }
}
