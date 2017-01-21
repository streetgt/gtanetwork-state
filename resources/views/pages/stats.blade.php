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
                <li><b>Most Players Online Record</b>: {{ $players['most_players_online_record'] }}</li>
                <hr>
                <li><b>Current Players</b>: {{ $players['today_current'] }}</li>
                <li><b>Servers Online</b>: {{ $players['total_servers'] }}</li>
                <hr>
                <li><b>Max Players Today</b>: {{ $players['today_max'] }}</li>
                <li><b>Avg Players Today</b>: {{ $players['today_avg'] }}</li>
                <li><b>Min Players Today</b>: {{ $players['today_min'] }}</li>
            </ul>
            <div class="chart">
                <canvas id="players_chart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.js"></script>
    <script>
        var lineChartData = {
            labels: [
                @foreach($stats as $day)
                        "{{ \Carbon\Carbon::parse($day->date)->format('D, M j, Y') }}",
                @endforeach
            ],
            datasets: [{
                fill: false,
                label: "Min Players",
                data: [
                    @foreach($stats as $day)
                            "{{ $day->min }}",
                    @endforeach
                ],
                yAxisID: "y-axis-1",
                borderColor: "#fecb00",
            }, {
                fill: false,
                label: "Avg Players",
                data: [
                    @foreach($stats as $day)
                            "{{ round(array_sum(json_decode($day->avg)) / 4) }}",
                    @endforeach
                ],
                yAxisID: "y-axis-2",
            }, {
                fill: false,
                label: "Max Players",
                data: [
                    @foreach($stats as $day)
                            "{{ $day->max }}",
                    @endforeach
                ],
                yAxisID: "y-axis-3",
                borderColor: "#6f99bb",
            }]
        };

        window.onload = function () {
            var ctx = document.getElementById("players_chart").getContext("2d");
            window.myLine = Chart.Line(ctx, {
                data: lineChartData,
                options: {
                    responsive: true,
                    hoverMode: 'index',
                    stacked: false,
                    title: {
                        display: true,
                        text: 'Players Stats Online'
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            gridLines: {
                                offsetGridLines: false
                            }
                        }],
                        yAxes: [{
                            type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                            id: "y-axis-1",
                            display: true,
                            ticks: {
                                max: {{ ($players['max']) }},
                                min: {{ $players['min'] }},
                            }
                        }, {
                            type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                            display: false,
                            id: "y-axis-2",

                        }, {
                            type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                            display: false,
                            id: "y-axis-3",

                        }],
                    }
                }
            });
        };
    </script>

@endsection
