@extends('app')

@section('title', $event->title)

@section('content')
    <div class="event-details">
        <a href="/">← Back to Events</a>

        <h1>{{ $event->title }}</h1>
        <p class="description">{{ $event->description ?: 'No description provided.' }}</p>

        <hr>

        <h3>Location</h3>
        <p><strong>Space:</strong> {{ $event->space->name }}</p>
        <p><strong>Address:</strong> {{ $event->space->address }}</p>

        <h3>Date & Time</h3>
        <p><strong>Starts:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y - H:i') }}</p>
        <p><strong>Ends:</strong> {{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y - H:i') }}</p>

        @auth
            <div style="margin-top: 20px;">
                <a href="/events/{{ $event->id }}/edit">Edit Event</a>
            </div>
            <form action="/events/{{ $event->id }}" method="POST">
                @csrf
                @method('DELETE')
                <button style="color: red; cursor: pointer;">
                    Delete Event
                </button>
            </form>
        @endauth
    </div>
@endsection