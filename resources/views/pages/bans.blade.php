@extends('app')

@section('title','Bans')

@section('content')
    <div class="jumbotron">
        <ol class="breadcrumb">
            <li><a href="{{ route('homepage') }}">Home</a></li>
            <li class="active">Bans</li>
        </ol>
        <div class="faq">
            <p class="lead network"><b>Bans - Wall of shame</b></p>
            <div class="table-responsive">
                <table class="table" id="players-table">
                    <thead>
                    <tr>
                        <th>Social Club</th>
                        <th>Reason</th>
                        <th>Banned By</th>
                        <th>Expires</th>
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
                lengthMenu: [[10, 20, 50, 100], [10, 20, 50, 100]],
                pageLength: 20,
                ajax: '{!! route('api.bans.datatable') !!}',
                order: [[ 3, "desc" ]],
                columns: [
                    { data: 'social_club', name: 'social_club', className: "dt-center"},
                    { data: 'reason', name: 'reason', className: "dt-center" },
                    { data: 'banned_by', name: 'banned_by', className: "dt-center" },
                    { data: 'expires', name: 'expires', className: "dt-center"  },
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