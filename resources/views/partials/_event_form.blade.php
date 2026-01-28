@php
    // Determine if we are editing or creating
    // isset checks if $event variable exists, thus is we are creating a new event or editing an existing one
    $isEdit = isset($event);
    $action = $isEdit ? "/events/{$event->id}" : "/events/create";
@endphp

<form action="{{ $action }}" method="POST" class="space-y-6">
    @csrf
    @if($isEdit) @method('PUT') @endif

    {{-- Title --}}
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text font-bold">Event Title</span>
        </label>
        <input type="text" name="title" placeholder="e.g. Laravel Workshop"
            class="input input-bordered w-full @error('title') input-error @enderror"
            value="{{ old('title', $event->title ?? '') }}" required />
        @error('title') <label class="label"><span class="label-text-alt text-error font-semibold">{{ $message
        }}</span></label> @enderror
    </div>

    {{-- Space Selection --}}
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text font-bold">Select Space</span>
        </label>
        <select name="space_id" class="select select-bordered w-full @error('space_id') select-error @enderror"
            required>
            <option value="" disabled {{ !old('space_id', $event->space_id ?? '') ? 'selected' : '' }}>-- Choose a
                Location --</option>
            @foreach($spaces as $space)
                <option value="{{ $space->id }}" {{ old('space_id', $event->space_id ?? '') == $space->id ? 'selected' : ''
                                        }}>
                    {{ $space->name }}
                </option>
            @endforeach
        </select>
        @error('space_id') <label class="label"><span class="label-text-alt text-error font-semibold">{{ $message
        }}</span></label> @enderror
    </div>

    {{-- Dates Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="form-control">
            <label class="label">
                <span class="label-text font-bold">Start Date & Time</span>
            </label>
            <input type="datetime-local" name="start_date"
                class="input input-bordered w-full @error('start_date') input-error @enderror"
                value="{{ old('start_date', $isEdit ? \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i') : '') }}"
                required />
            @error('start_date') <label class="label"><span class="label-text-alt text-error font-semibold">{{ $message
            }}</span></label> @enderror
        </div>

        <div class="form-control">
            <label class="label">
                <span class="label-text font-bold">End Date & Time</span>
            </label>
            <input type="datetime-local" name="end_date"
                class="input input-bordered w-full @error('end_date') input-error @enderror"
                value="{{ old('end_date', $isEdit ? \Carbon\Carbon::parse($event->end_date)->format('Y-m-d\TH:i') : '') }}"
                required />
            @error('end_date') <label class="label"><span class="label-text-alt text-error font-semibold">{{ $message
            }}</span></label> @enderror
        </div>
    </div>

    {{-- Description --}}
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text font-bold">Description (Optional)</span>
        </label>
        <textarea name="description" placeholder="Tell people what this event is about..."
            class="textarea textarea-bordered h-32 leading-relaxed">{{ old('description', $event->description ?? '') }}</textarea>
    </div>

    {{-- Submit Button --}}
    <div class="pt-4">
        <button type="submit" class="btn btn-primary btn-block shadow-lg">
            {{ $isEdit ? 'Update Event' : 'Create Event' }}
        </button>
        <a href="{{ $isEdit ? "/events/{$event->id}" : "/" }}" class="btn btn-ghost btn-block mt-2">Cancel</a>
    </div>
</form>