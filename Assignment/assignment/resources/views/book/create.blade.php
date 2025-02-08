@extends('layouts.app')

@section('title', 'Create Book')

@section('content')
<div class="card">
    <div class="card-body">
        <h2>Create Book</h2>

        <form action="{{ route('book.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Book Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" />
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>            
            <div class="mb-3">
                <label for="author_id" class="form-label">Author</label>
                <select name="author_id" id="author_id" class="form-control">
                    <option value="">Select Author</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author['id'] }}">{{ $author['first_name'] }} {{ $author['last_name'] }}</option>
                    @endforeach
                </select>
                @error('author_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="{{ route('book.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
