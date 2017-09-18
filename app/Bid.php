<?php

namespace App;

use Moloquent\Eloquent\Model as Model;

class Bid extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bid',
        'bidder',
        'seat',
    ];

    public static function getHighBid($seat = 1)
    {
        $highBid = self::where('seat', $seat)->max('bid');

        return is_null($highBid) ? config('bids.min') : $highBid;
    }

    public static function getHighBidOwner($seat = 1)
    {
        $highBid = self::where('seat', $seat)->orderBy('bid', 'desc')->first();

        return is_null($highBid) ? null : $highBid->bidder;
    }

}
