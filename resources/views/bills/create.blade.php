@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Select an Application to Create Bill</h2>

    <div class="list-group mt-3">
        @foreach ($applications as $application)
            <a href="{{ url('/applications/' . $application->id . '/bills/create') }}" class="list-group-item list-group-item-action">
                {{ $application->title }}
            </a>
        @endforeach
    </div>
</div>
@endsection
