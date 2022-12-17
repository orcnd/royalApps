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
                <thead>
                @foreach($columns as $columnkey=> $column)
                    <th>{{ $column['text'] }}</th>
                @endforeach
                    @if (isset($rowActions))
                    <th>Actions</th>
                    @endif
                </thead>
                <tbody>
                @foreach($rows as $row)
                    <tr>
                        @foreach($columns as $column =>$ctext)
                            @if ($ctext['type']=='text')
                            <td>{{ $row->$column }}</td>
                            @endif
                            @if ($ctext['type']=='date')
                            <td>{{ date('d/m/Y',strtotime($row->$column)) }}</td>
                            @endif
                            @if ($ctext['type']=='datetime')
                            <td>{{ date('d/m/Y H:i:s',strtotime($row->$column)) }}</td>
                            @endif
                        @endforeach
                        @if(isset($rowActions)) 
                            <td>
                            @foreach ($rowActions as $action => $text)
                                <a href="{{ route($action, $row->id) }}" class="btn btn-primary btn-xs">{{ $text }}</a>
                            @endforeach
                            </td>
                            
                        @endif
                        
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
