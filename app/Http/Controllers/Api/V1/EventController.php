<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Http\Resources\EventResource;

class EventController extends Controller
{
    public function index()
    {
        // Get events where start_date is greater than 'now'
        // Load the space to avoid N+1 issues
        $events = Event::with('space')
            ->where('start_date', '>', now())
            ->orderBy('start_date', 'asc')
            ->get();

        // Return the collection through the Resource
        return EventResource::collection($events);
    }
}