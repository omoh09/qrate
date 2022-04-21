<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    protected $guarded = ['id'];
    protected $hidden = ['created_at','updated_at','user_id'];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
