<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artworks extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];
    
    public function likes()
    {
        return $this->morphMany(Likes::class,'owner');
    }
    public function comments()
    {
        return $this->morphMany(Comments::class,'owner');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function files()
    {
        return $this->morphMany(File::class,'owner');
    }
    public function category()
    {
        return $this->hasOne(Categories::class,'id','category_id');
    }
    public function artCollection()
    {
        return $this->belongsToMany(Collection::class,'collections_artworks','artwork_id','collection_id');
    }
    public function toCart()
    {
        return $this->morphMany(Cart::class,'owner');
    }
    public function auction()
    {
        return $this->hasOne(Auction::class,'artwork_id','id');
    }
    public function bid()
    {
        return $this->hasMany(Bid::class,'artwork_id','id')->orderBy('amount','desc');
    }
    public function video()
    {
        return $this->MorphMany(Video::class,'owner');
    }

    //
}
