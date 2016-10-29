@extends('app')

@section('content')
    <div class="jumbotron">
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
                <form action="{{ route('map.post') }}" method="POST">
                    <div class="form-group">
                        <select name="convertion-source" id="convertion-source">
                            <option value="0" selected>Guadmaz Map Editor - XML</option>
                        </select>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            @if(isset($code))
                                <textarea name="code-area" id="code-area" cols="30" rows="10">
                                    @foreach($code as $item)
                                        API.createObject({{ $item['id'] }},new Vector3({{ $item['position'][0] . ',' . $item['position'][1] .',' . $item['position'][2]}}), new Vector3({{ $item['rotation'][0] . ',' . $item['rotation'][1] .',' . $item['rotation'][2]}}));
                                    @endforeach
                                </textarea>
                            @else
                                <textarea name="code-area" id="code-area" cols="30" rows="10"></textarea>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-network">Convert!</button>
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
@endsection