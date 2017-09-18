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
                        <strong>You have been out bid! The current high bid for seat {{$i}} is ${{ number_format(App\Bid::getHighBid($i)) }}. Would
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
                        @endif
                        Once bidding has been closed, the winner will be notified by email.</p>

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

