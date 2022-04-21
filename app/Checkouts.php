<?php

namespace App;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * @method static orderBy(string $string, string $ORDER = null);
 * @method static wherePaid(Boolean $boolean)
 */
class Checkouts extends Model
{
    use Uuid;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    public function payment()
    {
       return $this->hasOne(Payment::class,'checkout_id','id');
    }

    public function cart()
    {
        return $this->belongsToMany(Cart::class,'checkout_cart','checkout_id','cart_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
