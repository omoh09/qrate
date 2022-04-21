<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ExhibitionCheckoutResource extends JsonResource
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
            'exhibition_id' => $this->exhibition_id,
            'firstname' => $this->firstname,
            'lastname'  => $this->lastname,
            'email' => $this->email,
            'paid' => $this->paid ?? false,
            'amount' => $this->amount,
            'created_at' => Carbon::parse($this->created_at)
        ];
    }
}
