@extends('app')

@section('title','Utils - Natives')

@section('content')
    <div class="jumbotron">
        <ol class="breadcrumb">
            <li><a href="{{ route('homepage') }}">Home</a></li>
            <li class="active">Utils</li>
            <li class="active">Natives</li>
        </ol>
        <div class="faq">
            <p class="lead network"><b>Natives</b></p>
            <div class="table-responsive">
                <table class="table" id="natives-table">
                    <thead>
                    <tr>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Function</th>
                        <th>Hash</th>
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
            $("#natives-table").DataTable({
                responsive: true,
                processing: false,
                serverSide: true,
                pageLength: 50,
                ajax: '{!! route('api.natives') !!}',
                columns: [
                    { data: 'category', name: 'category', className: "dt-center"},
                    { data: 'type', name: 'type', className: "dt-center" },
                    { data: 'name', name: 'name' },
                    { data: 'hash', name: 'hash' },
                ]
            });
        });
    </script>
@endsection