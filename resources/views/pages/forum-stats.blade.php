@extends('app')

@section('content')
    <ol class="breadcrumb">
        <li><a href="{{ route('homepage') }}">Home</a></li>
        <li>Utils</li>
        <li class="active">Forum Stats</li>
    </ol>
    <div class="jumbotron">
        <p class="lead network"><b>Forum Stats - October</b></p>
        <hr>
        <div class="chart">
            <canvas id="forum_stats_chart" width="400" height="200"></canvas>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.js"></script>
    <script>
        var ctx = document.getElementById("forum_stats_chart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    "Sat Oct 01 2016",
                    "Sun Oct 02 2016",
                    "Mon Oct 03 2016",
                    "Tue Oct 04 2016",
                    "Wed Oct 05 2016",
                    "Thu Oct 06 2016",
                    "Fri Oct 07 2016",
                    "Sat Oct 08 2016",
                    "Sun Oct 09 2016",
                    "Mon Oct 10 2016",
                    "Tue Oct 11 2016",
                    "Wed Oct 12 2016",
                    "Thu Oct 13 2016",
                    "Fri Oct 14 2016",
                    "Sat Oct 15 2016",
                    "Sun Oct 16 2016",
                    "Mon Oct 17 2016",
                    "Tue Oct 18 2016",
                    "Wed Oct 19 2016",
                    "Thu Oct 20 2016",
                    "Fri Oct 21 2016",
                    "Sat Oct 22 2016",
                    "Sun Oct 23 2016",
                    "Mon Oct 24 2016",
                    "Tue Oct 25 2016",
                    "Wed Oct 26 2016",
                    "Thu Oct 27 2016",
                    "Fri Oct 28 2016",
                    "Sat Oct 29 2016",
                    "Sun Oct 30 2016",
                    "Mon Oct 31 2016",
                    "Tue Nov 01 2016"
                ],
                datasets: [{
                    label: 'Users',
                    data: [
                        288,
                        302,
                        321,
                        331,
                        335,
                        363,
                        374,
                        418,
                        488,
                        454,
                        459,
                        466,
                        471,
                        479,
                        484,
                        492,
                        500,
                        504,
                        510,
                        517,
                        522,
                        522,
                        525,
                        529,
                        533,
                        537,
                        542,
                        548,
                        554,
                        557,
                        560,
                        566
                    ],
                    backgroundColor: "rgba(0,0,0,0)",
                    borderColor: "#6f99bb",
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Forum Users - October'
                },
                scales: {
                    yAxes: [{
                        display: true,
                    }]
                }
            }
        });
    </script>

@endsection