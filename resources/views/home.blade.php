@extends('app')

@section('title', 'Upcoming Events')

@section('content')
    <h1>All Events</h1>
 @auth <a href="/events/new">Create an event</a> @endauth
    @if($events->isEmpty())
        <p>No events found. 
            
        </p>
    @else
        <div class="events-list">
            @foreach ($events as $event)
                <div >
                    <h3>
                        <a href="/events/{{ $event->id }}">{{ $event->title }}</a>
                    </h3>
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