@extends('app')

@section('title','Map Converter')

@section('content')
    <div class="jumbotron">
        <ol class="breadcrumb">
            <li><a href="{{ route('homepage') }}">Home</a></li>
            <li class="active">Utils</li>
            <li class="active">Map Converter</li>
        </ol>
        <div class="faq">
            <p class="lead network"><b>Map Converter</b></p>
            <div class="code-convertion">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('util.map.post') }}" method="POST">
                    <div class="form-group">
                        <select name="convertion-source" id="convertion-source">
                            <option value="0" selected>Guadmaz Map Editor - XML</option>
                            <option value="1">Menyoo Object Spooner - XML</option>
                            {{--<option value="2">GTA:NETWORK - CS</option>--}}
                            {{--<option value="3">GTA:NETWORK - XML</option>--}}
                        </select>
                        <select name="convertion-output" id="convertion-output">
                            <option value="0" selected>GTA:NETWORK - CS</option>
                            <option value="1">GTA:NETWORK - XML</option>
                        </select>
                        @if(isset($total))
                            <span class="total-converted pull-right">Total: {{ $total }}</span>
                        @endif
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <textarea name="code-area" id="code-area" cols="30" rows="10">{{ isset($code) ? implode("\n",$code) : '' }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-network">Convert!</button>
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
@endsection