@extends('layouts.app')

@section('content')
    <div>
        <br/>
        @if (session('status'))
            <div class="alert alert-success alert-dismissable" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissable" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                {{ session('error') }}
            </div>
        @endif

        @if(Auth::check() && (time() >= strtotime(config('bids.open')) || config('bids.skip_date_check') === true) && Auth::user()->confirmed === true)
            @for ($i = 1; $i < 7; $i++)
                @if(Auth::user()->hasHighBid($i))
                    <div class="alert alert-success alert-dismissable" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <strong>Congratulations! You currently have the high bid for seat {{$i}}!</strong>
                    </div>
                @elseif(App\Bid::getHighBid($i) > 0 && Auth::user()->wasLastBidder($i))
                    <div class="alert alert-danger alert-dismissable" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                        </button>
                        <strong>You have been out bid! The current high bid for seat {{$i}} is
                            ${{ number_format(App\Bid::getHighBid($i)) }}. Would
                            you
                            like to <a href="#bid-form">bid again</a>?</strong>
                    </div>

                @endif
            @endfor
        @endif
    </div>
    <div class="footer_area panel-primary pad">
        <p>Join Larry Correia, author of the Monster Hunter International series, as he GMs a special one night role
            playing game session for the upcoming Savage Worlds Monster Hunter game. Welcome MHI graduating newbie class
            of 2017. Evil looms. Cowboy up. Kill it. Get paid. Open for up to six players. Game session should last
            about four or five hours. You do not need to know Savage Worlds rules and can learn them as we go.</p>

        <p>You will be able to bid on one of the six seats that are available. All proceeds from the auction will
            benefit Saving Grace K9s.</p>

        <h4>To see the most current bids, you can <a href="/">refresh</a> this page.</h4>
        <h2>Bidding will close in <span id="countdown"></span></h2>

    </div>
    <br/>
    @if(Auth::check())

        <div class="panel panel-primary" id="bid-form">
            <div class="panel-heading">
                <h3 class="panel-title">
                    @if(time() > strtotime(config('bids.close')))
                        Bidding has closed
                    @else
                        How to Bid</h3>
                @endif
            </div>
            <div class="panel-body bids">
                @if(time() > strtotime(config('bids.close')))
                    <p>We're sorry, but bidding has closed.</p>
                @else
                    <p>Only whole dollar bids will be accepted. @if(Auth::user()->confirmed === false)You must confirm
                        your email address to bid.
                        @endif</p>
                    <p>
                        By bidding in HonorCon’s auction, each bidder agrees to these auction rules:<br/>
                    <ol>
                        <li>All sales are final. There will be no exchanges or refunds unless otherwise noted. HonorCon
                            has attempted to describe this auction correctly, but neither warrants nor represents and in
                            no event shall be responsible for the correctness of descriptions, genuineness, authorship,
                            provenance or condition of the items. No statement made in this Auction, or made orally at
                            the auction or elsewhere, shall be deemed such a warranty, representation, or assumption of
                            liability.
                        </li>
                        <li>The auction item's starting value listed is an estimate of fair market value. Items have not
                            been appraised unless so noted. The amount you pay above this fair market value estimate is
                            normally tax deductible as a charitable contribution. Please consult your tax adviser to
                            clarify amount of deduction.
                        </li>
                        <li>Payment for this Auction must be made in full within 24 hours or the spot will go to the
                            next in line. HonorCon accepts via Paypal sent to finance@honorcon.org.
                        </li>
                        <li>Following payments, you will receive a confirmation email from Paypal. Please forward that
                            confirmation to conchair2@gmail.com as verification to hold your spot at the gaming table.
                            You must show your paid receipt for entrance to the game.
                        </li>
                        <li>Each person bidding assumes all risks and hazards related to the auction and items obtained
                            at the auction. Each bidder agrees to hold harmless from any liability arising indirectly
                            from HonorCon, their elected and appointed officials, members and employees, the
                            auctioneer(s), the auction company and its agents and employees, the event organizers,
                            sponsors, and/or volunteers connected with the auction
                        </li>
                    </ol>
                    </p>

                    {{--Only show bid form if it's past the opening date or skip_date_check is true AND the user has confirmed their email address--}}
                    @if((time() >= strtotime(config('bids.open')) || config('bids.skip_date_check') === true) && Auth::user()->confirmed === true)
                        <ul>
                            @for ($i = 1; $i < 7; $i++)
                                <li>The current high bid for seat {{ $i }} is
                                    ${{number_format(App\Bid::getHighBid($i))}}. You must bid at least
                                    ${{number_format(App\Bid::getHighBid($i) + config('bids.increment'))}}


                                    <div class="well well-sm">
                                        {{ Form::open(['route' => 'bid', 'class' => 'form-horizontal']) }}
                                        {{ Form::hidden('seat', $i) }}
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label" for="bid">Enter a bid for seat {{$i}}
                                                of at least
                                                ${{ number_format(App\Bid::getHighBid($i) + config('bids.increment')) }}</label>
                                            <div class="col-sm-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon">$</span>
                                                    {{ Form::text('bid', App\Bid::getHighBid($i) + config('bids.increment'), ['type' => 'number', 'id' => 'bid', 'class' => 'form-control']) }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            {{ Form::submit('Place Bid', ['class' => 'btn btn-success']) }}
                                        </div>

                                        {{ Form::close() }}
                                    </div>
                                </li>
                            @endfor
                        </ul>
                    @endif
                @endif
            </div>

        </div>
    @else
        <div class="panel panel-primary">
            <div class="panel-body bids footer_area">
                <p>You must register for an account or log in to be able to place a bid or check the status of your
                    bids.</p>
            </div>
        </div>
    @endif

    <script>
        CountDownTimer('{{ config('bids.close') }}', 'countdown');

        function CountDownTimer(dt, id) {
            var end = new Date(dt);

            var _second = 1000;
            var _minute = _second * 60;
            var _hour = _minute * 60;
            var _day = _hour * 24;
            var timer;

            function showRemaining() {
                var now = new Date();
                var distance = end - now;
                if (distance < 0) {

                    clearInterval(timer);
                    document.getElementById(id).innerHTML = '';

                    return;
                }
                var days = Math.floor(distance / _day);
                var hours = Math.floor((distance % _day) / _hour);
                var minutes = Math.floor((distance % _hour) / _minute);
                var seconds = Math.floor((distance % _minute) / _second);

                document.getElementById(id).innerHTML = days + ' days ';
                document.getElementById(id).innerHTML += hours + ' hrs ';
                document.getElementById(id).innerHTML += minutes + ' mins ';
                document.getElementById(id).innerHTML += seconds + ' secs';
            }

            timer = setInterval(showRemaining, 1000);
        }

    </script>
@endsection

