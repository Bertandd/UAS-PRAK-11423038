@extends('layouts.my_layout')
@section('title', 'Page Not Found')
@section('content')
{{-- min height 70vh, gravity center vertical horizontal --}}
<div class="d-flex justify-content-center align-items-center" style="min-height: 75vh;">
    <div class="text-center">
        <h1 class="display-1 text-danger">404</h1>
        <h2>Page Not Found</h2>
        <p>Sorry, the page you are looking for could not be found.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
    </div>
</div>
@endsection
@section('script')
@endsection
