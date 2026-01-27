<?php

namespace App\Http\Controllers;

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
}
