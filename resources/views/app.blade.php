<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GTA Network server monitoring, stats, banner and live signatures!">
    <meta name="keywords" content="gtanetwork, game state, server info, multiplayer, server, information">
    <meta property="og:site_name" content="GTA Network Server State">
    <meta property="og:image" content="{{ asset('logo.og.png') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title')">
    <meta property="og:url" content="{{ Request::url() }}">
    <link rel="canonical" href="{{ Request::url() }}">
    <link rel="apple-touch-icon" href="{{ asset('logo.og.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <title>GTA Network Server State - @yield('title')</title>

    <!-- Application CSS -->
    @if(env('APP_ENV') == 'local')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @else
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet">
    @endif

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="container">

    @include('partials._header')

    @yield('content')

    @include('partials._footer')

    <div id="donateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Hello friend, welcome back!</h4>
                </div>
                <div class="modal-body">
                    <img class="img-responsive center-block" src="{{ asset('images/tip-jar.png') }}" alt="Tip Jar"><br>

                    <p>If you don't know or if you haven't read <a href="{{ route('faq') }}">the FAQ</a> yet, currently I support the website from my own pocket, hosted on Amazon AWS services for $5/month.<p>
                    If you really enjoy the platform and want to contribute helping me running the platform, you can donate <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=tiagocardosoweb%40gmail%2ecom&lc=PT&item_name=GTA%20NETWORK%20%2d%20SERVER%20STATE&item_number=gtanetworkserverstate&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted">here</a>.</p>
                    <p>Greetings, <br><i>StreetGT</i></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-color-network" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<!-- Javascript! -->
@if(env('APP_ENV') == 'local')
<script src="{{ asset('js/app.js') }}"></script>
@else
<script src="{{ asset('js/app.min.js') }}"></script>
@endif
@yield('javascript')
</body>
</html>
