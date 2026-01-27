<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Space;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function new()
    {
        // Fetch all spaces so the user can select one in the form
        $spaces = Space::all();
        
        return view('events.new', ['spaces' => $spaces]);
    }

    // app/Http/Controllers/EventController.php

public function create(Request $request) 
{
    // Validation
    $incomingFields = $request->validate([
        'title'       => ['required', 'string', 'max:100'],
        'description' => ['nullable', 'string'],
        'space_id'    => ['required', 'exists:spaces,id'], //exists makes sure the space id is in db
        'start_date'  => ['required', 'date','after:today'], // after today validates the event will not start at a past date
        'end_date'    => ['required', 'date', 'after:start_date'], // after validates it's a later date than start_date
    ]);

    
    Event::create($incomingFields);

    // Redirect back home with a success message
    return redirect('/')->with('success', 'Event created successfully!');
}
}
