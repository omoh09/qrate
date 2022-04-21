<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminCheckoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return
        [
            'id' => $this->id,
            'date' => $this->created_at,
            'buyer_name' => $this->name,
            'paid' => $this->paid,
            'address' => $this->str_address,
            'city_state' => $this->city_state,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'country' => $this->country,
            'products' => CartResource::collection($this->cart),
            'user' => UserResource::make($this->user)
        ];
    }
}
