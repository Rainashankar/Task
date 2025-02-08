@extends('layouts.app')

@section('title', 'Books')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2>Book List</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('book.create') }}" class="btn btn-primary">+ Add Book</a>
    </div>
</div>

<!-- Success and Error Messages -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<!-- Table for books -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>Sr No.</th>
            <th>Book Name</th>
            <th>Author</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($books as $key => $book)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $book['name'] ?? '' }}</td>
                <td>{{ getAuthorName($book['author_id']) ?? '' }}</td>
                <td>
                    <form action="{{ route('book.destroy', $book['id']) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
