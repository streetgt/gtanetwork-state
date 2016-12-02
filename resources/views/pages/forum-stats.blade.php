@extends('app')

@section('title','Forum Stats')

@section('content')
    <div class="jumbotron">
        <ol class="breadcrumb">
            <li><a href="{{ route('homepage') }}">Home</a></li>
            <li class="active">Utils</li>
            <li class="active">Forum Stats</li>
        </ol>
        <p class="lead network"><b>Forum Stats - October</b></p>
        <hr>
        <div class="chart">
            <canvas id="forum_stats_chart_october" width="400" height="200"></canvas>
        </div>
        <hr>
        <p class="lead network"><b>Forum Stats - November</b></p>
        <hr>
        <div class="chart">
            <canvas id="forum_stats_chart_november" width="400" height="200"></canvas>
        </div>

    </div>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.js"></script>
    <script>
        var ctx = document.getElementById("forum_stats_chart_october");
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

        var ctx = document.getElementById("forum_stats_chart_november");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    "Tue Nov 01 2016",
                    "Wed Nov 02 2016",
                    "Thu Nov 03 2016",
                    "Fri Nov 04 2016",
                    "Sat Nov 05 2016",
                    "Sun Nov 06 2016",
                    "Mon Nov 07 2016",
                    "Tue Nov 08 2016",
                    "Wed Nov 09 2016",
                    "Thu Nov 10 2016",
                    "Fri Nov 11 2016",
                    "Sat Nov 12 2016",
                    "Sun Nov 13 2016",
                    "Mon Nov 14 2016",
                    "Tue Nov 15 2016",
                    "Wed Nov 16 2016",
                    "Thu Nov 17 2016",
                    "Fri Nov 18 2016",
                    "Sat Nov 19 2016",
                    "Sun Nov 20 2016",
                    "Mon Nov 21 2016",
                    "Tue Nov 22 2016",
                    "Wed Nov 23 2016",
                    "Thu Nov 24 2016",
                    "Fri Nov 25 2016",
                    "Sat Nov 26 2016",
                    "Sun Nov 27 2016",
                    "Mon Nov 28 2016",
                    "Tue Nov 29 2016",
                    "Wed Nov 30 2016",
                    "Thu Dec 01 2016"
                ],
                datasets: [{
                    label: 'Users',
                    data: [
                        566,
                        572,
                        578,
                        583,
                        587,
                        590,
                        590,
                        594,
                        596,
                        600,
                        603,
                        606,
                        608,
                        614,
                        618,
                        620,
                        621,
                        625,
                        627,
                        631,
                        634,
                        638,
                        643,
                        646,
                        648,
                        651,
                        652,
                        657,
                        658,
                        658,
                        660
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