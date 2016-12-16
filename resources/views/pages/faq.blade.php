@extends('app')

@section('title','FAQ')

@section('content')
    <div class="jumbotron">
        <ol class="breadcrumb">
            <li><a href="{{ route('homepage') }}">Home</a></li>
            <li class="active">FAQ</li>
        </ol>
        <div class="faq">
            <p class="lead network"><b>Frequenly Asked Questions</b></p>
            <ul>
                <li>
                    <b>What is <a href="https://gtanet.work">GTA Network</a>?</b>
                    <ul>
                        <li>GTA Network is an standalone multiplayer for GTA V where you can run your custom gamemodes and have fun with other players.</li>
                    </ul>
                </li>
                <li>
                    <b>Why my server is not listed?</b>
                    <ul>
                        <li>The platform runs a cronjob every hour for list automatically, if you server is not listed you just need to wait for the next cronjob.</li>
                    </ul>
                </li>
                <li>
                    <b>I want to contact you, how?</b>
                    <ul>
                        <li>You can send me a private message in <a href="https://forum.gtanet.work/index.php?members/streetgt.81/">GTA Network Forum</a></li>
                    </ul>
                </li>

                <hr>

                <li>
                    <b>Looking for send me a donation?</b>
                    <ul>
                        <li>Currently I support the website from my own pocket, hosted on DigitalOcean $5/month,
                            If you really enjoy the platform and want to contribute and help me running the platform, you can donate <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=tiagocardosoweb%40gmail%2ecom&lc=PT&item_name=GTA%20NETWORK%20%2d%20SERVER%20STATE&item_number=gtanetworkserverstate&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted">here</a>.</li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
@endsection