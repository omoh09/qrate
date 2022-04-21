<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    //
    protected $table = 'advert';
    protected $gaurded = ['id'];
    protected $fillable = ['title'];
    
    public function files()
    {
        return $this->morphMany(File::class,'owner');
    }
}
