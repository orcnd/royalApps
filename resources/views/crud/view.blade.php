@extends('layouts.app')

@section('content')
<div class="container">
    @if (isset($title))
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>{{ $title }}</h1>
        </div>
    </div>
    @endif
    @if (isset($buttons))
    <div class="row">
        <div class="col">
            
            @foreach ($buttons as $button)
                <a href="{{ $button['url'] }}" class="btn btn-primary">{{ $button['text'] }}</a>
            @endforeach
            
        </div>
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table">
                <tbody>
                @foreach($columns as $column =>$ctext)
                    <tr>
                        <th>{{ $ctext['text'] }}</th>
                        @if ($ctext['type']=='text')
                        <td>{{ $data->$column }}</td>
                        @endif
                        @if ($ctext['type']=='author')
                        <td><a href="{{route('viewAuthor',$data->author_id)}}">{{ $data->$column }}</a></td>
                        @endif
                        @if ($ctext['type']=='date')
                        <td>{{ date('d/m/Y',strtotime($data->$column)) }}</td>
                        @endif
                        @if ($ctext['type']=='datetime')
                        <td>{{ date('d/m/Y H:i:s',strtotime($data->$column)) }}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
