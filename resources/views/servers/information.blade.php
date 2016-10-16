@extends('app')

@section('content')
    <div class="jumbotron">
        <ol class="breadcrumb">
            <li><a href="{{ route('homepage') }}">Home</a></li>
            <li class="active">{{ $server->servername }}</li>
        </ol>
        <!-- Nav tabs -->
        <ul id="myTabs" class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#information" aria-controls="information" role="tab" data-toggle="tab"><i class="fa fa-info-circle" aria-hidden="true"></i> Server Information</a></li>
            <li role="presentation"><a href="#banners" aria-controls="banners" role="tab" data-toggle="tab"><i class="fa fa-picture-o" aria-hidden="true"></i> Banners</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="information">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="logo pull-right">
                            <img class="img-thumbnail" src="{{ asset('images/logo.png') }}" alt="GTA Network">
                        </div>
                        <h3>Server Information</h3>
                        <b>Name</b>: {{ $server->servername }}<br>
                        <b>IP</b>: <a src="gtan://{{ $server->ip }}">{{ $server->ip }} <i class="fa fa-sign-in" aria-hidden="true"></i></a><br>
                        <b>Gamemode</b>: {{ $server->gamemode }}<br>
                        <b>Location</b>: {{ $server->country }}

                        <h3>Players Information</h3>
                        <b>Players Online</b>: {{ $playersOnline->currentplayers }}<br>
                        <b>Max Players</b>: {{ $playersOnline->maxplayers }}<br>
                        <b>Highest Peak</b>: {{ $statistics->highest_peak }}
                        @if($statistics->highest_peak >= $playersOnline->maxplayers)
                            <i class="fa fa-trophy network" aria-hidden="true"></i>
                        @endif
                        <br>

                        <hr>
                        <p>
                            <canvas id="myChart" width="400" height="100"></canvas>
                        </p>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="banners">
                <div class="panel panel-default">
                    <div class="panel-body text-center">
                        <div class="banner">
                            <img src="{{ route('server.banner',$server->ip) }}" alt="">
                            <textarea class="code" rows="3" cols="50" readonly>[url={{ route('server.information',$server->ip) }}][img]{{ route('server.banner',$server->ip) }}[/img][/url]</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.js"></script>
    <script>
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?php for($i = 0; $i < 24; $i++) if($i < 23) echo '"'.$i.':00h"' .','; else echo '"'.$i.':00h"';  ?>],
                datasets: [{
                    label: 'Players online',
                    data: {{ $statistics->daily_stats }},
                    backgroundColor: "#6f99bb",
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Players Online in the last 24 hours.'
                },
                scales: {
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true,
                            maxTicksLimit: {{ $playersOnline->maxplayers }}
                        }
                    }]
                }
            }
        });
        {{--var data = {--}}
        {{--labels: ,--}}
        {{--datasets: [--}}
        {{--{--}}
        {{--label: "My First dataset",--}}
        {{--fill: false,--}}
        {{--lineTension: 0.1,--}}
        {{--backgroundColor: "rgba(75,192,192,0.4)",--}}
        {{--borderColor: "rgba(75,192,192,1)",--}}
        {{--borderCapStyle: 'butt',--}}
        {{--borderDash: [],--}}
        {{--borderDashOffset: 0.0,--}}
        {{--borderJoinStyle: 'miter',--}}
        {{--pointBorderColor: "rgba(75,192,192,1)",--}}
        {{--pointBackgroundColor: "#fff",--}}
        {{--pointBorderWidth: 1,--}}
        {{--pointHoverRadius: 5,--}}
        {{--pointHoverBackgroundColor: "rgba(75,192,192,1)",--}}
        {{--pointHoverBorderColor: "rgba(220,220,220,1)",--}}
        {{--pointHoverBorderWidth: 2,--}}
        {{--pointRadius: 1,--}}
        {{--pointHitRadius: 10,--}}
        {{--data: "{{ $statistics->daily_stats }}",--}}
        {{--spanGaps: false,--}}
        {{--}--}}
        {{--]--}}
        {{--};--}}
    </script>

@endsection