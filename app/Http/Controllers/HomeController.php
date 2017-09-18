<?php

namespace App\Http\Controllers;

use App\Bid;
use App\Mail\Outbid;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Illuminate\Support\Facades\Mail;

/**
 * Class HomeController
 * @package App\Http\Controllers
 *
 * @mixin \Eloquent
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['confirm_email', 'index']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome', ['high_bid' => Bid::getHighBid()]);
    }

    public function confirm_email($userid)
    {
        if ($user = User::find($userid)) {
            $user->confirmed = true;
            $user->save();

            Auth::login($user);

            return redirect('/')->with('status', 'Your email address has been confirmed');
        }
    }

    public function placeBid(Request $request)
    {
        $bid = (int)$request->bid;
        $seat = (int)$request->seat;

        if ($bid >= (Bid::getHighBid($seat) + config('bids.increment'))) {
            // Get the current high bidder
            $highBidder = Bid::getHighBidOwner($seat);

            // Instantiate a user so we can let them know they've been outbid
            $highBidder = User::find($highBidder);

            try {
                Bid::create(['bid' => $bid, 'bidder' => Auth::user()->id, 'seat' => $seat]);

                if (!is_null($highBidder)) {
                    Mail::to($highBidder)->send(new Outbid($highBidder, $seat));
                }

                return redirect('/')->with('status', 'Your bid for seat ' . $seat . ' has been placed');

            } catch (Exception $e) {
                return redirect('/')->with('error', 'There was a problem placing your bid.  Please try again.');
            }

        }

        return redirect('/')->with('error', 'Your bid is not high enough');

    }
}
