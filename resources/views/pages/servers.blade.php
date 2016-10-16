@extends('app')

@section('content')
    <div class="jumbotron">
        <div class="faq">
            <p class="lead network"><b>Servers</b></p>
            <table class="table table-bordered" id="players-table">
                <thead>
                <tr>
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
@endsection

@section('javascript')
    <script>
        $(function() {
            $("#players-table").DataTable({
                processing: false,
                serverSide: true,
                ajax: '{!! route('api.servers') !!}',
                columns: [
                    { data: 'country', name: 'country' },
                    { data: 'servername', name: 'servername' },
                    { data: 'currentplayers', name: 'currentplayers' },
                    { data: 'maxplayers', name: 'maxplayers' },
                    { data: 'ip', name: 'ip',
                        render: function (ip) {
                            return '<a href="{!! Request::root() !!}/server/search/'+ip+'">' + ip + '</a>';
                        }
                    },
                    { data: 'ip', orderable: false,
                        render: function (ip) {
                            return '<a href="gtan://'+ip+'"><i class="fa fa-sign-in" aria-hidden="true"></i></a>';
                        }
                    },
                ]
            });
        });
    </script>
@endsection