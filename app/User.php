<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Moloquent\Eloquent\Model as Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * App\User
 *
 * @property-read mixed
 *                    $id
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[]
 *                $notifications
 * @mixin \Eloquent
 */
class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'confirmed',
        'order_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function hasHighBid($seat = 1)
    {
        $myBid = null;

        if ($this->numberOfBids() > 0) {
            $myBid = Bid::where('bidder', $this->id)->where('seat', $seat)->max('bid');
        }

        return $myBid == Bid::getHighBid($seat) ? true : false;
    }

    public function numberOfBids($seat = 1)
    {
        return count(Bid::where('bidder', $this->id)->where('seat', $seat)->get());
    }

    public function wasLastBidder($seat = 1)
    {
        try {
            $lastBid = Bid::where('seat', $seat)->orderBy('bid')->skip(1)->take(1)->firstOrFail();

            return $lastBid->bidder == $this->id;
        } catch (\Exception $e) {
            return false;
        }

    }
}
