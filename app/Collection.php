<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function artworks()
    {
       return $this->belongsToMany(Artworks::class,'collections_artworks','collection_id','artwork_id');
    }
}
