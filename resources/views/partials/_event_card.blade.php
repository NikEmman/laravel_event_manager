<div class="card bg-base-100 shadow-sm border border-base-300 hover:shadow-xl transition-all duration-300 group">
    <div class="card-body p-6">
        {{-- Space Badge --}}
        <div class="flex justify-between items-start mb-4">
            <span
                class="badge badge-outline badge-sm opacity-70 px-3 py-3 uppercase tracking-wider font-bold text-[10px]">
                {{ $event->space->name }}
            </span>
            <div class="text-right">
                <span class="text-xs font-bold block uppercase opacity-50">Starts</span>
                <span
                    class="text-sm font-medium">{{ \Carbon\Carbon::parse($event->start_date)->format('M d, H:i') }}</span>
            </div>
        </div>

        {{-- Title & Description --}}
        <h2 class="card-title text-xl font-bold group-hover:text-primary transition-colors">
            {{ $event->title }}
        </h2>
        <p class="text-base-content/70 text-sm line-clamp-3 my-2">
            {{ $event->description }}
        </p>

        <div class="divider my-1"></div>

        {{-- Footer/Actions --}}
        <div class="card-actions justify-between items-center mt-2">
            <div class="text-xs opacity-50 italic">
                Ends {{ \Carbon\Carbon::parse($event->end_date)->diffForHumans($event->start_date, true) }} later
            </div>

            <a href="/events/{{ $event->id }}" class="btn btn-primary btn-sm rounded-lg">
                View Details
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</div>