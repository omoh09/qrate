<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Auction extends Model
{
    //
    protected $table = 'auction';
    protected $guarded = ['id'];
    protected $touches = ['artwork'];

    public function artwork()
    {
        return $this->belongsTo(Artworks::class,'artwork_id','id');
    }
    public function scopeArtworkAuctionUpcoming($query)
    {
        return $query->leftJoin('artworks','artworks.id','=','auction.artwork_id')->select(DB::raw('auction.*'))->where("approved",true)->where('bid_start','>',Now())->take(5)->orderBy('bid_start');
    }
    public function scopeArtworkAuctionPast($query)
    {
        return $query->leftJoin('artworks','artworks.id','=','auction.artwork_id')->select(DB::raw('auction.*'))->where("approved",1)->where('bid_end','<=',Now())->take(5)->orderBy('bid_end', 'desc');
    }
    public function scopeArtworkAuctionLive($query, $time)
    {
        return $query->leftJoin('artworks','artworks.id','=','auction.artwork_id')->select(DB::raw('auction.*'))->where('bid_start','>=',$time)->where('bid_start' ,'<=',Now())->where("approved",true)->where('bid_end','>',Now()->toDateTime())->orderBy('bid_start');
    }
}
