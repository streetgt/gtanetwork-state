<div class="header clearfix">
    <div class="header-content text-center">
        <h1 class="text-muted">
            GTA <span>NETWORK</span> <i class="fa fa-globe"></i>
        </h1>
        <span class="label label-danger">BETA</span>
    </div>
    <ul class="nav nav-pills pull-right">
        <li role="presentation" class="{{ isActiveRoute('homepage') }}"><a href="{{ route('homepage') }}">Home</a></li>
        <li role="presentation" class="{{ isActiveRoute('servers') }}"><a href="{{ route('servers') }}">Servers</a></li>
        <li role="presentation" class="{{ isActiveRoute('stats') }}"><a href="{{ route('stats') }}">Stats</a></li>
        <li role="presentation" class="{{ isActiveRoute('map.get') || isActiveRoute('map.post') }}"><a href="{{ route('map.get') }}">Map Converter</a></li>
        <li role="presentation" class="{{ isActiveRoute('faq') }}"><a href="{{ route('faq') }}">FAQ</a></li>
    </ul>
</div>
