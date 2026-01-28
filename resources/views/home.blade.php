@extends('app')

@section('title', 'Upcoming Events')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
        <div>
            <h1 class="text-4xl font-black tracking-tight">Upcoming Events</h1>
            <p class="text-base-content/60">Discover what's happening in your community.</p>
        </div>

        @auth
            <a href="/events/new" class="btn btn-primary shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Create Event
            </a>
        @endauth
    </div>

    @if($events->isEmpty())
        <div class="hero bg-base-100 rounded-3xl p-12 shadow-sm border border-base-300">
            <div class="hero-content text-center">
                <div class="max-w-md">
                    <h2 class="text-2xl font-bold opacity-50">No events found</h2>
                    <p class="py-4 opacity-40">It looks like the calendar is clear for now. Check back later or create the first
                        event yourself!</p>
                </div>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($events as $event)
                @include('partials._event_card', ['event' => $event])
            @endforeach
        </div>
    @endif
@endsection