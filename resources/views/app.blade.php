<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GTA Network server monitoring, stats, banner and live signatures!">
    <meta name="keywords" content="gtanetwork, game state, server info, multiplayer, server, information">
    <meta property="og:site_name" content="GTA Network Server State">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title')">
    <meta property="og:image" content="{{ asset('images/logo.png') }}" />
    <meta property="og:url" content="{{ Request::url() }}">
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

</div>

<!-- Javascript! -->
@if(env('APP_ENV') == 'local')
<script src="{{ asset('js/app.js') }}"></script>
@else
<script src="{{ asset('js/app.min.js') }}"></script>
@endif
@yield('javascript')
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-45569214-4', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>
