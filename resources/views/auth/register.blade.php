@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 footer_area">
                <div>
                    <div class="panel-heading"><h2 class="text-uppercase text-center">Register</h2></div>
                    <div class="panel-body">

                        @if ($errors->any())
                            <div>
                                <p>Please correct the following errors:</p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <hr>
                            </div>
                        @endif

                        <p>You must register for an account to be able to place a bid or check the status of your
                            bid.</p>

                        <p>
                            By registering to bid in HonorCon’s auction, each bidder agrees to these auction rules:<br/>
                        <ol>
                            <li>All sales are final. There will be no exchanges or refunds unless otherwise noted.
                                HonorCon
                                has attempted to describe this auction correctly, but neither warrants nor represents
                                and in
                                no event shall be responsible for the correctness of descriptions, genuineness,
                                authorship,
                                provenance or condition of the items. No statement made in this Auction, or made orally
                                at
                                the auction or elsewhere, shall be deemed such a warranty, representation, or assumption
                                of
                                liability.
                            </li>
                            <li>The auction item's starting value listed is an estimate of fair market value. Items have
                                not
                                been appraised unless so noted. The amount you pay above this fair market value estimate
                                is
                                normally tax deductible as a charitable contribution. Please consult your tax adviser to
                                clarify amount of deduction.
                            </li>
                            <li>Payment for this Auction must be made in full within 24 hours or the spot will go to the
                                next in line. HonorCon accepts via Paypal sent to finance@honorcon.org.
                            </li>
                            <li>Following payments, you will receive a confirmation email from Paypal. Please forward
                                that
                                confirmation to conchair2@gmail.com as verification to hold your spot at the gaming
                                table.
                                You must show your paid receipt for entrance to the game.
                            </li>
                            <li>Each person bidding assumes all risks and hazards related to the auction and items
                                obtained
                                at the auction. Each bidder agrees to hold harmless from any liability arising
                                indirectly
                                from HonorCon, their elected and appointed officials, members and employees, the
                                auctioneer(s), the auction company and its agents and employees, the event organizers,
                                sponsors, and/or volunteers connected with the auction
                            </li>
                        </ol>
                        </p>

                        <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ticket" class="col-md-4 control-label">Eventbrite Order #</label>

                                <div class="col-md-6">
                                    <input id="ticket" type="text" class="form-control" name="ticket" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
