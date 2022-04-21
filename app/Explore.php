<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Explore extends Model
{
    //
    protected $table = 'user_preferred_category';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Categories::class,'category_id');
    }
}
