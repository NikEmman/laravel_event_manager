@extends('app')

@section('title', 'Create New Event')

@section('content')
    <div class="max-w-2xl mx-auto bg-base-100 rounded-3xl p-8 shadow-sm border border-base-300">
        <div class="mb-8">
            <h1 class="text-3xl font-black">Create a New Event</h1>
            <p class="text-base-content/60">Fill in the details below to host a new gathering.</p>
        </div>

        @include('partials._event_form')
    </div>
@endsection