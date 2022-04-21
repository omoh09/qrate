<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static whereId(int|string $key)
 */
class Categories extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $hidden = ['created_at','deleted_at','updated_at'];

    public function artists()
    {
        return $this->belongsToMany(User::class,'artist_work_category','category_id','user_id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class,'category_post', 'category_id', 'post_id');
       // return $this->hasMany(Post::class,'category_id');
    }

    public function artworks()
    {
        return $this->hasMany(Artworks::class,'category_id');
    }

    //
}
