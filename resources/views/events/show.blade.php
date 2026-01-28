@extends('app')

@section('title', $event->title)

@section('content')
    <div class="max-w-5xl mx-auto">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="/" class="btn btn-ghost btn-sm gap-2 opacity-70 hover:opacity-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Events
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Left Column: The Card (Reused Partial) --}}
            <div class="lg:col-span-1">
                @include('partials._event_card', ['event' => $event])
                
                @auth
                    <div class="mt-6 p-4 bg-base-100 rounded-2xl border border-base-300 shadow-sm">
                        <h4 class="text-xs font-bold uppercase opacity-50 mb-4">Admin Actions</h4>
                        <div class="flex flex-col gap-2">
                            <a href="/events/{{ $event->id }}/edit" class="btn btn-warning btn-outline btn-sm w-full">
                                Edit Event Details
                            </a>
                            <form action="/events/{{ $event->id }}" method="POST" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-error btn-ghost btn-sm w-full" onclick="return confirm('Are you sure you want to delete this event?')">
                                    Delete Event
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>

            {{-- Right Column: Expanded Details --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-base-100 rounded-3xl p-8 shadow-sm border border-base-300">
                    <h2 class="text-2xl font-black mb-6">Location Details</h2>
                    
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-primary/10 text-primary rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg">{{ $event->space->name }}</h4>
                            <p class="text-base-content/60">{{ $event->space->address }}</p>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <h2 class="text-2xl font-black mb-6">Full Schedule</h2>
                    <div class="stats stats-vertical lg:stats-horizontal shadow bg-base-200 w-full">
                        <div class="stat">
                            <div class="stat-title italic">Starts</div>
                            <div class="stat-value text-primary text-xl">
                                {{ \Carbon\Carbon::parse($event->start_date)->format('M d') }}
                            </div>
                            <div class="stat-desc font-bold">{{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }}</div>
                        </div>
                        
                        <div class="stat">
                            <div class="stat-title italic">Ends</div>
                            <div class="stat-value text-secondary text-xl">
                                {{ \Carbon\Carbon::parse($event->end_date)->format('M d') }}
                            </div>
                            <div class="stat-desc font-bold">{{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection