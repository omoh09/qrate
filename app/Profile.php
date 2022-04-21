<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'artist_profiles';
    protected $guarded = ['id'];
    //
}
