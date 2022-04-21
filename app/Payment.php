<?php

namespace App;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    use Uuid;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    public function checkout()
    {
        return $this->belongsTo( Checkouts::class,'checkout_id','id');
    }
}
