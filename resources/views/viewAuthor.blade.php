@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Author: {{ $author->first_name }} {{ $author->last_name }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h2>{{__('Biography')}}</h2>
            <p>{{ $author->biography }}</p>
        </div>
        @if (count($author->books)>0)
        <div class="col">
            <h2>{{__('Books')}}</h2>
            
                @foreach ($author->books as $book)

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">{{$book->title}}</div>
                        <div class="card-subtitle mb-2 text-muted">{{$book->isbn}}</div>
                        <p class="card-text">
                            {{$book->description}}
                        </p>
                        <a href="{{route('viewBook',$book->id)}}" class="btn btn-primary">{{__('View')}}</a>
                        <a href="{{route('deleteBook',$book->id)}}" class="btn btn-danger">{{__('Delete')}}</a>
                    </div>
                </div>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    @if (count($author->books)==0)
    <div class="row">
        <div class="col"><a href="{{route('deleteAuthor',$author->id)}}" class="btn btn-danger">Delete Author</a></div>
    </div>
    @endif 
</div>
@endsection
