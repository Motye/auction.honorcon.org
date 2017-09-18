<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon"
          type="image/png"
          href="/favicon.png">
</head>
<body>
<div class="container-fluid" id="main_page">
    <div class="row">
        <div class="col-sm-3 col-lg-2 col-sm-push-9 col-lg-push-10">
            <nav class="navbar navbar-default navbar-fixed-side" id="Site_Navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav nav-pills nav-stacked text-center">
                            <li>
                                <div class="container-fluid visible-lg visible-md">
                                    <a href="http://www.trmn.org/portal/" target="_blank">
                                        <img src="/images/TRMN-anniversary-crest.png" class="img-responsive"
                                             alt="Responsive image">
                                    </a>
                                </div>
                            </li>
                            <br>
                            <li><a href="http://honorcon.org">HonorCon HOME</a></li>
                            @if (Auth::guest())
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            @else
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-expanded="false">
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            <br>
                            <li>
                                <div class="container-fluid visible-lg visible-md">
                                    <a href="http://savinggracek9s.com/index.html" target="_blank">
                                        <img src="/images/charity-logo.png" class="img-responsive"
                                             alt="Responsive image">
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="col-sm-9 col-lg-10 col-sm-pull-3 col-lg-pull-2">
            <div class="container-fluid" id="Header_Banner">
                <div class="col-lg-10 col-md-10">
                        <img src="/images/HC2017-logo-register.png" class="img-responsive" alt="Responsive image">
                </div>
                <div class="col-lg-2 col-md-2 visible-lg visible-lg" id="hotel_logo">
                    <a href="http://www.hilton.com/en/hi/groups/personalized/R/RDUNHHF-HCO-20171026/index.jhtml"
                       target="_blank">
                        <img src="/images/HonorCon_Venue/HHR_masterbrand_logo.png" class="img-responsive"
                             alt="Responsive image">
                    </a>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12" id="main_content">
                <div class="container-fluid">

                    <!--- 					MAIN CONTENT STARTS HERE! 						--->
                @yield('content')
                <!--- 					MAIN CONTENT ENDS HERE! 						--->

                </div>
            </div>
        </div>
    </div>
    <br>
    <footer>
        <div class="container fixed-bottom footer_area fix-bottom">
            <div class="row" id="spnsor_area2">
                <div class="col-sm-4 col-xs-4 visible-sm visible-xs">
                    <a href="#" target="_blank">
                        <img src="/images/TRMN-anniversary-crest.png" class="img-responsive" alt="Responsive image">
                    </a>
                </div>
                <div class="col-sm-4 col-xs-4 visible-sm visible-xs">
                    <a href="#" target="_blank">
                        <img src="/images/HonorCon_Venue/HHR_masterbrand_logo.png" class="img-responsive"
                             alt="Responsive image">
                    </a>
                </div>
                <div class="col-sm-4 col-xs-4 visible-sm visible-xs">
                    <a href="#" target="_blank">
                        <img src="/images/charity-logo.png" class="img-responsive" alt="Responsive image">
                    </a>
                </div>
            </div>
            <span class="text-center"><h1>Our Sponsors</h1></span>
            <div class="row" id="sponsor_area">
                @include('sponsors')
            </div>
        </div>
    </footer>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
