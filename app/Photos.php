<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    protected $guarded = ['id'];

    public function files()
    {
        return $this->morphMany(File::class,'owner');
    }
}
