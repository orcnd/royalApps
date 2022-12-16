@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1>{{$title}}</h1>
        </div>
    </div>
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
    <div class="row">
        <div class="col">
            <form action="{{ $url }}" method="post">
                @csrf
                <button type="submit" class="btn btn-danger w-100">{{__('Delete')}}</button>
            </form>
        </div>
    </div> 
</div>
@endsection
