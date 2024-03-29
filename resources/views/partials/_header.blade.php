<div class="header clearfix">
    <div class="header-content text-center">
        <h1 class="text-muted">
            <a href="{{ route('homepage') }}">GTA <span>NETWORK</span> <i class="fa fa-globe"></i></a>
        </h1>
        <h4>Unofficial Platform</h4>
        <span class="label label-danger">BETA</span>
    </div>
    <ul class="nav nav-pills pull-right">
        <li role="presentation" class="{{ isActiveRoute('homepage') }}"><a href="{{ route('homepage') }}">Home</a></li>
        <li class="dropdown {{ areActiveRoutes(['servers.verified','servers.internet']) }}"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Servers<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li class="{{ isActiveRoute('servers.verified') }}"><a href="{{ route('servers.verified') }}">Verified</a></li>
                <li class="{{ isActiveRoute('servers.internet') }}"><a href="{{ route('servers.internet') }}">Internet</a></li>
            </ul>
        </li>
        <li role="presentation" class="{{ isActiveRoute('stats') }}"><a href="{{ route('stats') }}">Stats</a></li>
        <li role="presentation" class="{{ isActiveRoute('bans') }}"><a href="{{ route('bans') }}">Bans</a></li>
        <li class="dropdown {{ areActiveRoutes(['util.map.get','util.map.post']) }}"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Utils<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li class="{{ isActiveRoute('util.natives') }}"><a href="{{ route('util.natives') }}">Natives</a></li>
                <li class="{{ areActiveRoutes(['util.map.get','util.map.post']) }}"><a href="{{ route('util.map.get') }}">Map Converter</a></li>
            </ul>
        </li>
        <li role="presentation" class="{{ isActiveRoute('faq') }}"><a href="{{ route('faq') }}">FAQ</a></li>
    </ul>
</div>
