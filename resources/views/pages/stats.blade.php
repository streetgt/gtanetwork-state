@extends('app')

@section('title','Stats')

@section('content')
    <div class="jumbotron">
        <ol class="breadcrumb">
            <li><a href="{{ route('homepage') }}">Home</a></li>
            <li class="active">Stats</li>
        </ol>
        <div class="faq">
            <p class="lead network"><b>Current Stats</b></p>
            <ul>
                <li><b>Most Players Online Record</b>: {{ $players['most_players_online_record'][0] }} - <i><small>{{ $players['most_players_online_record'][1]->diffForHumans() }}</small></i></li>
                <hr>
                <li><b>Current Players</b>: {{ $players['today_current'] }}</li>
                <li><b>Servers Online</b>: {{ $players['total_servers'] }}</li>
                <hr>
                <li><b>Max Players Today</b>: {{ $players['today_max'] }}</li>
                <li><b>Avg Players Today</b>: {{ $players['today_avg'] }}</li>
                <li><b>Min Players Today</b>: {{ $players['today_min'] }}</li>
            </ul>
            <div class="chart">
                <div id="chartContainer" style="height: 200px"></div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.min.js"></script>
    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer",
            {
                    zoomEnabled: true,
                    title: {
                        text: "Player Stats Online"
                    },
                    axisY: {
                        includeZero: false
                    },
                    toolTip: {
                        shared: "true"
                    },
                    data: [
                        {
                            xValueFormatString: "DDD, MMM D YYYY",
                            type: "line",
                            color: "#6f99bb",
                            name: "Max players",
                            dataPoints: [
                                @foreach($stats as $day)
                                    {x: new Date("{{ \Carbon\Carbon::parse($day->date)->toW3cString() }}"), y: {{ $day->max }} },
                                @endforeach
                            ]
                        },
                        {
                            xValueFormatString: "DDD, MMM D YYYY",
                            type: "line",
                            color: "grey",
                            name: "Avg players",
                            dataPoints: [
                                    @foreach($stats as $day)
                                {x: new Date("{{ \Carbon\Carbon::parse($day->date)->toW3cString() }}"), y: {{ round(array_sum(json_decode($day->avg)) / 4) }} },
                                @endforeach
                            ]
                        },
                        {
                            xValueFormatString: "DDD, MMM D YYYY",
                            type: "line",
                            color: "#fecb00",
                            name: "Min players",
                            dataPoints: [
                                @foreach($stats as $day)
                                    {x: new Date("{{ \Carbon\Carbon::parse($day->date)->toW3cString() }}"), y: {{ $day->min }} },
                                @endforeach
                            ]
                        }]
                });
            chart.render();
        }
    </script>

@endsection
