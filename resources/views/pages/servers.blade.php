@extends('app')

@section('title','Servers')

@section('content')
    <div class="jumbotron">
        <ol class="breadcrumb">
            <li><a href="{{ route('homepage') }}">Home</a></li>
            <li class="active">Servers</li>
        </ol>
        <div class="faq">
            <p class="lead network"><b>Servers</b></p>
            <div class="table-responsive">
                <table class="table" id="players-table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Country</th>
                        <th>Name</th>
                        <th>Current Players</th>
                        <th>Max Players</th>
                        <th>IP</th>
                        <th>Join</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(function() {
            $("#players-table").DataTable({
                responsive: true,
                processing: false,
                serverSide: true,
                ajax: '{!! route('api.servers') !!}',
                columns: [
                    { data: 'passworded', name: 'passworded', orderable: false, className: "dt-center",
                        render: function (passworded) {
                            return passworded ? '<i class="fa fa-lock" aria-hidden="true"></i></a>' : '';
                        }
                    },
                    { data: 'country', name: 'country', className: "dt-center",
                        render: function (country) {
                            return '<img src="/images/flags/18x12/' + country.toLowerCase() + '.gif">';
                        }
                    },
                    { data: 'servername', name: 'servername',
                        render: function (data, type, row) {
                            return '<a href="{!! Request::root() !!}/server/search/' + row.ip + '">' + row.servername + '</a>';
                        }
                    },
                    { data: 'currentplayers', name: 'currentplayers', className: "dt-center"},
                    { data: 'maxplayers', name: 'maxplayers', className: "dt-center" },
                    { data: 'ip', name: 'ip' },
                    { data: 'ip', orderable: false, className: "dt-center",
                        render: function (ip) {
                            return '<a href="gtan://'+ip+'"><i class="fa fa-sign-in" aria-hidden="true"></i></a>';
                        }
                    },
                ]
            });
        });
    </script>
@endsection