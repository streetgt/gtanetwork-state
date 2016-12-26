@extends('app')

@section('title','Servers')

@section('content')
    <div class="jumbotron">
        <ol class="breadcrumb">
            <li><a href="{{ route('homepage') }}">Home</a></li>
            <li class="active">Servers</li>
            <li class="active">{{ $type == 'verified' ? 'Verified' : 'Internet'}}</li>
        </ol>
        <div class="faq">
            <p class="lead network"><b>Servers - {{ $type == 'verified' ? 'Verified' : 'Internet'}}</b></p>
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
                        @if($type == 'verified')
                            <th>Website</th>
                        @endif
                        <th>Join</th>
                    </tr>
                    </thead>
                </table>
                @if($type == 'verified')
                    <small class="pull-left" style="padding-top: 20px;">Looking to verify your server? Take a look at <a href="{{route('faq')}}">FAQ</a>.</small>
                @endif
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
                lengthMenu: [[10, 20, 50, 100], [10, 20, 50, 100]],
                pageLength: 20,
                @if($type == "verified")
                ajax: '{!! route('api.servers.verified') !!}',
                @else
                ajax: '{!! route('api.servers.internet') !!}',
                @endif
                order: [[ 3, "desc" ]],
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
                            return '<a href="{!! Request::root() !!}/servers/search/' + row.ip + '">' + escapeHtml(limitStr(row.servername,50)) + '</a>';
                        }
                    },
                    { data: 'currentplayers', name: 'currentplayers', className: "dt-center"},
                    { data: 'maxplayers', name: 'maxplayers', className: "dt-center" },
                    { data: 'ip', name: 'ip' },
                    @if($type == 'verified')
                    { data: 'website', orderable: false, className: "dt-center",
                        render: function (data, type, row) {
                            return '<a href="'+ row.website +'"><i class="fa fa-globe" aria-hidden="true"></i></a>';
                        }
                    },
                    @endif
                    { data: 'ip', orderable: false, className: "dt-center",
                        render: function (ip) {
                            return '<a href="gtan://'+ip+'"><i class="fa fa-sign-in" aria-hidden="true"></i></a>';
                        }
                    },
                ]
            });
        });

        function escapeHtml(text) {
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        function limitStr(string,length)
        {
            var trimmedString = string.length > length ?
            string.substring(0, length) + "..." :
                    string;

            return trimmedString;
        }
    </script>
@endsection