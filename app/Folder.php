<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $guarded = ['id'];
    public function artworks(){
       return $this->belongsToMany(Artworks::class,'items','folder_id','artwork_id');
   }
}
