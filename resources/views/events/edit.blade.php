@extends('app')

@section('title', 'Edit Event: ' . $event->title)

@section('content')
    <div class="max-w-2xl mx-auto bg-base-100 rounded-3xl p-8 shadow-sm border border-base-300">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-2 text-warning mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span class="text-xs font-bold uppercase tracking-widest">Editing Mode</span>
            </div>
            <h1 class="text-3xl font-black">Edit Event</h1>
            <p class="text-base-content/60 italic">Updating: {{ $event->title }}</p>
        </div>

        {{-- Event Form Partial --}}
        @include('partials._event_form')
    </div>
@endsection