@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h2>Welcome, {{ Auth::user()->first_name ?? '' }}</h2>
    <p><strong>First Name:</strong> {{ Auth::user()->first_name ?? '' }}</p>
    <p><strong>Last Name:</strong> {{ Auth::user()->last_name ?? '' }}</p>
@endsection
