@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <form action="{{route('newBookStore')}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="titleinput" class="form-label">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control" id="titleinput" required>
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="releasedateInput" class="form-label">Release Date</label>
                    <input type="date" name="release_date" value="{{ old('email') }}" class="form-control" id="releasedateInput" required>
                    @error('release_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descriptionInput" class="form-label">Description</label>
                    <textarea  class="form-control" name="description" id="descriptionInput" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="isbninput" class="form-label">isbn</label>
                    <input type="text" name="isbn" value="{{ old('isbn') }}" class="form-control" id="isbninput" required>
                    @error('isbn')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="number_of_pagesinput" class="form-label">number of pages</label>
                    <input type="number" min="0" name="number_of_pages" value="{{ old('number_of_pages') }}" class="form-control" id="number_of_pagesinput" required>
                    @error('number_of_pages')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="authorinput" class="form-label">Author</label>
                    <select class="form-select" name="author_id" aria-label="Default select example" required>
                        <option selected value="">Select Author</option>
                        @foreach ($authors as $author)
                        <option value="{{$author->id}}">{{$author->first_name}} {{$author->last_name}}</option>
                        @endforeach
                    </select>
                    @error('author_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
