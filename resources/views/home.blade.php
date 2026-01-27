@extends('app')

@section('title', 'Upcoming Events')

@section('content')
    <h1>All Events</h1>

    @if($events->isEmpty())
        <p>No events found. 
            @auth <a href="/events/create">Create one?</a> @endauth
        </p>
    @else
        <div class="events-list">
            @foreach ($events as $event)
                <div >
                    <h3>{{ $event->title }}</h3>
                    <p>{{ $event->description }}</p>
                    <small>
                        Starts: {{ $event->start_date }} | 
                        Ends: {{ $event->end_date }}
                    </small>
                </div>
            @endforeach
        </div>
    @endif

@endsection