<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exhibition extends Model
{
    //
    use SoftDeletes;
    protected $guarded = ['id'];

    public function user(){
        return $this->BelongsTo(User::class);
    }

    public function files()
    {
        return $this->morphMany(File::class,'owner');
    }

    public function likes()
    {
        return $this->morphMany(Likes::class,'owner');
    }

    public function video()
    {
        return $this->MorphMany(Video::class,'owner');
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class,'exhibition_user','exhibitions_id','user_id');
    }
}
