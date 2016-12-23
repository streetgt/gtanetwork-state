@extends('app')

@section('title','Homepage')

@section('content')
<div class="jumbotron text-center">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <p class="lead">Find information about your GTA Network server here!</p>
    <form action="{{ route('server.postSearch') }}" method="POST">
        <div class="form-group">
            <input name="ip" id="ip" class="form-control" type="text" placeholder="127.0.0.1:4499">
        </div>
        <button type="submit" class="btn btn-network">Submit</button>
        {{ csrf_field() }}
    </form>
</div>
@endsection