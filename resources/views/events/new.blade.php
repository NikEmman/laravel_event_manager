@extends('app')

@section('title', 'Create New Event')

@section('content')
    <h2>Create a New Event</h2>

    <form action="/events/create" method="POST">
        @csrf

        <div>
            <label>Event Title</label>
            {{-- old() method, in case of redirect to form due to failed validations, fills in the old (correct) value  --}}
            <input type="text" name="title" value="{{ old('title') }}" required>
            @error('title') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <div>
            <label>Description (Optional)</label>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>

        <div>
            <label>Select Space</label>
            <select name="space_id" required>
                <option value="">-- Choose a Space --</option>
                @foreach($spaces as $space)
                    <option value="{{ $space->id }}">{{ $space->name }}</option>
                @endforeach
            </select>
            @error('space_id') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <div>
            <label>Start Date & Time</label>
            <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" required>
            @error('start_date') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <div>
            <label>End Date & Time</label>
            <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" required>
            @error('end_date') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <button type="submit">Create Event</button>
    </form>
@endsection