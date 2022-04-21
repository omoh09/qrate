<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    //
    protected $guarded = ['id'];
    public function folders()
    {
       return $this->hasMany(Folder::class,'catalogue_id');
    }

    public function user()
    {
       return $this->belongsTo(User::class);
    }
}
