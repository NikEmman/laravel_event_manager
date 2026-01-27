@extends('app')

@section('content')
    <h1>Edit Event: {{ $event->title }}</h1>

    <form action="/events/{{ $event->id }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="{{ old('title', $event->title) }}" required>
            @error('title') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description">{{ old('description', $event->description) }}</textarea>
            @error('description') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label>Space</label>
            <select name="space_id" required>
                @foreach($spaces as $space)
                    <option value="{{ $space->id }}" {{ (old('space_id', $event->space_id) == $space->id) ? 'selected' : '' }}>
                        {{ $space->name }}
                    </option>
                @endforeach
            </select>
            @error('space_id') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label>Start Date & Time</label>
            <input type="datetime-local" name="start_date"
                value="{{ old('start_date', \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i')) }}" required>
            @error('start_date') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label>End Date & Time</label>
            <input type="datetime-local" name="end_date"
                value="{{ old('end_date', \Carbon\Carbon::parse($event->end_date)->format('Y-m-d\TH:i')) }}" required>
            @error('end_date') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <div style="margin-top: 20px;">
            <button type="submit">Update Event</button>
            <a href="/events/{{ $event->id }}">Cancel</a>
        </div>
    </form>
@endsection