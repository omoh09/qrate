<?php

namespace App;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model;

class ExhibitionCheckout extends Model
{
    use Uuid;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class,'exhibition_id');
    }

    //function called to attach exhibition to user when paid
    /**
     * @return mixed
     */
    public function isPaidFor()
    {
        return $this->user->exhibitionsAttended()->attach($this->exhibition_id);
    }
}
