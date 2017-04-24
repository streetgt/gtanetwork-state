@extends('app')

@section('title','FAQ')

@section('content')
    <div class="jumbotron">
        <ol class="breadcrumb">
            <li><a href="{{ route('homepage') }}">Home</a></li>
            <li class="active">FAQ</li>
        </ol>
        <div class="faq">
            <p class="lead network"><b>Frequently Asked Questions</b></p>
            <ul>
                <li>
                    <b>What is <a href="https://gtanet.work">GTA Network</a>?</b>
                    <ul>
                        <li>GTA Network is a standalone multiplayer for GTA V where you can run your own custom gamemodes and have fun with other players.</li>
                    </ul>
                </li>
                <li>
                    <b>Why is my server not listed?</b>
                    <ul>
                        <li>The platform runs a cronjob every hour for the list automatically, if you server is not listed please wait for the next cronjob.</li>
                    </ul>
                </li>
                <li>
                    <b>How can I contact you?</b>
                    <ul>
                        <li>You can send me a private message on <a href="https://forum.gtanet.work/index.php?members/streetgt.81/">GTA Network Forum</a></li>
                    </ul>
                </li>

                <hr>

                <li>
                    <b>Looking to send me a donation?</b>
                    <ul>
                        <li>Currently I support the website from my own pocket, hosted on Amazon AWS services for $5/month, If you really enjoy the platform and want to contribute and help me run the platform, you can donate <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=tiagocardosoweb%40gmail%2ecom&lc=PT&item_name=GTA%20NETWORK%20%2d%20SERVER%20STATE&item_number=gtanetworkserverstate&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted">here</a>.</li>
                        <li>
                            Donation Goals
                            <ul>
                                <li>Keep the platform online.</li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
@endsection