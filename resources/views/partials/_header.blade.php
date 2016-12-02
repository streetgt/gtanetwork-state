<div class="header clearfix">
    <div class="header-content text-center">
        <h1 class="text-muted">
            <a href="{{ route('homepage') }}">GTA <span>NETWORK</span> <i class="fa fa-globe"></i></a>
        </h1>
        <span class="label label-danger">BETA</span>
    </div>
    <ul class="nav nav-pills pull-right">
        <li role="presentation" class="{{ isActiveRoute('homepage') }}"><a href="{{ route('homepage') }}">Home</a></li>
        <li role="presentation" class="{{ isActiveRoute('servers') }}"><a href="{{ route('servers') }}">Servers</a></li>
        <li role="presentation" class="{{ isActiveRoute('stats') }}"><a href="{{ route('stats') }}">Stats</a></li>
        {{--<li role="presentation" class="{{ areActiveRoutes(['map.get','map.post']) }}"><a href="{{ route('map.get') }}">Map Converter</a></li>--}}
        <li class="dropdown {{ areActiveRoutes(['util.map.get','util.map.post']) }}"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Utils<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li class="{{ isActiveRoute('util.natives') }}"><a href="{{ route('util.natives') }}">Natives</a></li>
                <li class="{{ areActiveRoutes(['util.map.get','util.map.post']) }}"><a href="{{ route('util.map.get') }}">Map Converter</a></li>
                <li class="{{ areActiveRoutes(['util.forum.stats','util.forum.stats']) }}"><a href="{{ route('util.forum.stats') }}">Forum Stats</a></li>
            </ul>
        </li>
        <li role="presentation" class="{{ isActiveRoute('faq') }}"><a href="{{ route('faq') }}">FAQ</a></li>
    </ul>
</div>
