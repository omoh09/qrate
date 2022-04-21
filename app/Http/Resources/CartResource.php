<?php

namespace App\Http\Resources;

use App\ArtSupply;
use App\Artworks;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product_type = '';
        if($this->product instanceof Artworks)
        {
            $product = MiniArtworkResourceForCart::make($this->product);
            $product_type = 'artwork';
        }
        if($this->product instanceof ArtSupply)
        {
            $product = MiniArtSupplyResource::make($this->product);
            $product_type = 'supplies';
        }
        return
            [
                'id' => $this->id,
                'quantity' => $this->quantity,
                'product' => $product,
                'type' => $product_type,
                'sub_total' => (float) $this->quantity * (float) $this->product->price,
                'bought' => $this->bought
            ];
    }
}
