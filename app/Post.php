<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Post extends Model
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

    public function categories()
    {
        return $this->belongsToMany(Categories::class,'category_post', 'post_id', 'category_id');
    }

    public function scopeUserTimeline($query, $user_id)
    {
        return $query->leftJoin('follow','follow.user_followed_id','=','posts.user_id')->where('follow.user_id',$user_id)->orWhere('posts.user_id',$user_id)->select(DB::raw('posts.*'))->orderBy('posts.created_at','desc');
    }
    //
}
