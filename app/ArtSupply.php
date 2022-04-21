<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArtSupply extends Model
{
    //]

    protected $table = 'artsupplies';
    protected $guarded = ['id'];

    public function files()
    {
        return $this->morphMany(File::class,'owner');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(SuppliesCategory::class,'category_id');
    }
    public function toCart()
    {
        return $this->morphMany(Cart::class,'owner');
    }
}
