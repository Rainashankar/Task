@extends('layouts.app')

@section('title', 'Author')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2>Author List</h2>
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
            <th>First Name</th>
            <th>Last Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($authors as $key => $author)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $author['first_name'] }}</td>
                <td>{{ $author['last_name'] }}</td>
                <td>
                    @if(App\Models\Book::where('author_id', $author['id'])->exists())
                    <a href="{{ route('view_books', ['author_id' => $author['id']]) }}" class="btn btn-primary btn-sm">View Books</a>
                    @endif
                    <form action="{{ route('author.destroy', $author['id']) }}" method="POST" class="d-inline">
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
